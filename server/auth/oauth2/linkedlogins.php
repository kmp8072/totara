<?php
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

use auth_oauth2\api;

/**
 * OAuth 2 Linked login configuration page.
 *
 * @package    auth_oauth2
 * @copyright  2017 Damyon Wiese <damyon@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/tablelib.php');

$linkedloginid = optional_param('linkedloginid', 0, PARAM_INT);
$issuerid = optional_param('issuerid', 0, PARAM_INT);

$PAGE->set_url('/auth/oauth2/linkedlogins.php');
$PAGE->set_context(context_user::instance($USER->id));
$PAGE->set_pagelayout('admin');
$strheading = get_string('linkedlogins', 'auth_oauth2');
$PAGE->set_title($strheading);
$PAGE->set_heading($strheading);

require_login();

// Match access control in lib.php.
if (!is_enabled_auth('oauth2')) {
    throw new \moodle_exception('notenabled', 'auth_oauth2');
}
$usercontext = context_user::instance($USER->id);
require_capability('auth/oauth2:managelinkedlogins', $usercontext);

$action = optional_param('action', '', PARAM_ALPHAEXT);
if ($issuerid && $action === 'new' && api::can_link_login($issuerid)) {
    require_sesskey();
    $issuer = \core\oauth2\api::get_issuer($issuerid);

    // We do a login dance with this issuer.
    $addparams = ['action' => 'new', 'issuerid' => $issuerid, 'sesskey' => sesskey()];
    $addurl = new moodle_url('/auth/oauth2/linkedlogins.php', $addparams);
    $client = \core\oauth2\api::get_user_oauth_client($issuer, $addurl);

    if (optional_param('logout', false, PARAM_BOOL)) {
        $client->log_out();
    }

    if (!$client->is_logged_in()) {
        redirect($client->get_login_url());
    }

    $userinfo = $client->get_userinfo();

    if (!empty($userinfo)) {
        try {
            api::link_login($userinfo, $issuer, $USER);
            redirect($PAGE->url, get_string('changessaved'), null, \core\output\notification::NOTIFY_SUCCESS);
        } catch (Exception $e) {
            redirect($PAGE->url, $e->getMessage(), null, \core\output\notification::NOTIFY_ERROR);
        }
    } else {
        redirect($PAGE->url, get_string('notloggedin', 'auth_oauth2'), null, \core\output\notification::NOTIFY_ERROR);
    }
} else if ($linkedloginid && $action === 'delete' && api::can_delete_linked_login($linkedloginid)) {
    require_sesskey();
    api::delete_linked_login($linkedloginid);
    redirect($PAGE->url, get_string('changessaved'), null, \core\output\notification::NOTIFY_SUCCESS);
}

$renderer = $PAGE->get_renderer('auth_oauth2');

$linkedloginid = optional_param('id', '', PARAM_RAW);
$linkedlogin = null;

$issuers = \core\oauth2\api::get_all_issuers();
$linkedlogins = api::get_visible_linked_logins();

$issuerbuttons = array();
foreach ($issuers as $k => $issuer) {
    if (!api::can_link_login($issuer->get('id'))) {
        unset($issuers[$k]);
        continue;
    }
    $addparams = ['action' => 'new', 'issuerid' => $issuer->get('id'), 'sesskey' => sesskey(), 'logout' => true];
    $addurl = new moodle_url('/auth/oauth2/linkedlogins.php', $addparams);
    $issuerbuttons[$issuer->get('id')] = $renderer->single_button($addurl, get_string('createnewlinkedlogin', 'auth_oauth2', s($issuer->get('name'))));
}

if (!$issuerbuttons && !$linkedlogins) {
    // Just a notification that we can't make it.
    $preferencesurl = new moodle_url('/user/preferences.php');
    redirect($preferencesurl, get_string('noissuersavailable', 'auth_oauth2'), null, \core\output\notification::NOTIFY_WARNING);
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('linkedlogins', 'auth_oauth2'));
echo $OUTPUT->doc_link('Linked_Logins', get_string('linkedloginshelp', 'auth_oauth2'));

echo $renderer->linked_logins_table($linkedlogins);

foreach ($issuerbuttons as $issuerbutton) {
    echo $issuerbutton;
}

echo $OUTPUT->footer();


