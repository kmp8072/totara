<?php
/**
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
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Kunle Odusan <kunle.odusan@totaralearning.com>
 */

use core\webapi\execution_context;
use core_phpunit\testcase;
use mod_approval\model\workflow\stage_feature\base;
use mod_approval\model\workflow\workflow_stage;
use mod_approval\webapi\resolver\type\workflow_stage_feature;

require_once __DIR__ . '/fixtures/workflow/sample_stage_feature.php';

/**
 * @coversDefaultClass mod_approval\webapi\resolver\type\workflow_stage_feature
 *
 * @group approval_workflow
 */
class mod_approval_webapi_type_workflow_stage_feature_testcase extends testcase {

    public function test_resolves_only_stage_type() {
        $this->expectException(coding_exception::class);
        $this->expectExceptionMessage("source must be an instance of " . base::class);
        workflow_stage_feature::resolve('', new stdClass(), [], $this->createMock(execution_context::class));
    }

    public function test_resolves_fields() {
        $execution_context = $this->createMock(execution_context::class);
        $mock_stage = $this->createMock(workflow_stage::class);
        $source = new sample_stage_feature($mock_stage);

        $label = workflow_stage_feature::resolve('label', $source, [], $execution_context);
        $enum = workflow_stage_feature::resolve('enum', $source, [], $execution_context);

        $this->assertEquals(sample_stage_feature::get_label(), $label);
        $this->assertEquals(sample_stage_feature::get_enum(), $enum);
    }
}
