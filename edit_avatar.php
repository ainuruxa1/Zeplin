<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
            if(empty($_FILES['avatar']['name']))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Вы не загрузили картинку.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            $avatar_tmp = $_FILES['avatar']['tmp_name'];
            
            $getinfo = getimagesize($avatar_tmp);
            
            if($getinfo[2] !== 1 and $getinfo[2] !== 2 and $getinfo[2] !== 3)
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Разрешены только три формата картинки.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            if($getinfo[0] !== 100 and $getinfo[1] !== 100)
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Размеры картинки не соотвествуют требованиям.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            if($getinfo[2] == 1)
            {
                $img_type = ".gif";
            }
            
            if($getinfo[2] == 2)
            {
                $img_type = ".jpg";
            }
            
            if($getinfo[2] == 3)
            {
                $img_type = ".png";
            }
            
            $random = rand(1000,9999);
            
            $avatar_url = "avatars/avatar_".$random."".$img_type;
            
            if(move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_url))
            {
                $login_session = $_SESSION['user_login'];
                $edit_avatar = mysqli_query($db,"UPDATE `users` SET `avatar` = '$avatar_url' WHERE `login` = '$login_session'");
                if($edit_avatar == TRUE)
                {
                    unlink($_SESSION['user_avatar']);
                    $_SESSION['user_avatar'] = $avatar_url;
                    echo('
                        <div class="register_center">
                            <div class="register_center_text">
                                <div class="register_center_text_t1">Ваш аватар успешно изменен.</div>
                            </div>
                        </div></div><br />');
                include("blocks/footer.php");
                exit;
                }
            }
            
            
            
            
            
            
            ?>
        </div>
        <?
        include("blocks/footer.php");
        ?>
    </div>

</body>
</html>