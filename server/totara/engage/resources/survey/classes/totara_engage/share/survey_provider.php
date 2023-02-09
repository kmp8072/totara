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

namespace engage_survey\totara_engage\share;

use engage_survey\totara_engage\resource\survey;
use totara_engage\share\provider;
use totara_engage\share\shareable;

final class survey_provider extends provider {

    /**
     * @inheritDoc
     */
    public function get_item_instance(int $id): shareable {
        return survey::from_resource_id($id);
    }

    /**
     * @inheritDoc
     */
    public function update_access(shareable $instance, int $access, int $userid): void {
        $data = ['access' => $access];

        /** @var survey $instance */
        $instance->update($data, $userid);
    }

    /**
     * @return string
     */
    public function get_provider_type(): string {
        return 'survey';
    }
}