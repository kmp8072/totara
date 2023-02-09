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
 * @author Nathan Lewis <nathan.lewis@totaralearning.com>
 * @package mod_facetoface
 */
namespace mod_facetoface\totara_notification\notification;

use lang_string;
use mod_facetoface\signup\state\booked;
use mod_facetoface\totara_notification\resolver\booking_event_start_date;
use totara_notification\notification\abstraction\additional_criteria_notification;
use totara_notification\notification\built_in_notification;
use totara_notification\recipient\manager;
use totara_notification\schedule\schedule_before_event;

final class booking_event_start_date_for_manager extends built_in_notification implements additional_criteria_notification {
    /**
     * @return string
     */
    public static function get_resolver_class_name(): string {
        return booking_event_start_date::class;
    }

    /**
     * @return string
     */
    public static function get_title(): string {
        return get_string('notification_booking_event_start_date_for_manager_title', 'mod_facetoface');
    }

    /**
     * @return string
     */
    public static function get_recipient_class_name(): string {
        return manager::class;
    }

    /**
     * @return lang_string
     */
    public static function get_default_body(): lang_string {
        return new lang_string('notification_booking_event_start_date_for_manager_body', 'mod_facetoface');
    }

    /**
     * @return lang_string
     */
    public static function get_default_subject(): lang_string {
        return new lang_string('notification_booking_event_start_date_for_manager_subject', 'mod_facetoface');
    }

    /**
     * Default reminder notifications will send to "booked" users/managers.
     * @return string json encoded
     */
    public static function get_default_additional_criteria(): string {
        return '{"recipients":["status_booked"]}';
    }


    /**
     * @return int
     */
    public static function get_default_schedule_offset(): int {
        // Defaults to 2 days before seminar event.
        return schedule_before_event::default_value(2);
    }
}
