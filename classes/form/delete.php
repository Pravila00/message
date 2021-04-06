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
 * @copyright   onwards Martin Dougiamas (http://dougiamas.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("$CFG->libdir/formslib.php");

class delete extends moodleform
{
    //Add elements to form
    public function definition()
    {
        global $DB;
        global $CFG;
        $record = $DB->get_record('local_message', ['id' => $this->_customdata['id']]);
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('html', '<h2>Sure to delete message with id ' . $record->id . '?</h2>');
        $mform->addElement('html', $record->messagetext);
        $mform->addElement('hidden', 'id', $record->id);
        $mform->setType('id', PARAM_INT);


        $this->add_action_buttons();
    }
    //Custom validation should be added here
    function validation($data, $files)

    {
        return array();
    }
}
