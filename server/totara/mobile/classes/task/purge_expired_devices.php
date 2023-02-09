<?php
/*
 * This file is part of Totara Learn
 *
 * Copyright (C) 2019 onwards Totara Learning Solutions LTD
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
 * @author Chris Snyder <chris.snyder@totaralearning.com>
 * @package totara_mobile
 */

namespace totara_mobile\task;

/**
 * Purge expired mobile device registrations depending on 'totara_mobile | timeout' setting
 *
 */
final class purge_expired_devices extends \core\task\scheduled_task {
    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskpurgeexpireddevices', 'totara_mobile');
    }

    /**
     * Execute task.
     */
    public function execute() {
        global $DB;

        $max_age_days = get_config('totara_mobile', 'timeout');
        if (empty($max_age_days)) {
            return;
        }
        $max_age_secs = $max_age_days * DAYSECS;

        $select = $DB->sql('timeregistered < :stale', ['stale' => time() - $max_age_secs]);
        $DB->delete_records_select('totara_mobile_devices', $select);
    }
}

