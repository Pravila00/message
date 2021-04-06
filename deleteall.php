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

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/message/classes/form/deleteall.php');

$PAGE->set_url(new moodle_url('/local/message/deleteall.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Delete All');

//We want to display our form
$mform = new deleteall();

if ($mform->is_cancelled()) {
    //Go back to manage.php page
    redirect($CFG->wwwroot . '/local/message/manage.php', 'Not deleted!');
} else if ($fromform = $mform->get_data()) {
    $conditions = []; //delete all messages
    $DB->delete_records('local_message', $conditions);

    //Go back to manage.php page
    redirect(
        $CFG->wwwroot . '/local/message/manage.php',
        'You deleted all messages'
    );
}

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
