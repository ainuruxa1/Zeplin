$(document).ready(function() {
    $('#like').click(function () {
        setLike('like', $(this));
    });

    $('#dislike').click(function () {
        setDislike('dislike', $(this));
    });
    $('#add_comment').click(function () {
        addCommenta('add_comment', $(this));
    });

    var variAble = 0;

    $(".headPanel").on("click", ".authBlockOpen", function () {

        if (variAble == 0) {
            $("#auth_block_id").css("display", "block");
            variAble = 1;
        } else {
            $("#auth_block_id").css("display", "none");
            variAble = 0;
        }

    });


    $("#comments").on("click", ".comment_block .delete_comment", function (e) {
        var comment_id = $(e.target).parents(".comment_block").attr("data-id");
        var post_id = $('#post_id').val();
        // ïîëó÷åíèå äàííûõ èç ïîëåé
        $.ajax({
            // ìåòîä îòïðàâêè 
            type: "POST",
            // ïóòü äî ñêðèïòà-îáðàáîò÷èêà
            url: "delete_comment.php",
            // êàêèå äàííûå áóäóò ïåðåäàíû
            data: {
                'comment_id': comment_id,
                'post_id': post_id
            },
            // òèï ïåðåäà÷è äàííûõ
            dataType: "json",
            // äåéñòâèå, ïðè îòâåòå ñ ñåðâåðà
            success: function (data) {
                // â ñëó÷àå, êîãäà ïðèøëî success. Îòðàáîòàëî áåç îøèáîê
                if (data.result == 'success') {
                    var deleted_block = '<div class="comment_deleted"><div class="comment_deleted_text">Коментарий удалён.</div></div>';
                    $(e.target).parents(".comment_block").replaceWith($(deleted_block).fadeOut({duration: 3000}));
                    var null_comments = "<center><div id='null_comments'><h3>Нет комментариев</h3></div></center>";
                    if (data.null_comments == "null") {
                        $("#comments").append(null_comments);
                    }
                    $("#count_comments").html(data.count_comments);
                } else {
                    alert("ERROR!");
                }

            }
        });
    });

    $(".posts").on("click", ".comment_block .delete_comment", function (e) {

        var eTarget = $(e.target);

        var comment_id = eTarget.parents(".comment_block").attr("data-id");
        var post_id = eTarget.parents(".post_block").attr("data-post-id");
        // ïîëó÷åíèå äàííûõ èç ïîëåé
        $.ajax({
            // ìåòîä îòïðàâêè
            type: "POST",
            // ïóòü äî ñêðèïòà-îáðàáîò÷èêà
            url: "delete_comment.php",
            // êàêèå äàííûå áóäóò ïåðåäàíû
            data: {
                'comment_id': comment_id,
                'post_id': post_id
            },
            // òèï ïåðåäà÷è äàííûõ
            dataType: "json",
            // äåéñòâèå, ïðè îòâåòå ñ ñåðâåðà
            success: function (data) {
                // â ñëó÷àå, êîãäà ïðèøëî success. Îòðàáîòàëî áåç îøèáîê
                if (data.result == 'success') {
                    var deleted_block = '<div class="comment_deleted"><div class="comment_deleted_text">Коментарий удалён.</div></div>';
                    $(e.target).parents(".comment_block").replaceWith($(deleted_block).fadeOut({duration: 3000}));
                    if (data.null_comments == "null") {
                        $(e.target).parents(".post_block").find(".showComments").remove();
                        $(e.target).parents(".post_block").find(".hideComments").remove();
                    }
                    $("div[data-post-id=" + post_id + "]").find(".countComments").html(data.count_comments);
                } else {
                    alert("ERROR!");
                }

            }
        });
    });

    $("#comments").on("click", ".comment_block .edit_comment", function (e) {
        $(e.target).parents(".comment_block").find(".comment_text").html('<textarea class="edit_comment_textarea">' + $(e.target).parents(".comment_block").find(".comment_text_t").text() + '</textarea><div class="edit_button"><div class="edit_button_text">Сохранить</div></div>');
        $(e.target).text("");
        $(e.target).parents(".comment_nickname").find(".slashEdit").text("");
    });

    $("#comments").on("click", ".comment_block .comment_block_center .comment_text .edit_button", function (e) {
        var editted_comment_text = $(e.target).parents(".comment_text").find(".edit_comment_textarea").val();
        var comment_id = $(e.target).parents(".comment_block").attr("data-id");
        var post_id = $("#post_id").val();
        $.ajax({
            // ìåòîä îòïðàâêè
            type: "POST",
            // ïóòü äî ñêðèïòà-îáðàáîò÷èêà
            url: "edit_comment.php",
            // êàêèå äàííûå áóäóò ïåðåäàíû
            data: {
                'editted_comment_text': editted_comment_text,
                'comment_id': comment_id,
                'post_id': post_id
            },
            // òèï ïåðåäà÷è äàííûõ
            dataType: "json",
            // äåéñòâèå, ïðè îòâåòå ñ ñåðâåðà
            success: function (data) {
                // â ñëó÷àå, êîãäà ïðèøëî success. Îòðàáîòàëî áåç îøèáîê
                if (data.result == 'success') {
                    $(e.target).parents(".comment_block").find(".edit_comment").html("Редактировать");
                    $(e.target).parents(".comment_block").find(".slashEdit").text("/");
                    $(e.target).parents(".comment_text").html('<div class="comment_text_t">' + data.editted_comment_text + '</div>');
                } else {
                    alert("ERROR!");
                }
            }
        });
    });

    $(".main_body").on("click", ".post_block .post_block_like_image", function (e) {

        var post_id = $(e.target).parents(".post_block").attr("data-post-id");
        $.ajax({
            // ìåòîä îòïðàâêè
            type: "POST",
            // ïóòü äî ñêðèïòà-îáðàáîò÷èêà
            url: "like.php",
            // êàêèå äàííûå áóäóò ïåðåäàíû
            data: {
                'post_id': post_id,
                'type': "like"
            },
            // òèï ïåðåäà÷è äàííûõ
            dataType: "json",
            // äåéñòâèå, ïðè îòâåòå ñ ñåðâåðà
            success: function (data) {
                // â ñëó÷àå, êîãäà ïðèøëî success. Îòðàáîòàëî áåç îøèáîê
                if (data.result == 'success') {
                    var like_kolvo = data.like_count;
                    $(e.target).parents(".post_block_bottom_right").find(".post_block_like_text").html(like_kolvo);
                } else {
                    alert("ERROR!");
                }
            }
        });

    });

    $(".main_body").on("click", ".post_block .post_block_dislike_image", function (e) {

        var post_id = $(e.target).parents(".post_block").attr("data-post-id");
        $.ajax({
            // ìåòîä îòïðàâêè
            type: "POST",
            // ïóòü äî ñêðèïòà-îáðàáîò÷èêà
            url: "dislike.php",
            // êàêèå äàííûå áóäóò ïåðåäàíû
            data: {
                'post_id': post_id,
                'type': "dislike"
            },
            // òèï ïåðåäà÷è äàííûõ
            dataType: "json",
            // äåéñòâèå, ïðè îòâåòå ñ ñåðâåðà
            success: function (data) {
                // â ñëó÷àå, êîãäà ïðèøëî success. Îòðàáîòàëî áåç îøèáîê
                if (data.result == 'success') {
                    var dislike_kolvo = data.dislike_count;
                    $(e.target).parents(".post_block_bottom_right").find(".post_block_dislike_text").html(dislike_kolvo);
                } else {
                    alert("ERROR!");
                }
            }
        });

    });

    $(".main_body").on("click", ".add_post .add_post_button", function () {
        if ($(".add_post_block").css("display", "none")) {
            $(".add_post_block").css("display", "block");
            $(".add_post").replaceWith('<div class="close_add_post"><a class="close_add_post_button">Закрыть окно</a></div>');
        }
    });

    $(".main_body").on("click", ".close_add_post .close_add_post_button", function () {
        if ($(".add_post_block").css("display", "block")) {
            $(".add_post_block").css("display", "none");
            $(".close_add_post").replaceWith('<div class="add_post"><a class="add_post_button">Добавить пост</a></div>');
        }
    });

    var files;

    $('.post_image').change(function () {
        files = this.files;
    });

    $(".add_post_submit_2").on("click", function (event) {

        var tag1 = $(".add_post_tag_1").val();
        var tag2 = $(".add_post_tag_2").val();
        var tag3 = $(".add_post_tag_3").val();
        var tag4 = $(".add_post_tag_4").val();
        var tag5 = $(".add_post_tag_5").val();

        event.stopPropagation(); // остановка всех текущих JS событий
        event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега

        // ничего не делаем если files пустой
        if (typeof files == 'undefined') return;

        // создадим объект данных формы
        var data = new FormData();

        // заполняем объект данных файлами в подходящем для отправки формате
        $.each(files, function (key, value) {
            data.append(key, value);
        });

        // добавим переменную для идентификации запроса
        data.append('my_file_upload', 1);
        data.append("tag1", tag1);
        data.append("tag2", tag2);
        data.append("tag3", tag3);
        data.append("tag4", tag4);
        data.append("tag5", tag5);

        function setProgress(e) {
            if (e.lengthComputable) {
                var complete = e.loaded / e.total;
                $(".add_post_warning").text(Math.floor(complete * 100) + "%");
            }
        }

        // AJAX запрос
        $.ajax({
            url: 'add_post_ajax.php',
            type: 'POST', // важно!
            data: data,
            cache: false,
            dataType: 'json',
            // отключаем обработку передаваемых данных, пусть передаются как есть
            processData: false,
            // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
            contentType: false,
            // функция успешного ответа сервера
            success: function (respond, status, jqXHR) {

                // ОК - файлы загружены
                if (typeof respond.errorr === 'undefined') {
                    // выведем пути загруженных файлов в блок '.ajax-reply'
                    var files_path = respond.files;
                    var html = '';
                    var imagevar;
                    $.each(files_path, function (key, val) {
                        imagevar = respond.image;
                    });

                    $(".posts").prepend('<div class="post_block" data-post-id="' + respond.id + '"><div class="post_block_top"><div class="post_block_top_left"><div class="post_block_top_left_avatar"><img src="' + respond.avatar + '" class="post_block_top_left_avatar_image" /></div><div class="post_block_top_left_nickname"><div class="post_block_top_left_nickname_text"><a href="user.php?user_id=' + respond.ses_user_id + '" class="a_nickname">' + respond.nickname + '</a> ' + respond.admin + '</div></div></div><div class="post_block_top_right"><div class="post_block_top_right_tags"><a href="posts.php?tag=' + respond.tag1 + '"><span class="post_block_top_right_first_tag1">' + respond.tag1 + '</span></a><a href="posts.php?tag=' + respond.tag2 + '"><span class="post_block_top_right_tag2">' + respond.tag2 + '</span></a><a href="posts.php?tag=' + respond.tag3 + '"><span class="post_block_top_right_tag3">' + respond.tag3 + '</span></a>' + respond.tag4 + respond.tag5 + '</div></div></div><div class="post_block_center"><div class="post_block_center_image">' + respond.file + '</div></div><div class="post_block_bottom"><div class="post_block_bottom_left"><div class="post_block_bottom_left_com"><div class="post_block_bottom_left_com_b"><div class="post_block_bottom_left_com_b_t">Комментарии (0)</div></div></div><div class="post_block_bottom_left_date">' + respond.date + ' / <label class="delete_post_a">Удалить</label> / <a href="view_post.php?post_id=' + respond.id + '" class="view_post_a">Открыть</a> / <a href="edit_post.php?post_id=' + respond.id + '" class="edit_post_a">Редактировать</a></div></div><div class="post_block_bottom_right"><div class="post_block_bottom_right_raiting"><div class="post_block_dislike_count"><div class="post_block_dislike_text" id="dislike_count">0</div></div><div class="post_block_dislike"><img src="img/dislike.png" class="post_block_dislike_image" /></div><div class="post_block_like_count"><div class="post_block_like_text" id="like_count">0</div></div><div class="post_block_like"><img src="img/like.png" class="post_block_like_image" /></div></div></div></div></div>');
                    if ($("div").is(".not_found_posts")) {
                        $(".posts").find(".not_found_posts").remove();
                    }
                    $(".add_post_tag_1").val("");
                    $(".add_post_tag_2").val("");
                    $(".add_post_tag_3").val("");
                    $(".add_post_tag_4").val("");
                    $(".add_post_tag_5").val("");
                    $(".post_image").val("");
                    $(".add_post_block").css("display", "none");
                    $(".close_add_post").replaceWith('<div class="add_post"><a href="#" class="add_post_button">Добавить пост</a></div>');
                }

                // ошибка
                else {
                    console.log('ОШИБКА: ' + respond.data);
                }
                if (!empty(respond.errorr)) {
                    console.log(respond.errorr);
                }
            },
            // функция ошибки ответа сервера
            error: function (jqXHR, status, errorThrown) {
                console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
            }

        });

    });

    $(".posts").on("click", ".post_block .delete_post_a", function (e) {

        var post_id = $(e.target).parents(".post_block").attr("data-post-id");
        var post_height = $(e.target).parents(".post_block").css("height");
        var post_target = e.target;
        var have_tag = $(e.target).parents(".post_block").find(".have_tag").val();

        $(".main_body").prepend('<div class="background_block"></div>\n' +
            '            <div class="background_delete_block">\n' +
            '                <div class="background_delete_top">\n' +
            '                    <div class="background_delete_top_text">Внимание!</div>\n' +
            '                </div>\n' +
            '                <div class="background_delete_center">\n' +
            '                    <div class="background_delete_center_text">Удалить пост <a href="view_post.php?post_id=' + post_id + '" class="bg_del_post_id">#' + post_id + '</a>?</div>\n' +
            '                    <div class="background_delete_center_text">Восстановление невозможно.</div>\n' +
            '                </div>\n' +
            '                <div class="background_delete_bottom">\n' +
            '                    <div class="bg_del_cancel_button">\n' +
            '                        <div class="bg_del_cancel_button_t">Отмена</div>\n' +
            '                    </div>\n' +
            '                    <div class="bg_del_ok_button">\n' +
            '                        <div class="bg_del_ok_button_t">Удалить</div>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '            </div>');
        $(".bg_del_cancel_button").on("click", function () {
            $(".background_block").remove();
            $(".background_delete_block").remove();

        });
        $(".bg_del_ok_button").on("click", function () {
            $.ajax({
                // ìåòîä îòïðàâêè
                type: "POST",
                // ïóòü äî ñêðèïòà-îáðàáîò÷èêà
                url: "delete_post.php",
                // êàêèå äàííûå áóäóò ïåðåäàíû
                data: {
                    'post_id': post_id,
                    'have_tag': have_tag
                },
                // òèï ïåðåäà÷è äàííûõ
                dataType: "json",
                // äåéñòâèå, ïðè îòâåòå ñ ñåðâåðà
                success: function (data) {
                    // â ñëó÷àå, êîãäà ïðèøëî success. Îòðàáîòàëî áåç îøèáîê
                    if (data.result == "success") {
                        $(".background_block").remove();
                        $(".background_delete_block").remove();
                        var bg_delete_block = '<div class="bg_deleted_post" style="height: ' + post_height + '"><div class="bg_deleted_post_block"><div class="bg_deleted_post_text">Пост удалён</div></div></div>';
                        $(post_target).parents(".post_block").replaceWith($(bg_delete_block).fadeOut({duration: 3000}));
                        if (data.num_posts == "empty") {
                            $(".posts").prepend("<div class='not_found_posts'><center><h1>Нет записей</h1></center></div>");
                        }
                    } else {
                        console.log(data.error);
                    }
                },
                error: function (data) {
                    alert(data.error);
                }
            });
        });
    });

    var runnedVideo = 0;
    var runnedVideoOnView = 0;

    $(".posts").on("click", ".post_video", function (e) {

        if (runnedVideoOnView == 0) {
            $(e.target)[0].play();
            runnedVideoOnView = 1;
        } else {
            $(e.target)[0].pause();
            runnedVideoOnView = 0;
        }
    });

    $(".post_block").on("click", ".postVideo", function (e) {

        if (runnedVideoOnView == 0) {
            $(e.target)[0].play();
            runnedVideoOnView = 1;
        } else {
            $(e.target)[0].pause();
            runnedVideoOnView = 0;
        }
    });

    $(".posts").on("click", ".mute_video", function (e) {
        if ($(".posts").find(".post_video")[0].muted == false) {
            $(".posts").find(".post_video")[0].muted = true;
        } else {
            $(".posts").find(".post_video")[0].muted = false;
        }
        ;
    });

    $(".posts").on("click", ".showComments", function (e) {

        var page = parseInt($(e.target).parents(".post_block").find(".showComments").attr("page"));
        var postId = $(e.target).parents(".post_block").attr("data-post-id");
        var perPage = 3;

        $.ajax({
            url: "load_comments.php",
            type: "POST",
            dataType: "json",
            data: {
                "perPage": perPage,
                "page": page,
                "postId": postId
            },
            success: function (data) {
                if (data.result == "success") {
                    $(e.target).parents(".post_block").find(".comments").append(data.html);
                    $(e.target).parents(".post_block").find(".showComments").attr("page", page + 1);
                    $(e.target).parents(".post_block").find(".show_comment_text").text("Показать ещё");
                    if (data.totalCount <= page * perPage) {
                        $(e.target).parents(".post_block").find(".showComments").replaceWith('<div class="hideComments hide_comment_button"><div class="hide_comment_text">Скрыть комментарий</div></div>');
                    }
                }
                if (data.result == "finish") {
                    $(e.target).parents(".post_block").find(".showComments").replaceWith('<div class="hideComments hide_comment_button"><div class="hide_comment_text">Скрыть комментарий</div></div>');
                }
            }
        });
    });

    $(".posts").on("click", ".hideComments", function (e) {

        $(e.target).parents(".post_block").find(".comments").html("");
        $(e.target).parents(".post_block").find(".hideComments").replaceWith('<div class="showComments show_comment_button" page="1"><div class="show_comment_text">Показать комментарий</div></div>');


    });

    $(".posts").on("click", ".subAddCom", function(e){

        var eTarget = $(e.target).parents(".post_block");

        var postId = eTarget.attr("data-post-id");
        var commentText = eTarget.find(".addComText").val();

        $.ajax({
            type: "POST",
            url: "add_comment.php",
            dataType: "json",
            data: {
                "post_id": postId,
                "comment_text": commentText
            },
            success: function (data) {
                if(data.result == "success"){

                    eTarget.find(".addComText").val("");
                    eTarget.find('.comments').prepend('<div class="comment_block" data-id="' + data.comment_id + '"><div class="comment_block_top"><div class="comment_block_top_in"><div class="comment_block_top_left"><div class="comment_avatar"><img src="' + data.user_avatar + '" class="comment_avatar_image" /></div></div><div class="comment_block_top_right"><div class="comment_nickname"><a href="user.php?user_id=' + data.user_id + '"><b style="text-decoration: underline; color: black;">' + data.user_nickname + '</b></a> / ' + data.date + ' <label class="slashEdit">/</label> <label class="edit_comment">Редактировать</label> / <label class="delete_comment">Удалить</label></div></div></div><div class="comment_block_top_in_right"><div class="comment_block_id">#' + data.comment_id + '</div></div></div><div class="comment_block_center"><div class="comment_text"><div class="comment_text_t">' + data.comment_text + '</div></div></div></div>');
                    eTarget.find(".countComments").html(data.count_comments);
                    if (data.count_comments_before == "null") {
                        eTarget.append('<div class="hideComments hide_comment_button"><div class="hide_comment_text">Скрыть комментарий</div></div>');
                    }
                }
            }
        });

    });

document.getElementById('post_file_id').addEventListener('change', handleFileSelect, false);

    function handleFileSelect(evt) {
        var file = evt.target.files; // FileList object
        var f = file[0];
        // Only process image files.
        if (!f.type.match('image.*')) {
            alert("Image only please....");
        }
        var reader = new FileReader();
        // Closure to capture the file information.
        reader.onload = (function (theFile) {
            return function (e) {
                // Render thumbnail.
                $("#post_image_value").val(e.target.result);
            };
        })(f);
        // Read in the image file as a data URL.
        reader.readAsDataURL(f);
    }

    function setDislike(type, element) {
        // ïîëó÷åíèå äàííûõ èç ïîëåé
        var session_user_id = $('#session_user_id').val();
        var post_id = $('#post_id').val();

        $.ajax({
            // ìåòîä îòïðàâêè
            type: "POST",
            // ïóòü äî ñêðèïòà-îáðàáîò÷èêà
            url: "dislike.php",
            // êàêèå äàííûå áóäóò ïåðåäàíû
            data: {
                'session_user_id': session_user_id,
                'post_id': post_id,
                'type': "dislike"
            },
            // òèï ïåðåäà÷è äàííûõ
            dataType: "json",
            // äåéñòâèå, ïðè îòâåòå ñ ñåðâåðà
            success: function (data) {
                // â ñëó÷àå, êîãäà ïðèøëî success. Îòðàáîòàëî áåç îøèáîê
                if (data.result == 'success') {
                    var dislike_kolvo = data.dislike_count;
                    $('#dislike_count').html(dislike_kolvo);
                } else {
                    alert("ERROR!");
                }
            }
        });
    }

    function setLike(type, element) {
        // ïîëó÷åíèå äàííûõ èç ïîëåé
        var session_user_id = $('#session_user_id').val();
        var post_id = $('#post_id').val();

        $.ajax({
            // ìåòîä îòïðàâêè
            type: "POST",
            // ïóòü äî ñêðèïòà-îáðàáîò÷èêà
            url: "like.php",
            // êàêèå äàííûå áóäóò ïåðåäàíû
            data: {
                'session_user_id': session_user_id,
                'post_id': post_id,
                'type': "like"
            },
            // òèï ïåðåäà÷è äàííûõ
            dataType: "json",
            // äåéñòâèå, ïðè îòâåòå ñ ñåðâåðà
            success: function (data) {
                // â ñëó÷àå, êîãäà ïðèøëî success. Îòðàáîòàëî áåç îøèáîê
                if (data.result == 'success') {
                    var like_kolvo = data.like_count;
                    $("#like_count").html(like_kolvo);
                } else {
                    alert("ERROR!");
                }
            }
        });
    }

    function addCommenta(type, element) {
        // ïîëó÷åíèå äàííûõ èç ïîëåé
        var post_id = $('#post_id').val();
        var comment_text = $('#comment_text').val();
        $.ajax({
            // ìåòîä îòïðàâêè
            type: "POST",
            // ïóòü äî ñêðèïòà-îáðàáîò÷èêà
            url: "add_comment.php",
            // êàêèå äàííûå áóäóò ïåðåäàíû
            data: {
                'post_id': post_id,
                'comment_text': comment_text
            },
            // òèï ïåðåäà÷è äàííûõ
            dataType: "json",
            // äåéñòâèå, ïðè îòâåòå ñ ñåðâåðà
            success: function (data) {
                // â ñëó÷àå, êîãäà ïðèøëî success. Îòðàáîòàëî áåç îøèáîê
                if (data.result == 'success') {
                    $("#comment_text").val("");
                    if (data.count_comments_before == "null") {
                        $("#null_comments").remove();
                    }
                    $('#comments').prepend('<div class="comment_block" data-id="' + data.comment_id + '"><div class="comment_block_top"><div class="comment_block_top_in"><div class="comment_block_top_left"><div class="comment_avatar"><img src="' + data.user_avatar + '" class="comment_avatar_image" /></div></div><div class="comment_block_top_right"><div class="comment_nickname"><a href="user.php?user_id=' + data.user_id + '"><b style="text-decoration: underline; color: black;">' + data.user_nickname + '</b></a> / ' + data.date + ' <label class="slashEdit">/</label> <label class="edit_comment">Редактировать</label> / <label class="delete_comment">Удалить</label></div></div></div><div class="comment_block_top_in_right"><div class="comment_block_id">#' + data.comment_id + '</div></div></div><div class="comment_block_center"><div class="comment_text"><div class="comment_text_t">' + data.comment_text + '</div></div></div></div>');
                    $("#count_comments").html(data.count_comments);
                } else {
                    alert("ERROR!");
                }

            }
        });
    }

});
