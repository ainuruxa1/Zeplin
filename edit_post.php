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
            
            if(isset($_GET['post_id']))
            {
                $post_id = $_GET['post_id'];
            }
            
            if(!preg_match('/^[0-9]{1,10}$/', $post_id))
            {
                echo('<script language="JavaScript">
                        document.location.href = "index.php";
                      </script>');
            }
            
            $zapros1 = mysqli_query($db,"SELECT * FROM `posts` WHERE `id` = '$post_id'");
            $row1 = mysqli_fetch_array($zapros1);
            
            if(empty($row1['id']))
            {
                echo('<script language="JavaScript">
                        document.location.href = "index.php";
                      </script>');
            }
            
            if($row1['nickname'] !== $_SESSION['user_nickname'])
            {
                echo("
                    <script type='text/javascript'>
                    document.location.href = 'index.php';
                    </script>
                    ");
            }
            
            if($row1['tag4'] == "tag_empty")
            {
                $tag4 = "";
            }
            else
            {
                $tag4 = $row1['tag4'];
            }
            
            if($row1['tag5'] == "tag_empty")
            {
                $tag5 = "";
            }
            else
            {
                $tag5 = $row1['tag5'];
            }
            
            ?>
            <div class="add_post_top">
                <div class="add_post_top_text">Форма редактирования поста</div>
            </div>
            <div class="add_post_center">
                <form action="edit_post_process.php" method="post" enctype="multipart/form-data">
                    <div class="add_post_center_in">
                        <div class="add_post_center_left">
                            <input type="file" name="post_image" accept=".jpg, .jpeg, .png, .gif" id="post_file_id" class="post_file_input" />
                            <input type="hidden" name="post_image_value" id="post_image_value" value="<? echo $row1['file']; ?>" />
                            <label for="post_file_id" id="post_file_id_label">
                                <div class="post_file">
                                    <div class="post_file_text">Сменить фотографию</div>
                                </div>
                            </label>
                            <input type="text" name="tag1" class="post_tag" autocomplete="off" placeholder="Тег 1 *" value="<? echo $row1['tag1']; ?>"/>
                            <input type="text" name="tag2" class="post_tag" autocomplete="off" placeholder="Тег 2 *" value="<? echo $row1['tag2']; ?>"/>
                            <input type="text" name="tag3" class="post_tag" autocomplete="off" placeholder="Тег 3 *" value="<? echo $row1['tag3']; ?>"/>
                            <input type="text" name="tag4" class="post_tag" autocomplete="off" placeholder="Тег 4" value="<? echo $tag4; ?>"/>
                            <input type="text" name="tag5" class="post_tag" autocomplete="off" placeholder="Тег 5" value="<? echo $tag5; ?>"/>
                            <input type="hidden" name="post_id" value="<? echo $row1['id']; ?>" />
                        </div>
                        <div class="add_post_center_right">
                            <div class="add_post_center_right_in">
                                <div class="edit_post_warning">
                                    <div class="add_post_warning_top">Внимание, друг мой!</div>
                                    <div class="add_post_warning_center">
                                        <div class="add_post_warning_center_text">* Разрешены только фотографии с форматом .jpg, .jpeg, .png и .gif.</div>
                                        <div class="add_post_warning_center_text">* Теги должны содержать только кириллицу, латиницу и цифры!!!</div>
                                        <div class="add_post_warning_center_text">* Первые три тега обязательны к заполнению.</div>
                                        <div class="add_post_warning_center_text2">Не соблюдал правила? Пост не запостится, увы =)</div>
                                    </div>
                                </div>
                                <div class="add_post_center_right_bottom">
                                    <input type="submit" name="submit" value="Изменить пост" class="add_post_submit" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?
        include("blocks/footer.php");
        ?>
    </div>

</body>
</html>