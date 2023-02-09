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
 * @author  Michael Ivanov <michael.ivanov@totaralearning.com>
 * @package totara_api
 */

namespace totara_api\formatter;

use core\orm\formatter\entity_model_formatter;
use core\webapi\formatter\field\string_field_formatter;
use core\webapi\formatter\field\textarea_field_formatter;

class client_formatter extends entity_model_formatter {
    /**
     * @return array
     */
    protected function get_map(): array {
        return [
            'name' => string_field_formatter::class,
            'description' => textarea_field_formatter::class,
            'tenant_id' => null,
            'oauth2_client_providers' => null,
            'id' => null,
            'status' => null,
            'service_account' => null
        ];
    }
}