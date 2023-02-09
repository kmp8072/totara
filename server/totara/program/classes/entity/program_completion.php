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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Johannes Cilliers <johannes.cilliers@totaralearning.com>
 * @package totara_program
 */

namespace totara_program\entity;

use core\orm\entity\entity;

/**
 * Program completion entity
 *
 * @property-read int $id ID
 * @property int $programid
 * @property int $userid
 * @property int $coursesetid
 * @property int $status
 * @property int $timestarted
 * @property int $timecreated
 * @property int $timedue
 * @property int $timecompleted
 * @property int $organisationid
 * @property int $positionid
 */
class program_completion extends entity {

    public const TABLE = 'prog_completion';

}