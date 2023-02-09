<?php
/**
 * This file is part of Totara Learn
 *
 * Copyright (C) 2020 onwards Totara Learning Solutions LTD
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
 * @author Cody Finegan <cody.finegan@totaralearning.com>
 * @package engage_survey
 */

namespace engage_survey\totara_engage\link;

use moodle_url;
use totara_engage\link\destination_generator;

/**
 * Generator to create survey links.
 *
 * @package engage_survey\totara_engage\link
 */
final class survey_destination extends destination_generator {
    /**
     * @var array
     */
    protected $auto_populate = ['id'];

    /**
     * @return moodle_url
     */
    protected function base_url(): moodle_url {
        $page = $this->attributes['page'] ?? null;

        switch ($page) {
            case 'edit':
                return new moodle_url('/totara/engage/resources/survey/survey_edit.php');

            case 'vote':
                return new moodle_url('/totara/engage/resources/survey/survey_vote.php');

            case 'view':
                return new moodle_url('/totara/engage/resources/survey/survey_view.php');

            case 'redirect':
            default:
                return new moodle_url('/totara/engage/resources/survey/redirect.php');
        }
    }
}