<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('uploads.json'), true);
    $updatedVideo = json_decode(file_get_contents('php://input'), true);
    
    foreach ($data as &$video) {
        if ($video['id'] === $updatedVideo['id']) {
            $video['views'] = $updatedVideo['views'];
            break;
        }
    }
    
    file_put_contents('uploads.json', json_encode($data, JSON_PRETTY_PRINT));
    echo json_encode(['status' => 'success']);
}
?>
