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

namespace container_workspace\observer;

use container_workspace\workspace;
use core\event\tenant_created;
use core_container\container_category_helper;

final class tenant_observer {

    /**
     * Create categories for the workspace container.
     *
     * @param tenant_created $event
     */
    public static function tenant_created(tenant_created $event): void {
        /** @var \core\entities\tenant $tenant */
        $tenant = $event->get_record_snapshot('tenant', $event->objectid);
        container_category_helper::create_container_category(workspace::get_type(), $tenant->categoryid);
    }

}
