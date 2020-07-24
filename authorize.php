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
            if(empty($login) or empty($password))
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
            
            $login_bd = mysqli_query($db,"SELECT * FROM `users` WHERE `login` = '$login'");
            $login_bdrow = mysqli_fetch_array($login_bd);
            
            if(empty($login_bdrow['id']))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Такой пользователь не существует.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            if($password !== $login_bdrow['password'])
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Пароль введён неверно.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            
            if($login_bdrow['activate'] == "no")
            {
                $ver_code = rand(1000, 9999);
                $_SESSION['ver_login'] = $login;
                mail($login_bdrow['email'], "VERIFICATION ACCOUNT ON ZEPLIN", "Доброго времени суток, ".$login_bdrow['nickname'].".\r\nНеобходимо подтвердить ваш аккаунт для дальнейших действий.\r\nВаш код: ".$ver_code.".",
                     "Content-Type: text/html; charset=windows-1251\r\nFrom: Admin@zeplinru \r\n");
                $update_ver_code = mysqli_query($db,"UPDATE `users` SET `ver_code` = '$ver_code' WHERE `login` = '$login'");
                echo('
                <div class="register_verification_center">
                    <div class="register_verification_text">
                        <div class="register_verification_text_t1">
                            '.$login_bdrow['nickname'].', мы выслали вам 4-значный код на вашу почту.<br /><br />
                            Пожалуйста, введите его сюда чтобы активировать аккаунт.<br /><br />
                            Если вы не активируете аккаунт в течении 24 часов, то она удаляется.<br />
                            <form action="verification.php" method="post">
                                <input type="text" name="ver_code" class="register_verification_input" maxlength="4" />
                                <div class="register_verification_button">
                                    <input type="submit" name="submit" value="Подтвердить" class="register_verification_button_b" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>');
            }
            else
            {
                $_SESSION['user_id'] = $login_bdrow['id'];
                $_SESSION['user_login'] = $login_bdrow['login'];
                $_SESSION['user_password'] = $login_bdrow['password'];
                $_SESSION['user_nickname'] = $login_bdrow['nickname'];
                $_SESSION['user_email'] = $login_bdrow['email'];
                $_SESSION['user_avatar'] = $login_bdrow['avatar'];
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">'.$_SESSION['user_nickname'].', вы успешно авторизовались.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            ?><br />
        </div>
        <?
        include("blocks/footer.php");
        ?>
    </div>

</body>
</html>