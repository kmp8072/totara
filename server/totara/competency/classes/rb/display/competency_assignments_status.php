<?php
/*
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
* @author Oleg Demeshev <oleg.demeshev@totaralearning.com>
* @package totara_competency
*/

namespace totara_competency\rb\display;

use rb_column;
use reportbuilder;
use stdClass;
use totara_reportbuilder\rb\display\base;
use totara_competency\entity\assignment;

defined('MOODLE_INTERNAL') || die();

class competency_assignments_status extends base {

    /**
     * Return the Assignment status value.
     *
     * @param string $value
     * @param string $format
     * @param \stdClass $row
     * @param \rb_column $column
     * @param \reportbuilder $report
     * @return string
     */
    public static function display($value, $format, stdClass $row, rb_column $column, reportbuilder $report) {
        if ($value == assignment::STATUS_ACTIVE) {
            return get_string('status_active', 'totara_competency');
        } else if ($value == assignment::STATUS_ARCHIVED) {
            return get_string('status_archived', 'totara_competency');
        } else {
            return get_string('unknown');
        }
    }

    /**
     * Is this column graphable?
     *
     * @param rb_column $column
     * @param \rb_column_option $option
     * @param reportbuilder $report
     * @return bool
     */
    public static function is_graphable(rb_column $column, \rb_column_option $option, reportbuilder $report) {
        return false;
    }
}