<?php
session_start();
include("blocks/bd.php");

if(isset($_POST['comment_id']))
{
    $comment_id = $_POST['comment_id'];
}

if(isset($_POST['post_id']))
{
    $post_id = $_POST['post_id'];
}

$user_id = $_SESSION['user_id'];

$delete_comment = mysqli_query($db,"DELETE FROM `comments` WHERE `id` = '$comment_id' AND `user_id` = '$user_id'");

if($delete_comment == TRUE)
{
    $zapros_comments = mysqli_query($db,"SELECT * FROM `comments` WHERE `post_id` = '$post_id'");
    $row_comments = mysqli_fetch_array($zapros_comments);
    $count_comments = mysqli_num_rows($zapros_comments);
    if(empty($row_comments['id']))
    {
        $null_comments = "null";
    }
    else{
        $null_comments = "notnull";
    }
    echo json_encode(array("result" => "success", "comment_id" => $comment_id, "null_comments" => $null_comments, "count_comments" => $count_comments));
}

?>