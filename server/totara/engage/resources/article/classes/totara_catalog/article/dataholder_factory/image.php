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
 * @package engage_article
 * @category totara_catalog
 */

namespace engage_article\totara_catalog\article\dataholder_factory;

defined('MOODLE_INTERNAL') || die();

use engage_article\totara_catalog\article\dataformatter\image as image_formatter;
use totara_catalog\dataformatter\formatter;
use totara_catalog\dataholder;
use totara_catalog\dataholder_factory;

class image extends dataholder_factory {

    public static function get_dataholders(): array {
        return [
            new dataholder(
                'image',
                'not used image dataholder',
                [
                    formatter::TYPE_PLACEHOLDER_IMAGE => new image_formatter(
                        'imagesource.id',
                        'imagesource.name',
                        'imagesource.userid'
                    ),
                ],
                [
                    'imagesource' =>
                        "LEFT JOIN {engage_resource} imagesource
                                ON imagesource.instanceid = base.id
                               AND imagesource.resourcetype = 'engage_article'"
                ]
            )
        ];
    }
}
