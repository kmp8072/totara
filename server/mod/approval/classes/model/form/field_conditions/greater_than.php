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
 * @author Kunle Odusan <kunle.odusan@totaralearning.com>
 */

namespace mod_approval\model\form\field_conditions;

/**
 * Asserts a value is greater than another.
 */
class greater_than implements condition {

    /**
     * Condition Identifier.
     *
     * @var string
     */
    public const IDENTIFIER = '>';

    /**
     * @inheritDoc
     */
    public function assert($expected, $actual): bool {
        return $actual > $expected;
    }
}
