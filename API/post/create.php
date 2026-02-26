<?php 
    //headers
     header('Access-Control-Allow-Origin: *');
     header('Content-Type: application/json');
     header('Access-Control-Allow-Methods: POST');
     header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,
     Access-Control-Allow_methods, Authorization, X-Requested-with');
     include_once '../../config/Database.php';
     include_once '../../models/Post.php';

     // Instantiate DB & Connect
     $database = new Database();
     $db = $database->connect();
     
     // Instantiate Blog Post Object
     $post = new Post($db);

     // Get raw posted data
     $data = json_decode(file_get_contents("phpL//input"));

     $post->title = $data->title;
     $post->body = $data->body;
     $post->author = $data->author;
     $post->category_id = $data->category_id;

     //Create post
     if($post->create()){
        echo json_encode(
            array('message' => 'Post Created')
        );
     } else {
        echo json_encode(
            array('message' => 'Post Not Created')
        );
     }