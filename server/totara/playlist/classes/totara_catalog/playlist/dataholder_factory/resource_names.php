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
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author David Curry <david.curry@totaralearning.com>
 * @package totara_playlist
 * @category totara_catalog
 */

namespace totara_playlist\totara_catalog\playlist\dataholder_factory;

defined('MOODLE_INTERNAL') || die();

use totara_catalog\dataholder_factory;
use totara_catalog\dataholder;
use totara_catalog\dataformatter\formatter;
use totara_catalog\dataformatter\fts;


class resource_names extends dataholder_factory {

    /**
     * @return array
     */
    public static function get_dataholders(): array {
        global $DB;

        return [
            new dataholder(
                'resource_names',
                new \lang_string('field:resourcenames', 'totara_playlist'),
                [formatter::TYPE_FTS => new fts('resource_names.resources')],
                [
                    // Note: To make this apply to all resources not just articles, just remove the WHERE in there.
                    'resource_names' =>
                        "LEFT JOIN (SELECT pr.playlistid, {$DB->sql_group_concat('er.name',',')} AS resources
                                      FROM {playlist_resource} pr
                                      JOIN {engage_resource} er ON er.id = pr.resourceid
                                     WHERE er.resourcetype = 'engage_article'
                                     GROUP BY pr.playlistid) resource_names
                           ON resource_names.playlistid = base.id"
                ]
            ),
        ];
    }
}
