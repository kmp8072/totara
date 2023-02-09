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
 * @package core_orm
 */

namespace core\orm\entity\relations;

use core\orm\collection;
use core\orm\entity\entity;
use core\orm\query\builder;
use core\orm\query\field;

/**
 * Class has_many
 *
 * Represents one to many relationship between entities
 */
class has_many extends relation {

    /**
     * Allow saving child models
     *
     * @var bool
     */
    protected $can_save = true;

    /**
     * This method should apply necessary constraints when loading a relation for a single entity
     *
     * @return void
     */
    public function constraints_for_entity() {
        if (!$this->entity->exists()) {
            $this->repo->where_raw('1 = 2');
            return;
        }

        $this->repo->where(
            $this->get_foreign_key(),
            $this->entity->get_attribute($this->get_key())
        );
    }

    /**
     * Apply constraints for loading relation for collection of items and map them back to the collection.
     *
     * @param string $name
     * @param collection $collection
     * @return void
     */
    public function load_for_collection(string $name, collection $collection) {
        $keys = $this->get_keys_from_collection($collection);

        // Chunk this to avoid too many value for IN condition
        $keys_chunked = array_chunk($keys, builder::get_db()->get_max_in_params());

        // Group the result so that we can get the related results quicker
        $grouped = [];

        $field = new field($this->get_foreign_key(), $this->repo->get_builder());
        $field->set_identifier('has_many_foreign_key');

        foreach ($keys_chunked as $keys) {
            // Load possible values
            $results = $this->repo
                ->remove_where($field)
                ->where($field, $keys)
                ->get();

            foreach ($results as $result) {
                $grouped[$result->{$this->get_foreign_key()}][$result->id] = $result;
            }
        }

        // No need to proceed
        if (empty($grouped)) {
            return;
        }

        // Now iterate over original collection and append the results there
        $collection->map(
            function (entity $item) use ($grouped, $name) {
                if ($item->exists()) {
                    $item->relate($name, new collection($grouped[$item->{$this->get_key()}] ?? []));
                }

                return $item;
            }
        );
    }

}
