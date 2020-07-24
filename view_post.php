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
            if(isset($_GET['post_id']))
            {
                $post_id = $_GET['post_id'];
            }
            
            if(empty($post_id))
            {
                echo
                ("
                <script type='text/javascript'>
                document.location.href = 'index.php';
                </script>
                ");
            }
            
            if(!preg_match("/^[0-9]{1,10}$/", $post_id))
            {
                echo
                ("
                <script type='text/javascript'>
                document.location.href = 'index.php';
                </script>
                ");
            }
            
            $post = mysqli_query($db,"SELECT * FROM `posts` WHERE `id` = '$post_id'");
            $post_row = mysqli_fetch_array($post);
            
            if(empty($post_row['id']))
            {
                echo
                ("
                <script type='text/javascript'>
                document.location.href = 'index.php';
                </script>
                ");
            }
            
            $post_nickname = $post_row['nickname'];
            
            $zap_user = mysqli_query($db,"SELECT * FROM `users` WHERE `nickname` = '$post_nickname'");
            $user = mysqli_fetch_array($zap_user);
            
            if($user['login'] == $_SESSION['user_login'])
            {
                $delete = '/ <a class="delete_post_a" href="delete_post_not_ajax.php?post_id='.$post_row['id'].'">Удалить</a>';
                $edit = '/ <a href="edit_post.php?post_id='.$post_row['id'].'" class="edit_post_a">Редактировать</a>';
            }
            else
            {
                $delete = "";
                $edit = "";
            }
            
            if($post_row['nickname'] == "avkhadiev123")
            {
				$admin = '<img src="img/galka.png" />';
            }
            else
            {
            $admin = "";
            }
            
            if($post_row['tag4'] == "tag_empty")
            {
                $tag4 = "";
            }
            else
            {
                $tag4 = '<a href="posts.php?tag='.$post_row['tag4'].'">   
									   <span class="post_block_top_right_tag4">'.$post_row['tag4'].'</span>
                                    </a>';
            }
            
            if($post_row['tag5'] == "tag_empty")
            {
                $tag5 = "";
            }
            else
            {
                $tag5 = '<a href="posts.php?tag='.$post_row['tag5'].'">   
									   <span class="post_block_top_right_tag5">'.$post_row['tag5'].'</span>
                                    </a>';
            }

            if($post_row['type_file'] == "video")
            {
                $file = '<video style="width: 400px; height: 400px;" class="postVideo post_video">
                    <source src="'.$post_row['file'].'" type="video/mp4">
                </video>';
            }
            if($post_row['type_file'] == "image")
            {
                $file = '<img src="'.$post_row['file'].'" class="post_block_center_image_i" />';
            }
            
            $like_query = mysqli_query($db,"SELECT * FROM `rating` WHERE `post_id` = '$post_id' AND `type` = 'like'");
            $like_count = mysqli_num_rows($like_query);
            $dislike_query = mysqli_query($db,"SELECT * FROM `rating` WHERE `post_id` = '$post_id' AND `type` = 'dislike'");
            $dislike_count = mysqli_num_rows($dislike_query);
            
            $zapros4 = mysqli_query($db,"SELECT * FROM `comments` WHERE `post_id` = '$post_id'");
            $comment_count = mysqli_num_rows($zapros4);
            
            ?>
            <div class="post_block">
						<div class="post_block_top">
							<div class="post_block_top_left">
								<div class="post_block_top_left_avatar">
									<img src="<? echo $user['avatar']; ?>" class="post_block_top_left_avatar_image" />
								</div>
								<div class="post_block_top_left_nickname">
									<div class="post_block_top_left_nickname_text"><a href="user.php?user_id=<? echo $user['id']; ?>" class="a_nickname"><? echo $user['nickname']; ?></a> <? echo $admin; ?></div>
								</div>
							</div>
							<div class="post_block_top_right">
								<div class="post_block_top_right_tags">
									<a href="posts.php?tag=<? echo $post_row['tag1']; ?>">
                                        <span class="post_block_top_right_first_tag1"><? echo $post_row['tag1']; ?></span>
                                    </a>
                                    <a href="posts.php?tag=<? echo $post_row['tag2']; ?>">
									   <span class="post_block_top_right_tag2"><? echo $post_row['tag2']; ?></span>
                                    </a>
                                    <a href="posts.php?tag=<? echo $post_row['tag3']; ?>">
									   <span class="post_block_top_right_tag3"><? echo $post_row['tag3']; ?></span>
                                    </a>
                                    <?
                                    echo $tag4;
                                    echo $tag5;
                                    ?>
								</div>
							</div>
						</div>
						<div class="post_block_center">
							<div class="post_block_center_image">
								<? echo $file; ?>
							</div>
						</div>
						<div class="post_block_bottom">
							<div class="post_block_bottom_left">
								<div class="post_block_bottom_left_com">
									<div class="post_block_bottom_left_com_b">
										<div class="post_block_bottom_left_com_b_t">Комментарии (<label id="count_comments"><? echo $comment_count; ?></label>)</div>
									</div>
								</div>
								<div class="post_block_bottom_left_date"><? echo $post_row['date']." ".$delete." ".$edit; ?></div>
							</div>
                            <input type="hidden" name="post_id" value="<? echo $post_id; ?>" id="post_id" />
                            <input type="hidden" name="session_user_id" value="<? echo $_SESSION['user_id']; ?>" id="session_user_id" />
							<div class="post_block_bottom_right">
								<div class="post_block_bottom_right_raiting">
								    <div class="post_block_dislike_count">
                                        <div class="post_block_dislike_text" id="dislike_count"><? echo $dislike_count; ?></div>
								    </div>
    								<div class="post_block_dislike">
    									<img src="img/dislike.png" id="dislike" class="post_block_dislike_image_2" />
    								</div>
   									<div class="post_block_like_count">
  										<div class="post_block_like_text" id="like_count"><? echo $like_count; ?></div>
   									</div>
   									<div class="post_block_like">
  										<img src="img/like.png" id="like" class="post_block_like_image_2" />
   									</div>
								</div>
							</div>
						</div>
                        <div class="add_comment_block">
                            <div class="add_comment_left">
                                <textarea id="comment_text" name="comment_text" class="add_comment_text"></textarea>
                            </div>
                            <div class="add_comment_right">
                                <div id="add_comment" class="add_comment_button">
                                    <div class="add_button">
                                        <div class="add_button_text">Добавить</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="comments">
                        <?
                        
                        $zapros1 = mysqli_query($db,"SELECT * FROM `comments` WHERE `post_id` = '$post_id' ORDER BY `date` DESC");
                        $row1 = mysqli_fetch_array($zapros1);
                        if(empty($row1['id']))
                        {
                            echo("<center><div id='null_comments'><h3>Нет комментариев</h3></div></center>");
                        }
                        else
                        {
                            do
                            {
                            
                            $com_user_id = $row1['user_id'];
                            
                            $user_zapros = mysqli_query($db,"SELECT * FROM `users` WHERE `id` ='$com_user_id'");
                            $user_row = mysqli_fetch_array($user_zapros);
                            
                            if($com_user_id == $_SESSION['user_id'])
                            {
                                $delete_comment_button = '/ <label class="delete_comment">Удалить</label>';
                                $edit_comment_button = '<label class="slashEdit">/</label> <label class="edit_comment">Редактировать</label>';
                            }
                            else
                            {
                                $delete_comment_button = "";
                                $edit_comment_button = "";
                            }
                            
                            printf('<div class="comment_block" data-id="%s">
                                        <div class="comment_block_top">
                                            <div class="comment_block_top_in">
                                                <div class="comment_block_top_left">
                                                    <div class="comment_avatar">
                                                        <img src="%s" class="comment_avatar_image" />
                                                    </div>
                                                </div>
                                                <div class="comment_block_top_right">
                                                    <div class="comment_nickname"><a href="user.php?user_id=%s"><b style="text-decoration: underline; color: black;">%s</b></a> / %s %s %s</div>
                                                </div>
                                            </div>
                                            <div class="comment_block_top_in_right">
                                                <div class="comment_block_id">#%s</div>
                                            </div>
                                        </div>
                                        <div class="comment_block_center">
                                            <div class="comment_text">
                                                <div class="comment_text_t">%s</div>
                                            </div>
                                        </div>
                                    </div>', $row1['id'], $user_row['avatar'], $user_row['id'], $user_row['nickname'], $row1['date'], $edit_comment_button, $delete_comment_button, $row1['id'], $row1['text']);
                                
                            }
                            while($row1 = mysqli_fetch_array($zapros1));
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