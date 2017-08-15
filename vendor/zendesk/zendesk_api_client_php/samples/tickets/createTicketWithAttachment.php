<?php
error_reporting(0);

include("../../../../../vendor/autoload.php");

use Zendesk\API\HttpClient as ZendeskAPI;

// Post Variables
$description = $_POST['description'];
$location = $_POST['location'];
$image = $_FILES['image'];
$pride = $_POST['pride'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$subdomain = "apu1502217909";
$username  = "knakamura13@apu.edu";
$token     = "hVTTqdotz8hLoAkuT5LFBNtG9iu6tanymZZ51gGX";

$targetdir = '../../../../../uploads/';
$targetfile = $targetdir.$_FILES['image']['name'];
$attachment = $targetfile;

// Build message body
$textBody = "";
if (isset($_POST["description"])) {
    $textBody .= $description."\n";
    $textBody = preg_replace('/^[ \t]*[\r\n]+/m', '', $textBody);
    $textBody .= "\n";
}
if (isset($_POST["location"])) {
    $textBody .= "Location: ";
    $textBody .= $location."\n";
}
if (isset($_POST["pride"])) {
    $textBody .= "Pride of place: ";
    if ($pride === "on") {
        $textBody .= "YES\n\n";
    } else {
        $textBody .= "NO\n\n";
    }
}
if (isset($_POST["phone"]) || (isset($_POST["email"]))) {
    if (isset($_POST["phone"])) {
        $textBody .= "Phone: ";
        $textBody .= $phone."\n";
    }
    if (isset($_POST["email"])) {
        $textBody .= "Email: ";
        $textBody .= $email."\n";
    }
}

$client = new ZendeskAPI($subdomain);
$client->setAuth('basic', ['username' => $username, 'token' => $token]);
if (move_uploaded_file($_FILES['image']['tmp_name'], $targetfile)) {
    try {
        // Upload file
        $attachment = $client->attachments()->upload([
            'file' => $attachment,
            'type' => 'image/png',
            'name' => $_FILES['image']['name']
        ]);
        
        // Create a new ticket with attachment
        $newTicket = $client->tickets()->create([
            'type' => 'problem',
            'subject'  => 'The quick brown fox',
            'comment'  => array(
                'body' => $textBody,
                'uploads' => [$attachment->upload->token]
            ),
            // 'requester' => array(
            //     'locale_id' => '1',
            //     'name' => 'Kyle Nakamura',
            //     'email' => $username,
            // ),
            'priority' => 'normal',
        ]);
        unlink($targetfile);
    } catch (\Zendesk\API\Exceptions\ApiResponseException $e) {
        echo $e->getMessage().'</br>';
    }
} else {
    // Create a new ticket without attachment
    $newTicket = $client->tickets()->create([
        'type' => 'problem',
        'subject'  => 'The quick brown fox',
        'comment'  => array(
            'body' => $textBody
        ),
        // 'requester' => array(
        //     'locale_id' => '1',
        //     'name' => 'Kyle Nakamura',
        //     'email' => $username,
        // ),
        'priority' => 'normal',
    ]);
}

$ticketID = $newTicket->ticket->id;

if (is_numeric($ticketID)) { ?>
    <script> <?php 
    $url = 'https://'.$subdomain.'.zendesk.com/agent/tickets/'.$ticketID;
    echo "window.open('$url');".PHP_EOL;
    echo "history.go(-1);"; ?>
    </script> <?php
} else {
    echo "There was an error and the Zendesk ticket was not created.";
}
