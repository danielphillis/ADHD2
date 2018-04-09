<?php

    /**
     * sanitiseTitle 
     * shifted to this dedicated function
     * to create more specific, coherent modules
     * 
     * code in progress
     * 
     * title can start with numeral (ie 3D Golf)
     * 
     * references for name checking of data ?
     * 
     * 
     * @param type $_title
     * @param type $_debug
     */
    function sanitiseTitle($_title, $_debug){
        
        #check for spaces on ends
        
        $_title = trim($_title);
        
        
        return $_title;
        
    }
    
    /**
     * sanitiseYear
     * 
     * @param type $_yr
     * @param type $_debug
     * @return type
     */
    function sanitiseYear($_yr, $_debug){
        
        #check for numerals
        $_yr_str = ''.$_yr;

        for($i=0; $i < strlen($_yr_str); $i++){
            $char = $_yr_str[$i];
            echo $char.'<br>';
            
        }
        
        if ($_debug){
            if(gettype($_yr)!=getype(1)){ #int
                _msgBox('o', 'W: year is not an integer');
                exit();
            }
        }
        #check for spaces on ends
        
        if (gettype($_yr)==gettype('string')){
            _msgBox('o', 'W: year datatype is a string');
            $_yr = trim($_yr);
            _msgBox('o', 'W: year is now cast as an int');
            $_yr = (int) $_yr;
        }
        
        #check all chars for numbers
        return $_yr;
    }
    
?>

