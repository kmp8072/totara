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
 * @author Mark Metcalfe <mark.metcalfe@totaralearning.com>
 * @package container_workspace
 */

namespace container_workspace\task;

use container_workspace\workspace;
use core\task\adhoc_task;

/**
 * Class create_missing_categories
 * @package container_workspace\task
 */
final class create_missing_categories extends adhoc_task {

    public function execute() {
        workspace::create_categories();
        if (!PHPUNIT_TEST) {
            mtrace('Created missing workspace container categories');
        }
    }

}
