<?php
error_reporting(0); // turn off all error reporting
	if (isset($_POST['firstNameField']) && isset($_POST['lastNameField'])) {
	    $data = "Name: \t\t" 		. $_POST['firstNameField'] . " "  . 
	    							  $_POST['lastNameField'] . "\n" .
	    	 	"Phone: \t\t"  		. $_POST['phoneField']   . "\n" .
	    	 	"Email: \t\t" 		. $_POST['emailField']   . "\n" .
	    	 	"Campus: \t" 		. $_POST['campusRadio']   . "\n" .
	    	 	"Building: \t" 		. $_POST['buildingDropdown']  . "\n" .
	    		"Department: \t" 	. $_POST['departmentDropdown']   . "\n" .
	    		"Details: \t" 		. trim(preg_replace('/\s\s+/', ' ', $_POST['informationText']))  . "\n" .
	    		"Image: \t" 		. "\n" .
	    		"-------------------------------------------------------------- \n";
	    $ret = file_put_contents('../view/formData.txt', $data, FILE_APPEND);
	    $uploaddir = '../view/uploadedImages/';
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		  echo "Image is valid and was successfully uploaded.\n";
		} else {
		   echo "Image upload failed";
		}

	    chmod("../view/formData.txt", 0777);  // Allow read-write on text file
	    if($ret === false) {
	        die('There was an error writing to formData.txt');
	    }
	    else {
	        echo "$ret bytes were written to formData.txt.";
	    }
	} else {
	   die('no post data to process');
	}
?>

<?php

/*
define("ZDAPIKEY", "[INSERT YOUR ZENDESK API KEY (Channels -> API)]");  
define("ZDUSER", "[ADMIN USERNAME]");  
define("ZDURL", "https://[YOUR SUBDOMAIN].zendesk.com/api/v2");

function curlWrap($url, $json, $action)  
{  
 $ch = curl\_init();  
 curl\_setopt($ch, CURLOPT\_FOLLOWLOCATION, true);  
 curl\_setopt($ch, CURLOPT\_MAXREDIRS, 10 );  
 curl\_setopt($ch, CURLOPT\_URL, ZDURL.$url);  
 curl\_setopt($ch, CURLOPT\_USERPWD, ZDUSER."/token:".ZDAPIKEY);  
 switch($action){  
 case "POST":  
 curl\_setopt($ch, CURLOPT\_CUSTOMREQUEST, "POST");  
 curl\_setopt($ch, CURLOPT\_POSTFIELDS, $json);  
 break;  
 case "GET":  
 curl\_setopt($ch, CURLOPT\_CUSTOMREQUEST, "GET");  
 break;  
 case "PUT":  
 curl\_setopt($ch, CURLOPT\_CUSTOMREQUEST, "PUT");  
 curl\_setopt($ch, CURLOPT\_POSTFIELDS, $json);  
 break;  
 case "DELETE":  
 curl\_setopt($ch, CURLOPT\_CUSTOMREQUEST, "DELETE");  
 break;  
 default:  
 break;  
 }

curl\_setopt($ch, CURLOPT\_HTTPHEADER, array('Content-type: application/json'));  
 curl\_setopt($ch, CURLOPT\_USERAGENT, "MozillaXYZ/1.0");  
 curl\_setopt($ch, CURLOPT\_RETURNTRANSFER, true);  
 curl\_setopt($ch, CURLOPT\_TIMEOUT, 10);  
 $output = curl\_exec($ch);  
 curl\_close($ch);  
 $decoded = json\_decode($output);  
 return $decoded;  
}

// CREATE AN ARRAY WITH POST DATA AND DESIRED TICKET CONTENT/ATTRIBUTES  
$arr = array(  
 "new\_req\_name" => $\_POST["req\_name"],  
 "new\_req\_email" => $\_POST["req\_email"],  
 "new\_tick\_group" => "20546933",  
 "new\_tick\_assignee" => "346228388",  
 "new\_tick\_subj" => $\_POST["subject"],  
 "new\_tick\_desc" => $\_POST["tick\_desc"]  
);

// CREATE JSON FORMATTED VARIABLE TO PASS AS PARAMETER TO API  
$create = json\_encode(  
 array(  
 'ticket' => array(  
 'requester' => array(  
 'name' => $arr['new\_req\_name'],  
 'email' => $arr['new\_req\_email']  
 ),  
 'group\_id' => $arr['new\_tick\_group'],  
 'assignee\_id' => $arr['new\_tick\_assignee'],  
 'subject' => $arr['new\_tick\_subj'],  
 'description' => $arr['new\_tick\_desc']  
 )  
 ),  
 JSON\_FORCE\_OBJECT  
);

$data = curlWrap("/tickets.json", $create, "POST");  
var\_dump($data);

print $data->ticket->id;  
print "\n";
*/

?>