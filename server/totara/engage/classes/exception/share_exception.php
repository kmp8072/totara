<?php
/**
 * This file is part of Totara Learn
 *
 * Copyright (C) 2020 onwards Totara Learning Solutions LTD
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
 * @author Johannes Cilliers <johannes.cilliers@totaralearning.com>
 * @package totara_engage
 */
namespace totara_engage\exception;

final class share_exception extends \moodle_exception {
    /**
     * share_exception constructor.
     *
     * @param string                    $errorcode
     * @param string                    $module
     * @param null|\stdClass|array      $a
     * @param null|array|\stdClass      $debuginfo
     */
    public function __construct(string $errorcode, string $module, $a = null, $debuginfo = null) {
        parent::__construct($errorcode, $module, '', $a, $debuginfo);
    }
}