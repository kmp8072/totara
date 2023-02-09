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
 * @author Cody Finegan <cody.finegan@totaralearning.com>
 * @package block_totara_recommendations
 */

use block_totara_recommendations\observer\trending_observer;

defined('MOODLE_INTERNAL') || die();

$observers = [
    [
        'eventname' => '\totara_playlist\event\playlist_deleted',
        'callback'  => [trending_observer::class, 'watch_delete'],
    ],
    [
        'eventname' => '\engage_article\event\article_deleted',
        'callback'  => [trending_observer::class, 'watch_delete'],
    ],
    [
        'eventname' => '\engage_survey\event\survey_deleted',
        'callback'  => [trending_observer::class, 'watch_delete'],
    ],
];