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
 * Role updated event.
 *
 * @package    core
 * @copyright  2019 Simey Lameze <simey@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\event;

defined('MOODLE_INTERNAL') || die();

/**
 * Role updated event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string name: name of role.
 *      - string shortname: shortname of role.
 *      - string description: role description.
 *      - string archetype: role type.
 *      - bool updated_name
 *      - bool updated_shortname
 *      - bool updated_description
 *      - bool updated_archetype
 * }
 *
 * @package    core
 * @since      Totara 13.0
 * @copyright  2019 Simey Lameze <simey@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class role_updated extends base {
    /**
     * Flag for prevention of direct create() call.
     * @var bool
     */
    protected static $preventcreatecall = true;

    /**
     * Create instance of event.
     *
     * @param \stdClass $role Updated role
     * @param \stdClass $oldrole Old role
     * @return role_updated
     */
    public static function create_from_instance(\stdClass $role, \stdClass $oldrole) {
        $data = array(
            'objectid' => $role->id,
            'context' => \context_system::instance(),
            'other' => array(
                'name' => $role->name,
                'shortname' => $role->shortname,
                'archetype' => $role->archetype,
                'description' => $role->description,
                'updated_name' => ($role->name !== $oldrole->name),
                'updated_shortname' => ($role->shortname !== $oldrole->shortname),
                'updated_description' => ($role->description !== $oldrole->description),
                'updated_archetype' => ($role->archetype !== $oldrole->archetype),
            )
        );

        self::$preventcreatecall = false;
        /** @var role_updated $event */
        $event = self::create($data);
        $event->add_record_snapshot('role', $role);
        self::$preventcreatecall = true;

        return $event;
    }

    /**
     * Initialise event parameters.
     */
    protected function init() {
        $this->data['objecttable'] = 'role';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventroleupdated', 'role');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        $result = "The user with id '$this->userid' updated the role with id '$this->objectid'";
        $info = [];
        if (!empty($this->other['updated_shortname'])) {
            $info[] = 'shortname: ' . $this->other['shortname'];
        }
        if (!empty($this->other['updated_name'])) {
            $info[] = 'name: ' . $this->other['name'];
        }
        if (!empty($this->other['updated_archetype'])) {
            $info[] = 'archetype: ' . ($this->other['archetype'] === '' ? 'none' : $this->other['archetype']);
        }
        if (!empty($this->other['updated_description'])) {
            // Do not put full description here, it might be too long.
            $info[] = 'description: changed';
        }
        if ($info) {
            $result .= ' (' . implode(', ', $info) . ')';
        }
        $result .= '.';
        return $result;
    }

    /**
     * Returns relevant URL.
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/admin/roles/define.php', ['action' => 'view', 'roleid' => $this->objectid]);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['shortname'])) {
            throw new \coding_exception('The \'shortname\' value must be set in other.');
        }
        if (!isset($this->other['name'])) {
            throw new \coding_exception('The \'name\' value must be set in other.');
        }
        if (!isset($this->other['description'])) {
            throw new \coding_exception('The \'description\' value must be set in other.');
        }
        if (!isset($this->other['archetype'])) {
            throw new \coding_exception('The \'archetype\' value must be set in other.');
        }
    }
}
