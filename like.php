<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
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
    if (isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];
    }
    //$total_post_cnt_chk = mysqli_query($this->con, "SELECT * FROM posts WHERE added_by='$id'");
    //$total_post_cnt = mysqli_num_rows($total_post_cnt_chk);

    $get_likes = mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
	$row = mysqli_fetch_array($get_likes);
	$total_likes = $row['likes']; 
	$user_liked = $row['added_by'];

	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user_liked'");
	$row = mysqli_fetch_array($user_details_query);
	$total_user_likes = $row['num_likes'];

    if(isset($_POST['like_button'])) {
		$total_likes++;
		$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
		$total_user_likes++;
		$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
		$insert_user = mysqli_query($con, "INSERT INTO likes VALUES('', '$userLoggedIn', '$post_id')");
	}

    if(isset($_POST['unlike_button'])) {
		$total_likes--;
		$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
		$total_user_likes--;
		$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
		$insert_user = mysqli_query($con, "DELETE FROM likes WHERE username='$userLoggedIn' AND post_id='$post_id'");
	}

    $check_query = mysqli_query($con, "SELECT * FROM likes WHERE username='$userLoggedIn' AND post_id='$post_id'");
	$num_rows = mysqli_num_rows($check_query);
    if($num_rows > 0) {
		echo '<form action="like.php?post_id=' . $post_id . '" method="POST" class="likeform" style="margin-top:26px;">
				<input type="submit" class="comment_like" name="unlike_button" value="좋아요" style="color:#3498db; background-color: transparent; border: none;">
				<div class="like_value" style="font-size:15px;display:inline;">
				'. $total_likes .'명이 좋아합니다.
				</div>
			</form>
		';
	}
	else {
		echo '<form action="like.php?post_id=' . $post_id . '" method="POST" class="likeform" style="margin-top:26px;">
				<input type="submit" class="comment_like" name="like_button" value="좋아요" style="color:#3498db; background-color: transparent;">
				<div class="like_value" style="font-size:14px; border: none; display:inline;">
				'. $total_likes .'명이 좋아합니다.
				</div>
			</form>
		';
	}
	?>
</body>

</html>