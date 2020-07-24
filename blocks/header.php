<div class="header">
            <div class="header_left_block">
                <div class="header_logo">
                    <a href="index.php" class="header_logo_a_text">
                    <div class="header_logo_text">ZEPLIN</div>
                    </a>
                </div>
            </div>
            <div class="header_right_block">
                <div class="headPanel header_right_menu">
                        <?php
                        if(empty($_SESSION['user_id']))
                        {
                            echo('<div class="header_right_menu_text">
                                    <label class="authBlockOpen header_url_edit">Авторизация</label> / 
                                    <a href="register.php" class="header_url_edit">Регистрация</a>
                                  </div>');
                        }
                        else
                        {
                            echo('<div class="header_right_menu_text_exit">
                                    <a href="settings.php" class="header_url_edit">Настройки</a> / 
                                    <a href="exit.php" class="header_url_edit">Выход</a>
                                  </div>');
                        }
                        ?>
                    
                </div>
                <div id="auth_block_id" class="auth_block">
                    <form action="authorize.php" method="post">
                        <div class="auth_block_menu">
                            <input type="text" name="login" placeholder="Логин" autocomplete="off" class="auth_form_input_login" />
                            <input type="password" name="password" placeholder="Пароль" autocomplete="off" class="auth_form_input_password" />
                            <input type="submit" name="submit" value="Войти" class="auth_form_button" />
                        </div>
                    </form>
                </div>
            </div>
</div>
