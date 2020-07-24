<?php
session_start();
include("blocks/bd.php");

// C какой статьи будет осуществляться вывод
$startFrom = (int)$_POST['startFrom'];
$pPage = (int)$_POST['pPage'];
$startIndex = $startFrom * $pPage;

// Получаем 10 статей, начиная с последней отображенной
$res = mysqli_query($db, "SELECT * FROM `posts` ORDER BY `date` DESC LIMIT $startIndex, $startFrom");

// Формируем массив со статьями
$posts = array();
while($row = mysqli_fetch_array($res))
{
    $posts[] = $row;
}

if(empty($posts)){
    echo json_encode(array("result" => "finish"));
    exit();
}
else{
    $html = "";
    foreach ($posts as $post){

        if($post['nickname'] == "avkhadiev123")
        {
            $admin = '<img src="img/galka.png" />';
        }
        else
        {
            $admin = "";
        }

        if($post['nickname'] == $_SESSION['user_nickname'])
        {
            $delete = '/ <label class="delete_post_a">Удалить</label>';
            $edit = '/ <a href="edit_post.php?post_id='.$post['id'].'" class="edit_post_a">Редактировать</a>';
        }
        else
        {
            $delete = "";
            $edit = "";
        }

        if($post['tag4'] == "tag_empty")
        {
            $post_tag4 = "";
        }
        else
        {
            $post_tag4 = '<a href="posts.php?tag='.$post['tag4'].'">   
    									   <span class="post_block_top_right_tag4">'.$post['tag4'].'</span>
                                        </a>';
        }

        if($post['tag5'] == "tag_empty")
        {
            $post_tag5 = "";
        }
        else
        {
            $post_tag5 = '<a href="posts.php?tag='.$post['tag5'].'">   
    									   <span class="post_block_top_right_tag5">'.$post['tag5'].'</span>
                                        </a>';
        }
        if($post['type_file'] == "video")
        {
            $file = '<video style="width: 400px; height: 400px;" class="post_video">
                    <source src="'.$post['file'].'" type="video/mp4">
                </video>';
        }
        if($post['type_file'] == "image")
        {
            $file = '<img src="'.$post['file'].'" class="post_block_center_image_i" />';
        }

        $post_nickname = $post['nickname'];

        $user_query = mysqli_query($db,"SELECT * FROM `users` WHERE `nickname` = '$post_nickname'");
        $user_row = mysqli_fetch_array($user_query);

        $post_id = $post['id'];

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

        $html .= '<div class="post_block" data-post-id="'.$post['id'].'">
                        <div class="post_block_top">
                            <div class="post_block_top_left">
                                <div class="post_block_top_left_avatar">
                                    <img src="'.$user_row['avatar'].'" class="post_block_top_left_avatar_image" />
                                </div>
                                <div class="post_block_top_left_nickname">
                                    <div class="post_block_top_left_nickname_text"><a href="user.php?user_id='.$user_row['id'].'" class="a_nickname">'.$user_row['nickname'].'</a> '.$admin.'</div>
                                </div>
                            </div>
                            <div class="post_block_top_right">
                                <div class="post_block_top_right_tags">
                                    <a href="posts.php?tag='.$post['tag1'].'">
                                        <span class="post_block_top_right_first_tag1">'.$post['tag1'].'</span>
                                    </a>
                                    <a href="posts.php?tag='.$post['tag2'].'">
                                       <span class="post_block_top_right_tag2">'.$post['tag2'].'</span>
                                    </a>
                                    <a href="posts.php?tag='.$post['tag3'].'">
                                       <span class="post_block_top_right_tag3">'.$post['tag3'].'</span>
                                    </a>
                                    '.$post_tag4.'
                                    '.$post_tag5.'
                                </div>
                            </div>
                        </div>
                        <div class="post_block_center">
                            <div class="post_block_center_image">
                                '.$file.'
                            </div>
                        </div>
                        <div class="post_block_bottom">
                            <div class="post_block_bottom_left">
                                <div class="post_block_bottom_left_com">
                                    <div class="post_block_bottom_left_com_b">
                                        <div class="post_block_bottom_left_com_b_t">Комментарии (<label class="countComments">'.$count_comments.'</label>)</div>
                                    </div>
                                </div>
                                <div class="post_block_bottom_left_date">'.$post['date'].' '.$delete.' / <a href="view_post.php?post_id='.$post['id'].'" class="view_post_a">Открыть</a> '.$edit.'</div>
                            </div>
                            <div class="post_block_bottom_right">
                                <div class="post_block_bottom_right_raiting">
                                    <div class="post_block_dislike_count">
                                        <div class="post_block_dislike_text" id="dislike_count">'.$dislike_count.'</div>
                                    </div>
                                    <div class="post_block_dislike">
                                        <img src="img/dislike.png" class="post_block_dislike_image" />
                                    </div>
                                    <div class="post_block_like_count">
                                        <div class="post_block_like_text" id="like_count">'.$like_count.'</div>
                                    </div>
                                    <div class="post_block_like">
                                        <img src="img/like.png" class="post_block_like_image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="comments"></div>'.$showCommentButton.'
                    </div>';

    }
}

// Превращаем массив статей в json-строку для передачи через Ajax-запрос
echo json_encode(array(
    "result" => "success",
    "html" => $html
));
?>
