<?php 

    //headers
     header('Access-Control-Allow-Origin: *');
     header('Content-Type: application/json');

    //include
     include_once '../../config/Database.php';
     include_once '../../models/Post.php';
    include_once '../../models/category.php';
     // Instantiate DB & Connect
     $database = new Database();
     $db = $database->connect();

    // Instantiate category object
     $category = new Category($db);
     $result = $category->read();
     $num = $result ->rowCount();

    // Check if there are any categories
     if($num > 0) {

     // Category Array
        $cat_arr = array();
        $cat_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $cat_item = array (
                'id' => $id,
                'name' => $name,
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name
            );

            // Push to "data"
            array_push($cat_arr['data'], $cat_item);
        }

        // Turn to JSON & Output
        echo json_encode($cat_arr);

     } else {
        // No Posts
        echo json_encode(
            array('message' => 'No Posts Found')
        );

     }