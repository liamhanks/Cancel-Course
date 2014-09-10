<?php
 
function xmldb_block_cancelcourse_upgrade($oldversion) {
    global $CFG, $DB;
 
	$dbman = $DB->get_manager(); // loads ddl manager and xmldb classes
	
    $result = TRUE;
 
    if ($oldversion < 2013081220) {

        // Define table block_cancelcourse to be created.
        $table = new xmldb_table('block_cancelcourse');

        // Adding fields to table block_cancelcourse.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('classid', XMLDB_TYPE_CHAR, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('canceldate', XMLDB_TYPE_CHAR, '8', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table block_cancelcourse.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for block_cancelcourse.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Cancelcourse savepoint reached.
        upgrade_block_savepoint(true, 2013081220, 'cancelcourse');
    }


 
    return $result;
}
?>