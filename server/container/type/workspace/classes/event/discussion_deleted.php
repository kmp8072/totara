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
 * @author Kian Nguyen <kian.nguyen@totaralearning.com>
 * @package container_workspace
 */
namespace container_workspace\event;

use container_workspace\discussion\discussion;
use core\event\base;

/**
 * Event for discussion deleted.
 */
final class discussion_deleted extends base {
    /**
     * @return void
     */
    protected function init(): void {
        $this->data['crud'] = 'd';
        $this->data['objecttable'] = 'workspace_discussion';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * @return string
     */
    public static function get_name() {
        return get_string('discussion_deleted', 'container_workspace');
    }

    /**
     * @param discussion $discussion
     * @param int|null   $actor_id
     *
     * @return discussion_deleted
     */
    public static function from_discussion(discussion $discussion, ?int $actor_id = null): discussion_deleted {
        $workspace_id = $discussion->get_workspace_id();

        $data = [
            'objectid' => $discussion->get_id(),
            'userid' => $actor_id,
            'courseid' => $workspace_id,
            'relateduserid' => $discussion->get_user_id(),
            'context' => \context_course::instance($workspace_id)
        ];

        /** @var discussion_deleted $event */
        $event = static::create($data);
        return $event;
    }
}