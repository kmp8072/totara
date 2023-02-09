<?php
/**
 * This file is part of Totara Core
 *
 * Copyright (C) 2022 onwards Totara Learning Solutions LTD
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author  Michael Ivanov <michael.ivanov@totaralearning.com>
 * @package totara_webapi
 */

namespace totara_webapi\webapi\resolver\middleware;

use totara_webapi\hook\api_hook;

class test_component_middleware_watcher {

    public static function watch(api_hook $api_hook) {
        global $CFG;
        require_once($CFG->dirroot . '/totara/webapi/tests/fixtures/resolver/middleware/test_request_3.php');
        require_once($CFG->dirroot . '/totara/webapi/tests/fixtures/resolver/middleware/test_result_3.php');
        if ($api_hook->component === 'totara_webapi') {
            $api_hook->middleware = array_merge([test_request_3::class, test_result_3::class], $api_hook->middleware);
        }
    }
}