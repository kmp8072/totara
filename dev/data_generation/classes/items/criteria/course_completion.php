<?php
/*
 * This file is part of Totara Learn
 *
 * Copyright (C) 2019 onwards Totara Learning Solutions LTD
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
 * @author Aleksandr Baishev <aleksandr.baishev@totaralearning.com>
 * @package totara_competency
 */

namespace degeneration\items\criteria;

use degeneration\items\course;
use Exception;
use totara_criteria\criterion as criterion_model;

class course_completion extends criterion {

    /**
     * Array of courses to add to create a course completion criterion
     *
     * @var course[]
     */
    protected $courses = [];

    /**
     * Default aggregation method
     *
     * @var int
     */
    protected $aggregation_method = criterion_model::AGGREGATE_ALL;

    /**
     * Default aggregation required items
     *
     * @var int
     */
    protected $aggregation_required_items = 1;

    /**
     * Add course to be saved with this course completion criterion
     *
     * @param course $course
     * @return $this
     */
    public function add_course(course $course) {
        $this->courses[] = $course;

        return $this;
    }

    /**
     * Set aggregation method
     *
     * @param int $method
     * @return $this
     */
    public function set_aggregation_method(int $method) {
        $this->aggregation_method = $method;

        return $this;
    }

    /**
     * Set aggregation required items
     *
     * @param int $items
     * @return $this
     */
    public function set_required_items(int $items) {
        $this->aggregation_required_items = $items;

        return $this;
    }

    /**
     * Get list of properties to be added to the generated item
     *
     * @return array
     */
    public function get_properties(): array {

        $course_ids = array_map(function (course $course) {
            return $course->get_data('id');
        }, $this->courses);

        return [
            'courseids' => $course_ids,
            'aggregation' => [
                'method' => $this->aggregation_method,
                'req_items' => $this->aggregation_required_items,
            ]
        ];
    }

    /**
     * Check prerequisites for creating a course completion
     *
     * @return $this
     */
    public function check_prerequisites() {
        if (empty($this->courses)) {
            throw new Exception('You must specify at least one course to create a course completion criterion');
        }

        return parent::check_prerequisites();
    }

    /**
     * Get criterion type
     *
     * @return string
     */
    public function get_type(): string {
        return 'coursecompletion';
    }
}
