<?php
session_start();
include("blocks/bd.php");

if(isset($_POST['editted_comment_text']))
{
    $editted_comment_text = $_POST['editted_comment_text'];
}

if(isset($_POST['comment_id']))
{
    $comment_id = $_POST['comment_id'];
}

if(isset($_POST['post_id']))
{
    $post_id = $_POST['post_id'];
}

$user_id = $_SESSION['user_id'];

if(empty($editted_comment_text))
{
    exit;
}

if(empty($comment_id))
{
    exit;
}

if(empty($post_id))
{
    exit;
}


$edit_comment_zapros = mysqli_query($db,"UPDATE `comments` SET `text` = '$editted_comment_text' WHERE `id` = '$comment_id' AND `post_id` = '$post_id'");

if($edit_comment_zapros == TRUE)
{
    echo json_encode(array("result" => "success", "comment_id" => $comment_id, "editted_comment_text" => $editted_comment_text, "post_id" => $post_id));
}

?>