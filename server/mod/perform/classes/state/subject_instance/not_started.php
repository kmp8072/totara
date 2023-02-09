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
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Matthias Bonk <matthias.bonk@totaralearning.com>
 * @package mod_perform
 */

namespace mod_perform\state\subject_instance;

use mod_perform\entity\activity\subject_instance as subject_instance_entity;
use mod_perform\state\subject_instance\condition\all_participant_instances_complete;
use mod_perform\state\subject_instance\condition\at_least_one_participant_instance_started;
use mod_perform\state\subject_instance\condition\not_all_participant_instances_complete;
use mod_perform\state\transition;

defined('MOODLE_INTERNAL') || die();

/**
 * This class represents the "not_started" progress status of a subject instance.
 *
 * @package mod_perform
 */
class not_started extends subject_instance_progress {

    public static function get_name(): string {
        return 'NOT_STARTED';
    }

    public static function get_code(): int {
        return 0;
    }

    public function get_transitions(): array {
        return [
            transition::to(new complete($this->object))->with_conditions([
                all_participant_instances_complete::class
            ]),

            transition::to(new in_progress($this->object))->with_conditions([
                not_all_participant_instances_complete::class,
                at_least_one_participant_instance_started::class,
            ]),

            transition::to(new not_submitted($this->object))->with_conditions([
                not_all_participant_instances_complete::class,
            ]),
        ];
    }

    public function on_enter(): void {
        // Set the completed_at date.
        /** @var subject_instance_entity $subject_instance_entity */
        $subject_instance_entity = subject_instance_entity::repository()->find($this->get_object()->get_id());
        if (empty($subject_instance_entity->completed_at)) {
            return;
        }
        $subject_instance_entity->completed_at = null;
        $subject_instance_entity->update();
    }

    public function update_progress(): void {
        foreach ([complete::class, in_progress::class] as $to_state) {
            if ($this->can_switch($to_state)) {
                $this->object->switch_state($to_state);
                break;
            }
        }
    }

    public function manually_complete(): void {
        if ($this->can_switch(not_submitted::class)) {
            $this->object->switch_state(not_submitted::class);
        }
    }

    public function manually_uncomplete(): void {
        // Not relevant when incomplete. Do nothing.
    }

}
