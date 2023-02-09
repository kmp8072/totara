// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Standard Ajax wrapper for Moodle. It calls the central Ajax script,
 * which can call any existing webservice using the current session.
 * In addition, it can batch multiple requests and return multiple responses.
 *
 * @module     core/ajax
 * @class      ajax
 * @package    core
 * @copyright  2015 Damyon Wiese <damyon@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      2.9
 */
define(['jquery', 'core/config', 'core/log', 'core/notification'], function($, config, Log, notification) {

    // Keeps track of when the user leaves the page so we know not to show an error.
    var unloading = false;

    /**
     * Success handler. Called when the ajax call succeeds. Checks each response and
     * resolves or rejects the deferred from that request.
     *
     * @method requestSuccess
     * @private
     * @param {Object[]} responses Array of responses containing error, exception and data attributes.
     */
    var requestSuccess = function(responses) {
        // Call each of the success handlers.
        var requests = this;
        var exception = null;
        var i = 0;
        var request;
        var response;

        if (responses.error) {
            // There was an error with the request as a whole.
            // We need to reject each promise.
            // Unfortunately this may lead to duplicate dialogues, but each Promise must be rejected.
            for (; i < requests.length; i++) {
                request = requests[i];
                request.deferred.reject(responses);
            }

            return;
        }

        for (i = 0; i < requests.length; i++) {
            request = requests[i];

            response = responses[i];
            // We may not have responses for all the requests.
            if (typeof response !== "undefined") {
                if (response.error === false) {
                    // Call the done handler if it was provided.
                    request.deferred.resolve(response.data);
                } else {
                    exception = response.exception;
                    break;
                }
            } else {
                // This is not an expected case.
                exception = new Error('missing response');
                break;
            }
        }
        // Something failed, reject the remaining promises.
        if (exception !== null) {
            for (; i < requests.length; i++) {
                request = requests[i];
                request.deferred.reject(exception);
            }
        }
    };

    /**
     * Fail handler. Called when the ajax call fails. Rejects all deferreds.
     *
     * @method requestFail
     * @private
     * @param {jqXHR} jqXHR The ajax object.
     * @param {string} textStatus The status string.
     * @param {Error|Object} exception The error thrown.
     */
    var requestFail = function(jqXHR, textStatus, exception) {
        // Reject all the promises.
        var requests = this;

        var i = 0;
        for (i = 0; i < requests.length; i++) {
            var request = requests[i];

            if (unloading) {
                // No need to trigger an error because we are already navigating.
                Log.error("Page unloaded.");
                Log.error(exception);
            } else {
                request.deferred.reject(exception);
            }
        }
    };

    return /** @alias module:core/ajax */ {
        // Public variables and functions.
        /**
         * Make a series of ajax requests and return all the responses.
         *
         * @method call
         * @param {Object[]} requests Array of requests with each containing methodname and args properties.
         *                   done and fail callbacks can be set for each element in the array, or the
         *                   can be attached to the promises returned by this function.
         * @param {Boolean} async Optional, defaults to true.
         *                  If false - this function will not return until the promises are resolved.
         * @param {Boolean} loginrequired Optional, defaults to true.
         *                  If false - this function will call the faster nologin ajax script - but
         *                  will fail unless all functions have been marked as 'loginrequired' => false
         *                  in services.php
         * @return {Promise[]} Array of promises that will be resolved when the ajax call returns.
         */
        call: function(requests, async, loginrequired) {
            $(window).bind('beforeunload', function() {
                unloading = true;
            });
            var ajaxRequestData = [],
                i,
                promises = [],
                methodInfo = [],
                requestInfo = '';

            if (typeof loginrequired === "undefined") {
                loginrequired = true;
            }
            if (typeof async === "undefined") {
                async = true;
            }
            for (i = 0; i < requests.length; i++) {
                var request = requests[i];
                ajaxRequestData.push({
                    index: i,
                    methodname: request.methodname,
                    args: request.args
                });
                request.deferred = $.Deferred();
                promises.push(request.deferred.promise());
                // Allow setting done and fail handlers as arguments.
                // This is just a shortcut for the calling code.
                if (typeof request.done !== "undefined") {
                    request.deferred.done(request.done);
                }
                if (typeof request.fail !== "undefined") {
                    request.deferred.fail(request.fail);
                }
                request.index = i;
                methodInfo.push(request.methodname);
            }

            if (methodInfo.length <= 5) {
                requestInfo = methodInfo.sort().join();
            } else {
                requestInfo = methodInfo.length + '-method-calls';
            }

            ajaxRequestData = JSON.stringify(ajaxRequestData);
            var settings = {
                type: 'POST',
                data: ajaxRequestData,
                context: requests,
                dataType: 'json',
                processData: false,
                async: async,
                contentType: "application/json",
                headers: {
                    'x-totara-sesskey': config.sesskey
                }
            };

            var script = 'service.php';
            if (!loginrequired) {
                script = 'service-nologin.php';
            }
            var url = config.wwwroot + '/lib/ajax/' + script +
                    '?info=' + requestInfo;

            // Jquery deprecated done and fail with async=false so we need to do this 2 ways.
            if (async) {
                $.ajax(url, settings)
                    .done(requestSuccess)
                    .fail(requestFail);
            } else {
                settings.success = requestSuccess;
                settings.error = requestFail;
                $.ajax(url, settings);
            }

            return promises;
        },

        /**
         * Totara: Wrap the call function with behat and a ES6 promise
         *
         * @method getData
         * @param {Object} ajaxRequest Object for request data containing methodname, args properties and an optional callback array
         * @return {Promise} es6 Promise
         */
        getData: function(ajaxRequest) {
            var behatPause = ajaxRequest.methodname + '_requesting_data',
                callback = '',
                that = this;

            if (ajaxRequest.callback) {
                callback = ajaxRequest.callback;
                delete ajaxRequest.callback;
            }

            M.util.js_pending(behatPause);
            return new Promise(function(resolve, reject) {
                // This extension currently always hardcodes loginrequired to true, if there is a usecase where this isn't required
                // please extend here.
                var request = that.call([ajaxRequest], true, true);

                request[0].done(function(results) {
                    resolve({'results': results, 'callbacks': callback});
                    M.util.js_complete(behatPause);
                }).fail(function(ex) {
                    notification.exception(ex);
                    reject(ex);
                    M.util.js_complete(behatPause);
                });
            });
        },

        /**
         * Totara: Make required ajax requests, then call all callbacks, then return an ES6 promise once all callbacks resolve
         *
         * @method getDataUpdate
         * @param {Array} requests array of webservice request objects
         * @return {Promise} es6 Promise
         */
        getDataUpdate: function(requests) {
            var that = this;

            return new Promise(function(resolve, reject) {
                var ajaxRequest,
                    getMultiDataPromise = [];

                // Loop through passed request data
                for (var a = 0; a < requests.length; a++) {
                    ajaxRequest = requests[a];
                    // Add ajax request promise to promise.all
                    getMultiDataPromise.push(that.getData(ajaxRequest));
                }

                Promise.all(getMultiDataPromise).then(function(responses) {
                    var a,
                        callback,
                        callbacks,
                        data,
                        i,
                        updateList = [];

                    // Loop through responses
                    for (i = 0; i < responses.length; i++) {
                        data = responses[i].results;
                        callbacks = responses[i].callbacks;

                        // Loop through response callbacks
                        for (a = 0; a < callbacks.length; a++) {
                            callback = callbacks[a];

                            if (typeof callback !== 'function') {
                                Log.error('Callback is not a function');
                            } else {
                                updateList.push(callback(data));
                            }
                        }
                    }

                    // Trigger all callbacks and resolve once all are complete
                    Promise.all(updateList).then(function() {
                        resolve();
                    }).catch(function() {
                        reject();
                    });
                });
            });
        }
    };
});
