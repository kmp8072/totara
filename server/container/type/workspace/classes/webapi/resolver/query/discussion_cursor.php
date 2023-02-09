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
namespace container_workspace\webapi\resolver\query;

use container_workspace\loader\discussion\loader;
use container_workspace\query\discussion\query;
use container_workspace\query\discussion\sort;
use core\orm\pagination\offset_cursor_paginator;
use core\pagination\offset_cursor;
use core\webapi\execution_context;
use core\webapi\middleware\require_advanced_feature;
use core\webapi\middleware\require_login;
use core\webapi\query_resolver;
use core_container\factory;
use container_workspace\workspace;
use container_workspace\interactor\workspace\interactor as workspace_interactor;

/**
 * Query to fetch the cursor for discussion
 */
class discussion_cursor extends query_resolver {
    /**
     * @param array $args
     * @param execution_context $ec
     *
     * @return offset_cursor_paginator
     */
    public static function resolve(array $args, execution_context $ec): offset_cursor_paginator {
        /** @var workspace $workspace */
        $workspace = factory::from_id($args['workspace_id']);

        if (!$ec->has_relevant_context()) {
            $ec->set_relevant_context($workspace->get_context());
        }

        if (!$workspace->is_typeof(workspace::get_type())) {
            throw new \coding_exception("Cannot count the discussions from a container that is not a workspace");
        }

        $workspace_interactor = new workspace_interactor($workspace);
        if (!$workspace_interactor->can_view_discussions()) {
            throw new \coding_exception("Cannot get the discussion's cursor");
        }

        $query = new query($workspace->get_id());

        if (isset($args['cursor'])) {
            $cursor = offset_cursor::decode($args['cursor']);
            $query->set_cursor($cursor);
        }

        if (isset($args['search_term'])) {
            $query->set_search_term($args['search_term']);
        }

        if (isset($args['sort'])) {
            $sort_value = sort::get_value($args['sort']);
            $query->set_sort($sort_value);
        }

        if (isset($args['pinned'])) {
            $query->set_pinned($args['pinned']);
        }

        return loader::get_discussions($query);
    }

    /**
     * @inheritDoc
     */
    public static function get_middleware(): array {
        return [
            new require_login(),
            new require_advanced_feature('container_workspace'),
        ];
    }

}