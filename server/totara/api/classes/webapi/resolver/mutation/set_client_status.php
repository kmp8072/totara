<?php
/**
 * This file is part of Totara Core
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
 * @author Qingyang Liu <qingyang.liu@totaralearning.com>
 * @package totara_api
 */

namespace totara_api\webapi\resolver\mutation;

use coding_exception;
use core\webapi\execution_context;
use core\webapi\middleware\require_advanced_feature;
use core\webapi\middleware\require_authenticated_user;
use core\webapi\mutation_resolver;
use totara_api\model\client;
use totara_api\webapi\middleware\require_manage_capability;

/**
 * Class set_client_status
 * @package totara_api\webapi\resolver\mutation
 */
class set_client_status extends mutation_resolver {

    /**
     *
     * @param array             $args
     * @param execution_context $ec
     * @return client
     */
    public static function resolve(array $args, execution_context $ec): client {
        $id = $args['id'];
        $client_status = $args['status'];

        if (!isset($id) || !isset($client_status)) {
            throw new coding_exception('No required parameters being passed');
        }
        $client = client::load_by_id($id);
        $client->set_client_status($client_status);

        return $client;
    }

    /**
     * @return array
     */
    public static function get_middleware(): array {
        return [
            new require_authenticated_user(),
            new require_advanced_feature('api'),
            require_manage_capability::by_client_id('id', true)
        ];
    }
}