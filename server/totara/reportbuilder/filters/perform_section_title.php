<?php
/**
 * This file is part of Totara Perform
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
 * @author Oleg Demeshev <oleg.demeshev@totaralearning.com>
 * @package totara_reportbuilder
 * @subpackage mod_perform
 */

/** @var \core_config $CFG */
require_once($CFG->dirroot . '/mod/perform/classes/rb/filter/section_titles_by_activity.php');

use mod_perform\rb\filter\section_titles_by_activity as rb_filter_section_titles_by_activity;

/**
 * Filter based on selecting multiple section titles by activity id via a dialog
 */
class rb_filter_perform_section_title extends rb_filter_section_titles_by_activity {
    // Keep mod_perform filters under mod_perform plugin
}
