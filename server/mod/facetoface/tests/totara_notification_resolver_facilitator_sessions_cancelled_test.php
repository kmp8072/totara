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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author David Curry <david.curry@totaralearning.com>
 * @package @mod_facetoface
 */

use core\json_editor\helper\document_helper;
use core\json_editor\node\paragraph;
use core\orm\query\builder;
use core_course\totara_notification\placeholder\activity as activity_placeholder;
use core_course\totara_notification\placeholder\course as course_placeholder;
use core_phpunit\testcase;
use core_user\totara_notification\placeholder\user as user_placeholder;
use mod_facetoface\totara_notification\placeholder\event as event_placeholder;
use mod_facetoface\seminar_event;
use mod_facetoface\facilitator_user;
use mod_facetoface\seminar_event_helper;
use mod_facetoface\testing\generator as facetoface_generator;
use mod_facetoface\totara_notification\recipient\facilitator;
use mod_facetoface\totara_notification\resolver\facilitator_sessions_cancelled;
use totara_core\extended_context;
use totara_notification\entity\notification_queue;
use totara_notification\task\process_event_queue_task;
use totara_notification\testing\generator as notification_generator;
use totara_notification\entity\notifiable_event_queue;
use totara_notification\json_editor\node\placeholder;

defined('MOODLE_INTERNAL') || die();

/**
 * @group totara_notification
 */
class mod_facetoface_totara_notification_resolver_facilitator_sessions_cancelled_test extends testcase {
    use \totara_notification\testing\notification_log_test_trait;

    private $user = null;
    private $course = null;
    private $seminar_event = null;
    private $facilitator = null;
    private $start_time = null;
    private $system_custom_preference = null;

    /**
     * @return void
     */
    protected function setUp(): void {
        parent::setUp();

        // We always clear all related caches before testing with them, to prevent leaks between tests.
        user_placeholder::clear_instance_cache();
        event_placeholder::clear_instance_cache();
        course_placeholder::clear_instance_cache();
        activity_placeholder::clear_instance_cache();

        // Delete built-in notifications.
        builder::table('notification_preference')->delete();

        $gen = self::getDataGenerator();
        $f2f_gen = facetoface_generator::instance();

        // Create a base user.
        $this->user = $gen->create_user(['lastname' => 'User1 lastname']);

        // The user is a facilitator.
        $this->facilitator = new facilitator_user($f2f_gen->add_internal_facilitator([], $this->user));

        // Create courses.
        $this->course = $gen->create_course([
            'fullname' => 'Test course with completion',
            'enablecompletion' => COMPLETION_ENABLED,
        ]);

        $this->start_time = time() + DAYSECS;

        // Add an event with a session with the facilitator.
        $f2f = $f2f_gen->create_instance(['course' => $this->course->id]);
        $eventid = $f2f_gen->add_session(
            [
                'facetoface' => $f2f->id,
                'capacity' => 5,
                'sessiondates' => [
                    (object)[
                        'sessiontimezone' => '99',
                        'timestart' => $this->start_time,
                        'timefinish' => $this->start_time + HOURSECS, // One hour.
                        'roomids' => [],
                        'assetids' => [],
                        'facilitatorids' => [],
                    ],
                    (object)[
                        'sessiontimezone' => '99',
                        'timestart' => $this->start_time + 2 * HOURSECS,
                        'timefinish' => $this->start_time + 4 * HOURSECS, // Two hours.
                        'roomids' => [],
                        'assetids' => [],
                        'facilitatorids' => [$this->facilitator->get_id()],
                    ],
                ],
            ],
        );

        // Load the object.
        $this->seminar_event = new seminar_event($eventid);

        // Create a custom notification in system context.
        $notification_generator = notification_generator::instance();
        $this->system_custom_preference = $notification_generator->create_notification_preference(
            facilitator_sessions_cancelled::class,
            extended_context::make_system(),
            [
                'schedule_offset' => 0,
                'recipient' => facilitator::class,
                'recipients' => [facilitator::class],
                'body_format' => FORMAT_JSON_EDITOR,
                'body' => document_helper::json_encode_document(
                    document_helper::create_document_from_content_nodes([
                        paragraph::create_json_node_from_text('Test body'),
                        paragraph::create_json_node_with_content_nodes([
                            placeholder::create_node_from_key_and_label('recipient:first_name', 'Recipient first name'),
                            placeholder::create_node_from_key_and_label('facilitator:last_name', 'Facilitator last name'),
                            placeholder::create_node_from_key_and_label('event:all_sessions', 'Event session date(s)'),
                            placeholder::create_node_from_key_and_label('course:full_name_link', 'Course name'),
                            placeholder::create_node_from_key_and_label('activity:name_link', 'Seminar name'),
                        ]),
                    ])
                ),
                'subject' => 'Test notification subject',
                'subject_format' => FORMAT_PLAIN,
                'additional_criteria' => '{"ical":["include_ical_attachment"]}',
            ]
        );
    }

    /**
     * @return void
     */
    public function tearDown(): void {
        // We always clear all related caches after testing with them, to prevent leaks between tests.
        user_placeholder::clear_instance_cache();
        event_placeholder::clear_instance_cache();
        course_placeholder::clear_instance_cache();
        activity_placeholder::clear_instance_cache();

        $this->user = null;
        $this->course = null;
        $this->seminar_event = null;
        $this->facilitator = null;
        $this->start_time = null;
        $this->system_custom_preference = null;

        parent::tearDown();
    }

    /**
     * @dataProvider data_provider_test_resolver
     * @param bool $site_allow_legacy
     * @param bool $use_legacy
     */
    public function test_resolver(bool $site_allow_legacy, $use_legacy): void {
        global $DB;

        set_config('facetoface_allow_legacy_notifications', (int)$site_allow_legacy);
        $this->seminar_event->get_seminar()->set_legacy_notifications($use_legacy)
            ->save();

        // Ensure all are empty.
        $DB->delete_records('notifiable_event_queue');
        self::assertEquals(0, $DB->count_records(notifiable_event_queue::TABLE));
        self::assertEquals(0, $DB->count_records(notification_queue::TABLE));

        // Trigger the event
        $dates = [
            (object)[
                'sessiontimezone' => '99',
                'timestart' => $this->start_time,
                'timefinish' => $this->start_time + HOURSECS, // One hour.
                'roomids' => [],
                'assetids' => [],
                'facilitatorids' => [],
            ],
        ]; // Changed - session removed.
        seminar_event_helper::merge_sessions($this->seminar_event, $dates);

        if ($site_allow_legacy && $use_legacy) {
            self::assertEquals(0, $DB->count_records(notifiable_event_queue::TABLE));
            self::assertEquals(0, $DB->count_records(notification_queue::TABLE));
            return;
        }

        self::assertEquals(1, $DB->count_records(notifiable_event_queue::TABLE));
        self::assertEquals(0, $DB->count_records(notification_queue::TABLE));

        // Redirect messages.
        $sink = self::redirectMessages();

        $messages = $sink->get_messages();
        self::assertCount(0, $messages);

        // Run tasks.
        $task = new process_event_queue_task();
        $task->execute();

        self::assertEquals(0, $DB->count_records(notifiable_event_queue::TABLE));
        self::assertEquals(0, $DB->count_records(notification_queue::TABLE));

        $messages = $sink->get_messages();
        self::assertCount(1, $messages);

        $message = reset($messages);

        self::assertEquals('Test notification subject', $message->subject);
        self::assertStringContainsString('Test body', $message->fullmessage); // Body
        self::assertStringContainsString($this->user->firstname, $message->fullmessage); // Recipient
        self::assertStringContainsString($this->user->lastname, $message->fullmessage); // Facilitator
        self::assertStringContainsString($this->course->fullname, $message->fullmessage); // Course
        self::assertStringContainsString('1 hour', $message->fullmessage); // Event
        self::assertStringNotContainsString('2 hours', $message->fullmessage); // Event
        self::assertStringContainsString('Seminar 1', $message->fullmessage); // Seminar
        self::assertEquals($this->user->id, $message->userto->id);

        // Check the logs
        $delivery_channels = json_decode($message->totara_notification_delivery_channels);
        $event_time = $this->start_time;

        self::verify_notification_logs([
            [
                'resolver_class_name' => facilitator_sessions_cancelled::class,
                'context_id' => $this->seminar_event->get_seminar()->get_context()->id,
                'logs' => [
                    [
                        'preference_id' => $this->system_custom_preference->get_id(),
                        'recipients' => 1,
                        'channels' => count($delivery_channels),
                    ],
                ],
                'event_name' => get_string('notification_log_facilitator_sessions_cancelled', 'mod_facetoface', [
                    'resolver_title' => facilitator_sessions_cancelled::get_notification_title(),
                    'user' => 'Firstname1 User1 lastname',
                    'course' => 'Test course with completion',
                    'activity' => 'Seminar 1',
                    'date' => userdate($event_time),
                ])
            ],
        ]);
    }

    public function data_provider_test_resolver(): array {
        return [
            [true, false],
            [true, true],
            [false, false],
            [false, true],
        ];
    }
}
