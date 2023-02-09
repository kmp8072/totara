<?php
/*
 * This file is part of Totara Perform
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
 * @author Oleg Demeshev <oleg.demeshev@totaralearning.com>
 * @package performelement_multi_choice_multi
 */

namespace performelement_multi_choice_multi;

use mod_perform\models\response\element_validation_error;

class option_required_error extends element_validation_error {

    public const OPTION_REQUIRED = 'OPTION_REQUIRED';

    public function __construct() {
        $error_code = self::OPTION_REQUIRED;
        $error_message = get_string('error_answer_required', 'performelement_multi_choice_multi');

        parent::__construct($error_code, $error_message);
    }
}