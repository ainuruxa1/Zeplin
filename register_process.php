<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<?
include("blocks/bd.php");
?>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="" />
    <? include("blocks/head_scripts.php"); ?>
	<title>ZEPLIN</title>
</head>

<body>
    <div class="head_block">
        <? 
        include("blocks/header.php");
        ?>
        <div class="register_body">
            <?
            if(isset($_POST['login']))
            {
                $login = $_POST['login'];
            }
            if(isset($_POST['password']))
            {
                $password = $_POST['password'];
            }
            if(isset($_POST['repassword']))
            {
                $repassword = $_POST['repassword'];
            }
            if(isset($_POST['nickname']))
            {
                $nickname = $_POST['nickname'];
            }
            if(isset($_POST['email']))
            {
                $email = $_POST['email'];
            }
            if(empty($login) or empty($password) or empty($repassword) or empty($nickname) or empty($email))
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
            if(!preg_match('/^[a-zA-Z0-9]{5,20}$/', $login))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Логин не соответствует требованиям.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            if(!preg_match('/^[a-zA-Z0-9]{5,20}$/', $password))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Пароль не соответствует требованиям.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            if(!preg_match('/^[a-zA-Z0-9]{5,20}$/', $repassword))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Повторно введённый пароль не соответствует требованиям.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            if(!preg_match('/^[a-zA-Z0-9]{4,10}$/', $nickname))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Никнейм не соответствует требованиям.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            if(!preg_match("~^([a-zA-Z0-9_\-\.])+@([a-zA-Z0-9_\-\.])+\.([a-z0-9])+$~i", $email))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Некорректная E-mail почта.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            if(strlen($email) < 6)
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! E-mail почта не может быть меньше 6 символов.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            $login_bd = mysqli_query($db,"SELECT * FROM `users` WHERE `login` = '$login'");
            $login_bdrow = mysqli_fetch_array($login_bd);
            
            if(!empty($login_bdrow['id']))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Логин '.$login.' уже занят.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            if($repassword !== $password)
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Повторно введённый пароль не соответствует основному.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            $nickname_bd = mysqli_query($db,"SELECT * FROM `users` WHERE `nickname` = '$nickname'");
            $nickname_bdrow = mysqli_fetch_array($nickname_bd);
            
            if(!empty($nickname_bdrow['id']))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Никнейм '.$nickname.' уже занят.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            $email_bd = mysqli_query($db,"SELECT * FROM `users` WHERE `email` = '$email'");
            $email_bdrow = mysqli_fetch_array($email_bd);
            
            if(!empty($email_bdrow['id']))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! E-mail почта '.$email.' уже используется другим аккаунтом.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            $ver_code = rand(1000, 9999);
            $avatar_numb = rand(1, 4);
            if($avatar_numb == 1)
            {
                $avatar_url = "avatars/avatar_1.jpg";
            }
            
            if($avatar_numb == 2)
            {
                $avatar_url = "avatars/avatar_2.gif";
            }
            
            if($avatar_numb == 3)
            {
                $avatar_url = "avatars/avatar_3.png";
            }
            
            if($avatar_numb == 4)
            {
                $avatar_url = "avatars/avatar_4.jpg";
            }
            $reg_user_query = mysqli_query($db,"INSERT INTO `users` (`login`,`password`,`nickname`,`email`,`avatar`,`ver_code`,`activate`) VALUES ('$login','$password','$nickname','$email','$avatar_url','$ver_code','yes')");
            if($reg_user_query == TRUE)
            {
                $_SESSION['ver_login'] = $login;
                echo('
                <div class="register_verification_center">
                    <div class="register_verification_text">
                        <div class="register_verification_text_t1">
                            Поздравляем, '.$nickname.', вы успешно зарегистрировались.<br /><br />
                        </div>
                    </div>
                </div>');
            }
            else
            {
                echo("NOT WORK!");
            }
            ?><br />
        </div>
        <?
        include("blocks/footer.php");
        ?>
    </div>

</body>
</html>