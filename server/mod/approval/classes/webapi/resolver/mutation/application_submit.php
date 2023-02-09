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

use core\entity\user;
use core\orm\query\builder;
use core\webapi\execution_context;
use core\webapi\middleware\require_advanced_feature;
use core\webapi\middleware\require_authenticated_user;
use core\webapi\mutation_resolver;
use invalid_parameter_exception;
use mod_approval\exception\access_denied_exception;
use mod_approval\exception\model_exception;
use mod_approval\model\application\action\submit;
use mod_approval\model\application\application;
use mod_approval\model\application\application_submission;
use mod_approval\model\assignment\assignment;
use mod_approval\model\form\form_data;
use mod_approval\model\workflow\stage_type\form_submission;
use mod_approval\webapi\middleware\require_assignment;

/**
 * Marks the current draft submission as submitted and transitions to the next state.
 *
 * application_submit mutation.
 */
final class application_submit extends mutation_resolver {

    /**
     * @inheritDoc
     */
    public static function resolve(array $args, execution_context $ec): array {
        $input = $args['input'];
        /** @var application $application */
        $application = $args['application'];
        /** @var assignment $assignment */
        $assignment = $args['assignment'];

        $user = user::logged_in();

        if (!$application->get_interactor($user->id)->can_edit()) {
            throw access_denied_exception::submission();
        }

        // Check that the application is in the right state to submit.
        if (!$application->current_state->is_stage_type(form_submission::get_code())) {
            throw new model_exception("Can't submit because application is in the wrong state");
        }

        if (empty($input['form_data'])) {
            throw new invalid_parameter_exception('form_data is required');
        }

        // We don't need to check the form data because submit_with_transition will fail if it is not valid.
        $form_data = form_data::from_json($input['form_data']);
        builder::get_db()->transaction(function () use ($application, $user, $form_data) {
            $submission = application_submission::create_or_update($application, $user->id, $form_data);
            $submission->publish($user->id);
            submit::execute($application, $user->id);
        });

        // reload the instance to wash out application->submissions.
        $application = application::load_by_id($application->id);

        if (!$ec->has_relevant_context()) {
            $ec->set_relevant_context($assignment->get_context());
        }
        return ['application' => $application];
    }

    /**
     * @inheritDoc
     */
    public static function get_middleware(): array {
        return [
            new require_advanced_feature('approval_workflows'),
            new require_authenticated_user(),
            require_assignment::by_input_application_id(),
        ];
    }
}
