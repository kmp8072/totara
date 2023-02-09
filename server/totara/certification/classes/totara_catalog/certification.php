<?php
/*
 * This file is part of Totara Learn
 *
 * Copyright (C) 2018 onwards Totara Learning Solutions LTD
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
 * @author Matthias Bonk <matthias.bonk@totaralearning.com>
 * @package totara_certification
 * @category totara_catalog
 */
namespace totara_certification\totara_catalog;

defined('MOODLE_INTERNAL') || die();

use totara_catalog\provider;
use totara_core\advanced_feature;
use totara_customfield\totara_catalog\dataholder_factory as customfield_dataholder_factory;

global $CFG;

require_once($CFG->dirroot . '/totara/program/lib.php');

class certification extends provider {

    /**
     * @var [] Caches configuration for this provider.
     */
    private $config_cache = null;

    public static function is_plugin_enabled(): bool {
        return !advanced_feature::is_disabled('certifications');
    }

    public static function get_name(): string {
        return get_string('certifications', 'totara_certification');
    }

    public static function get_object_type(): string {
        return 'certification';
    }

    public function get_object_table(): string {
        return '{prog}';
    }

    public function get_objectid_field(): string {
        return 'id';
    }

    public function can_see(array $objects): array {
        $results = [];

        $issiteadmin = is_siteadmin();

        foreach ($objects as $object) {
            if ($issiteadmin) {
                $results[$object->objectid] = true;
                continue;
            }

            $program = new \program($object->objectid);
            $results[$object->objectid] =  $program->is_viewable();
        }

        return $results;
    }

    public function get_all_objects_sql(): array {

        $sql = "SELECT p.id AS objectid, 'certification' AS objecttype, con.id AS contextid
                  FROM {prog} p
                  JOIN {context} con
                    ON con.instanceid = p.id
                 WHERE p.certifid IS NOT NULL
                   AND con.contextlevel = :programcontextlevel";

        return [$sql, ['programcontextlevel' => CONTEXT_PROGRAM]];
    }

    public function get_data_holder_config(string $key) {

        if (is_null($this->config_cache)) {
            $this->config_cache = [
                'sort'     => [
                    'text' => 'fullname',
                    'time' => 'timecreated',
                ],
                'fts'      => [
                    'high'   => ['fullname', 'shortname'],
                    'medium' => ['summary_fts', 'ftstags', 'search_metadata'],
                    'low'    => array_merge(
                        customfield_dataholder_factory::get_fts_dataholder_keys('prog', 'certification', $this),
                        ['idnumber', 'course_fullnames', 'course_shortnames', 'course_category_hierarchy']
                    ),
                ],
                'image'       => 'image',
                'progressbar' => 'progressbar',
            ];
        }

        if (isset($this->config_cache[$key])) {
            return $this->config_cache[$key];
        }

        return null;
    }

    public function get_manage_link(int $objectid) {
        $program = new \program($objectid);

        if (!$program->has_capability_for_overview_page()) {
            return null;
        }

        $link = new \stdClass();
        $link->url = (new \moodle_url('/totara/program/edit.php', ['id' => $objectid]))->out();
        $link->label = get_string('editcertif', 'totara_certification');

        return $link;
    }

    public function get_details_link(int $objectid) {
        global $CFG, $USER;

        $program = new \program($objectid);

        if ($program->user_is_assigned($USER->id)) {
            $link = new \stdClass();
            $link->description = get_string('catalog_already_enrolled', 'totara_certification');
            $link->button = new \stdClass();
            $link->button->url = (new \moodle_url('/totara/program/view.php', ['id' => $objectid]))->out();
            $link->button->label = get_string('catalog_go_to_certification', 'totara_certification');
            return $link;
        }

        if (empty($CFG->audiencevisibility) || $program->is_viewable()) {
            $link = new \stdClass();
            $link->description = get_string('catalog_not_enrolled', 'totara_certification');
            $link->button = new \stdClass();
            $link->button->url = (new \moodle_url('/totara/program/view.php', ['id' => $objectid]))->out();
            $link->button->label = get_string('catalog_go_to_certification', 'totara_certification');
            return $link;
        }

        $link = new \stdClass();
        $link->description = get_string('catalog_cannot_view', 'totara_certification');
        return $link;
    }

    public function get_create_buttons(): array {

        $categoryid = totara_get_categoryid_with_capability('totara/certification:createcertification');
        $buttons = [];

        if ($categoryid !== false) {
            $button = new \stdClass();
            $button->label = get_string('certification', 'totara_certification');
            $button->url = (new \moodle_url("/totara/certification/add.php", ['category' => $categoryid]))->out();
            $buttons[] = $button;
        }

        return $buttons;
    }
}

