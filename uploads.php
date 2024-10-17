<?php
// Path to the uploads.json file
$jsonFile = 'uploads.json';

// Check if the file exists
if (!file_exists($jsonFile)) {
    file_put_contents($jsonFile, '[]'); // Create empty JSON file if not exists
}

// Get the current contents of the file
$data = file_get_contents($jsonFile);
$uploads = json_decode($data, true);

// Generate a random ID for the video
function generateRandomId($length = 8) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

// Get data from form
$title = $_POST['title'];
$url = $_POST['url'];
$thumbnail = !empty($_POST['thumbnail']) ? $_POST['thumbnail'] : "default-thumbnail.jpg"; // Use default if empty

// Append new video data with a random ID
$newVideo = [
    'id' => generateRandomId(),
    'title' => $title,
    'url' => $url,
    'thumbnail' => $thumbnail
];
$uploads[] = $newVideo;

// Save the updated data back to the file
file_put_contents($jsonFile, json_encode($uploads));

// Redirect back to the admin page
header('Location: admin.html');
exit();
?>
