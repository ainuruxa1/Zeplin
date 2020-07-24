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
            <div class="register_top">
                <div class="register_top_text">Форма регистрации</div>
            </div>
            <div class="register_center">
                <div class="register_center_text">
                    <div class="register_center_text_t1">Регистрация лёгкая и быстрая!</div>
                    <div class="register_center_text_t2">Заполните данные поля и нажмите "Зарегистрироваться".</div>
                </div>
                <form action="register_process.php" method="post">
                    <div class="register_form">
                        <div class="register_form_text">Логин *</div>
                        <div class="register_form_input">
                            <input type="text" name="login" autocomplete="off" class="register_form_input_i" />
                            <span class="register_form_helper">Минимум 6 символов (латинские буквы и цифры), крякозябры не принимаются!</span>
                        </div>
                        <div class="register_form_text">Пароль *</div>
                        <div class="register_form_input">
                            <input type="password" name="password" autocomplete="off" class="register_form_input_i" />
                            <span class="register_form_helper">Минимум 6 символов (латинские буквы и цифры), так же, крякозябры мимо.</span>
                        </div>
                        <div class="register_form_text">Пароль (ещё раз) *</div>
                        <div class="register_form_input">
                            <input type="password" name="repassword" autocomplete="off" class="register_form_input_i" />
                            <span class="register_form_helper">Для подтверждения пароля введите ещё раз.</span>
                        </div>
                        <div class="register_form_text">Никнейм *</div>
                        <div class="register_form_input">
                            <input type="text" name="nickname" autocomplete="off" class="register_form_input_i" />
                            <span class="register_form_helper">Это будет ваш персональный никнейм, который будут видеть все.</span>
                        </div>
                        <div class="register_form_text">E-mail адрес *</div>
                        <div class="register_form_input">
                            <input type="text" name="email" autocomplete="off" class="register_form_input_i" />
                            <span class="register_form_helper">Требуется для подтверждения и восстановления доступа к аккаунту.</span>
                        </div>
                        <div class="register_form_button">
                            <input type="submit" name="submit" value="Зарегистрироваться" class="register_form_button_b" />
                        </div>
                    </div>
                </form>
            </div>
        </div><br />
        <?
        include("blocks/footer.php");
        ?>
    </div>
</body>
</html>