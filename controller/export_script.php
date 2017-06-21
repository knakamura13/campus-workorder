<?php
error_reporting(0);
	if(isset($_POST['firstNameField']) && isset($_POST['lastNameField'])) {
	    $data = "Name: \t\t" 		. $_POST['firstNameField'] . " "  . 
	    							  $_POST['lastNameField'] . "\n" .
	    	 	"Phone: \t\t"  		. $_POST['phoneField']   . "\n" .
	    	 	"Email: \t\t" 		. $_POST['emailField']   . "\n" .
	    	 	"Campus: \t" 		. $_POST['campusSection']   . "\n" .
	    	 	"Building: \t" 		. $_POST['buildingSection']  . "\n" .
	    		"Department: \t" 	. $_POST['departmentSection']   . "\n" .
	    		"Service: \t"		. $_POST['serviceOne'] . $_POST['serviceTwo'] . 
	    							  $_POST['serviceThree'] . $_POST['serviceFour'] . 
	    							  $_POST['serviceFive'] . $_POST['serviceSix'] .  "\n" .
	    		"Details: \t" 		. trim(preg_replace('/\s\s+/', ' ', $_POST['informationSection']))  . "\n" .
	    		"Image: \t" 		. $_POST['imageSection']  . "\n" .
	    		"-------------------------------------------------------------- \n";
	    $ret = file_put_contents('../view/form_data.txt', $data, FILE_APPEND | LOCK_EX);
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