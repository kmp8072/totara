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
 * @author Kunle Odusan <kunle.odusan@totaralearning.com>
 */

use core_course\local\archive_progress_helper\output\validator\completed_users;
use core_phpunit\testcase;

/**
 * @covers \core_course\local\archive_progress_helper\output\validator\completed_users
 */
class core_course_archive_progress_helper_output_validator_completed_users_testcase extends testcase {

    public function test_generate_secret() {
        $course = $this->getDataGenerator()->create_course();
        $instance = new completed_users($course);
        $secret = sha1(sprintf('%s-%s', $course->id, $course->timemodified));
        $this->assertEquals($secret, $instance->generate_secret());
    }
}