<?php

include("../../../../../vendor/autoload.php");

use Zendesk\API\HttpClient as ZendeskAPI;

// Post Variables
$description = $_POST['description'];
$location = $_POST['location'];
// $pride = $_POST['pride'];
// $email = $_POST['email'];
// $phone = $_POST['phone'];
$image = $_FILES['image'];

$subdomain = "apu1502217909";
$username  = "knakamura13@apu.edu";
$token     = "hVTTqdotz8hLoAkuT5LFBNtG9iu6tanymZZ51gGX";


$targetdir = '../../../../../uploads/';
$targetfile = $targetdir.$_FILES['image']['name'];
$attachment = $targetfile;

if (move_uploaded_file($_FILES['image']['tmp_name'], $targetfile)) {

    $client = new ZendeskAPI($subdomain);
    $client->setAuth('basic', ['username' => $username, 'token' => $token]);

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
                'body' => $_POST['description'],
                'uploads' => [$attachment->upload->token]
            ),
            'requester' => array(
                'locale_id' => '1',
                'name' => 'Example User',
                'email' => 'customer@example.com',
            ),
            'priority' => 'normal',
        ]);

        // Show result
        echo "<pre>";
        print_r($newTicket);
        echo "</pre>";
    } catch (\Zendesk\API\Exceptions\ApiResponseException $e) {
        echo $e->getMessage().'</br>';
    }
} else {

}
