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
 * @author Tatsuhiro Kirihara <tatsuhiro.kirihara@totaralearning.com>
 * @package totara_msteams
 */

namespace totara_msteams\botfw\entity;

use core\orm\entity\entity;
use totara_msteams\botfw\account\channel_account;
use totara_msteams\botfw\repository\bot_repository;

/**
 * @property integer $id
 * @property string  $bot_id        ms teams bot id
 * @property string  $bot_name      ms teams bot name
 * @property string  $service_url   ms teams bot service url
 * @method static bot_repository repository()
 */
class bot extends entity {
    public const TABLE = 'totara_msteams_bot';

    /**
     * @return channel_account
     */
    public function to_account(): channel_account {
        $account = new channel_account();
        $account->id = $this->bot_id;
        if (isset($this->bot_name)) {
            $account->name = $this->bot_name;
        }
        return $account;
    }

    /**
     * @return string
     */
    public static function repository_class_name(): string {
        return bot_repository::class;
    }
}
