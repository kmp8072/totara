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
 * @author Tatsuhiro Kirihara <tatsuhiro.kirihara@totaralearning.com>
 * @package mod_approval
 */

namespace mod_approval\webapi\resolver\mutation;

use core\entity\user as user_entity;
use core\webapi\execution_context;
use core\webapi\middleware\require_advanced_feature;
use core\webapi\middleware\require_authenticated_user;
use core\webapi\mutation_resolver;
use dml_write_exception;
use mod_approval\exception\access_denied_exception;
use mod_approval\model\workflow\workflow;
use mod_approval\webapi\middleware\require_workflow;

/**
 * workflow_archive mutation.
 */
final class workflow_archive extends mutation_resolver {

    /**
     * @inheritDoc
     */
    public static function resolve(array $args, execution_context $ec) {
        $actor = user_entity::logged_in();

        /** @var workflow $workflow */
        $workflow = $args['workflow'];
        if (!$workflow->get_interactor($actor->id)->can_archive()) {
            throw access_denied_exception::workflow('Cannot archive workflow');
        }
        $workflow->archive();
        return ['workflow' => $workflow];
    }

    /**
     * @inheritDoc
     */
    public static function get_middleware(): array {
        return [
            new require_advanced_feature('approval_workflows'),
            new require_authenticated_user(),
            require_workflow::by_input_workflow_id(true)
        ];
    }
}
