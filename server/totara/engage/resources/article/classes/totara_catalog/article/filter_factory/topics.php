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
 * @author David Curry <david.curry@totaralearning.com>
 * @package engage_article
 * @category totara_catalog
 */

namespace engage_article\totara_catalog\article\filter_factory;

defined('MOODLE_INTERNAL') || die();

use totara_catalog\filter;
use totara_catalog\filter_factory;
use totara_catalog\datasearch\equal;
use totara_catalog\datasearch\in_or_equal;
use totara_catalog\merge_select\multi;
use totara_catalog\merge_select\single;

class topics extends filter_factory {

    /**
     * This is mostly copied from /core_tag/totara_catalog/filter_factory::get_filters()
     * with a tweak to rename the collection
     */
    public static function get_filters(): array {
        global $CFG, $DB;

        $itemtype = 'engage_resource';
        $objecttype = 'engage_article';
        $component = 'engage_article';

        if (empty($CFG->usetags)) {
            return [];
        }

        if (!\core_tag_area::is_enabled($component, $itemtype)) {
            return [];
        }

        $collectionid = \core_tag_area::get_collection($component, $itemtype);
        $coll = $DB->get_record('tag_coll', ['id' => $collectionid], '*', MUST_EXIST);
        $displayname = \core_tag_collection::display_name($coll);

        $filters = [];

        $optionsloader = function () use ($itemtype, $component, $coll) {
            global $DB;

            $sql = '
                SELECT DISTINCT tag.id, tag.rawname AS name
                FROM "ttr_tag_instance" tag_instance
                JOIN "ttr_tag" tag
                    ON tag_instance.tagid = tag.id
                WHERE tag_instance.itemtype = :itemtype
                AND tag_instance.component = :component
                AND tag.tagcollid = :collection_id
            ';

            $records = $DB->get_records_sql(
                $sql,
                [
                    'itemtype' => $itemtype,
                    'component' => $component,
                    'collection_id' => $coll->id
                ]
            );

            $systemcontext = \context_system::instance();

            $options = [];
            foreach ($records as $record) {
                $options[$record->id] = format_string($record->name, true, ['context' => $systemcontext]);
            }

            return $options;
        };

        // The panel filter can appear in the panel region.
        $tagpanelkey = 'tag_panel_' . $collectionid;
        $paneldatafilter = new in_or_equal(
            $tagpanelkey,
            'catalog',
            ['objecttype', 'objectid']
        );

        $itemtypeparamkey = 'tfip_' . $collectionid . '_type_' . $objecttype;
        $paneltablealias = 'tfip_' . $collectionid . '_' . $objecttype;

        $tag_instance_select_resource_alias = 'er_' . $collectionid . '_' . $objecttype;
        $tag_instance_select_tag_alias = 'tg_' . $collectionid . '_' . $objecttype;

        // We have to filter on the tag, however the catalog knows the articleid, but the tags use the resourceid
        // A join must take place, and since the source doesn't accept a direct join, we do it via subselect instead
        $taginstance_select = "
            SELECT {$tag_instance_select_resource_alias}.instanceid AS objectid, 
                   {$tag_instance_select_tag_alias}.tagid, 
                   {$tag_instance_select_tag_alias}.itemtype
            FROM {tag_instance} {$tag_instance_select_tag_alias} 
            JOIN {engage_resource} {$tag_instance_select_resource_alias} ON {$tag_instance_select_tag_alias}.itemid = {$tag_instance_select_resource_alias}.id 
            WHERE {$tag_instance_select_resource_alias}.resourcetype = '{$component}'
        ";
        $paneldatafilter->add_source(
            "{$paneltablealias}.tagid",
            "({$taginstance_select})",
            $paneltablealias,
            [
                'objectid' => $paneltablealias . '.objectid',
                'objecttype' => "'{$objecttype}'"
            ],
            "{$paneltablealias}.itemtype = :{$itemtypeparamkey}",
            [
                $itemtypeparamkey => $itemtype,
            ]
        );

        $panelselector = new multi(
            $tagpanelkey,
            new \lang_string('tagscollectionx', 'tag', $displayname)
        );
        $panelselector->add_options_loader($optionsloader);

        $filters[] = new filter(
            $tagpanelkey,
            filter::REGION_PANEL,
            $paneldatafilter,
            $panelselector
        );

        // The browse filter can appear in the primary region.
        $tagbrowsekey = 'tag_browse_' . $collectionid;
        $browsedatafilter = new equal(
            $tagbrowsekey,
            'catalog',
            ['objecttype', 'objectid']
        );

        $itemtypeparamkey = 'tfib_' . $collectionid . '_type_' . $objecttype;
        $browsetablealias = 'tfib_' . $collectionid . '_' . $objecttype;

        $browsedatafilter->add_source(
            "{$browsetablealias}.tagid",
            "({$taginstance_select})",
            $browsetablealias,
            [
                'objectid' => $browsetablealias . '.objectid',
                'objecttype' => "'{$objecttype}'"
            ],
            "{$browsetablealias}.itemtype = :{$itemtypeparamkey}",
            [
                $itemtypeparamkey => $itemtype,
            ]
        );

        $browseselector = new single(
            $tagbrowsekey,
            new \lang_string('tagscollectionx', 'tag', $displayname)
        );
        $browseselector->add_all_option();
        $browseselector->add_options_loader($optionsloader);

        $filters[] = new filter(
            $tagbrowsekey,
            filter::REGION_BROWSE,
            $browsedatafilter,
            $browseselector
        );

        return $filters;
    }
}
