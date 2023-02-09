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
 * @author Kian Nguyen <kian.nguyen@totaralearning.com>
 * @package totara_reportedcontent
 */
namespace totara_reportedcontent;

use totara_reportedcontent\loader\review_loader;

/**
 * Public API for the plugin.
 */
final class reported_content_helper {
    /**
     * reported_content_helper constructor.
     */
    private function __construct() {
        // Preventing this class from construction
    }

    /**
     * Note that this function will not run thru any capabilities check.
     *
     * @param int       $item_id
     * @param string    $component
     * @param string    $area
     * @param int       $context_id
     *
     * @return void
     */
    public static function purge_area_review(int $item_id, string $component, string $area,
                                             int $context_id): void {
        $paginator = review_loader::get_paginator($item_id, $context_id, $component, $area, 0);
        $reviews = $paginator->get_items()->all();

        /** @var review $review */
        foreach ($reviews as $review) {
            $review->delete();
        }
    }
}