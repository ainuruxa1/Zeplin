<?php

session_start();
include("blocks/bd.php");

$session_user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];
$type = $_POST['type'];

$proverka_dislike = mysqli_query($db,"SELECT * FROM `rating` WHERE `post_id` = '$post_id' AND `user_id` = '$session_user_id' AND `type` = '$type'");
$proverka_dislike_row = mysqli_fetch_array($proverka_dislike);

if(!empty($proverka_dislike_row['id']))
{
    $delete_dislike = mysqli_query($db,"DELETE FROM `rating` WHERE `post_id` = '$post_id' AND `user_id` = '$session_user_id' AND `type` = '$type'");
    $dislike_zapros = mysqli_query($db,"SELECT * FROM `rating` WHERE `post_id` = '$post_id' AND `type` = '$type'");
    $dislike_kolvo = mysqli_num_rows($dislike_zapros);
    echo json_encode(array("result" => "success", "dislike_count" => $dislike_kolvo));
}
else
{
    $add_dislike = mysqli_query($db,"INSERT INTO `rating` (`post_id`,`user_id`,`type`) VALUES ('$post_id', '$session_user_id', '$type')");
    $dislike_zapros = mysqli_query($db,"SELECT * FROM `rating` WHERE `post_id` = '$post_id' AND `type` = '$type'");
    $dislike_kolvo = mysqli_num_rows($dislike_zapros);
    echo json_encode(array("result" => "success", "dislike_count" => $dislike_kolvo));
}

?>