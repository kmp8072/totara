<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Unit tests for those parts of adminlib.php that implement the admin tree
 * functionality.
 *
 * @package     core
 * @category    phpunit
 * @copyright   2013 David Mudrak <david@moodle.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir.'/adminlib.php');

/**
 * Provides the unit tests for admin tree functionality.
 */
class core_admintree_testcase extends advanced_testcase {

    /**
     * Adding nodes into the admin tree.
     */
    public function test_add_nodes() {

        $tree = new admin_root(true);
        $tree->add('root', $one = new admin_category('one', 'One'));
        $tree->add('root', new admin_category('three', 'Three'));
        $tree->add('one', new admin_category('one-one', 'One-one'));
        $tree->add('one', new admin_category('one-three', 'One-three'));

        // Check the order of nodes in the root.
        $map = array();
        foreach ($tree->children as $child) {
            $map[] = $child->name;
        }
        $this->assertEquals(array('one', 'three'), $map);

        // Insert a node into the middle.
        $tree->add('root', new admin_category('two', 'Two'), 'three');
        $map = array();
        foreach ($tree->children as $child) {
            $map[] = $child->name;
        }
        $this->assertEquals(array('one', 'two', 'three'), $map);

        // Non-existing sibling.
        $tree->add('root', new admin_category('four', 'Four'), 'five');
        $this->assertDebuggingCalled('Sibling five not found', DEBUG_DEVELOPER);

        $tree->add('root', new admin_category('five', 'Five'));
        $map = array();
        foreach ($tree->children as $child) {
            $map[] = $child->name;
        }
        $this->assertEquals(array('one', 'two', 'three', 'four', 'five'), $map);

        // Insert a node into the middle of the subcategory.
        $tree->add('one', new admin_category('one-two', 'One-two'), 'one-three');
        $map = array();
        foreach ($one->children as $child) {
            $map[] = $child->name;
        }
        $this->assertEquals(array('one-one', 'one-two', 'one-three'), $map);

        // Check just siblings, not parents or children.
        $tree->add('one', new admin_category('one-four', 'One-four'), 'one');
        $this->assertDebuggingCalled('Sibling one not found', DEBUG_DEVELOPER);

        $tree->add('root', new admin_category('six', 'Six'), 'one-two');
        $this->assertDebuggingCalled('Sibling one-two not found', DEBUG_DEVELOPER);

        // Me! Me! I wanna be first!
        $tree->add('root', new admin_externalpage('zero', 'Zero', 'http://foo.bar'), 'one');
        $map = array();
        foreach ($tree->children as $child) {
            $map[] = $child->name;
        }
        $this->assertEquals(array('zero', 'one', 'two', 'three', 'four', 'five', 'six'), $map);
    }

    public function test_add_nodes_before_invalid1() {
        $tree = new admin_root(true);
        $this->expectException(coding_exception::class);
        $tree->add('root', new admin_externalpage('foo', 'Foo', 'http://foo.bar'), array('moodle:site/config'));
    }

    public function test_add_nodes_before_invalid2() {
        $tree = new admin_root(true);
        $this->expectException(coding_exception::class);
        $tree->add('root', new admin_category('bar', 'Bar'), '');
    }

    public function test_path() {
        $tree = new admin_root(true);
        $tree->add('root', $one = new admin_category('one', 'One'));
        $tree->add('root', $three = new admin_category('three', 'Three'));
        $tree->add('one', $oneone = new admin_category('one-one', 'One-one'));
        $tree->add('one-one', $oneoneone = new admin_externalpage('one-one-one', 'One-one-one', new moodle_url('/')));
        $onethree = new admin_category('one-three', 'One-three');
        $onethree->add('one-three', $onethreeone = new admin_settingpage('one-three-one', 'One-three-one'));
        $onethreeone->add(new admin_setting_heading('xx', 'XXX xxx', 'YYY yyy'));
        $tree->add('one', $onethree);

        $expected = array('one-three-one', 'one-three', 'one', 'root');
        $this->assertSame($expected, $onethreeone->path);
    }

    public function test_visiblepath() {
        $tree = new admin_root(true);
        $tree->add('root', $one = new admin_category('one', 'One'));
        $tree->add('root', $three = new admin_category('three', 'Three'));
        $tree->add('one', $oneone = new admin_category('one-one', 'One-one'));
        $tree->add('one-one', $oneoneone = new admin_externalpage('one-one-one', 'One-one-one', new moodle_url('/')));
        $onethree = new admin_category('one-three', 'One-three');
        $onethree->add('one-three', $onethreeone = new admin_settingpage('one-three-one', 'One-three-one'));
        $onethreeone->add(new admin_setting_heading('xx', 'XXX xxx', 'YYY yyy'));
        $tree->add('one', $onethree);

        $expected = array('One-three-one', 'One-three', 'One', 'Administration');
        $this->assertSame($expected, $onethreeone->visiblepath);
    }

    public function test_locate() {
        $tree = new admin_root(true);
        $tree->add('root', $one = new admin_category('one', 'One'));
        $tree->add('root', $three = new admin_category('three', 'Three'));
        $tree->add('one', $oneone = new admin_category('one-one', 'One-one'));
        $tree->add('one-one', $oneoneone = new admin_externalpage('one-one-one', 'One-one-one', new moodle_url('/')));
        $onethree = new admin_category('one-three', 'One-three');
        $onethree->add('one-three', $onethreeone = new admin_settingpage('one-three-one', 'One-three-one'));
        $onethreeone->add(new admin_setting_heading('xx', 'XXX xxx', 'YYY yyy'));
        $tree->add('one', $onethree);

        // The is recommended way to look up stuff!
        $this->assertSame($tree, $tree->locate('root'));
        $this->assertSame($one, $tree->locate('one'));
        $this->assertSame($oneone, $tree->locate('one-one'));
        $this->assertSame($oneoneone, $tree->locate('one-one-one'));
        $this->assertSame($onethree, $tree->locate('one-three'));
        $this->assertSame($onethreeone, $tree->locate('one-three-one'));

        // Lookup via any category - this works only without the paths because it uses the cache.
        $this->assertSame($tree, $onethree->locate('root'));
        $this->assertSame($one, $onethree->locate('one'));
        $this->assertSame($oneone, $onethree->locate('one-one'));
        $this->assertSame($oneoneone, $onethree->locate('one-one-one'));
        $this->assertSame($onethree, $onethree->locate('one-three'));
        $this->assertSame($onethreeone, $onethree->locate('one-three-one'));
    }

    public function test_locate_not_attached() {
        $onethree = new admin_category('one-three', 'One-three');
        $onethree->add('one-three', $onethreeone = new admin_settingpage('one-three-one', 'One-three-one'));

        $this->assertSame($onethree, $onethree->locate('one-three'));
        $this->assertSame($onethreeone, $onethree->locate('one-three-one'));
    }

    public function test_prune() {
        $tree = new admin_root(true);
        $tree->add('root', $one = new admin_category('one', 'One'));
        $tree->add('root', $three = new admin_category('three', 'Three'));
        $tree->add('one', $oneone = new admin_category('one-one', 'One-one'));
        $tree->add('one-one', $oneoneone = new admin_externalpage('one-one-one', 'One-one-one', new moodle_url('/')));
        $onethree = new admin_category('one-three', 'One-three');
        $onethree->add('one-three', $onethreeone = new admin_settingpage('one-three-one', 'One-three-one'));
        $onethreeone->add(new admin_setting_heading('xx', 'XXX xxx', 'YYY yyy'));
        $tree->add('one', $onethree);

        // The is recommended way to look up stuff!
        $this->assertSame($tree, $tree->locate('root'));
        $this->assertSame($one, $tree->locate('one'));
        $this->assertSame($oneone, $tree->locate('one-one'));
        $this->assertSame($oneoneone, $tree->locate('one-one-one'));
        $this->assertSame($onethree, $tree->locate('one-three'));
        $this->assertSame($onethreeone, $tree->locate('one-three-one'));

        $this->assertTrue($tree->prune('one-three'));

        $this->assertSame($tree, $tree->locate('root'));
        $this->assertSame($one, $tree->locate('one'));
        $this->assertSame($oneone, $tree->locate('one-one'));
        $this->assertSame($oneoneone, $tree->locate('one-one-one'));
        $this->assertSame(null, $tree->locate('one-three'));
        $this->assertSame(null, $tree->locate('one-three-one'));
        $this->assertSame($three, $tree->locate('three'));

        $this->assertFalse($tree->prune('xxx'));

        $this->assertSame($tree, $tree->locate('root'));
        $this->assertSame($one, $tree->locate('one'));
        $this->assertSame($oneone, $tree->locate('one-one'));
        $this->assertSame($oneoneone, $tree->locate('one-one-one'));
        $this->assertSame(null, $tree->locate('one-three'));
        $this->assertSame(null, $tree->locate('one-three-one'));
        $this->assertSame($three, $tree->locate('three'));

        $this->assertTrue($tree->prune('one-one-one'));

        $this->assertSame($tree, $tree->locate('root'));
        $this->assertSame($one, $tree->locate('one'));
        $this->assertSame($oneone, $tree->locate('one-one'));
        $this->assertSame(null, $tree->locate('one-one-one'));
        $this->assertSame(null, $tree->locate('one-three'));
        $this->assertSame(null, $tree->locate('one-three-one'));
        $this->assertSame($three, $tree->locate('three'));

        $this->assertTrue($tree->prune('one'));

        $this->assertSame($tree, $tree->locate('root'));
        $this->assertSame(null, $tree->locate('one'));
        $this->assertSame(null, $tree->locate('one-one'));
        $this->assertSame(null, $tree->locate('one-one-one'));
        $this->assertSame(null, $tree->locate('one-three'));
        $this->assertSame(null, $tree->locate('one-three-one'));
        $this->assertSame($three, $tree->locate('three'));

        try {
            $tree->prune('root');
        } catch (moodle_exception $e) {
            $this->assertInstanceOf('coding_exception', $e);
        }
    }

    /**
     * Testing whether a configexecutable setting is executable.
     */
    public function test_admin_setting_configexecutable() {
        global $CFG;
        $this->setAdminUser();

        $CFG->theme = 'ventura';
        $executable = new admin_setting_configexecutable('test1', 'Text 1', 'Help Path', '');

        // Check for an invalid path.
        $result = $executable->output_html($CFG->dirroot . '/lib/tests/other/file_does_not_exist');
        $this->assertMatchesRegularExpression('/class="patherror"/', $result);

        // Check for a directory.
        $result = $executable->output_html($CFG->dirroot);
        $this->assertMatchesRegularExpression('/class="patherror"/', $result);

        // Check for a file which is not executable.
        $result = $executable->output_html($CFG->dirroot . '/filter/tex/readme_moodle.txt');
        $this->assertMatchesRegularExpression('/class="patherror"/', $result);

        // Check for an executable file.
        if ($CFG->ostype == 'WINDOWS') {
            $filetocheck = 'mimetex.exe';
        } else {
            $filetocheck = 'mimetex.darwin';
        }
        $result = $executable->output_html($CFG->dirroot . '/filter/tex/' . $filetocheck);
        $this->assertMatchesRegularExpression('/class="pathok"/', $result);

        // Check for no file specified.
        $result = $executable->output_html('');
        $this->assertMatchesRegularExpression('/name="s__test1"/', $result);
        $this->assertMatchesRegularExpression('/value=""/', $result);
    }

    /**
     * Saving of values.
     */
    public function test_config_logging() {
        global $DB;
        $this->setAdminUser();

        $DB->delete_records('config_log', array());

        $adminroot = new admin_root(true);
        $adminroot->add('root', $one = new admin_category('one', 'One'));
        $page = new admin_settingpage('page', 'Page');
        $page->add(new admin_setting_configtext('text1', 'Text 1', '', ''));
        $page->add(new admin_setting_configpasswordunmask('pass1', 'Password 1', '', ''));
        $adminroot->add('one', $page);

        $this->assertEmpty($DB->get_records('config_log'));
        $data = array('s__text1'=>'sometext', 's__pass1'=>'');
        $count = $this->save_config_data($adminroot, $data);

        $this->assertEquals(2, $count);
        $records = $DB->get_records('config_log', array(), 'id asc');
        $this->assertCount(2, $records);
        reset($records);
        $record = array_shift($records);
        $this->assertNull($record->plugin);
        $this->assertSame('text1', $record->name);
        $this->assertNull($record->oldvalue);
        $this->assertSame('sometext', $record->value);
        $record = array_shift($records);
        $this->assertNull($record->plugin);
        $this->assertSame('pass1', $record->name);
        $this->assertNull($record->oldvalue);
        $this->assertSame('', $record->value);

        $DB->delete_records('config_log', array());
        $data = array('s__text1'=>'other', 's__pass1'=>'nice password');
        $count = $this->save_config_data($adminroot, $data);

        $this->assertEquals(2, $count);
        $records = $DB->get_records('config_log', array(), 'id asc');
        $this->assertCount(2, $records);
        reset($records);
        $record = array_shift($records);
        $this->assertNull($record->plugin);
        $this->assertSame('text1', $record->name);
        $this->assertSame('sometext', $record->oldvalue);
        $this->assertSame('other', $record->value);
        $record = array_shift($records);
        $this->assertNull($record->plugin);
        $this->assertSame('pass1', $record->name);
        $this->assertSame('', $record->oldvalue);
        $this->assertSame('********', $record->value);

        $DB->delete_records('config_log', array());
        $data = array('s__text1'=>'', 's__pass1'=>'');
        $count = $this->save_config_data($adminroot, $data);

        $this->assertEquals(2, $count);
        $records = $DB->get_records('config_log', array(), 'id asc');
        $this->assertCount(2, $records);
        reset($records);
        $record = array_shift($records);
        $this->assertNull($record->plugin);
        $this->assertSame('text1', $record->name);
        $this->assertSame('other', $record->oldvalue);
        $this->assertSame('', $record->value);
        $record = array_shift($records);
        $this->assertNull($record->plugin);
        $this->assertSame('pass1', $record->name);
        $this->assertSame('********', $record->oldvalue);
        $this->assertSame('', $record->value);
    }

    protected function save_config_data(admin_root $adminroot, array $data) {
        $adminroot->errors = array();

        $settings = admin_find_write_settings($adminroot, $data);

        $count = 0;
        foreach ($settings as $fullname=>$setting) {
            /** @var $setting admin_setting */
            $original = $setting->get_setting();
            $error = $setting->write_setting($data[$fullname]);
            if ($error !== '') {
                $adminroot->errors[$fullname] = new stdClass();
                $adminroot->errors[$fullname]->data  = $data[$fullname];
                $adminroot->errors[$fullname]->id    = $setting->get_id();
                $adminroot->errors[$fullname]->error = $error;
            } else {
                $setting->write_setting_flags($data);
            }
            if ($setting->post_write_settings($original)) {
                $count++;
            }
        }

        return $count;
    }

    public function test_preventexecpath() {

        set_config('preventexecpath', 0);
        set_config('execpath', null, 'abc_cde');
        $this->assertFalse(get_config('abc_cde', 'execpath'));
        $setting = new admin_setting_configexecutable('abc_cde/execpath', 'some desc', '', '/xx/yy');
        $setting->write_setting('/oo/pp');
        $this->assertSame('/oo/pp', get_config('abc_cde', 'execpath'));

        // Prevent changes.
        set_config('preventexecpath', 1);
        $setting->write_setting('/mm/nn');
        $this->assertSame('/oo/pp', get_config('abc_cde', 'execpath'));

        // Use default in install.
        set_config('execpath', null, 'abc_cde');
        $setting->write_setting('/mm/nn');
        $this->assertSame('/xx/yy', get_config('abc_cde', 'execpath'));

        // Use empty value if no default.
        $setting = new admin_setting_configexecutable('abc_cde/execpath', 'some desc', '', null);
        set_config('execpath', null, 'abc_cde');
        $setting->write_setting('/mm/nn');
        $this->assertSame('', get_config('abc_cde', 'execpath'));

        // This also affects admin_setting_configfile and admin_setting_configdirectory.

        set_config('preventexecpath', 0);
        set_config('execpath', null, 'abc_cde');
        $this->assertFalse(get_config('abc_cde', 'execpath'));
        $setting = new admin_setting_configfile('abc_cde/execpath', 'some desc', '', '/xx/yy');
        $setting->write_setting('/oo/pp');
        $this->assertSame('/oo/pp', get_config('abc_cde', 'execpath'));

        // Prevent changes.
        set_config('preventexecpath', 1);
        $setting->write_setting('/mm/nn');
        $this->assertSame('/oo/pp', get_config('abc_cde', 'execpath'));

        // Use default in install.
        set_config('execpath', null, 'abc_cde');
        $setting->write_setting('/mm/nn');
        $this->assertSame('/xx/yy', get_config('abc_cde', 'execpath'));

        // Use empty value if no default.
        $setting = new admin_setting_configfile('abc_cde/execpath', 'some desc', '', null);
        set_config('execpath', null, 'abc_cde');
        $setting->write_setting('/mm/nn');
        $this->assertSame('', get_config('abc_cde', 'execpath'));

        set_config('preventexecpath', 0);
        set_config('execpath', null, 'abc_cde');
        $this->assertFalse(get_config('abc_cde', 'execpath'));
        $setting = new admin_setting_configdirectory('abc_cde/execpath', 'some desc', '', '/xx/yy');
        $setting->write_setting('/oo/pp');
        $this->assertSame('/oo/pp', get_config('abc_cde', 'execpath'));

        // Prevent changes.
        set_config('preventexecpath', 1);
        $setting->write_setting('/mm/nn');
        $this->assertSame('/oo/pp', get_config('abc_cde', 'execpath'));

        // Use default in install.
        set_config('execpath', null, 'abc_cde');
        $setting->write_setting('/mm/nn');
        $this->assertSame('/xx/yy', get_config('abc_cde', 'execpath'));

        // Use empty value if no default.
        $setting = new admin_setting_configdirectory('abc_cde/execpath', 'some desc', '', null);
        set_config('execpath', null, 'abc_cde');
        $setting->write_setting('/mm/nn');
        $this->assertSame('', get_config('abc_cde', 'execpath'));
    }

    /**
     * Test setting for blocked hosts
     *
     * For testing the admin settings element only. Test for blocked hosts functionality can be found
     * in lib/tests/curl_security_helper_test.php
     */
    public function test_mixedhostiplist() {

        $adminsetting = new admin_setting_configmixedhostiplist('abc_cde/hostiplist', 'some desc', '', '');

        // Test valid settings.
        $validsimplesettings = [
            'localhost',
            "localhost\n127.0.0.1",
            '192.168.10.1',
            '0:0:0:0:0:0:0:1',
            '::1',
            'fe80::',
            '231.54.211.0/20',
            'fe80::/64',
            '231.3.56.10-20',
            'fe80::1111-bbbb',
            '*.example.com',
            '*.sub.example.com',
        ];

        foreach ($validsimplesettings as $setting) {
            $errormessage = $adminsetting->write_setting($setting);
            $this->assertEmpty($errormessage, $errormessage);
            $this->assertSame($setting, get_config('abc_cde', 'hostiplist'));
            $this->assertSame($setting, $adminsetting->get_setting());
        }

        // Test valid international site names.
        $valididnsettings = [
            'правительство.рф' => 'xn--80aealotwbjpid2k.xn--p1ai',
            'faß.de' => 'xn--fa-hia.de',
            'ß.ß' => 'xn--zca.xn--zca',
            '*.tharkûn.com' => '*.xn--tharkn-0ya.com',
        ];

        foreach ($valididnsettings as $setting => $encodedsetting) {
            $errormessage = $adminsetting->write_setting($setting);
            $this->assertEmpty($errormessage, $errormessage);
            $this->assertSame($encodedsetting, get_config('abc_cde', 'hostiplist'));
            $this->assertSame($setting, $adminsetting->get_setting());
        }

        // Invalid settings.
        $this->assertEquals('These entries are invalid: nonvalid site name', $adminsetting->write_setting('nonvalid site name'));
        $this->assertEquals('Empty lines are not valid', $adminsetting->write_setting("localhost\n"));
    }

    /**
     * Test hiding enrol plugins from the "Manage enrol plugins" interface.
     */
    public function test_manageenrols_hide_enrol_plugins(): void {
        global $DB;

        // 'totara_learningplan' should be in the list by default, but not 'container_perform'.
        $manage_enrols = new admin_setting_manageenrols();
        $manage_table = $manage_enrols->output_html('');
        self::assertStringContainsString('totara_learningplan', $manage_table);
        self::assertStringNotContainsString('container_perform', $manage_table);

        // Create a record in the enrol table for 'container_perform' enrol plugin. It should still not show up because we exclude it.
        $DB->insert_record('enrol', [
            'enrol' => 'container_perform',
            'courseid' => 1,
        ]);
        // Any other plugins found in the table should show up.
        $DB->insert_record('enrol', [
            'enrol' => 'mock_enrol_plugin',
            'courseid' => 1,
        ]);
        $manage_table = $manage_enrols->output_html('');
        self::assertStringContainsString('totara_learningplan', $manage_table);
        self::assertStringContainsString('mock_enrol_plugin', $manage_table);
        self::assertStringNotContainsString('container_perform', $manage_table);

        // Change the list of excluded plugins to make sure it works.
        $reflection = new ReflectionClass($manage_enrols);
        $hide_enrol_plugins = $reflection->getProperty('hide_enrol_plugins');
        $hide_enrol_plugins->setAccessible(true);

        $hide_enrol_plugins->setValue($manage_enrols, []);
        $manage_table = $manage_enrols->output_html('');
        self::assertStringContainsString('totara_learningplan', $manage_table);
        self::assertStringContainsString('container_perform', $manage_table);
        self::assertStringContainsString('mock_enrol_plugin', $manage_table);

        $hide_enrol_plugins->setValue($manage_enrols, ['totara_learningplan', 'container_perform', 'mock_enrol_plugin']);
        $manage_table = $manage_enrols->output_html('');
        self::assertStringNotContainsString('totara_learningplan', $manage_table);
        self::assertStringNotContainsString('container_perform', $manage_table);
        self::assertStringNotContainsString('mock_enrol_plugin', $manage_table);
    }
}
