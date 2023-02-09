<?php
/**
 * This file is part of Totara Core
 *
 * Copyright (C) 2020 onwards Totara Learning Solutions LTD
 *
 * MIT License
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @author Sam Hemelryk <sam.hemelryk@totaralearning.com>
 * @package totara_tui
 */

use totara_tui\controllers\theme_settings;

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->libdir . '/adminlib.php');

class totara_tui_local_controllers_theme_settings_testcase extends advanced_testcase {

    public function test_happy_path() {
        $this->setAdminUser();
        admin_get_root(true); // Fix random errors depending on test order.

        $controller = new theme_settings();
        $_POST['theme_name'] = 'ventura';

        ob_start();
        $controller->process();
        $output = ob_get_clean();

        self::assertSame(\context_system::instance()->id, $controller->get_context()->id);
        self::assertStringContainsString(get_string('theme_settings', 'totara_tui'), $output);
        self::assertStringContainsString('data-tui-component="tui/pages/ThemeSettings"', $output);
    }

    public function test_happy_path_with_tenant() {
        $this->setAdminUser();
        admin_get_root(true); // Fix random errors depending on test order.

        set_config('tenantsenabled', true);

        $controller = new theme_settings();
        $_POST['theme_name'] = 'ventura';
        $_POST['tenant_id'] = \totara_tenant\testing\generator::instance()->create_tenant()->id;

        ob_start();
        $controller->process();
        $output = ob_get_clean();

        self::assertSame(\context_system::instance()->id, $controller->get_context()->id);
        self::assertStringContainsString(get_string('theme_settings', 'totara_tui'), $output);
        self::assertStringContainsString('data-tui-component="tui/pages/ThemeSettings"', $output);
    }

    public function test_theme_is_required_arg() {
        $this->setAdminUser();
        self::expectException(moodle_exception::class);
        self::expectExceptionMessage('A required parameter (theme_name) was missing');
        (new theme_settings())->process();
    }

    public function test_login_is_required_arg() {
        self::expectException(moodle_exception::class);
        self::expectExceptionMessage('Unsupported redirect detected, script execution terminated');
        (new theme_settings())->process();
    }

    public function test_requires_totara_core_appearance_capability() {
        $roleid = $this->getDataGenerator()->create_role();
        assign_capability('totara/core:appearance', CAP_ALLOW, $roleid, \context_system::instance());
        assign_capability('totara/tui:themesettings', CAP_ALLOW, $roleid, \context_system::instance());

        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->role_assign($roleid, $user2->id);

        self::assertTrue(has_capability('totara/core:appearance', \context_system::instance(), $user2));
        self::assertTrue(has_capability('totara/tui:themesettings', \context_system::instance(), $user2));

        $_POST['theme_name'] = 'ventura';
        $this->setUser($user1);

        try {
            (new theme_settings())->process();
            self::fail('Exception expected. User does not have the required capability');
        } catch (moodle_exception $ex) {
            self::assertStringContainsString('Access denied', $ex->getMessage());
        }

        $this->setUser($user2);
        admin_get_root(true);

        ob_start();
        (new theme_settings())->process();
        $output = ob_get_clean();
        self::assertStringContainsString(get_string('theme_settings', 'totara_tui'), $output);
        self::assertStringContainsString('data-tui-component="tui/pages/ThemeSettings"', $output);

    }

    public function test_user_cant_see_other_tenant_capability() {
        /** @var \totara_tenant\testing\generator $tenant_generator */
        $tenant_generator = \totara_tenant\testing\generator::instance();
        $tenant_generator->enable_tenants();

        $roleid = $this->getDataGenerator()->create_role();
        assign_capability('totara/tui:themesettings', CAP_ALLOW, $roleid, \context_system::instance());

        $tenant1 = \totara_tenant\testing\generator::instance()->create_tenant();
        $tenant2 = \totara_tenant\testing\generator::instance()->create_tenant();
        $user1 = $this->getDataGenerator()->create_user(
            ['tenantid' => $tenant1->id, 'tenantdomainmanager' => $tenant1->idnumber]
        );
        $user2 = $this->getDataGenerator()->create_user(['tenantid' => $tenant2->id]);
        $this->getDataGenerator()->role_assign($roleid, $user1->id);

        self::assertTrue(has_capability('totara/tui:themesettings', \context_system::instance(), $user1));

        $_POST['theme_name'] = 'ventura';
        $this->setUser($user1);

        $_POST['tenant_id'] = $tenant1->id;
        ob_start();
        (new theme_settings())->process();
        $output = ob_get_clean();
        self::assertStringContainsString(get_string('theme_settings', 'totara_tui'), $output);
        self::assertStringContainsString('data-tui-component="tui/pages/ThemeSettings"', $output);

        try {
            $_POST['tenant_id'] = $tenant2->id;
            (new theme_settings())->process();
            self::fail('Exception expected. User who is a member of tenant1 accessed theme settings for tenant2');
        } catch (moodle_exception $ex) {
            self::assertStringContainsString(
                'Unsupported redirect detected, script execution terminated',
                $ex->getMessage()
            );
        }
    }

    public function test_invalid_tenant_succeeds() {
        $this->setAdminUser();

        $controller = new theme_settings();
        $_POST['theme_name'] = 'ventura';
        $_POST['tenant_id'] = 7;

        try {
            $controller->process();
        } catch (moodle_exception $ex) {
            self::assertStringContainsString(
                'Invalid tenant',
                $ex->getMessage()
            );
        }
    }

}