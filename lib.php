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
 * @package    block_testblock
 * @copyright  Pablo Rodriguez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

function local_message_before_footer(){
    global $DB, $USER;

    $sql = "SELECT lm.id, lm.messagetext, lm.messagetype FROM {local_message}
        lm left join {local_message_read} lmr ON lm.id = lmr.messageid
        WHERE lmr.userid <> :userid OR lmr.userid IS NULL
        ";


    $params = [
        'userid' => $USER->id,
    ];


    
    foreach($messages as $message){
        $type = 'tipo';
        if($message->messagetype === '0'){
            $type = \core\output\notification::NOTIFY_WARNING;
        }
        else if($message->messagetype === '1'){
            $type = \core\output\notification::NOTIFY_SUCCESS;
        }
        else if($message->messagetype === '2'){
            $type = \core\output\notification::NOTIFY_ERROR;
        }
        else if($message->messagetype === '3'){
            $type = \core\output\notification::NOTIFY_INFO;
        }

        //Crea notificaciones arriba en la pagina
        \core\notification::add($message->messagetext, $type);

        $readrecord = new StdClass();
        $readrecord->message_id = $message->id;
        $readrecord->user_id = $USER->id;
        $readrecord->timeread = time();
        $DB->insert_record('local_message_read', $readrecord);
    }

}