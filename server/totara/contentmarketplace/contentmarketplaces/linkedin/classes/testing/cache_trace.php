<?php
/**
 * This file is part of Totara Core
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
 * @package contentmarketplace_linkedin
 */
namespace contentmarketplace_linkedin\testing;

use progress_trace;

class cache_trace extends progress_trace {
    /**
     * @var string[]
     */
    private $messages;

    /**
     * cache_trace constructor.
     */
    public function __construct() {
        $this->messages = [];
    }

    /**
     * @param string $message
     * @param int $depth
     */
    public function output($message, $depth = 0) {
        $this->messages[] = $message;
    }

    /**
     * @return string[]
     */
    public function get_messages(): array {
        return $this->messages;
    }
}