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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Petr Skoda <petr.skoda@totaralearning.com>
 * @package totara_catalog
 */

namespace totara_catalog\watcher;

class phpunit_reset_watcher {
    public static function reset_data(\core\hook\phpunit_reset $hook): void {
        if (class_exists('totara_catalog\local\config')) {
            \totara_catalog\local\config::phpunit_reset();
        }
        if (class_exists('totara_catalog\provider_handler')) {
            \totara_catalog\provider_handler::phpunit_reset();
        }
        if (class_exists('totara_catalog\local\feature_handler')) {
            \totara_catalog\local\feature_handler::phpunit_reset();
        }
        if (class_exists('totara_catalog\local\filter_handler')) {
            \totara_catalog\local\filter_handler::phpunit_reset();
        }
    }
}
