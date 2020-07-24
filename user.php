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
        
        if(isset($_GET['user_id']))
        {
            $userr_id = $_GET['user_id'];
        }
        
        if(empty($userr_id))
        {
            echo
            ("
            <script type='text/javascript'>
            document.location.href = 'index.php';
            </script>
            ");
        }
        
        if(!preg_match("/^[0-9]{1,10}$/", $userr_id))
        {
            echo
            ("
            <script type='text/javascript'>
            document.location.href = 'index.php';
            </script>
            ");
        }
        
        $zapros1 = mysqli_query($db,"SELECT * FROM `users` WHERE `id` = '$userr_id'");
        $row1 = mysqli_fetch_array($zapros1);
        
        if(empty($row1['id']))
        {
            echo
            ("
            <script type='text/javascript'>
            document.location.href = 'index.php';
            </script>
            ");
        }
        
        $ses_user_id = $_SESSION['user_id'];
        
        //Проверка, посмотрел ли пользователь когда-нибудь профиль пользователя, на которого он зашёл
        
        $zapros2 = mysqli_query($db,"SELECT * FROM `user_views` WHERE `guest_id` = '$ses_user_id' AND `user_id` = '$userr_id'");
        $row2 = mysqli_fetch_array($zapros2);
        
        if(empty($row2['id']))
        {
            if($ses_user_id !== $userr_id)
            {
                $add_view = mysqli_query($db,"INSERT INTO `user_views` (`guest_id`,`user_id`) VALUES ('$ses_user_id','$userr_id')");
                if($add_view !== TRUE)
                {
                    echo("error in INSERT");
                }
            }
        }
        
        $user_nick = $row1['nickname'];
        
        $zapros3 = mysqli_query($db,"SELECT * FROM `posts` WHERE `nickname` = '$user_nick'");
        $row3 = mysqli_num_rows($zapros3);
        
        $zapros4 = mysqli_query($db,"SELECT * FROM `comments` WHERE `user_id` = '$userr_id'");
        $row4 = mysqli_num_rows($zapros4);
                
        $zapros5 = mysqli_query($db,"SELECT * FROM `user_views` WHERE `user_id` = '$userr_id'");
        $row5 = mysqli_num_rows($zapros5);
        
        $zapros6 = mysqli_query($db,"SELECT * FROM `posts` WHERE `nickname` = '$user_nick' ORDER BY `date` DESC LIMIT 1");
        $row6 = mysqli_fetch_array($zapros6);
                
        ?>
        <div class="main_body">
            <div class="user_block">
                <div class="left_block">
                    <div class="avatar_block">
                        <img src="<? echo $row1['avatar']; ?>" class="avatar_image" />
                    </div>
                </div>
                <div class="right_block">
                    <div class="nickname_block">
                        <div class="nickname_text"><? echo $row1['nickname']; ?></div>
                    </div>
                    <div class="statistic_block">
                        <div class="post_count">
                            <div class="post_count_text"><? echo $row3; ?><br />постов</div>
                        </div>
                        <div class="comments_count">
                            <div class="comments_count_text"><? echo $row4; ?><br />комментариев</div>
                        </div>
                        <div class="view_user_count">
                            <div class="view_user_count_text"><? echo $row5; ?><br />просмотров</div>
                        </div>
                    </div>
                </div>
                <div class="last_post">
                    <div class="last_post_head">Последний пост <? echo $row1['nickname']; ?>:</div>
                    <?
                    if(empty($row6['id']))
                    {
                        echo("<center>Нет ни одного поста</center>");
                    }
                    else
                    {
                        if($row6['tag4'] !== "tag_empty")
                        {
                            $tag4 = ', <a href="posts.php?tag='.$row6['tag4'].'" class="last_post_tags_a">'.$row6['tag4'].'</a>';
                        }
                        else
                        {
                            $tag4 = "";
                        }
                        
                        if($row6['tag5'] !== "tag_empty")
                        {
                            $tag5 = ', <a href="posts.php?tag='.$row6['tag5'].'" class="last_post_tags_a">'.$row6['tag5'].'</a>';
                        }
                        else
                        {
                            $tag5 = "";
                        }
                        
                        $last_post_id = $row6['id'];
                        
                        $zapros7_like = mysqli_query($db,"SELECT * FROM `rating` WHERE `post_id` = '$last_post_id' AND `type` = 'like'");
                        $row7 = mysqli_num_rows($zapros7_like);
                        
                        $zapros8_dislike = mysqli_query($db,"SELECT * FROM `rating` WHERE `post_id` = '$last_post_id' AND `type` = 'dislike'");
                        $row8 = mysqli_num_rows($zapros8_dislike);
                        
                        $rating_itog = $row7 - $row8;
                        
                        if($rating_itog < 0)
                        {
                            $rating = '<label style="color: red;">'.$rating_itog.'</label>';
                        }
                        if($rating_itog > 0)
                        {
                            $rating = '<label style="color: green;">+'.$rating_itog.'</label>';
                        }
                        
                        if($rating_itog == 0)
                        {
                            $rating = '<label style="color: #666;">'.$rating_itog.'</label>';
                        }
                        
                        printf('<div class="last_post_block">
                        <div class="last_post_block_id">
                            <div class="last_post_id">ID</div>
                        </div>
                        <div class="last_post_block_tags">
                            <div class="last_post_tags">Метки (Теги)</div>
                        </div>
                        <div class="last_post_block_rating">
                            <div class="last_post_rating">Рейтинг</div>
                        </div>
                    </div>
                    <div class="last_post_block_2">
                        <div class="last_post_block_id">
                            <div class="last_post_id_2"><a href="view_post.php?post_id='.$row6['id'].'" class="last_post_tags_a">'.$row6['id'].'</a></div>
                        </div>
                        <div class="last_post_block_tags">
                            <div class="last_post_tags_2"><a href="posts.php?tag='.$row6['tag1'].'" class="last_post_tags_a">'.$row6['tag1'].'</a>, <a href="posts.php?tag='.$row6['tag2'].'" class="last_post_tags_a">'.$row6['tag2'].'</a>, <a href="posts.php?tag='.$row6['tag3'].'" class="last_post_tags_a">'.$row6['tag3'].'</a>'.$tag4.$tag5.'</div>
                        </div>
                        <div class="last_post_block_rating">
                            <div class="last_post_rating_2">'.$rating.'</div>
                        </div>
                    </div>');
                    }
                    ?>
                </div>
            </div>
        </div>
        <?
        include("blocks/footer.php");
        ?>
    </div>

</body>
</html>