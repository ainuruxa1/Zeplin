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
            if(isset($_POST['old_password']))
            {
                $old_password = $_POST['old_password'];
            }
            
            if(isset($_POST['new_password']))
            {
                $new_password = $_POST['new_password'];
            }
            
            if(empty($old_password) or empty($new_password))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Вы не заполнили все поля.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            if(!preg_match('/^[a-zA-Z0-9]{5,20}$/', $old_password))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Старый пароль не соответсвует требованиям.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            if(!preg_match('/^[a-zA-Z0-9]{5,20}$/', $new_password))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Новый пароль не соответсвует требованиям.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            if($old_password !== $_SESSION['user_password'])
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Старый пароль не совпадает с вашим.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            if($old_password == $new_password)
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Старый пароль совпадает с новым.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            $userlogin = $_SESSION['user_login'];
            $edit_pass = mysqli_query($db,"UPDATE `users` SET `password` = '$new_password' WHERE `login` = '$userlogin'");
            
            if($edit_pass == TRUE)
            {
                $_SESSION['user_password'] = $new_password;
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ваш пароль успешно изменён.</div>
                    </div>
                </div></div><br />');
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