<?php
/**
 * This file is part of Totara Perform
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
 * @author Gihan Hewaralalage <gihan.hewaralalage@totaralearning.com>
 * @package mod_perform
 */

namespace mod_perform\totara_notification\notification;

use lang_string;
use mod_perform\totara_notification\recipient\participant;
use mod_perform\totara_notification\resolver\participant_instance_created_resolver;
use totara_notification\notification\abstraction\additional_criteria_notification;
use totara_notification\notification\built_in_notification;
use totara_notification\schedule\schedule_after_event;

final class participant_instance_created_reminder extends built_in_notification implements additional_criteria_notification {
    /**
     * @return string
     */
    public static function get_resolver_class_name(): string {
        return participant_instance_created_resolver::class;
    }

    /**
     * @return string
     */
    public static function get_title(): string {
        return get_string('notification_instance_created_title', 'mod_perform');
    }

    /**
     * @return string
     */
    public static function get_recipient_class_name(): string {
        return participant::class;
    }

    /**
     * @return lang_string
     */
    public static function get_default_body(): lang_string {
        return new lang_string('notification_instance_created_reminder_participant_body', 'mod_perform');
    }

    /**
     * @return lang_string
     */
    public static function get_default_subject(): lang_string {
        return new lang_string('notification_instance_created_reminder_participant_subject', 'mod_perform');
    }

    /**
     * @return int
     */
    public static function get_default_schedule_offset(): int {
        // Defaults to 1 day after created.
        return schedule_after_event::default_value(1);
    }

    /**
     * @return string
     */
    public static function get_default_additional_criteria(): string {
        return '{"recipients":["manager", "managers_manager", "appraiser", "perform_peer", "perform_mentor", "perform_reviewer"]}';
    }

    /**
     * @return bool
     */
    public static function get_default_enabled(): bool {
        return false;
    }
}