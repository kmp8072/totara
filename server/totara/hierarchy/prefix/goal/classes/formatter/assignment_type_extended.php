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
 * @author Murali Nair <murali.nair@totaralearning.com>
 * @package hierarchy_goal
 */

namespace hierarchy_goal\formatter;

use core\webapi\formatter\formatter;
use core\webapi\formatter\field\string_field_formatter;

/**
 * Maps the personal_goal or company_goal entity class into a GraphQL
 * totara_hierarchy_goal_assignment_type_extended type.
 */
class assignment_type_extended extends formatter {
    /**
     * {@inheritdoc}
     */
    protected function get_map(): array {
        return [
            'type' => null,
            'description' => string_field_formatter::class
        ];
    }
}
