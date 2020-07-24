<?php
$db = mysqli_connect("localhost", "root", "root", "zeplin");
mysqli_query($db,"SET NAMES 'utf8'");
mysqli_query($db,"SET CHARACTER SET 'utf8'");
mysqli_query($db,"SET SESSION collation_connection = 'utf8_general_ci'");
?>
