<?php 
session_start();
include("blocks/bd.php");
        if(empty($_SESSION['user_id']))
        {
            echo json_encode(array("result" => "error", "error" => "session user id NOT FOUND"));
            exit;
        }
        
        if(isset($_POST['post_id']))
        {
            $post_id = $_POST['post_id'];
        }

        if(isset($_POST['have_tag']))
        {
            $have_tag = $_POST['have_tag'];
        }
        
        if(empty($post_id))
        {
            echo json_encode(array("result" => "error", "error" => "post_id not found"));
            exit;
        }

        if(!preg_match('/^[0-9]{1,10}$/', $post_id))
        {
            echo json_encode(array("result" => "error", "error" => "post_id not preg_match"));
            exit;
        }
        
        $zapros = mysqli_query($db,"SELECT * FROM `posts` WHERE `id` = '$post_id'");
        $row = mysqli_fetch_array($zapros);
        
        if(empty($row['id']))
        {
            echo json_encode(array("result" => "error", "error" => "not found post in database"));
            exit;
        }
        
        if($row['nickname'] !== $_SESSION['user_nickname'])
        {
            echo json_encode(array("result" => "error", "error" => "session user is not a AUTHOR"));
            exit;
        }
        
        unlink($row['file']);
        
        $delete_zapros = mysqli_query($db,"DELETE FROM `posts` WHERE `id` = '$post_id'");
        $delete_comments = mysqli_query($db,"DELETE FROM `comments` WHERE `post_id` = '$post_id'");
        $delete_rating = mysqli_query($db,"DELETE FROM `rating` WHERE `post_id` = '$post_id'");
        
        if($delete_zapros == TRUE)
        {
            if(empty($have_tag)) {
                $select_zapros = mysqli_query($db,"SELECT * FROM `posts`");
                $row_posts = mysqli_fetch_array($select_zapros);
                if (empty($row_posts['id'])) {
                    $num_posts = "empty";
                } else {
                    $num_posts = "not_empty";
                }
                echo json_encode(array("result" => "success", "num_posts" => $num_posts));
            }
            else
                {
                    $select_zapros = mysqli_query($db,"SELECT * FROM `posts` WHERE `tag1` = '$have_tag' OR `tag2` = '$have_tag' OR `tag3` = '$have_tag' OR `tag4` = '$have_tag' OR `tag5` = '$have_tag'");
                    $row_posts = mysqli_fetch_array($select_zapros);
                    if (empty($row_posts['id'])) {
                        $num_posts = "empty";
                    } else {
                        $num_posts = "not_empty";
                    }
                    echo json_encode(array("result" => "success", "num_posts" => $num_posts));
                }
        }
?>