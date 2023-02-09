<?php
/**
 * This file is part of Totara Learn
 *
 * Copyright (C) 2022 onwards Totara Learning Solutions LTD
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
 * @package mod_perform
 */

namespace mod_perform\models\activity\trigger\repeating;

use mod_perform\entity\activity\temp_track_user_assignment_queue;
use mod_perform\state\subject_instance\closed;
use mod_perform\state\subject_instance\complete;

/**
 * Indicates whether to create a new subject instance for the same activity with
 * respect to the creation time of the previously closed or completed instance.
 */
final class after_creation_and_completion_or_closure extends trigger {
    /**
     * {@inheritDoc}
     */
    public function get_name(): string {
        return 'COMPLETION_CLOSURE';
    }

    /**
     * {@inheritDoc}
     */
    public function get_interval(): string {
        return 'MINIMUM_TIME_SINCE_CREATION';
    }

    /**
     * {@inheritDoc}
     */
    public function get_reference_timestamp(
        temp_track_user_assignment_queue $assignment
    ): ?int {
        $progress = (int)$assignment->last_instance_progress;
        $availabilty = (int)$assignment->last_instance_availability;

        return $progress === complete::get_code() || $availabilty === closed::get_code()
            ? $assignment->last_instance_created_at
            : null;
    }
}
