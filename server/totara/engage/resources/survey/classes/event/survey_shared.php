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
 * @package engage_survey
 */

namespace engage_survey\event;

use core\event\base;
use engage_survey\entity\survey as survey_entity;
use totara_engage\share\share as share_model;

final class survey_shared extends base {
    /**
     * @return void
     */
    protected function init(): void {
        $this->data['objecttable'] = survey_entity::TABLE;
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Create an event for a share recipient.
     *
     * @param share_model $share
     * @param int|null $actorid
     * @return base
     */
    public static function from_share(share_model $share, int $actorid = null): survey_shared {
        global $USER;

        if (null == $actorid) {
            $actorid = $USER->id;
        }

        $context = \context_user::instance($share->get_sharer_id());

        $data = [
            'objectid' => $share->get_recipient_id(),
            'context' => $context,
            'userid' => $actorid,
        ];

        /** @var survey_shared $event */
        $event = static::create($data);
        return $event;
    }

    /**
     * @return string
     */
    public static function get_name() {
        return get_string('surveyshared', 'engage_survey');
    }
}