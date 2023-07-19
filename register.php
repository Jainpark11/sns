<?php
require './config/config.php';
require './inc/form_handlers/register_handler.php';
require './inc/form_handlers/login_handler.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>방문을 환영합니다</title>
    <link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>

<body>
    <?php

    if (isset($_POST['register_button'])) {
        echo '
    <script>

    $(document).ready(function() {
        if (in_array("<span style=`color: #14C800;`>모두 완료되었어요. 로그인을 시도해보세요!</span><br>", $error_array)){
            $("#first").hide();
            $("#second").show();
        }
        $("#first").hide();
        $("#second").show();
    });

    </script>

    ';
    }


    ?>
    <div class="wrapper">

        <div class="login_box">
            <div class="login_header">
                <h1>자인스타그램</h1>
                Login | 등록
            </div>
            <div id="first">
                <form action="register.php" method="POST">
                    <input type="email" name="log_email" placeholder="이메일주소" value="<?php
                                                                                    if (isset($_SESSION['log_email'])) {
                                                                                        echo $_SESSION['log_email'];
                                                                                    }
                                                                                    ?>" required>
                    <br>
                    <input type="password" name="log_password" placeholder="비밀번호" value="<?php
                                                                                            if (isset($_SESSION['log_password'])) {
                                                                                                echo $_SESSION['log_password'];
                                                                                            }
                                                                                            ?>" required>
                    <br>
                    <input type="submit" name="login_button" value="Login">
                    <br>
                    <?php if (in_array("이메일 혹은 비밀번호가 올바르지 않아요<br>", $error_array)) echo "이메일 혹은 비밀번호가 올바르지 않아요<br>"; ?>
                    <a href="#" id="signup" class="signup">계정이 아직 없으신가요?</a>
                </form>
            </div>
            <div id="second">
                <form action="register.php" method="POST">
                    <input type="text" name="reg_fname" placeholder="이름" value="<?php
                                                                                if (isset($_SESSION['reg_fname'])) {
                                                                                    echo $_SESSION['reg_fname'];
                                                                                }
                                                                                ?>" required>
                    <br>
                    <?php if (in_array("이름은 최소 2글자이어야 합니다<br>", $error_array)) echo "이름은 최소 2글자이어야 합니다<br>"; ?>
                    <!-- <input type="text" name="reg_lname" placeholder="Last Name" value="<?php
                                                                                            if (isset($_SESSION['reg_lname'])) {
                                                                                                echo $_SESSION['reg_lname'];
                                                                                            }
                                                                                            ?>" required>
                    <br> -->
                    <?php if (in_array("성은 최소 1글자이어야 합니다<br>", $error_array)) echo "성은 최소 1글자이어야 합니다<br>"; ?>

                    <input type="email" name="reg_email" placeholder="이메일" value="<?php
                                                                                    if (isset($_SESSION['reg_email'])) {
                                                                                        echo $_SESSION['reg_email'];
                                                                                    }
                                                                                    ?>" required>
                    <br>


                    <input type="email" name="reg_email2" placeholder="이메일을 다시 입력하세요" value="<?php
                                                                                                if (isset($_SESSION['reg_email2'])) {
                                                                                                    echo $_SESSION['reg_email2'];
                                                                                                }
                                                                                                ?>" required>
                    <br>
                    <?php if (in_array("이메일이 이미 사용중입니다.<br>", $error_array)) echo "이메일이 이미 사용중입니다.<br>";
                    else if (in_array("유효한 이메일 주소가 아니에요.<br>", $error_array)) echo "유효한 이메일 주소가 아니에요.<br>";
                    else if (in_array("이메일이 일치하지 않아요<br>", $error_array)) echo "이메일이 일치하지 않아요<br>"; ?>


                    <input type="password" name="reg_password" placeholder="비밀번호를 입력하세요" required>
                    <br>
                    <input type="password" name="reg_password2" placeholder="비밀번호를 다시 입력하세요" required>
                    <br>
                    <?php if (in_array("입력한 비밀번호가 일치하지 않아요<br>", $error_array)) echo "입력한 비밀번호가 일치하지 않아요<br>";
                    else if (in_array("Your password can only contain english characters or numbers<br>", $error_array)) echo "Your password can only contain english characters or numbers<br>";
                    else if (in_array("비밀번호는 2글자에서 30자 사이로 해주세요<br>", $error_array)) echo "비밀번호는 2글자에서 30자 사이로 해주세요<br>"; ?>


                    <input type="submit" name="register_button" value="Register">
                    <br>

                    <?php if (in_array("<span style=`color: #14C800;`>모두 완료되었어요. 로그인을 시도해보세요!</span><br>", $error_array)) echo "<span style=`color: #14C800;`>모두 완료되었어요. 로그인을 시도해보세요!</span><br>"; ?>
                    <a href="#" id="signin" class="signin">계정이 있으시다면 여기를 눌러 로그인하세요</a>

                </form>
            </div>
        </div>
        <div class="alert_box">
            *테스트용 email: user@user.user<br>
            *테스트용 패스워드: 12
        </div>
    </div>

</body>

</html>