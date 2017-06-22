<?php
error_reporting(0);
	if(isset($_POST['firstNameField']) && isset($_POST['lastNameField'])) {
	    $data = "Name: \t\t" 		. $_POST['firstNameField'] . " "  . 
	    							  $_POST['lastNameField'] . "\n" .
	    	 	"Phone: \t\t"  		. $_POST['phoneField']   . "\n" .
	    	 	"Email: \t\t" 		. $_POST['emailField']   . "\n" .
	    	 	"Campus: \t" 		. $_POST['campusRadio']   . "\n" .
	    	 	"Building: \t" 		. $_POST['buildingDropdown']  . "\n" .
	    		"Department: \t" 	. $_POST['departmentDropdown']   . "\n" .
	    		"Details: \t" 		. trim(preg_replace('/\s\s+/', ' ', $_POST['informationText']))  . "\n" .
	    		"Image: \t" 		. $_POST['imageFile']  . "\n" .
	    		"-------------------------------------------------------------- \n";
	    $ret = file_put_contents('../view/formData.txt', $data, FILE_APPEND);
	    chmod("../view/formData.txt", 0777);
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