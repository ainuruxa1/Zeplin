<?php
    session_start();
	include "blocks/bd.php"; // подключение к базе данных

	// $startIndex = $_POST['openComments']; // с какой записи начать выборку
    $perPage = (int)$_POST['perPage']; // 3
    $page = (int)$_POST['page']; // 1
    $startIndex = $perPage * ($page-1); // = 3 * 1 = 3
    $postId = $_POST['postId'];
	
	// запрос к бд
	$sql = mysqli_query($db,"SELECT * FROM `comments` WHERE `post_id` = '$postId' ORDER BY `date` DESC LIMIT $startIndex, $perPage") or die(mysqli_error());
	$comments = array();
	while($result = mysqli_fetch_array($sql, MYSQLI_ASSOC)){
		$comments[] = $result;
	}
	
	if(empty($comments)){
		// если новостей нет
		echo json_encode(array(
			'result' 	=> 'finish'
		));
	}else{
		// если новости получили из базы, то свормируем html элементы
		// и отдадим их клиенту
		$html = "";
		foreach($comments as $CommentArray){

		    $user_id = $CommentArray['user_id'];
		    $sql2 = mysqli_query($db,"SELECT * FROM `users` WHERE `id` = '$user_id'");
		    $userInfo = mysqli_fetch_array($sql2);

		    if($user_id == $_SESSION['user_id']){
                $delete_comment_button = '/ <label class="delete_comment">Удалить</label>';
                $edit_comment_button = '<label class="edit_comment"> / Редактировать</label>';
            }
            else
            {
                $delete_comment_button = "";
                $edit_comment_button = "";
            }

			$html .= '<div class="comment_block" data-id="'.$CommentArray['id'].'">
                                        <div class="comment_block_top">
                                            <div class="comment_block_top_in">
                                                <div class="comment_block_top_left">
                                                    <div class="comment_avatar">
                                                        <img src="'.$userInfo['avatar'].'" class="comment_avatar_image" />
                                                    </div>
                                                </div>
                                                <div class="comment_block_top_right">
                                                    <div class="comment_nickname"><a href="user.php?user_id='.$userInfo['id'].'"><b style="text-decoration: underline; color: black;">'.$userInfo['nickname'].'</b></a> / '.$CommentArray['date'].' '.$edit_comment_button.' '.$delete_comment_button.'</div>
                                                </div>
                                            </div>
                                            <div class="comment_block_top_in_right">
                                                <div class="comment_block_id">#'.$CommentArray['id'].'</div>
                                            </div>
                                        </div>
                                        <div class="comment_block_center">
                                            <div class="comment_text">
                                                <div class="comment_text_t">'.$CommentArray['text'].'</div>
                                            </div>
                                        </div>
                                    </div>';
		}

		// Получаем кол-во комментариев

        $sql3 = mysqli_query($db,"
		SELECT COUNT(*) as commentsCount FROM `comments` WHERE `post_id` = '$postId'
	    ") or die(mysqli_error());

		$commentsCount = mysqli_fetch_array($sql3, MYSQLI_ASSOC);

		echo json_encode(array(
			'result' 	=> 'success',
			'totalCount'     => $commentsCount['commentsCount'],
			'html'		=> $html
		));
	}
	
	