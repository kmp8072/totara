<?php
/*
 *  This file is part of Totara TXP
 *
 *  Copyright (C) 2022 onwards Totara Learning Solutions LTD
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  @author Simon Coggins <simon.coggins@totaralearning.com>
 *
 */

namespace totara_api\controllers\client;

use totara_core\advanced_feature;
use totara_mvc\tui_view;

class manage_clients extends base_clients {
    /**
     * @var string
     */
    public const URL =  '/totara/api/client/index.php';

    /**
     * @return tui_view
     */
    public function action(): tui_view {
        advanced_feature::require('api');

        return tui_view::create('totara_api/pages/Clients', $this->get_tui_props());
    }
}