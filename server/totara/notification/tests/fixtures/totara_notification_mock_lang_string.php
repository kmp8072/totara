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
 * @author  Kian Nguyen <kian.nguyen@totaralearning.com>
 * @package totara_notification
 */

class totara_notification_mock_lang_string extends lang_string {
    /**
     * @var string
     */
    private $text;

    /**
     * totara_notification_mock_lang_string constructor.
     * @param string $you_are_saying
     */
    public function __construct(string $you_are_saying) {
        parent::__construct('notification_subject_placeholder_group', 'totara_program');
        $this->text = $you_are_saying;
    }

    /**
     * @param string|null $lang
     * @return string
     */
    public function out($lang = null): string {
        return $this->text;
    }

    /**
     * @return string
     */
    public function get_string(): string {
        return $this->text;
    }
}