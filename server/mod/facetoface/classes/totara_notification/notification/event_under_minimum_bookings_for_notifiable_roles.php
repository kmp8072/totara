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
use mod_facetoface\totara_notification\recipient\notifiable_roles;
use mod_facetoface\totara_notification\resolver\event_under_minimum_bookings;
use totara_notification\notification\built_in_notification;
use totara_notification\schedule\schedule_on_event;

final class event_under_minimum_bookings_for_notifiable_roles extends built_in_notification {
    /**
     * @return string
     */
    public static function get_resolver_class_name(): string {
        return event_under_minimum_bookings::class;
    }

    /**
     * @return string
     */
    public static function get_title(): string {
        return get_string('notification_event_under_minimum_bookings_for_notifiable_roles_title', 'mod_facetoface');
    }

    /**
     * @return string
     */
    public static function get_recipient_class_name(): string {
        return notifiable_roles::class;
    }

    /**
     * @return lang_string
     */
    public static function get_default_body(): lang_string {
        return new lang_string('notification_event_under_minimum_bookings_for_notifiable_roles_body', 'mod_facetoface');
    }

    /**
     * @return lang_string
     */
    public static function get_default_subject(): lang_string {
        return new lang_string('notification_event_under_minimum_bookings_for_notifiable_roles_subject', 'mod_facetoface');
    }

    /**
     * @return int
     */
    public static function get_default_schedule_offset(): int {
        return schedule_on_event::default_value();
    }
}