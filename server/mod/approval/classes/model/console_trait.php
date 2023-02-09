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
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Chris Snyder <chris.snyder@totaralearning.com>
 * @package mod_approval
 */

namespace mod_approval\model;

/**
 * A trait for adding a console to any class, so that it can report what it is doing.
 */
trait console_trait {

    /** @var bool */
    public static $cli_mode = false;

    /** @var bool */
    public static $logging_enabled = false;

    /** @var array */
    private static $console = [];

    /**
     * Log informational and debugging messages, and/or write them to stdout.
     *
     * @param string $message
     */
    private static function log(string $message): void {
        if (static::$logging_enabled) {
            self::$console[] = basename(static::class) . ': ' . $message;
        }
        if (static::$cli_mode) {
            cli_writeln($message);
        }
    }

    /**
     * Get contents of console, separated by newlines.
     *
     * @return string
     */
    public static function get_console(): string {
        return implode("\n", self::$console);
    }
}