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
 * @author Ning Zhou <ning.zhou@totaralearning.com>
 * @package hierarchy_goal
 */

namespace hierarchy_goal\entity;

use core\orm\entity\entity;
use core\orm\entity\repository;

/**
 * Represents a company goal type record in the repository.
 *
 * @property-read int $id record id
 * @property string $shortname type name
 * @property string $idnumber type idnumber
 * @property string $description type description
 * @property int $sortorder type sort order
 * @property int $visible type visible
 * @property int $timecreated time created
 * @property int $timemodified time modified
 * @property int $usermodified time modified
 * @property string $fullname type name
 * @property int $hidecustomfields
 *
 * @method static repository repository()
 */
class company_goal_framework extends entity {
    public const TABLE = 'goal_framework';
}
