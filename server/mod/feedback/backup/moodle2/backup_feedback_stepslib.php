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
 * @package    mod_feedback
 * @subpackage backup-moodle2
 * @copyright 2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Define all the backup steps that will be used by the backup_feedback_activity_task
 */

/**
 * Define the complete feedback structure for backup, with file and id annotations
 */
class backup_feedback_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // To know if we are including userinfo
        $userinfo = $this->get_setting_value('userinfo');

        // Define each element separated
        $feedback = new backup_nested_element('feedback', array('id'), array(
                                                'name',
                                                'intro',
                                                'introformat',
                                                'anonymous',
                                                'email_notification',
                                                'multiple_submit',
                                                'autonumbering',
                                                'site_after_submit',
                                                'page_after_submit',
                                                'page_after_submitformat',
                                                'publish_stats',
                                                'timeopen',
                                                'timeclose',
                                                'timemodified',
                                                'completionsubmit'));

        $completeds = new backup_nested_element('completeds');

        $completeds_history = new backup_nested_element('completeds_history');

        $completed = new backup_nested_element('completed', array('id'), array(
                                                'userid',
                                                'timemodified',
                                                'random_response',
                                                'anonymous_response',
                                                'courseid'));

        $completed_history = new backup_nested_element('completed_history', array('id'), array(
                                                'userid',
                                                'timemodified',
                                                'random_response',
                                                'anonymous_response',
                                                'timearchived',
                                                'idarchived'));

        $items = new backup_nested_element('items');

        $item = new backup_nested_element('item', array('id'), array(
                                                'template',
                                                'name',
                                                'label',
                                                'presentation',
                                                'typ',
                                                'hasvalue',
                                                'position',
                                                'required',
                                                'dependitem',
                                                'dependvalue',
                                                'options'));

        $values = new backup_nested_element('values');

        $values_history = new backup_nested_element('values_history');

        $value = new backup_nested_element('value', array('id'), array(
                                                'item',
                                                'template',
                                                'completed',
                                                'value',
                                                'course_id'));

        $value_history = new backup_nested_element('value_history', array('id'), array(
                                                'item',
                                                'completed',
                                                'value',
                                                'timearchived',
                                                'idarchived'));

        // Build the tree
        $feedback->add_child($items);
        $items->add_child($item);

        $feedback->add_child($completeds);
        $feedback->add_child($completeds_history);
        $completeds->add_child($completed);
        $completeds_history->add_child($completed_history);

        $completed->add_child($values);
        $completed_history->add_child($values_history);
        $values->add_child($value);

        $values_history->add_child($value_history);

        // Define sources
        $feedback->set_source_table('feedback', array('id' => backup::VAR_ACTIVITYID));

        $item->set_source_table('feedback_item', array('feedback' => backup::VAR_PARENTID));

        // All these source definitions only happen if we are including user info
        if ($userinfo) {
            $completed->set_source_sql('
                SELECT *
                  FROM {feedback_completed}
                 WHERE feedback = ?',
                array(backup::VAR_PARENTID));

            $completed_history->set_source_sql('
                SELECT *
                  FROM {feedback_completed_history}
                 WHERE feedback = ?',
                array(backup::VAR_PARENTID));

            $value->set_source_table('feedback_value', array('completed' => backup::VAR_PARENTID));

            $value_history->set_source_table('feedback_value_history', array('completed' => backup::VAR_PARENTID));
        }

        // Define id annotations

        $completed->annotate_ids('user', 'userid');

        $completed_history->annotate_ids('user', 'userid');

        // Define file annotations

        $feedback->annotate_files('mod_feedback', 'intro', null); // This file area hasn't itemid
        $feedback->annotate_files('mod_feedback', 'page_after_submit', null); // This file area hasn't itemid

        $item->annotate_files('mod_feedback', 'item', 'id');

        // Return the root element (feedback), wrapped into standard activity structure
        return $this->prepare_activity_structure($feedback);
    }

}
