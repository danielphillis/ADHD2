<?php
/**
 * IMAGES / DOCS / UPLOADS
 */

$TOGGLE_TABLE_BORDERS = 1;
$DEBUG = 0;

$fileSQL = 'SELECT
		up.fileName, 
		up.fileType, 
		up.fileSize, 
		up.softwareID 
	FROM uploadedFiles AS up, software AS s 
	WHERE up.sequenceNum = 1 
	AND up.softwareID = s.softwareID 
	AND up.softwareID = \''.$softwareID.'\';';

$resFile = $conn->prepare($fileSQL);
$resFile->execute();
$resArray = $resFile->fetchAll();

#  GOING THROUGH THE DATA
if(count($resArray) > 0) {

	$filePathImage 	= array(); #  Save image names with path in an array for later display
	$filePathDoc 	= array(); #  Save document names with path in an array for later display
	$fileTypeDoc 	= array(); #  Save document types for later display
	$fileSizeDoc 	= array(); #  Save document size for later display

	$imageFlag 		= 0; #  To display to user whether the attachment is an image (0=no, 1=yes);
	$docFlag 		= 0; #  To display to user whether the attachment is a doc (0=no, 1=yes);
	$indexImage 	= 0; #  Index for image array
	$indexDoc 		= 0; #  Index for doc array

    # dont need to be looped
    $imgThumbSizeX = 100;
    $imgThumbSizeY = 140;

    #put all images in another table ?

    echo '<table border = "1" 
        style="
            /*border: whitesmoke; */
            /*border: red;*/
            border: whitesmoke;
        ">';
    echo '<tr>';

    foreach($resArray as $rowFile){

        echo '<tr><td width="100%">';
            # Keeping track of which files are images and which files are documents
    $newPath = 'includes/uploads/'.$softwareID."/".$rowFile['fileName'];
    $prevPath = $newPath;

    # dont display the same image more than once !

    switch ($rowFile['fileType']){
            case "gif":
                    $imageFlag = 1;
                    $filePathImage[$indexImage] = $newPath;
                    $indexImage++;
                    break;
            case "png":
                    $imageFlag = 1;
                    #$filePathImage[$indexImage] = "uploads/".$softwareID."/".$rowFile['fileName'];
                    $filePathImage[$indexImage] = $newPath;
                    $indexImage++;
                    break;	
            case "jpg":
                    $imageFlag = 1; #includes folder added to path below 8/12/17
                    #$filePathImage[$indexImage] = $base.$softwareID."/".$rowFile['fileName'];
                    $filePathImage[$indexImage] = $newPath;
                    $indexImage++;
                    break;	
            case "txt":
                    $docFlag = 1;
                    #$filePathDoc[$indexDoc] = "uploads/".$softwareID."/".$rowFile['fileName'];
                    $filePathImage[$indexImage] = $newPath;
                    $fileTypeDoc[$indexDoc] = $rowFile['fileType'];
                    $fileSizeDoc[$indexDoc] = floor($rowFile['fileSize']/1000);
                    $indexDoc++;
                    break;
            case "pdf":
                    $docFlag = 1;
                    #$filePathDoc[$indexDoc] = "uploads/".$softwareID. "/".$rowFile['fileName'];
                    $filePathDoc[$indexDoc] = $newPath;
                    $fileTypeDoc[$indexDoc] = $rowFile['fileType'];
                    $fileSizeDoc[$indexDoc] = floor($rowFile['fileSize']/1000);
                    $indexDoc++;
                    break;

    }# end switch

    if ($DEBUG) {
        echo 'Path: ';
        echo $filePathImage[$indexImage - 1];
        echo '<br>';
        #echo '@ls *';
        #print_r($res_array());
    }

    # DISPLAY UPLOADED IMAGES
    $imageCount = sizeOf($filePathImage);

    #if($imageFlag == 1 && ($imageCount > 0)){
    if($imageFlag && $imageCount){
        echo "<br><b>Photo Attachments:</b><br><br>";
        echo '<table border="'.$TOGGLE_TABLE_BORDERS.'" 
                style="
                    border-top: none;
                    border-bottom: none;
                    border-left: none;
                    border-right: none;
                    /*border-color: green;*/
                    border-color: whitesmoke; 
            ">';

        echo '<tr>';
        echo '<tr>';
        # TEST
        # echo 'ImagePath: '.$filePathImage.'<br>';
        # echo 'uploads/10/hobbit1.gif';
        if ($DEBUG) print_r($filePathImage);

        # FOREACH IMAGE

        if ($DEBUG) echo '$imageCount in image folder: '.$imageCount.'<br>';

                    for($i=0; $i < $indexImage; $i++){
                        if($DEBUG) {
                echo '$i: ' . $i . '<br>';
                echo '$indexImage: ' . $indexImage . '<br>';
            }
            #REMOVE DUPLICATE IMAGE DISPLAY #($filePathImage[$i] != $filePathImage[$i-1])
                            if( file_exists($filePathImage[$i])){
                    echo '<td>';
                    /** DONT DISPLAUY DUPLICATE IMAGES */
                    if($indexImage < 2) {
                    echo '<a href="' . $filePathImage[$i] . '" class="fullsizable">';
                    #DISLPAY IMAGE
                    echo '<img';
                    echo ' class="fullsizable" src="' . $filePathImage[$i];

                    # image size vars must be gloabls
                    echo '" width="' . $imgThumbSizeX . '"';
                    echo ' height="' . $imgThumbSizeY . '"';
                    echo '>';
                }
                echo '</a></td>';
                            }else{
                                    echo 'DEBUG: file path broken<br>';
                            }
                    }#end For loop
                    echo '</td></tr>';
            }

        /** DISPLAY UPLOADED DOCUMENTS
         *  Displaying the documents if any of the files in the switch
         * statement above were documents (true if the $docFlag is set to 1)
         */
        $_debug = 0;
        
        if ($docFlag == 1) {
                echo "<br><b>Document Attachments:</b><br>";
                echo '<br><br>';
                echo '<tr>';
                # FOREACH DOCUMENT
                for ($i=0; $i<sizeOf($filePathDoc); $i++) {
                        echo '<td>';

                         if($_debug){
                            echo 'filePathDoc: ';
                            print_r($filePathDoc);
                         }

                    if(file_exists($filePathDoc[$i])){
                        echo "<a href='" . $filePathDoc[$i];
                        echo "' target='_blank'>View This Document
                        </a> (";
                        echo $fileTypeDoc[$i] . ") (" . $fileSizeDoc[$i] . "kb)<br>";
                    }else{
                        echo 'DEBUG: Doc filePath Broken<br>';
                    }
                    echo '</td>';
                }
                echo '</tr>';
        }# end if documents are uploaded
        echo '</td></tr>';
        echo '</table>'; #table dedicated to images
    } # end for each(array)
    #echo '</table>';
    echo '</hr>';
    
}# end if
/** END UPLOADS -------------------------------------------------- */
?>