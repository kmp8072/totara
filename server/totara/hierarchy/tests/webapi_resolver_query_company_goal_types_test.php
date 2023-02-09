<?php
/*
 * This file is part of Totara Learn
 *
 * Copyright (C) 2022 onwards Totara Learning Solutions LTD
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
 * @author Matthias Bonk <matthias.bonk@totaralearning.com>
 * @package totara_hierarchy
 */

use core\orm\query\builder;
use core_phpunit\testcase;
use totara_core\advanced_feature;
use totara_core\feature_not_available_exception;
use totara_webapi\phpunit\webapi_phpunit_helper;

/**
 * Tests the totara_hierarchy_goal_assignment_types resolver.
 *
 * @group totara_hierarchy
 * @group totara_goal
 */
class totara_hierarchy_webapi_resolver_query_company_goal_types_testcase extends testcase {
    private const QUERY = 'totara_hierarchy_company_goal_types';

    use webapi_phpunit_helper;

    public function test_require_login(): void {
        self::setUser(null);

        $this->expectException(require_login_exception::class);
        $this->resolve_graphql_query(self::QUERY, []);
    }

    public function test_require_advanced_feature_goals() {
        self::setAdminUser();

        advanced_feature::disable('goals');

        $this->expectException(feature_not_available_exception::class);
        $this->resolve_graphql_query(self::QUERY, []);
    }

    public function test_empty_result(): void {
        self::setAdminUser();

        $actual_types = $this->resolve_graphql_query(self::QUERY, []);

        self::assertEquals([], $actual_types['items']);
    }

    public function test_result(): void {
        self::setAdminUser();

        /** @var \totara_hierarchy\testing\generator $hierarchy_generator */
        $hierarchy_generator = self::getDataGenerator()->get_plugin_generator('totara_hierarchy');
        $type1_data = [
            'idnumber' => 'type-1',
            'shortname' => 'TYPE1',
            'fullname' => 'Type One',
        ];
        $type1_id = $hierarchy_generator->create_goal_type($type1_data);
        // Create company goal with goal type 1
        $fw_id = $hierarchy_generator->create_goal_frame(['name' => 'fw'])->id;
        $hierarchy_generator->create_goal([
            'fullname' => 'goal1',
            'frameworkid' => $fw_id,
            'typeid' => $type1_id
        ]);

        $type2_data = [
            'idnumber' => 'type-2',
            'shortname' => 'TYPE2',
            'fullname' => 'Type Two',
        ];
        $type2_id = $hierarchy_generator->create_goal_type($type2_data);

        $expected_types[$type1_id] = $type1_data;
        $expected_types[$type2_id] = $type2_data;

        $actual_types = $this->resolve_graphql_query(self::QUERY, [])['items'];
        self::assertCount(1, $actual_types);
        foreach ($actual_types as $actual_type) {
            self::assertEqualsCanonicalizing($expected_types[$actual_type->id], [
                $actual_type->idnumber,
                $actual_type->shortname,
                $actual_type->fullname,
            ]);
        }
    }
}
