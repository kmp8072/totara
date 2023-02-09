<?php
/*
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
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Jaron Steenson <jaron.steenson@totaralearning.com>
 * @package mod_perform
 */

namespace mod_perform\formatter\response;

use core\orm\formatter\entity_model_formatter;

/**
 * Class section_element_response
 *
 * @package mod_perform\formatter\response
 * @property view_only_section_element_response object
 */
class view_only_section_element_response extends entity_model_formatter {

    protected function get_map(): array {
        return [
            'section_element_id' => null,
            'element' => null,
            'sort_order' => null,
            'other_responder_groups' => null,
        ];
    }

}