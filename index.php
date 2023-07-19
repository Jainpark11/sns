<?php
include("./inc/header.php");
include("./inc/classes/User.php");
include("./inc/classes/Post.php");
//session_destroy();


if (isset($_POST['post'])) {
    $post = new Post($con, $userLoggedIn);
    $post->submitPost($_POST['post_text'], 'none');   
}
?>
<div class="user_details column">
    <a href="<?php echo $userLoggedIn; ?>"> <img src="<?php echo $user['profile_pic']; ?>"> </a>

    <div class="user_details_left_right">
        <a href="<?php echo $userLoggedIn; ?>">
            <?php
            echo $user['first_name'] . " " . $user['last_name']; ?>
        </a>
        <br>      
      
        <?php echo "포스팅: " . $user['num_posts']. "<br>"; 
			echo "좋아요: " . $user['num_likes'];

        ?>
    </div>

</div>

<div class="main_column column">
    <form class="post_form" action="index.php" method="POST">
        <textarea name="post_text" id="post_text" placeholder="이곳에 메세지를 남겨보세요"></textarea>
        <input type="submit" name="post" id="post_button" value="포스트">
        <hr>

    </form>

    <div class="posts_area"></div>
    <img id="loading" src="assets/images/icons/loading.gif">


</div>

<script>
    var userLoggedIn = '<?php echo $userLoggedIn; ?>';

    $(document).ready(function() {

        $('#loading').show();

        $.ajax({
            url: "./inc/handlers/ajax_load_posts.php",
            type: "POST",
            data: "page=1&userLoggedIn=" + userLoggedIn,
            cache: false,

            success: function(data) {
                $('#loading').hide();
                $('.posts_area').html(data);
            }
        });

        $(window).scroll(function() {
            var height = $('.posts_area').height();
            var scroll_top = $(this).scrollTop();
            var page = $('.posts_area').find('.nextPage').val();
            var noMorePosts = $('.posts_area').find('.noMorePosts').val();

            if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
                $('#loading').show();              
                var ajaxReq = $.ajax({
                    url: "./inc/handlers/ajax_load_posts.php",
                    type: "POST",
                    data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
                    cache: false,

                    success: function(response) {
                        $('.posts_area').find('.nextPage').remove();
                        $('.posts_area').find('.noMorePosts').remove();

                        $('#loading').hide();
                        $('.posts_area').append(response);
                    }
                });
            }
            return false;
        });
    });
</script>




</div>
</body>
</body>

</html>