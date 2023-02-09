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
 * @author Qingyang Liu <qingyang.liu@totaralearning.com>
 * @package engage_article
 */
defined('MOODLE_INTERNAL') || die();

use totara_userdata\userdata\target_user;

class totara_engage_userdata_article_testcase extends advanced_testcase {
    /**
     * @throws coding_exception
     */
    public function test_purge_article(): void {
        global $DB;

        $gen = $this->getDataGenerator();
        $user_one = $gen->create_user();
        $user_two = $gen->create_user();
        $this->setUser($user_one);

        /** @var \engage_article\testing\generator $articlegen */
        $articlegen = $gen->get_plugin_generator('engage_article');

        $articlegen->create_article(['name' => 'article1']);
        $articlegen->create_article(['name' => 'article2']);
        $articlegen->create_article(['name' => 'article3']);

        $this->setUser($user_two);
        $articlegen->create_article(['name' => 'article from other user']);

        // Artcile created
        $this->assertTrue(
            $DB->record_exists('engage_resource', ['userid' => $user_one->id, 'resourcetype' => 'engage_article'])
        );

        $this->assertTrue(
            $DB->record_exists('engage_resource', ['userid' => $user_two->id, 'resourcetype' => 'engage_article'])
        );

        $user_one->deleted = 1;
        $DB->update_record('user', $user_one);

        $target_user = new target_user($user_one);
        $context = context_system::instance();

        $result = \engage_article\userdata\article::execute_purge($target_user, $context);
        $this->assertEquals(\engage_article\userdata\article::RESULT_STATUS_SUCCESS, $result);

        $this->assertFalse(
            $DB->record_exists('engage_resource', ['resourcetype' => 'engage_article', 'userid' => $user_one->id])
        );
        $this->assertTrue(
            $DB->record_exists('engage_resource', ['resourcetype' => 'engage_article', 'userid' => $user_two->id])
        );
        $this->assertCount(1, $DB->get_records('engage_resource'));
    }

    /**
     * @return void
     */
    public function test_export_article(): void {
        global $DB;

        $gen = $this->getDataGenerator();
        $user_one = $gen->create_user();
        $this->setUser($user_one);

        /** @var \engage_article\testing\generator $articlegen */
        $articlegen = $gen->get_plugin_generator('engage_article');

        $articlegen->create_article(['name' => 'article1']);
        $articlegen->create_article(['name' => 'article2']);
        $articlegen->create_article(['name' => 'article3']);

        // Artcile created
        $this->assertTrue(
            $DB->record_exists('engage_resource', ['userid' => $user_one->id, 'resourcetype' => 'engage_article'])
        );

        $target_user = new target_user($user_one);
        $context = context_system::instance();

        $export = \engage_article\userdata\article::execute_export($target_user, $context);

        $this->assertNotEmpty($export->data);
        $this->assertCount(3, $export->data);

        foreach ($export->data as $record) {
            $this->assertIsArray($record);
            $this->assertArrayHasKey('name', $record);
            $this->assertArrayHasKey('content', $record);
            $this->assertArrayHasKey('timecreated', $record);
            $this->assertArrayHasKey('timemodified', $record);
        }
    }
}