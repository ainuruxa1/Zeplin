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
    <script src="js/load_tagged_posts.js" charset="utf-8"></script>
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
            <div class="add_post">
                <?
                if(isset($_GET['tag']))
                {
                    $tag = $_GET['tag'];
                }
                
                if(empty($tag))
                {
                    echo
                    ("
                    <script type='text/javascript'>
                    document.location.href = 'index.php';
                    </script>
                    ");
                }
                
                if(!preg_match('/^[а-яА-Яa-zA-Z0-9]{1,20}$/u', $tag))
                {
                    echo
                    ("
                    <script type='text/javascript'>
                    document.location.href = 'index.php';
                    </script>
                    ");
                }
                
                echo('<label class="posts_tag_title">Посты с тегом: <a href="posts.php?tag='.$tag.'" class="postTag posts_tag_title_a">'.$tag.'</a></label>');

                ?>
            </div>
            <div class="posts">
            <?
            
            if(!empty($tag))
            {
                $post_query = mysqli_query($db,"SELECT * FROM `posts` WHERE `tag1` = '$tag' OR `tag2` = '$tag' OR `tag3` = '$tag' OR `tag4` = '$tag' OR `tag5` = '$tag' ORDER BY `date` DESC");
                $post_row = mysqli_fetch_array($post_query);
    			if(!empty($post_row['id']))
    			{
    				do
    				{
    					if($post_row['nickname'] == "avkhadiev123")
    					{
    						$admin = '<img src="img/galka.png" />';
    					}
    					else
    					{
    						$admin = "";
    					}
                        
    					$post_nickname = $post_row['nickname'];
                        
    					if($post_row['nickname'] == $_SESSION['user_nickname'])
    					{
    						$delete = '/ <label class="delete_post_a">Удалить</label>';
                            $edit = '/ <a href="edit_post.php?post_id='.$post_row['id'].'" class="edit_post_a">Редактировать</a>';
    					}
    					else
    					{
    						$delete = "";
                            $edit = "";
    					}

                        if($post_row['tag4'] == "tag_empty")
                        {
                            $post_tag4 = "";
                        }
                        else
                        {
                            $post_tag4 = '<a href="posts.php?tag='.$post_row['tag4'].'">   
    									   <span class="post_block_top_right_tag4">'.$post_row['tag4'].'</span>
                                        </a>';
                        }

                        if($post_row['tag5'] == "tag_empty")
                        {
                            $post_tag5 = "";
                        }
                        else
                        {
                            $post_tag5 = '<a href="posts.php?tag='.$post_row['tag5'].'">   
    									   <span class="post_block_top_right_tag5">'.$post_row['tag5'].'</span>
                                        </a>';
                        }

                        if($post_row['type_file'] == "video")
                        {
                            $file = '<video style="width: 400px; height: 400px;" class="post_video">
                    <source src="'.$post_row['file'].'" type="video/mp4">
                </video>';
                        }
                        if($post_row['type_file'] == "image")
                        {
                            $file = '<img src="'.$post_row['file'].'" class="post_block_center_image_i" />';
                        }
                        
    					$user_query = mysqli_query($db,"SELECT * FROM `users` WHERE `nickname` = '$post_nickname'");
    					$user_row = mysqli_fetch_array($user_query);
                        
                        $post_id = $post_row['id'];
                        
                        $like_query = mysqli_query($db,"SELECT * FROM `rating` WHERE `post_id` = '$post_id' AND `type` = 'like'");
                        $like_count = mysqli_num_rows($like_query);
                        
                        $dislike_query = mysqli_query($db,"SELECT * FROM `rating` WHERE `post_id` = '$post_id' AND `type` = 'dislike'");
                        $dislike_count = mysqli_num_rows($dislike_query);
                        
                        $count_comments_query = mysqli_query($db,"SELECT * FROM `comments` WHERE `post_id` = '$post_id'");
                        $count_comments = mysqli_num_rows($count_comments_query);

                        if($count_comments > 0){
                            $showCommentButton = '<div class="showComments show_comment_button" page="1">
    						    <div class="show_comment_text">Показать комментарий</div>
    						</div>';
                        }
                        else{
                            $showCommentButton = "";
                        }
                        
                        $user_session_id = $_SESSION['user_id'];
    					printf('
    					<div class="post_block" data-post-id="%s">
    					    <input type="hidden" name="tag" class="have_tag" value="%s" />
    						<div class="post_block_top">
    							<div class="post_block_top_left">
    								<div class="post_block_top_left_avatar">
    									<img src="%s" class="post_block_top_left_avatar_image" />
    								</div>
    								<div class="post_block_top_left_nickname">
    									<div class="post_block_top_left_nickname_text"><a href="user.php?user_id=%s" class="a_nickname">%s</a> %s</div>
    								</div>
    							</div>
    							<div class="post_block_top_right">
    								<div class="post_block_top_right_tags">
    									<a href="posts.php?tag=%s">
                                            <span class="post_block_top_right_first_tag1">%s</span>
                                        </a>
                                        <a href="posts.php?tag=%s">
    									   <span class="post_block_top_right_tag2">%s</span>
                                        </a>
                                        <a href="posts.php?tag=%s">
    									   <span class="post_block_top_right_tag3">%s</span>
                                        </a>
                                        %s
                                        %s
    								</div>
    							</div>
    						</div>
    						<div class="post_block_center">
    							<div class="post_block_center_image">
    								%s
    							</div>
    						</div>
    						<div class="post_block_bottom">
    							<div class="post_block_bottom_left">
    								<div class="post_block_bottom_left_com">
    									<div class="post_block_bottom_left_com_b">
    										<div class="post_block_bottom_left_com_b_t">Комментарии (<label class="countComments">%s</label>)</div>
    									</div>
    								</div>
    								<div class="post_block_bottom_left_date">%s %s / <a href="view_post.php?post_id=%s" class="view_post_a">Открыть</a> %s</div>
    							</div>
    							<div class="post_block_bottom_right">
    								<div class="post_block_bottom_right_raiting">
    								    <div class="post_block_dislike_count">
                                            <div class="post_block_dislike_text" id="dislike_count">%s</div>
    								    </div>
        								<div class="post_block_dislike">
        									<img src="img/dislike.png" class="post_block_dislike_image" />
        								</div>
       									<div class="post_block_like_count">
      										<div class="post_block_like_text" id="like_count">%s</div>
       									</div>
       									<div class="post_block_like">
      										<img src="img/like.png" class="post_block_like_image" />
       									</div>
    								</div>
    							</div>
    						</div>
    						<div class="comments"></div>
    						<div class="comAvatar">
    						    <img src="%s" class="comAvatarImg" />
    						</div>
    						<textarea id="comment_text" name="comment_text" class="addComText add_comment_text_2"></textarea>
    						<div class="subAddCom">
    						    <div class="subAddComText">Добавить</div>
    						</div>
    						%s
    					</div>', $post_row['id'], $tag, $user_row['avatar'], $user_row['id'], $user_row['nickname'], $admin, $post_row['tag1'], $post_row['tag1'], $post_row['tag2'], $post_row['tag2'], $post_row['tag3'], $post_row['tag3'], $post_tag4, $post_tag5, $file, $count_comments, $post_row['date'], $delete, $post_row['id'], $edit, $dislike_count, $like_count, $_SESSION['user_avatar'], $showCommentButton);
    				}
    				while($post_row = mysqli_fetch_array($post_query));
    			}
    			else
    			{
    				echo("<center><h1>Не найдено записей</h1></center>");
    			}
            }
			?>
        </div>
        </div>
        <?
        include("blocks/footer.php");
        ?>
    </div>

</body>
</html>