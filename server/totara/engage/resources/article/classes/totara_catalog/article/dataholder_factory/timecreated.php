<?php
/*
 * This file is part of Totara Learn
 *
 * Copyright (C) 2021 onwards Totara Learning Solutions LTD
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

use totara_catalog\dataformatter\formatter;
use totara_catalog\dataformatter\sort_time;
use totara_catalog\dataformatter\user_date;
use totara_catalog\dataholder;
use totara_catalog\dataholder_factory;

class timecreated extends dataholder_factory {

    public static function get_dataholders(): array {
        return [
            new dataholder(
                'timecreated',
                new \lang_string('field:timecreated', 'engage_article'),
                [
                    formatter::TYPE_PLACEHOLDER_TEXT => new user_date(
                        'namesource.timecreated'
                    ),
                    formatter::TYPE_SORT_TIME => new sort_time(
                        'namesource.timecreated'
                    ),
                ]
            )
        ];
    }
}
