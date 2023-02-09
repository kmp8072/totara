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
 * @author Tatsuhiro Kirihara <tatsuhiro.kirihara@totaralearning.com>
 * @package totara_msteams
 */

namespace totara_msteams\check\checks;

defined('MOODLE_INTERNAL') || die;

use moodle_url;
use totara_msteams\check\checkable;
use totara_msteams\check\status;

/**
 * Check allowframembedding.
 */
class admin_frame implements checkable {
    /**
     * @var string
     */
    protected $result = '';

    public function get_name(): string {
        return get_string('allowframembedding', 'admin');
    }

    public function get_config_name(): ?string {
        return 'allowframembedding';
    }

    public function get_helplink(): ?moodle_url {
        return null;
    }

    public function check(): int {
        global $CFG;
        // NOTE: this is not 'allowframeembedding'.
        if (empty($CFG->allowframembedding)) {
            $this->result = get_string('check:notticked', 'totara_msteams', get_string('allowframembedding', 'admin'));
            return status::FAILED;
        }
        return status::PASS;
    }

    public function get_report(): string {
        return $this->result;
    }
}
