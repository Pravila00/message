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
 * Version details
 *
 * @package    local_message
 * @copyright  Pablo Rodriguez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */
require_once("$CFG->libdir/formslib.php");

class edit extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG;

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('text', 'messagetext','Texto del mensaje'); // Add elements to your form
        $mform->setType('messagetext', PARAM_NOTAGS);                   //Set type of element
        $mform->setDefault('messagetext', 'Escriba su mensaje aqui');        //Default value



        $choices = array();
        $choices['0'] = \core\output\notification::NOTIFY_WARNING;
        $choices['1'] = \core\output\notification::NOTIFY_SUCCESS;
        $choices['2'] = \core\output\notification::NOTIFY_ERROR;
        $choices['3'] = \core\output\notification::NOTIFY_INFO;

        $mform->addElement('select', 'messagetype', 'Tipo del mensaje', $choices);
        $mform->setDefault('messagetype','3');
        
        $this->add_action_buttons();


    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}