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
 * @author Qingyang Liu <qingyang.liu@totaralearning.com>
 * @package totara_playlist
 */
defined('MOODLE_INTERNAL') || die();
use totara_core\advanced_feature;

global $CFG;
require_once($CFG->dirroot . '/totara/playlist/rb_sources/rb_source_playlistengagement.php');

class rb_playlistengagement_embedded extends rb_base_embedded {
    /**
     * @var string
     */
    public $defaultsortcolumn;

    /**
     * @var int
     */
    public $defaultsortorder;

    /**
     * rb_engagecontent_embedded constructor.
     * @param array $data
     */
    public function __construct(array $data) {
        $this->embeddedparams = $data;
        $this->url = '/totara/playlist/reporting/playlist_report.php';
        $this->source = 'playlistengagement';
        $this->shortname = 'playlistengagement';
        $this->fullname = get_string('playlistengagement', 'totara_playlist');
        $this->columns = $this->define_columns();
        $this->filters = $this->define_filters();

        $this->defaultsortcolumn = "playlistengagement_title";
        $this->defaultsortorder = SORT_DESC;
        $this->contentmode = REPORT_BUILDER_CONTENT_MODE_NONE;

        parent::__construct();
    }

    /**
     * @return bool
     */
    public function embedded_global_restrictions_supported() {
        return true;
    }

    /**
     * Can searches be saved?
     *
     * @return bool
     */
    public static function is_search_saving_allowed() : bool {
        return false;
    }

    /**
     * Define the default columns for this report.
     *
     * @return array
     */
    protected function define_columns() {
        return \rb_source_playlistengagement::get_default_columns();
    }

    /**
     * Define the default filters for this report.
     *
     * @return array
     */
    protected function define_filters() {
        return \rb_source_playlistengagement::get_default_filters();
    }

    /**
     * Check if the user is capable of accessing this report.
     *
     * @param int $reportfor id of the user that this report is being generated for
     * @param reportbuilder $report the report object - can use get_param_value to get params
     * @return bool true if the user can access this report
     */
    public function is_capable($reportfor, $report) : bool {
        $context = context_user::instance($reportfor);

        return has_capability('totara/playlist:view_playlist_report', $context, $reportfor);
    }

    /**
     * Report is ignored if features are disabled
     * @return bool
     */
    public static function is_report_ignored() {
        return \rb_source_playlistengagement::is_source_ignored();
    }

}