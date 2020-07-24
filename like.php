<?php

session_start();
include("blocks/bd.php");

$session_user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];
$type = $_POST['type'];

$proverka_like = mysqli_query($db,"SELECT * FROM `rating` WHERE `post_id` = '$post_id' AND `user_id` = '$session_user_id' AND `type` = '$type'");
$proverka_like_row = mysqli_fetch_array($proverka_like);

if(!empty($proverka_like_row['id']))
{
    $delete_like = mysqli_query($db,"DELETE FROM `rating` WHERE `post_id` = '$post_id' AND `user_id` = '$session_user_id' AND `type` = '$type'");
    $like_zapros = mysqli_query($db,"SELECT * FROM `rating` WHERE `post_id` = '$post_id' AND `type` = '$type'");
    $like_kolvo = mysqli_num_rows($like_zapros);
    echo json_encode(array("result" => "success", "like_count" => $like_kolvo));
}
else
{
    $add_like = mysqli_query($db,"INSERT INTO `rating` (`post_id`,`user_id`,`type`) VALUES ('$post_id', '$session_user_id', '$type')");
    $like_zapros = mysqli_query($db,"SELECT * FROM `rating` WHERE `post_id` = '$post_id' AND `type` = '$type'");
    $like_kolvo = mysqli_num_rows($like_zapros);
    echo json_encode(array("result" => "success", "like_count" => $like_kolvo));
}

?>