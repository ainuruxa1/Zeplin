<?php 
session_start();
?>
<!DOCTYPE HTML>
<html>
<?
include("blocks/bd.php");
?>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="" />
    <? include("blocks/head_scripts.php"); ?>
	<title>ZEPLIN</title>
</head>

<body>

    <div class="head_block">
        <? 
        include("blocks/header.php");
        if(empty($_SESSION['user_id']))
        {
            include("blocks/welcome.php");
            include("blocks/footer.php");
            exit;
        }
        ?>
        <div class="main_body">
            <?
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
            
            if(isset($_POST['post_id']))
            {
                $post_id = $_POST['post_id'];
            }
            
            if(isset($_POST['post_image_value']))
            {
                $post_image_value = $_POST['post_image_value'];
            }
            
            if(empty($post_id))
            {
                echo('<script language="JavaScript">
                        document.location.href = "index.php";
                      </script>');
            }
            
            if(empty($tag1) or empty($tag2) or empty($tag3))
            {
                echo('<div class="add_post_top">
                        <div class="add_post_top_text">
                            Первые три тега обязательны! 
                            <a href="edit_post.php?post_id='.$post_id.'" style="color: orange;">Назад</a>
                        </div>
                      </div></div>');
                include("blocks/footer.php");
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
                    echo('<div class="add_post_top">
                            <div class="add_post_top_text">
                                4-ый тег не соответствует требованиям.
                                <a href="edit_post.php?post_id='.$post_id.'" style="color: orange;">Назад</a>
                            </div>
                          </div></div>');
                    include("blocks/footer.php");
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
                    echo('<div class="add_post_top">
                            <div class="add_post_top_text">
                                5-ый тег не соответствует требованиям.
                                <a href="edit_post.php?post_id='.$post_id.'" style="color: orange;">Назад</a>
                            </div>
                          </div></div>');
                    include("blocks/footer.php");
                    exit;
                }
            }
            
            if(!preg_match('/^[а-яА-Яa-zA-Z0-9]{1,20}$/u', $tag1))
            {
                echo('<div class="add_post_top">
                        <div class="add_post_top_text">
                            1-ый тег не соответствует требованиям.
                            <a href="edit_post.php?post_id='.$post_id.'" style="color: orange;">Назад</a>
                        </div>
                      </div></div>');
                include("blocks/footer.php");
                exit;
            }
            
            if(!preg_match('/^[а-яА-Яa-zA-Z0-9]{1,20}$/u', $tag2))
            {
                echo('<div class="add_post_top">
                        <div class="add_post_top_text">
                            2-ой тег не соответствует требованиям.
                            <a href="edit_post.php?post_id='.$post_id.'" style="color: orange;">Назад</a>
                        </div>
                      </div></div>');
                include("blocks/footer.php");
                exit;
            }
            
            if(!preg_match('/^[а-яА-Яa-zA-Z0-9]{1,20}$/u', $tag3))
            {
                echo('<div class="add_post_top">
                        <div class="add_post_top_text">
                            3-ий тег не соответствует требованиям.
                            <a href="edit_post.php?post_id='.$post_id.'" style="color: orange;">Назад</a>
                        </div>
                      </div></div>');
                include("blocks/footer.php");
                exit;
            }
            
            $zapros1 = mysqli_query($db,"SELECT * FROM `posts` WHERE `id` = '$post_id'");
            $row1 = mysqli_fetch_array($zapros1);
            
            if($post_image_value !== $row1['file'])
            {
                if(empty($_FILES['post_image']['name']))
                {
                    echo('<div class="add_post_top">
                            <div class="add_post_top_text">
                                Файл не найден. 
                                <a href="edit_post.php?post_id='.$post_id.'" style="color: orange;">Назад</a>
                            </div>
                          </div></div>');
                    include("blocks/footer.php");
                    exit;
                }
                $type_image = $_FILES['post_image']['type'];
            
                if($type_image == "image/jpeg" or $type_image == "image/png" or $type_image == "image/gif")
                {
                    $random = rand(10000,99999);                
                    if($type_image == "image/jpeg")
                    {
                        $format_image = ".jpg";
                    }
                    if($type_image == "image/png")
                    {
                        $format_image = ".png";
                    }
                    if($type_image == "image/gif")
                    {
                        $format_image = ".gif";
                    }
                    $image_url = "posts/post_".$random."".$format_image;
                    unlink($row1['file']);
                    move_uploaded_file($_FILES['post_image']['tmp_name'], $image_url);
                }
                else
                {
                    echo('<div class="add_post_top">
                        <div class="add_post_top_text">
                        Неизвестный формат файла. Хочешь залить вирус?!
                        <a href="edit_post.php?post_id='.$post_id.'" style="color: orange;">Назад</a>
                        </div>
                        </div></div>');
                    include("blocks/footer.php");
                    exit;
                }
            }
            else
            {
                $image_url = $row1['file'];
            }
            
            $edit_post_zapros = mysqli_query($db,"UPDATE `posts` SET `tag1` = '$tag1', `tag2` = '$tag2', `tag3` = '$tag3', `tag4` = '$tag4', `tag5` = '$tag5', `file` = '$image_url' WHERE `id` = '$post_id'");
            if($edit_post_zapros == TRUE)
            {
                echo('<div class="add_post_top">
                    <div class="add_post_top_text">
                    Пост успешно редактирован.
                    <a href="index.php" style="color: orange;">На главную</a>
                    </div>
                    </div></div>');
                include("blocks/footer.php");
                exit;
            }

            ?>
        </div>
        <?
        include("blocks/footer.php");
        ?>
    </div>

</body>
</html>