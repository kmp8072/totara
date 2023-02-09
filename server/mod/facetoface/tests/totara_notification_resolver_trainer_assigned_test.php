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
 * @author Riana Rossouw <riana.rossouw@totaralearning.com>
 * @package mod_facetoface
 */

use core\json_editor\helper\document_helper;
use core\json_editor\node\paragraph;
use core\orm\query\builder;
use core_course\totara_notification\placeholder\activity as activity_placeholder;
use core_course\totara_notification\placeholder\course as course_placeholder;
use core_phpunit\testcase;
use core_user\totara_notification\placeholder\user as user_placeholder;
use mod_facetoface\seminar_session_list;
use mod_facetoface\testing\generator as facetoface_generator;
use mod_facetoface\totara_notification\placeholder\event as event_placeholder;
use mod_facetoface\totara_notification\recipient\trainer;
use mod_facetoface\totara_notification\resolver\trainer_assigned;
use mod_facetoface\trainer_helper;
use totara_core\extended_context;
use totara_notification\entity\notifiable_event_queue;
use totara_notification\entity\notification_queue;
use totara_notification\json_editor\node\placeholder;
use totara_notification\task\process_event_queue_task;
use totara_notification\testing\generator as notification_generator;

defined('MOODLE_INTERNAL') || die();

/**
 * @group totara_notification
 */
class mod_facetoface_totara_notification_resolver_trainer_assigned_testcase extends testcase {
    use \totara_notification\testing\notification_log_test_trait;

    private $users = [];
    private $course = null;
    private $seminar = null;
    private $seminarevent = null;
    private $roles = [];
    private $system_custom_preference = null;

    /**
     * @return void
     * @throws \coding_exception
     */
    protected function setUp(): void {
        parent::setUp();

        // We always clear all related caches before testing with them, to prevent leaks between tests.
        user_placeholder::clear_instance_cache();
        event_placeholder::clear_instance_cache();
        activity_placeholder::clear_instance_cache();
        course_placeholder::clear_instance_cache();

        // Delete built-in notifications.
        builder::table('notification_preference')->delete();

        $generator = self::getDataGenerator();

        // Create users. (Using old role names as keys for ease of use)
        $this->users['student'] = $generator->create_user(['lastname' => 'Learner lastname']);
        $this->users['editingteacher'] = $generator->create_user(['lastname' => 'Editing trainer lastname']);
        $this->users['teacher'] = $generator->create_user(['lastname' => 'Trainer lastname']);
        $roles = builder::table('role')
            ->select('id')
            ->add_select('shortname')
            ->where_in('shortname',['teacher', 'editingteacher', 'student'])
            ->fetch();
        foreach ($roles as $role) {
            $this->roles[$role->shortname] = $role->id;
        }

        // Set some Seminar event roles
        set_config('facetoface_session_roles', implode(',', array_keys($roles)));

        // Create a course.
        $this->course = $generator->create_course(['fullname' => 'The test course']);

        // Enrol users
        foreach ($this->users as $role => $user) {
            $generator->enrol_user($user->id, $this->course->id, $this->roles[$role]);
        }

        /** @var facetoface_generator $f2f_gen */
        $f2f_gen = $generator->get_plugin_generator('mod_facetoface');
        $this->seminarevent = $f2f_gen->create_session_for_course($this->course);
        $this->seminar = $this->seminarevent->get_seminar();
        $this->seminar->set_name('Seminar 1')->save();

        // Create a custom notification in system context.
        $notification_generator = notification_generator::instance();
        $this->system_custom_preference = $notification_generator->create_notification_preference(
            trainer_assigned::class,
            extended_context::make_system(),
            [
                'schedule_offset' => 0,
                'recipient' => trainer::class,
                'recipients' => [trainer::class],
                'body_format' => FORMAT_JSON_EDITOR,
                'body' => document_helper::json_encode_document(
                    document_helper::create_document_from_content_nodes([
                        paragraph::create_json_node_from_text('Trainer assigned test notification body'),
                        paragraph::create_json_node_with_content_nodes([
                            placeholder::create_node_from_key_and_label('recipient:last_name', 'Recipient last name'),
                            placeholder::create_node_from_key_and_label('trainer:last_name', 'Trainer last name'),
                            placeholder::create_node_from_key_and_label('course:full_name','Course full name'),
                            placeholder::create_node_from_key_and_label('activity:name', 'Seminar name'),
                            placeholder::create_node_from_key_and_label('event:duration','Event duration'),
                        ]),
                    ])
                ),
                'subject' => 'Test trainer assigned notification subject',
                'subject_format' => FORMAT_PLAIN,
                'additional_criteria' => '{"ical":["include_ical_attachment"]}',
            ]
        );
    }


    /**
     * @return void
     */
    public function tearDown(): void {
        user_placeholder::clear_instance_cache();

        $this->users = [];
        $this->course = null;
        $this->seminar = null;
        $this->seminarevent = null;
        $this->roles = [];
        $this->system_custom_preference = null;

        // We always clear all related caches after testing with them, to prevent leaks between tests.
        user_placeholder::clear_instance_cache();
        event_placeholder::clear_instance_cache();
        activity_placeholder::clear_instance_cache();
        course_placeholder::clear_instance_cache();

        parent::tearDown();
    }

    /**
     * @dataProvider data_provider_test_resolver
     * @param bool $site_allow_legacy
     * @param bool $use_legacy
     */
    public function test_resolver_trainer_assigned(bool $site_allow_legacy, bool $use_legacy): void {
        global $DB;

        set_config('facetoface_allow_legacy_notifications', (int)$site_allow_legacy);
        $this->seminar->set_legacy_notifications($use_legacy)
            ->save();

        // Ensure all are empty.
        $DB->delete_records('notifiable_event_queue');
        static::assertEquals(0, $DB->count_records(notifiable_event_queue::TABLE));
        static::assertEquals(0, $DB->count_records(notification_queue::TABLE));

        $event_queue_timestamps = [];
        $helper = new trainer_helper($this->seminarevent);
        foreach ($this->users as $role => $user) {
            $helper->add_trainers($this->roles[$role], [$user->id]);

            if (!$site_allow_legacy || !$use_legacy) {
                // The queue's timestamp is used in the logs to differentiate between triggered events
                // Retrieving it here to use later when checking the logs
                $event_queues = $DB->get_records(notifiable_event_queue::TABLE, ['resolver_class_name' => trainer_assigned::class], 'time_created DESC');
                $queue = reset($event_queues);
                $event_queue_timestamps[$role] = $queue->time_created;
            }

            // Sleep here to ensure each 'add trainer' event is logged separately
            self::waitForSecond();
        }

        if ($site_allow_legacy && $use_legacy) {
            self::assertEquals(0, $DB->count_records(notifiable_event_queue::TABLE));
            self::assertEquals(0, $DB->count_records(notification_queue::TABLE));
            return;
        }

        // Ensure logs are empty
        self::clear_notification_logs();

        static::assertEquals(3, $DB->count_records(notifiable_event_queue::TABLE, ['resolver_class_name' => trainer_assigned::class]));
        static::assertEquals(0, $DB->count_records(notification_queue::TABLE));

        // Redirect messages.
        $email_sink = $this->redirectEmails();
        $sink = static::redirectMessages();

        // Run tasks.
        $task = new process_event_queue_task();
        $task->execute();

        static::assertEquals(0, $DB->count_records(notifiable_event_queue::TABLE));
        static::assertEquals(0, $DB->count_records(notification_queue::TABLE));

        $messages = $sink->get_messages();
        static::assertCount(3, $messages);

        $expected_users_to = [];
        foreach ($this->users as $user) {
            $expected_users_to[] = $user->id;
        }

        $sessions = $this->seminarevent->get_sessions();
        $sessions->sort('timestart', seminar_session_list::SORT_DESC);
        $session_dates = $sessions->to_records(false);

        $event_time = empty($session_dates) ? '' : $session_dates[0]->timestart;

        $expected_logs = [];
        foreach ($messages as $idx => $message) {
            static::assertEquals('Test trainer assigned notification subject', $message->subject);
            static::assertStringContainsString('Trainer assigned test notification body', $message->fullmessage);
            static::assertStringContainsString('The test course', $message->fullmessage);
            static::assertStringContainsString('Seminar 1', $message->fullmessage);
            static::assertStringContainsString('1 min', $message->fullmessage); // Event duration
            static::assertContains($message->userto->id, $expected_users_to);

            $user_role = '';
            if (strpos($message->fullmessage, 'Trainer lastname') !== false) {
                $user_role = 'teacher';
            } else if (strpos($message->fullmessage, 'Editing trainer lastname') !== false) {
                $user_role = 'editingteacher';
            } else if (strpos($message->fullmessage, 'Learner lastname') !== false) {
                $user_role = 'student';
            } else {
                static::fail($message . " doesn't contain any of the expected assigned trainer last names");
            }

            $delivery_channels = json_decode($message->totara_notification_delivery_channels);

            $expected_logs[] = [
                'resolver_class_name' => trainer_assigned::class,
                'context_id' => $this->seminar->get_context()->id,
                'time_created' => $event_queue_timestamps[$user_role],
                'logs' => [
                    [
                        'preference_id' => $this->system_custom_preference->get_id(),
                        'recipients' => 1,
                        'channels' => count($delivery_channels),
                    ],
                ],
                'event_name' => get_string('notification_log_trainer_assigned', 'mod_facetoface', [
                    'resolver_title' => trainer_assigned::get_notification_title(),
                    'user' => fullname($this->users[$user_role]),
                    'course' => $this->course->fullname,
                    'activity' => 'Seminar 1',
                    'date' => userdate($event_time),
                ])
            ];
        }

        // Check the logs
        self::verify_notification_logs($expected_logs);
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
