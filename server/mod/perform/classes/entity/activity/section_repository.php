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
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Jaron Steenson <jaron.steenson@totaralearning.com>
 * @package mod_perform
 */

namespace mod_perform\entity\activity;

use core\orm\entity\repository;

class section_repository extends repository {

    /**
     * Find the first section for a given subject instance.
     *
     * @param int $subject_instance_id
     * @return section|null
     */
    public function find_first_for_subject_instance(int $subject_instance_id): ?section {
        return $this->as('s')
            ->select_raw('distinct s.*')
            ->join([participant_section::TABLE, 'ps'], 'ps.section_id', 's.id')
            ->join([participant_instance::TABLE, 'pi'], 'ps.participant_instance_id', 'pi.id')
            ->where('pi.subject_instance_id', $subject_instance_id)
            ->order_by('s.sort_order')
            ->first();
    }

}