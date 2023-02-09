<?php
/*
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Jaron Steenson <jaron.steenson@totaralearning.com>
 * @package totara_competency
 */

namespace totara_competency\views;

use help_icon;
use totara_competency\views\filters\assignments as filters;
use totara_core\output\select_region_panel;
use totara_core\output\select_tree;

class edit_proficiency_value extends base {

    protected $title = ['edit_proficiency_value_by_assignment', 'totara_competency'];

    public function __construct(array $data = []) {
        parent::__construct('totara_competency/edit_proficiency_value', $data);
    }

    protected function create_region_panel(): select_region_panel {
        return filters::create_region_panel_for_edit_proficiency_value();
    }

    protected function prepare_output($output): array {
        $output = parent::prepare_output($output);

        $selection_basket_data = [
            'actionBtn' => [
                'action' => 'bulkEdit',
                'label' => get_string('edit_proficiency_bulk_action_label', 'totara_competency'),
            ],
            'hasToggleSelection' => true,
            'selectionHideLabel' => get_string('back', 'totara_competency'),
        ];

        $help_icon = (new help_icon('edit_proficiency_value_by_assignment', 'totara_competency'))
            ->export_for_template($this->get_renderer());

        $content_data = [
            'has_level_toggle' => false,
            'has_paging' => true,
            'has_count' => true,
            'heading' => get_string('all_assignments', 'totara_competency'),
            'order_by' => $this->create_sorting(),
            'primary_filter_tree' => filters::create_framework_filter_for_edit_proficiency(),
            'selection_basket' => $selection_basket_data,
            'save_url' => null, // Overriding parent prepare_output.
            'help_icon' => $help_icon,
        ];

        return array_merge($output, $content_data);
    }

    private function create_sorting(): select_tree {
        return select_tree::create(
            'sorting',
            get_string('sort', 'totara_competency'),
            false,
            [
                (object)[
                    'name' => get_string('sort_competency_name', 'totara_competency'),
                    'key' => 'competency_name',
                    'default' => true
                ],
                (object)[
                    'name' => get_string('sort_user_group_name', 'totara_competency'),
                    'key' => 'user_group_name',
                ],
            ],
            null,
            true,
            false,
            null,
            false
        );
    }

}
