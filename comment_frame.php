<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>

	<style type="text/css">
	* {
		font-size: 12px;
		font-family: Arial, Helvetica, Sans-serif;
	}
	</style>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
    <?php
    require 'config/config.php';
    include("./inc/classes/User.php");
    include("./inc/classes/Post.php");

    if (isset($_SESSION['username'])) {
        $userLoggedIn = $_SESSION['username'];
        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
        $user = mysqli_fetch_array($user_details_query);
    } else {
        header("Location: register.php");
    }
    ?>
    
    <script>
        function toggle() {
            var element = document.getElementById("comment_section");
            if (element.style.display == "block")
                element.style.display = "none";
            else
                element.style.display = "block";
        }
    </script>
    <?php
    if (isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];
    }
    $user_query = mysqli_query($con, "SELECT added_by, user_to FROM posts WHERE id='$post_id'");
    $row = mysqli_fetch_array($user_query);
    $posted_to = $row['added_by'];

    if (isset($_POST['postComment' . $post_id])) {
        $post_body = $_POST['post_body'];
        $post_body = mysqli_escape_string($con, $post_body);
        $date_time_now = date("Y-m-d H:i:s");
        $insert_post = mysqli_query($con, "INSERT INTO comments VALUES ('', '$post_body', '$userLoggedIn','$posted_to','$date_time_now','no','$post_id')");
    }
    ?>
    <form action="comment_frame.php?post_id=<?php echo $post_id; ?>" method="POST" id="comment_form" name="postComment<?php echo $post_id; ?>">
        <textarea name="post_body"></textarea>
        <input type="submit" name="postComment<?php echo $post_id; ?>" value="코멘트">
    </form>
    <?php
    $get_comments = mysqli_query($con, "SELECT * FROM comments WHERE post_id= '$post_id' ORDER BY id ASC");
    $count = mysqli_num_rows($get_comments);

    if ($count != 0) {
        while ($comment = mysqli_fetch_array($get_comments)) {
            $comment_body = $comment['post_body'];
            $posted_to = $comment['posted_to'];
            $posted_by = $comment['posted_by'];
            $date_added = $comment['date_added'];
            $removed = $comment['removed'];


            $date_time_now = date("Y-m-d H:i:s");
            $start_date = new DateTime($date_added);
            $end_date = new DateTime($date_time_now);
            $interval = $start_date->diff($end_date);
            if ($interval->y >= 1) {
                if ($interval == 1)
                    $time_message = $interval->y . "년 전";
                else
                    $time_message = $interval->y . "년 전";
            } else if ($interval->m >= 1) {
                if ($interval->d == 0) {
                    $days = " ago";
                } else if ($interval->d == 1) {
                    $days = $interval->d . "일 전";
                } else {
                    $days = $interval->d . "일 전";
                }

                if ($interval->m == 1) {
                    $time_message = $interval->m . "년" . $days;
                } else {
                    $time_message = $interval->m . "달 " . $days;
                }
            } else if ($interval->d >= 1) {
                if ($interval->d == 1) {
                    $time_message = "년";
                } else {
                    $time_message = $interval->d . "일 전";
                }
            } else if ($interval->h >= 1) {
                if ($interval->h == 1) {
                    $time_message = $interval->h . "시간 전";
                } else {
                    $time_message = $interval->h . "시간 전";
                }
            } else if ($interval->i >= 1) {
                if ($interval->i == 1) {
                    $time_message = $interval->i . "분 전";
                } else {
                    $time_message = $interval->i . "분 전";
                }
            } else {
                if ($interval->s < 30) {
                    $time_message = "방금";
                } else {
                    $time_message = $interval->s . "초 전";
                }
            }
            //타임계산:끝
			$user_obj = new User($con, $posted_by);
			?>
			<div class="comment_section">
				<a href="<?php echo $posted_by?>" target="_parent"><img src="<?php echo $user_obj->getProfilePic();?>" title="<?php echo $posted_by; ?>" style="float:left;" height="30"></a>
				<a href="<?php echo $posted_by?>" target="_parent"> <b> <?php echo $user_obj->getFirstAndLastName(); ?> </b></a>
				&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $time_message . "<br>" . $comment_body; ?> 
				<hr>
			</div>
			<?php
            }
	}
	else {
		echo "<center><br><br>댓글이 아직 없어요. 친구의 포스트에 댓글을 달아보세요.</center>";
	}
	?>
</body>
</html>