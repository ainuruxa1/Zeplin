<?php
session_start();
include("blocks/bd.php");

if( isset( $_POST['my_file_upload'] ) ){  
	// ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно
            if(isset($_POST['tag1']))
            {
                $tag1 = $_POST['tag1'];
            }
            
            if(isset($_POST['tag2']))
            {
                $tag2 = $_POST['tag2'];
            }
            
            if(isset($_POST['tag3']))
            {
                $tag3 = $_POST['tag3'];
            }
            
            if(isset($_POST['tag4']))
            {
                $tag4 = $_POST['tag4'];
            }
            
            if(isset($_POST['tag5']))
            {
                $tag5 = $_POST['tag5'];
            }
            
            if(empty($tag1) or empty($tag2) or empty($tag3))
            {
                echo json_encode(array("errorr" => "empty tag1 2 3"));
                exit;
            }

            if(empty($tag4))
            {
                $tag4 = "tag_empty";
            }
            else
            {
                if(!preg_match('/^[а-яА-Яa-zA-Z0-9]{1,20}$/u', $tag4))
                {
                    echo json_encode(array("errorr" => "not preg match tag4"));
                    exit;
                }
            }
            
            if(empty($tag5))
            {
                $tag5 = "tag_empty";
            }
            else
            {
                if(!preg_match('/^[а-яА-Яa-zA-Z0-9]{1,20}$/u', $tag5))
                {
                    echo json_encode(array("errorr" => "not preg match tag5"));
                    exit;
                }
            }
            
            if(!preg_match('/^[а-яА-Яa-zA-Z0-9]{1,20}$/u', $tag1))
            {
                echo json_encode(array("errorr" => "not preg match tag1"));
                exit;
            }
            
            if(!preg_match('/^[а-яА-Яa-zA-Z0-9]{1,20}$/u', $tag2))
            {
                echo json_encode(array("errorr" => "not preg match tag2"));
                exit;
            }
            
            if(!preg_match('/^[а-яА-Яa-zA-Z0-9]{1,20}$/u', $tag3))
            {
                echo json_encode(array("errorr" => "not preg match tag3"));
                exit;
            }

	$uploaddir = 'posts'; // . - текущая папка где находится submit.php

	$files = $_FILES; // полученные файлы
	$done_files = array();

	// переместим файлы из временной директории в указанную
	foreach( $files as $file ){
		$file_name = $file['name'];

        if(empty($file_name))
        {
            echo json_encode(array("errorr" => "empty file_name"));
            exit;
        }
        
        $type_image = $file['type'];
        
        if($type_image == "image/jpeg" or $type_image == "image/png" or $type_image == "image/gif" or $type_image == "video/mp4")
        {
            $random = rand(10000,99999);                
            if($type_image == "image/jpeg")
            {
                $format_image = ".jpg";
                $type_file = "image";
            }
            if($type_image == "image/png")
            {
                $format_image = ".png";
                $type_file = "image";
            }
            if($type_image == "image/gif")
            {
                $format_image = ".gif";
                $type_file = "image";
            }
            if($type_image == "video/mp4")
            {
                $format_image = ".mp4";
                $type_file = "video";
            }
        }
        else
        {
            echo json_encode(array("errorr" => "invalid file type"));
            exit;
        }
                
        $image_url = "posts/post_".$random."".$format_image;
        
		if(move_uploaded_file($file['tmp_name'], $image_url)){
			$done_files[] = realpath("$uploaddir/$file_name");
            $nickname_session = $_SESSION['user_nickname'];
            $date = date("Y.m.d H:i:s");
            $add_post = mysqli_query($db,"INSERT INTO `posts` (`nickname`,`tag1`,`tag2`,`tag3`,`tag4`,`tag5`,`file`,`type_file`,`date`) VALUES ('$nickname_session','$tag1','$tag2','$tag3','$tag4','$tag5','$image_url','$type_file','$date')");
            if($add_post == TRUE)
            {
                $zapros1 = mysqli_query($db,"SELECT * FROM `posts` WHERE `nickname` = '$nickname_session' AND `date` = '$date'");
                $row1 = mysqli_fetch_array($zapros1);
                
                if($row1['tag4'] == "tag_empty")
                {
                    $post_tag4 = "";
                }
                else
                {
                $post_tag4 = '<a href="posts.php?tag='.$row1['tag4'].'">   
		                          <span class="post_block_top_right_tag4">'.$row1['tag4'].'</span>
                                </a>';
                }
                        
                if($row1['tag5'] == "tag_empty")
                {
                    $post_tag5 = "";
                }
                else
                {
                    $post_tag5 = '<a href="posts.php?tag='.$row1['tag5'].'">   
                                <span class="post_block_top_right_tag5">'.$row1['tag5'].'</span>
                            </a>';
                }
                
                if($row1['nickname'] == "avkhadiev123")
                {
                    $admin = '<img src="img/galka.png" />';
			    }
                else
    			{
    				$admin = "";
    			}

                if($type_file == "video")
                {
                    $file = '<video style="width: 400px; height: 400px;" class="post_video">
                    <source src="'.$image_url.'" type="video/mp4">
                </video>';
                }

                if($type_file == "image")
                {
                    $file = '<img src="'.$image_url.'" class="post_block_center_image_i" />';
                }

                $data = $done_files ? array("file" => $file, "id" => $row1['id'], "ses_user_id" => $_SESSION['user_id'], "nickname" => $row1['nickname'], "admin" => $admin, "avatar" => $_SESSION['avatar'], "tag1" => $row1['tag1'], "tag2" => $row1['tag2'], "tag3" => $row1['tag3'], "tag4" => $post_tag4, "tag5" => $post_tag5, "date" => $row1['date']) : array('error' => 'Ошибка загрузки файлов.');
                die(json_encode($data));
            }
		}
        else
        {
            echo json_encode(array("errorr" => "error move_uploaded_file"));
            exit;
        }
	}
}
?>