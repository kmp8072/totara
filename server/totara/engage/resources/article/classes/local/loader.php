<?php
/**
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
 * @author Kian Nguyen <kian.nguyen@totaralearning.com>
 * @package engage_article
 */
namespace engage_article\local;

use core\orm\paginator;
use core\orm\query\builder;
use engage_article\totara_engage\resource\article;
use totara_engage\entity\engage_resource;
use engage_article\entity\article as entity;

final class loader {
    /**
     * loader constructor.
     */
    private function __construct() {
        // Prevent the construction.
    }

    /**
     * @param int $userid
     * @param int $page     Setting $page to zero means that it will query all the record.
     *
     * @return paginator
     */
    public static function load_all_article_of_user(int $userid, int $page = 1): paginator {
        $builder = builder::table(engage_resource::TABLE, 'er');
        $builder->join([entity::TABLE, 'a'], 'er.instanceid', 'a.id');

        $builder->where('er.resourcetype', article::get_resource_type());
        $builder->where('er.userid', $userid);
        $builder->results_as_arrays();

        $builder->select(
            [
                // Resource fields.
                'er.id',
                'er.instanceid',
                'er.name',
                'er.resourcetype',
                'er.userid',
                'er.access',
                'er.timecreated',
                'er.timemodified',
                'er.extra',
                'er.contextid',

                // Article fields.
                'a.content',
                'a.format'
            ]
        );

        $builder->map_to(
            function (array $record) {
                $resource = engage_resource::from_record($record);

                $entity = new entity();
                $entity->id = $resource->instanceid;
                $entity->content = $record['content'];
                $entity->format = $record['format'];

                return article::from_entity($entity, $resource);
            }
        );

        return $builder->paginate($page);
    }
}