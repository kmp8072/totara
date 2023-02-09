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
 * @author Nathan Lewis <nathan.lewis@totaralearning.com>
 * @package mod_approval
 */

use core_phpunit\testcase;
use container_approval\approval as approval_container;
use mod_approval\model\workflow\workflow as workflow_model;
use mod_approval\model\workflow\workflow_stage as workflow_stage_model;
use mod_approval\testing\workflow_generator_object;
use mod_approval\totara_notification\resolver\level_base;
use totara_core\extended_context;
use mod_approval\testing\generator as workflow_generator;

defined('MOODLE_INTERNAL') || die();

/**
 * @group approval_workflow
 * @group totara_notification
 */
class mod_approval_totara_notification_level_testcase extends testcase {

    public function test_supports_context(): void {
        // User.
        $user = $this->getDataGenerator()->create_user();
        $user_context = context_user::instance($user->id);
        $user_extended_context = extended_context::make_with_context($user_context);
        self::assertFalse(level_base::supports_context($user_extended_context));

        // Non-approval course.
        $course = $this->getDataGenerator()->create_course();
        $course_context = context_course::instance($course->id);
        $course_extended_context = extended_context::make_with_context($course_context);
        self::assertFalse(level_base::supports_context($course_extended_context));

        // Non-approval category.
        $course_cat = $this->getDataGenerator()->create_category();
        $course_cat_context = context_coursecat::instance($course_cat->id);
        $course_cat_extended_context = extended_context::make_with_context($course_cat_context);
        self::assertFalse(level_base::supports_context($course_cat_extended_context));

        // System.
        $system_extended_context = extended_context::make_system();
        self::assertTrue(level_base::supports_context($system_extended_context));

        // Approval category.
        $approval_cat_context = approval_container::get_default_category_context();
        $approval_cat_extended_context = extended_context::make_with_context($approval_cat_context);
        self::assertTrue(level_base::supports_context($approval_cat_extended_context));

        // Approval container/course.
        $workflow_model = $this->create_workflow();
        $workflow_context = $workflow_model->get_container()->get_context();
        $workflow_extended_context = extended_context::make_with_context($workflow_context);
        self::assertTrue(level_base::supports_context($workflow_extended_context));

        // Approval stage.
        $stage_extended_context = extended_context::make_with_context(
            $workflow_context, // Note same as container/course above.
            'mod_approval',
            'workflow_stage',
            123
        );
        self::assertTrue(level_base::supports_context($stage_extended_context));

        // Other approval extended context.
        $other_extended_context = extended_context::make_with_context(
            $workflow_context, // Note same as container/course above.
            'mod_approval',
            'other_area',
            123
        );
        self::assertFalse(level_base::supports_context($other_extended_context));

        // Dodgy non-workflow container/course which looks like a workflow stage.
        $dodgy_extended_context = extended_context::make_with_context(
            $course_context, // Using old course from above, while component and area match.
            'mod_approval',
            'workflow_stage',
            123
        );
        self::assertFalse(level_base::supports_context($dodgy_extended_context));
    }

    private function create_workflow(): workflow_model {
        $workflow_generator = workflow_generator::instance();
        $workflow_type = $workflow_generator->create_workflow_type('test type');
        $form_version = $workflow_generator->create_form_and_version('simple', 'Simple Request Form');
        $form = $form_version->form;
        $workflow_go = new workflow_generator_object($workflow_type->id, $form->id, $form_version->id);
        $workflow_version = $workflow_generator->create_workflow_and_version($workflow_go);
        $workflow_entity = $workflow_version->workflow;
        return workflow_model::load_by_entity($workflow_entity);
    }

    public function test_is_valid_additional_criteria(): void {
        $system_extended_context = extended_context::make_system();

        // True when additional criteria is null.
        $additional_criteria = null;
        self::assertTrue(level_base::is_valid_additional_criteria($additional_criteria, $system_extended_context));

        // True when approval_level_id is null.
        $additional_criteria = [
            'approval_level_id' => null,
        ];
        self::assertTrue(level_base::is_valid_additional_criteria($additional_criteria, $system_extended_context));

        // False when approval_level_id is not an existing approval level.
        $additional_criteria = [
            'approval_level_id' => 123,
        ];
        self::assertFalse(level_base::is_valid_additional_criteria($additional_criteria, $system_extended_context));

        // True when approval_level_id is a valid approval level id belonging to the context workflow stage.
        $workflow_generator = workflow_generator::instance();
        $workflow = workflow_model::load_by_entity($workflow_generator->create_simple_request_workflow());
        /** @var workflow_stage_model $workflow_stage */
        $stage_1 = $workflow->get_latest_version()->get_stages()->first();
        $workflow_stage = $workflow->latest_version->get_next_stage($stage_1->id);
        $approval_level_id = $workflow_stage->approval_levels->first()->id;
        $workflow_extended_context = extended_context::make_with_id(
            $workflow->get_context()->id,
            'mod_approval',
            'workflow_stage',
            $workflow_stage->id
        );
        $additional_criteria = [
            'approval_level_id' => $approval_level_id,
        ];
        self::assertTrue(level_base::is_valid_additional_criteria($additional_criteria, $workflow_extended_context));
    }

    public function test_meets_additional_criteria(): void {
        $event_data = [
            'approval_level_id' => 123,
        ];

        // True when criteria approval_level_id indicates to match to all given event approval_level_ids.
        $additional_criteria = null;
        self::assertTrue(level_base::meets_additional_criteria($additional_criteria, $event_data));

        // True when criteria approval_level_id indicates to match to all given event approval_level_ids.
        $additional_criteria = [
            'approval_level_id' => null,
        ];
        self::assertTrue(level_base::meets_additional_criteria($additional_criteria, $event_data));

        // True when criteria approval_level_id is the same as the given event approval_level_ids.
        $additional_criteria = [
            'approval_level_id' => 123,
        ];
        self::assertTrue(level_base::meets_additional_criteria($additional_criteria, $event_data));

        // False when criteria approval_level_id is different to the given event approval_level_ids.
        $additional_criteria = [
            'approval_level_id' => 789,
        ];
        self::assertFalse(level_base::meets_additional_criteria($additional_criteria, $event_data));
    }
}
