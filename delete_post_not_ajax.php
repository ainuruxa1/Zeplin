<?php 
session_start();
include("blocks/bd.php");
        if(empty($_SESSION['user_id']))
        {
            echo("<script type='text/javascript'>
                    document.location.href = 'index.php';
                    </script>
                    ");
        }
        
        if(isset($_GET['post_id']))
        {
            $post_id = $_GET['post_id'];
        }
        
        if(empty($post_id))
        {
            echo("<script type='text/javascript'>
                    document.location.href = 'index.php';
                    </script>
                    ");
        }

        if(!preg_match('/^[0-9]{1,10}$/', $post_id))
        {
            echo("<script type='text/javascript'>
                    document.location.href = 'index.php';
                    </script>
                    ");
        }
        
        $zapros = mysqli_query($db,"SELECT * FROM `posts` WHERE `id` = '$post_id'");
        $row = mysqli_fetch_array($zapros);
        
        if(empty($row['id']))
        {
            echo("<script type='text/javascript'>
                    document.location.href = 'index.php';
                    </script>
                    ");
        }
        
        if($row['nickname'] !== $_SESSION['user_nickname'])
        {
            echo("<script type='text/javascript'>
                    document.location.href = 'index.php';
                    </script>
                    ");
        }
        
        unlink($row['file']);
        
        $delete_zapros = mysqli_query($db,"DELETE FROM `posts` WHERE `id` = '$post_id'");
        $delete_comments = mysqli_query($db,"DELETE FROM `comments` WHERE `post_id` = '$post_id'");
        $delete_rating = mysqli_query($db,"DELETE FROM `rating` WHERE `post_id` = '$post_id'");
        
        if($delete_zapros == TRUE)
        {
            echo("<script type='text/javascript'>
                    document.location.href = 'index.php';
                    </script>
                    ");
        }
?>