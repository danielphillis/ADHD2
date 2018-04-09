<?php

/**
 * 
 * @global type $conn
 */
function deleteAllTestDataWithPrefix($_prefix){
    global $conn;
    $del = 'delete * FROM software WHERE title LIKE "';
    $del.= $_prefix;
    $del.= '"';
    
    $count = $conn->exec($del); #no of rows affected
}

?>

