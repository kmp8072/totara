<?php
/*
 * This file is part of Totara Learn
 *
 * Copyright (C) 2018 onwards Totara Learning Solutions LTD
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
 * @author David Curry <david.curry@totaralearning.com>
 * @author Kian Nguyen <kian.nguyen@totaralearning.com>
 * @author Aaron Wells <aaronw@catalyst.net.nz>
 * @package totara_cohort
 */

namespace totara_cohort\rules\dialog;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/totara/core/dialogs/dialog_content_users.class.php');

class manager_cohort extends \totara_dialog_content_users {
    /**
     * Returns markup to be used in the selected pane of a multi-select dialog
     *
     * @param   $elements    array elements to be created in the pane
     * @return  $html
     */
    public function populate_selected_items_pane($elements) {
        $operatormenu = array();
        $operatormenu[0] = get_string('reportsto', 'totara_cohort');
        $operatormenu[1] = get_string('reportsdirectlyto', 'totara_cohort');
        $selected = isset($this->isdirectreport) ? $this->isdirectreport : '';
        $html = \html_writer::select($operatormenu, 'isdirectreport', $selected, array(),
            array('id' => 'id_isdirectreport', 'class' => 'cohorttreeviewsubmitfield'));
        return $html . parent::populate_selected_items_pane($elements);
    }
}
