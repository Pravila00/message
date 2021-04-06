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

require_once(__DIR__ . '/../../config.php');
global $DB;

$PAGE->set_url(new moodle_url('/local/message/manage.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Manage messages');

$messages = $DB->get_records('local_message');

//Displays html
echo $OUTPUT->header();

//Hacemos array_values porque el array messages empieza en 1 y no 0
//esto implica que el template no coja bien el array
//Array_values nos devuelve un array con los mismos valores
//que message pero empezando desde 0
$templatecontext =(object)[
    'messages' =>  array_values($messages),
    'editurl'  => new moodle_url('/local/message/edit.php'),
    'deleteurl' => new moodle_url('/local/message/delete.php'),
    'updateurl' => new moodle_url('/local/message/update.php'),
];
echo $OUTPUT->render_from_template('local_message/manage',$templatecontext);

echo $OUTPUT->footer();