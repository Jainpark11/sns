<?php

$fname = ""; 
$lname = "";
$em = ""; //email
$em2 = ""; //email 2
$password = ""; //password
$password2 = ""; //password 2
$date = ""; 
$error_array = array(); 

if (isset($_POST['register_button'])) {

  

    $fname = strip_tags($_POST['reg_fname']); 
    $fname = str_replace(' ', '', $fname);
    $fname = ucfirst(strtolower($fname));
    $_SESSION['reg_fname'] = $fname; 

  
    $lname = ($_POST['reg_lname']); 
    $lname = str_replace(' ', '', $lname); 
    $lname = ucfirst(strtolower($lname)); 
    $_SESSION['reg_lname'] = $lname; 

    //email
    $em = ($_POST['reg_email']);
    $em = str_replace(' ', '', $em); 
    $_SESSION['reg_email'] = $em;

    //email 2
    $em2 = ($_POST['reg_email2']);
    $em2 = str_replace(' ', '', $em2); 
    $_SESSION['reg_email2'] = $em2; 

    //Password
    $password = ($_POST['reg_password']);
    $password2 = ($_POST['reg_password2']);

    $date = date("Y-m-d"); 

    if ($em == $em2) {
   
        if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);         
            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");           
            $num_rows = mysqli_num_rows($e_check);
            if ($num_rows > 0) {
                array_push($error_array, "이메일이 이미 사용중입니다.<br>");
            }
        } else {
            array_push($error_array, "유효한 이메일 주소가 아니에요.<br>");
        }
    } else {
        array_push($error_array, "이메일이 일치하지 않아요<br>");
    }


    if (strlen($fname) > 25 || strlen($fname) < 1) {
        array_push($error_array, "이름은 최소 2글자이어야 합니다<br>");
        return false;
    }

    // if (strlen($lname) > 25 || strlen($lname) < 1) {
    //     array_push($error_array,  "성은 최소 1글자이어야 합니다<br>");
    //     return false;
    // }

    if ($password != $password2) {
        array_push($error_array,  "입력한 비밀번호가 일치하지 않아요<br>");
        echo $password2;
        return false;
    }

    if (strlen($password) > 30 || strlen($password) < 1) {
        array_push($error_array, "비밀번호는 2글자에서 30자 사이로 해주세요<br>");
        echo strlen($password);
        return false;
    }
    if (empty($error_array)) {
        $i = 0; 
        $password = md5($password);       
        //$username = ($fname . "_" . $lname);
        $username = ($fname . "_". $i);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");              
        while (mysqli_num_rows($check_username_query) != 0) {
            $i++; 
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
        }        
        $rand = rand(1, 2); 
        if ($rand == 1)
            $profile_pic = "assets/images/profile_pics/defaults/head_sun_flower.png";
        else if ($rand == 2)
            $profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";

        $lname ="";
        $query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");
        // $query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

        array_push($error_array, "<span style=`color: #14C800;`>모두 완료되었어요. 로그인을 시도해보세요!</span><br>");

        $_SESSION['reg_fname'] = "";
        $_SESSION['reg_lname'] = "";
        $_SESSION['reg_email'] = "";
        $_SESSION['reg_email2'] = "";
    }
}
