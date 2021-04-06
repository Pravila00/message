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
require_once($CFG->dirroot . '/local/message/classes/form/delete.php');
global $DB;

$PAGE->set_url(new moodle_url('/local/message/delete.php'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/local/message/js/delete.js')); //link javascript
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Delete');

$parameters = array_merge($_GET, $_POST);
$record = $DB->get_record('local_message', ['id' => $parameters['id']]);

//We want to display our form
$mform = new delete(null, $parameters);

if ($mform->is_cancelled()) {
    //Go back to manage.php page
    redirect($CFG->wwwroot . '/local/message/manage.php', 'No se ha borrado');
} else if ($fromform = $mform->get_data()) {
    //Delete data
    $object_delete = ['id' => $fromform->id];
    $DB->delete_records('local_message', $object_delete);

    //Go back to manage.php page
    redirect(
        $CFG->wwwroot . '/local/message/manage.php',
        'Borraste el mensaje con texto:  ' . $record->messagetext
    );
}

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
