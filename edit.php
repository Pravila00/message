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

//REQUIRES
require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/message/classes/form/edit.php');
global $DB;

$PAGE->set_url(new moodle_url('/local/message/manage.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Edit messages');

//Display form
$mform = new edit();

//Displays html

if ($mform->is_cancelled()) {
    //Volvemos a la pagina principal
    redirect($CFG->wwwroot . '/local/message/manage.php','Cancelaste el formulario');

}
else if ($fromform = $mform->get_data()) {
    //Metemos los datos en la base de datos
    $recordtoinsert = new stdClass();
    $recordtoinsert->messagetext = $fromform->messagetext;
    $recordtoinsert->messagetype = $fromform->messagetype;

    //Inserta en la base de datos
    $DB->insert_record('local_message',$recordtoinsert);

    //Volvemos a la pagina principal
    redirect($CFG->wwwroot . '/local/message/manage.php','Creaste el mensaje: ' . $fromform->messagetext);
}


echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();