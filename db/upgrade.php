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
 * Page module upgrade code
 *
 * This file keeps track of upgrades to
 * the resource module
 *
 * Sometimes, changes between versions involve
 * alterations to database structures and other
 * major things that may break installations.
 *
 * The upgrade function in this file will attempt
 * to perform all the necessary actions to upgrade
 * your older installation to the current version.
 *
 * If there's something it cannot do itself, it
 * will tell you what you need to do.
 *
 * The commands in here will all be database-neutral,
 * using the methods of database_manager class
 *
 * Please do not forget to use upgrade_set_timeout()
 * before any action that may take longer time to finish.
 *
 * @package local_message
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

function xmldb_local_message_upgrade($oldversion) {
    global $CFG,$DB;
    $dbman = $DB->get_manager();
    $dbman->generator->foreign_keys=true;

    //Aqui se pone el codigo php del editor XMLDB
    if ($oldversion < $oldversion + 1) {
        //TABLA LOCAL MESSAGE
        //Definimos la tabla
        $table = new xmldb_table('local_message');

        //Definimos los campos de la tabla
        $field_id = new xmldb_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $field_messagetext = new xmldb_field('messagetext', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $field_messagetype= new xmldb_field('messagetype', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);


        // Adding keys to table local_message.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Si la tabla no existe se crea
        if (!$dbman->table_exists($table)) {
            $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
            $table->add_field('messagetext', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
            $table->add_field('messagetype', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
            $dbman->create_table($table);

        } else {
            //Comprobamos si no existe id
            if(!$dbman->field_exists($table, 'id')){
                $dbman->add_field($table,$field_id);
            }
            //Comprobamos si no existe messagetext
            if(!$dbman->field_exists($table, 'messagetext')){
                $dbman->add_field($table,$field_messagetext);
            }

            //Comprobamos si no existe messagetype
            if(!$dbman->field_exists($table, 'messagetype')){
                $dbman->add_field($table,$field_messagetype);
            }


            /*
            $values = $DB->get_records('local_message');
            $num_records = $DB->count_records('local_message');

            $dbman->drop_table($table);
            $dbman->create_table($table);

            foreach ($values as $key => $object) {
                $DB->insert_record('local_message', $object);
            }*/
        }
        //Probamos a borrar messagetext local message
        //$dbman->drop_field($table,$field_messagetext);

        //Probamos a cambiar el tipo de un campo
        $new_field_messagetype=new xmldb_field('messagetype', XMLDB_TYPE_FLOAT, null, null, XMLDB_NOTNULL, null, null);
        $dbman->change_field_type($table,$new_field_messagetype);

        //Test de indices en el campo messagetext
        $index = new xmldb_index('messagetext', XMLDB_INDEX_NOTUNIQUE, ['messagetext']);
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }
        


        /*****************************/
        //TABLA LOCAL MESSAGE READ

        // Define table local_message_read to be created.
        $table_read = new xmldb_table('local_message_read');

        //Test foreign key con la tabla local_message_read


        // Adding fields to table local_message_read.
        $table_read->add_field('id', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table_read->add_field('messageid', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, '0');
        $table_read->add_field('userid', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, '0');
        $table_read->add_field('timeread', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table local_message_read.
        $table_read->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        //$table_read->add_key('foreignkey10', XMLDB_KEY_FOREIGN, ['messageid'], 'local_message', ['id']);
        $for_key=new xmldb_key('foreignkey10', XMLDB_KEY_FOREIGN, ['messageid'], 'local_message', ['id']);

        // Si la tabla no existe se crea
        if (!$dbman->table_exists($table_read)) {
            $dbman->create_table($table_read);

        } else {
            //$values_read = $DB->get_records('local_message_read');
            //$num_records_read = $DB->count_records('local_message_read');

            $dbman->drop_table($table_read);
            $dbman->create_table($table_read);

            //foreach ($values_read as $key => $object_read) {
              //  $DB->insert_record('local_message_read', $object_read);
            //}

        }
        $dbman->add_key($table_read,$for_key);
        // Message savepoint reached.
        upgrade_plugin_savepoint(true, $oldversion + 1, 'local', 'message');
    }

    return true;
}