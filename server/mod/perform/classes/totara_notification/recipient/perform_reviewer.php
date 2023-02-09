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
 * @author Matthias Bonk <matthias.bonk@totaralearning.com>
 * @package mod_perform
 */

namespace mod_perform\totara_notification\recipient;

use mod_perform\constants;

/**
 * Class perform_reviewer
 *
 * Recipients are all participants that have the perform_reviewer relationship in the given subject instance.
 *
 * @package mod_perform\recipient
 */
class perform_reviewer extends participant_relationship_recipient {

    protected static function get_relationship_idnumber(): string {
        return constants::RELATIONSHIP_REVIEWER;
    }

    public static function get_name(): string {
        return get_string('notification_participant_relationship_recipient_reviewer', 'mod_perform');
    }
}