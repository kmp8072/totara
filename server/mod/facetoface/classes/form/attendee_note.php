<?php
/*
 * This file is part of Totara LMS
 *
 * Copyright (C) 2010 onwards Totara Learning Solutions LTD
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
 * @author Oleg Demeshev <oleg.demeshev@totaralms.com>
 * @package modules
 * @subpackage facetoface
 */

namespace mod_facetoface\form;

defined('MOODLE_INTERNAL') || die();

class attendee_note extends \moodleform {

    public function definition() {

        $mform = & $this->_form;
        $signup = $this->_customdata['signup'];
        $id = $signup->get_id();
        $userid = $signup->get_userid();
        $sessionid = $signup->get_sessionid();

        $user = \core_user::get_user($userid);
        $userfullname = fullname($user);
        $mform->addElement('header', 'usernoteheader', get_string('usernoteheading', 'facetoface', $userfullname));

        $mform->addElement('hidden', 'id', $id);
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'userid', $userid);
        $mform->setType('userid', PARAM_INT);

        $mform->addElement('hidden', 's', $sessionid);
        $mform->setType('s', PARAM_INT);

        $mform->addElement('hidden', 'return', $this->_customdata['return']);
        $mform->setType('return', PARAM_ALPHA);

        $item = new \stdClass();
        $item->id = $id;
        customfield_definition($mform, $item, 'facetofacesignup', 0, 'facetoface_signup');
        $mform->removeElement('customfields');

        $submittitle = get_string('savenote', 'facetoface');
        $this->add_action_buttons(true, $submittitle);
    }
}