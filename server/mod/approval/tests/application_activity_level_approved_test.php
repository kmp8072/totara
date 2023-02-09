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
 * @author Angela Kuznetsova <angela.kuznetsova@totaralearning.com>
 * @package mod_approval
 */

use core\entity\user;
use mod_approval\event\level_approved as level_approved_event;
use mod_approval\model\application\action\submit;
use mod_approval\model\application\activity\level_approved;
use mod_approval\model\application\application_submission;
use mod_approval\model\form\form_data;

require_once(__DIR__ . '/testcase.php');

/**
 * @group approval_workflow
 * @coversDefaultClass mod_approval\model\application\activity\level_approved
 */
class mod_approval_application_activity_level_approved_testcase extends mod_approval_testcase {
    /**
     * @covers ::get_type
     */
    public function test_get_type(): void {
        $this->assertEquals(13, level_approved::get_type());
    }

    /**
     * @covers ::trigger_event
     */
    public function test_trigger_event(): void {
        $submitter_user = new user($this->getDataGenerator()->create_user());
        $approver_user = new user($this->getDataGenerator()->create_user());

        // Create application.
        $this->setAdminUser();
        $application = $this->create_application_for_user();

        // Submit the application.
        $submission = application_submission::create_or_update(
            $application,
            $submitter_user->id,
            form_data::from_json('{"kia":"kaha"}')
        );
        $submission->publish($submitter_user->id);
        submit::execute($application, $submitter_user->id);

        // Enable the event sink.
        $sink = $this->redirectEvents();

        // Trigger the event for user1 and application1.
        level_approved::trigger_event($application, $approver_user->id, []);

        // Collect any events triggered.
        $events = $sink->get_events();
        $sink->close();

        // Refresh application.
        $application->refresh(true);

        // Check that the expected event fired.
        $this->assertCount(1, $events);
        $this->assertInstanceOf(level_approved_event::class, $events[0]);
        $this->assertEquals($application->id, $events[0]->objectid);
        $this->assertEquals('stage 2', $events[0]->other['workflow_stage_name']);
        $this->assertEquals('Level 1', $events[0]->other['approval_level_name']);
    }
}
