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
            if(isset($_SESSION['ver_login']))
            {
                $ver_login = $_SESSION['ver_login'];
            }
            
            if(isset($_POST['ver_code']))
            {
                $ver_code = $_POST['ver_code'];
            }
            
            if(empty($ver_login))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Сессия потеряна или не найдена. Пожалуйста, попробуйте авторизоваться и заново подтвердить аккаунт.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            if(empty($ver_code))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Вы не ввели 4-х значный код.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            if(!preg_match("/^[0-9]{4}$/", $ver_code))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Некорректный код (возможно написаны буквы).</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            $ver_query = mysqli_query($db,"SELECT * FROM `users` WHERE `login` = '$ver_login'");
            $ver_row = mysqli_fetch_array($ver_query);
            
            if(empty($ver_row['id']))
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Пользователь не найден.</div>
                    </div>
                </div></div><br />');
                include("blocks/footer.php");
                exit;
            }
            
            if($ver_code == $ver_row['ver_code'])
            {
                $yes = "yes";
                $activate_user = mysqli_query($db,"UPDATE `users` SET `activate` = '$yes' WHERE `login` = '$ver_login'");
                if($activate_user == TRUE)
                {
                    echo('
                    <div class="register_center">
                        <div class="register_center_text">
                            <div class="register_center_text_t1">Добро пожаловать, '.$ver_row['nickname'].'! Ваш аккаунт успешно активирован!</div>
                        </div>
                    </div></div><br />');
                    include("blocks/footer.php");
                    exit;
                }
                else
                {
                    echo('
                    <div class="register_center">
                        <div class="register_center_text">
                            <div class="register_center_text_t1">Ошибка! Запрос подтверждения не сработал.</div>
                        </div>
                    </div></div><br />');
                include("blocks/footer.php");
                exit;
                }
            }
            else
            {
                echo('
                <div class="register_center">
                    <div class="register_center_text">
                        <div class="register_center_text_t1">Ошибка! Введённый вами код, неправильный. Попробуйте ещё раз.</div>
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