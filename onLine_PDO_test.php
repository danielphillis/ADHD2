<?php

include "includes/ADHD_functionsUtilities.php";
include "../conn/ADHD_DB_CONNECTION_PDO.php";
include "includes/ADHD_functionsDisplayData.php";

_msgBox('o', 'TEMP TEST CONNECTION PAGE');
echo 'Testing PDO connection...<br>';
$conn = null;
$conn = connectDB();

if($conn){ 
    _msgBox ('g', 'PDO object returned...');
} else {
    _msgBox ('r', 'no conneciton...');
}
echo '<hr>';

/* --------------------------------------------------- */
/* test 1 - a basic query (no boud parms)
/* --------------------------------------------------- */
$q = "SELECT * FROM `software` WHERE softwareID = 10";
echo 'query formed..(no binding)<br>';
echo $q.'<br>';

$stmt = $conn->prepare($q);
$stmt->execute();
echo 'stmt executed...<br>';

$res = $stmt->fetch(PDO::FETCH_ASSOC);
echo 'results fetched...<br>';
if ($res) _msgBox ('g', 'data retreived...');
#print_r($res);
displayDataInTableFromAssocArray($res, 'red', 100, 0);
#displayArrayAsTable($res);

echo '<hr>';

/* --------------------------------------------------- */
/* test 2 -paramater binding (bind Value)
/* --------------------------------------------------- */

echo 'testing with bindValues...<hr>';
$bq = "SELECT * FROM `software` WHERE softwareID = :id";
echo 'query formed..(with binding)<br>';
echo $bq.'<br>';

$stmt2 = $conn->prepare($bq);

$stmt2->bindValue('id', 9);
echo 'binding: id=9 (using bindValue not bindParam)...<br>';

$stmt2->execute();
echo 'stmt executed...<br>';

$res = $stmt2->fetch(PDO::FETCH_ASSOC);
echo 'results fetched...<br>';

if ($res) _msgBox ('g', 'data retreived using bound values...');
#print_r($res);
displayDataInTableFromAssocArray($res, 'green', 100, 0);
#displayArrayAsTable($res);
echo '<hr>';

/* --------------------------------------------------- */
/* test 3 -paramater binding (bind Param)
/* --------------------------------------------------- */

echo 'testing with bindParms...<hr>';
$bq = "SELECT * FROM `software` WHERE softwareID = :id";
echo 'query formed..(with binding)<br>';
echo $bq.'<br>';

$stmt3 = $conn->prepare($bq);

$_swid = 24;
$stmt3->bindParam('id', $_swid);
echo 'binding: id=24 (using bindParam not binfParam)...<br>';

$stmt3->execute();
echo 'stmt executed...<br>';

$res = $stmt3->fetch(PDO::FETCH_ASSOC);
echo 'results fetched...<br>';

if ($res) _msgBox ('g', 'data retreived using bound values...');
#print_r($res);
displayDataInTableFromAssocArray($res, 'green', 100, 0);
#displayArrayAsTable($res);
echo '<hr>';


/* --------------------------------------------------- */
/* test 4 - test view access with simple query
/* --------------------------------------------------- */

echo 'testing(4) with VIEW'; #and literal Value (7)...<hr>';

$bq = "SELECT * FROM vSoftware"; #WHERE `softwareID` = 7
#echo 'query formed..(with binding)<br>';
echo $bq.'<br>';
$stmt4 = null;

if($conn){
    _msgBox('g', 'connection established...');
    $stmt4 = $conn->prepare($bq);
    $stmt4->execute();
    echo 'stmt4 executed...<br>';
    $res = $stmt4->fetch(PDO::FETCH_ASSOC);
    print_r($res);
    
} else {
    _msgBox('r', 'connection not established...');
    exit;
}

/* --------------------------------------------------- */
/* test 5 - test siple view access with simple query
/* --------------------------------------------------- */

echo 'testing(5) with new VIEW'; #and literal Value (7)...<hr>';

#make a new view

$q = 'CREATE VIEW `vSoftware2`  AS  select * FROM software';

$bq = "SELECT * FROM vSoftware"; #WHERE `softwareID` = 7
#echo 'query formed..(with binding)<br>';
echo $bq.'<br>';
$stmt4 = null;

if($conn){
    _msgBox('g', 'connection established...');
    $stmt4 = $conn->prepare($bq);
    $stmt4->execute();
    echo 'stmt4 executed...<br>';
    $res = $stmt4->fetch(PDO::FETCH_ASSOC);
    print_r($res);
    
} else {
    _msgBox('r', 'connection not established...');
    exit;
}


exit;
/**

if ($res){ 
    _msgBox ('g', 'data retreived from VIEW...');#using bound values
    
} else {
    
    echo "\nPDO::errorInfo():\n";
    print_r($res->errorInfo());
}

if ($res) echo 'results fetched...<br>';

    #displayDataInTableFromAssocArray($res, 'blue', 100, 0);
    #displayArrayAsTable($res);
    echo '<hr>';
    exit();
 */

?>

