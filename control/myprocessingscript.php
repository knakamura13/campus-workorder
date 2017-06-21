<?php
error_reporting(0);
	if(isset($_POST['element_2_1']) && isset($_POST['element_2_2'])) {
	    $data = "Name: \t\t" 		. $_POST['element_2_1'] . " "  . 
	    							  $_POST['element_2_2'] . "\n" .
	    	 	"Phone: \t\t"  		. $_POST['element_6']   . "\n" .
	    	 	"Email: \t\t" 		. $_POST['element_7']   . "\n" .
	    	 	"Campus: \t" 		. $_POST['element_9']   . "\n" .
	    	 	"Building: \t" 		. $_POST['element_10']  . "\n" .
	    		"Department: \t" 	. $_POST['element_1']   . "\n" .
	    		"Service: \t"		. $_POST['element_8_1'] . $_POST['element_8_2'] . 
	    							  $_POST['element_8_3'] . $_POST['element_8_4'] . 
	    							  $_POST['element_8_5'] . $_POST['element_8_6'] .  "\n" .
	    		"Details: \t" 		. trim(preg_replace('/\s\s+/', ' ', $_POST['element_4']))  . "\n" .
	    		"Image: \t" 		. $_POST['element_3']  . "\n" .
	    		"-------------------------------------------------------------- \n";
	    $ret = file_put_contents('../view/mydata.txt', $data, FILE_APPEND | LOCK_EX);
	    if($ret === false) {
	        die('There was an error writing this file');
	    }
	    else {
	        echo "$ret bytes written to file";
	    }
	}
	else {
	   die('no post data to process');
	}
?>