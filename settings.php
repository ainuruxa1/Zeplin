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
            <form action="edit_password.php" method="post">
                <div class="set_block_1">
                	<div class="set_block_name">Смена пароля</div>
                    <div class="set_block_center">
                    	<div class="set_block_left">
                        	<input type="password" name="old_password" class="set_block_pass" autocomplete="off" placeholder="Старый пароль" />
                        </div>
                        <div class="set_block_right">
                        	<input type="password" name="new_password" class="set_block_pass" autocomplete="off" placeholder="Новый пароль" />
                        </div>
                    </div>
                    <div class="set_block_bottom">
                    	<input type="submit" name="submit" value="Сменить" class="set_block_button" />
                    </div>
                </div>
            </form>
            <form action="edit_avatar.php" method="post" enctype="multipart/form-data">
                <div class="set_block_2">
                	<div class="set_block_name_2">Смена аватара</div>
                    <div class="set_block_center_2">
                    	<div class="set_block_warning">
                        	<div class="set_block_warning_text">Внимание! Размер фото: 100х100 пикселей. Форматы: .jpg, .gif, .png</div>
                        </div>
                    </div>
                    <div class="set_block_bottom_2">
                    	<div class="set_block_bottom_2_left">
                        	<input type="file" name="avatar" accept=".jpg, .jpeg, .png, .gif" id="post_file_id" class="post_file_input" />
                            <label for="post_file_id">
                                <div class="post_file_2">
                                	<div class="post_file_2_text">Выбрать фотографию</div>
                            	</div>
                            </label>
                        </div>
                        <div class="set_block_bottom_2_right">
                            <input type="submit" name="submit" value="Сменить" class="set_block_button_2" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?
        include("blocks/footer.php");
        ?>
    </div>

</body>
</html>