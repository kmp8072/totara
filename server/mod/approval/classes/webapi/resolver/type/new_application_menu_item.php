<?php
/**
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
 * @author Chris Snyder <chris.snyder@totaralearning.com>
 * @package mod_approval
 */

namespace mod_approval\webapi\resolver\type;

use core\format;
use core\webapi\execution_context;
use core\webapi\type_resolver;
use mod_approval\formatter\application\new_application_menu_item as new_application_menu_item_formatter;
use mod_approval\webapi\schema_object\new_application_menu_item as new_application_menu_item_schema_object;

/**
 * New application menu item type resolver
 */
class new_application_menu_item extends type_resolver {

    /**
     * @param string $field
     * @param new_application_menu_item_schema_object|object $item
     * @param array $args
     * @param execution_context $ec
     *
     * @return mixed
     */
    public static function resolve(string $field, $item, array $args, execution_context $ec) {
        if (!$item instanceof new_application_menu_item_schema_object) {
            throw new \coding_exception('Expected new_application_menu_item schema object');
        }

        $format = $args['format'] ?? format::FORMAT_HTML;

        $formatter = new new_application_menu_item_formatter($item, $ec->get_relevant_context());

        return $formatter->format($field, $format);
    }
}