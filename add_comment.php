<?php
session_start();
include("blocks/bd.php");

if(isset($_POST['post_id']))
{
    $post_id = $_POST['post_id'];
}

if(isset($_POST['comment_text']))
{
    $comment_text = $_POST['comment_text'];
}

if(isset($_FILES['comment_picture']['name']))
{
    $comment_picture = $_FILES['comment_picture']['name'];
}
else
{
    $comment_picture = "empty";
}

if(empty($post_id))
{
    exit;
}
if(empty($comment_text))
{
    exit;
}

$zapros1 = mysqli_query($db,"SELECT * FROM `posts` WHERE `id` = '$post_id'");
$row1 = mysqli_fetch_array($zapros1);

/*
if(empty($row1['id']))
{
    exit;
}
*/

$zapros3 = mysqli_query($db,"SELECT * FROM `comments` WHERE `post_id` = '$post_id'");
$row3 = mysqli_fetch_array($zapros3);
if(empty($row3['id']))
{
    $count_comments_before = "null";
}
else{
    $count_comments_before = "notnull";
}

$comment_text = htmlspecialchars($comment_text);
$comment_text = stripslashes($comment_text);

$user_id = $_SESSION['user_id'];
$date = date("d.m.Y H:i:s");

$add_comment = mysqli_query($db,"INSERT INTO `comments` (`post_id`,`user_id`,`text`,`image`,`date`) VALUES ('$post_id','$user_id','$comment_text','$comment_picture','$date')");

if($add_comment == TRUE)
{
    $zapros2 = mysqli_query($db,"SELECT * FROM `comments` WHERE `post_id` = '$post_id' AND `user_id` = '$user_id' AND `text` = '$comment_text' AND `date` = '$date'");
    $row2 = mysqli_fetch_array($zapros2);
    
    $zapros5 = mysqli_query($db,"SELECT * FROM `comments` WHERE `post_id` = '$post_id'");
    $count_comments = mysqli_num_rows($zapros5);
    
    echo json_encode(array("result" => "success", "comment_id" => $row2['id'], "post_id" => $post_id, "comment_text" => $comment_text, "date" => $date, "user_avatar" => $_SESSION['user_avatar'], "user_nickname" => $_SESSION['user_nickname'], "user_id" => $_SESSION['user_id'], "deletee" => "Delete", "count_comments_before" => $count_comments_before, "count_comments" => $count_comments));
}






?>