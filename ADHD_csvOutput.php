<?php

    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename=DB_output.csv");
    header("Pragma: no-cache");
    header("Expires: 0");

    /**
     * Export MySQL table to Excel
     * csv (tabbed separated)
     * original version from http://mjdigital.co.uk/export-mysql-table-to-excel/
     * thank you

     * new version (tab separated added by graduate Daniel phillis
     * for Flinders University 2017
     * daniel.phillis@gmail.com)
    */


    # FILENAME
    $filename = 'ADHD_Entries.xls'; #modified

    # show errors (.ini file dependant) - true/false
    $showErrors = true;

    //////////////////////////////////////////////////////
    //
    //        DO NOT EDIT BELOW
    //
    //////////////////////////////////////////////////////

    if($showErrors) {
        error_reporting(E_ALL);
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors',1);
    }

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-type: application/vnd.ms-excel');


    function cleanData($str) {
        $str = preg_replace("/\t/", " ", $str); # clean out tabs in data - replace with space
        $str = preg_replace("/\n/", ", ", $str); # clean out line breaks and replace with comma+space
        $str = preg_replace("/\r/", "", $str); # clean out extra line breaks
        return $str;
    }

    require_once('../../conn/ADHD_DB_CONNECTION.php');
    $conn = connectDB();

    $d = '\n';

    $query_rsExport = "SELECT   title, 
                                year, 
                                description, 
                                notes, 
                                hardwareReq, 
                                softwareReq, 
                                licenceList, 
                                numberOfFiles, 
                                insertedDate, 
                                country, 
                                givenName, 
                                familyName, 
                                fullName, 
                                publisherName 
                                FROM 
                                vsoftware 
                                ORDER BY title";

    $rsExport = $conn->prepare($query_rsExport);
    $rsExport->execute();
    $fields = $rsExport -> fetchAll();



    #better way to go - make an array from the SQL string using explode
    #loop over it to make the first line of column titles

    #col names hardcoded (the query is hardcoded anyway)
    print "title\t year\t description\t notes\t hardwareReq\t softwareReq\t licenceList]\t numberOfFiles\t insertedDate\t country\t givenName\t familyName\t fullName\t publisherName";
    print PHP_EOL;

    #DATA
    foreach ($fields as $data){ /* each row is saved as $data */

            for($j=0;$j<sizeOf($data)/2;$j++){

                cleanData($data);
                print $data[$j];
                print "\t"; # note the use of " instead of ' - this is imperative
            }
            print PHP_EOL;

    }
?>
