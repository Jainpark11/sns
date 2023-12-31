<?php 
class User{
    private $user;
    private $con;
    public function __construct($con, $user){
        $this->con = $con;
        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user'");
        $this->user=mysqli_fetch_array($user_details_query);      
    }
    public function getUsername(){
        return $this->user['username'];
    }    
    public function getNumPosts() {
       
        $username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT num_posts FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['num_posts'];
		// $username = $this->user['username'];		
		// $query = mysqli_query($this->con, "SELECT * FROM posts WHERE added_by='$username'");
		// $postNum = mysqli_num_rows($query);
		// echo $postNum;
	}
    public function getFirstAndLastName(){
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT first_name From users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
       // return $row['first_name'] ."". $row['last_name'];
       return $row['first_name'];
    }
    public function getProfilePic(){
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT profile_pic From users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
       // return $row['first_name'] ."". $row['last_name'];
       return $row['profile_pic'];
    }
    public function isClosed(){
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT user_closed FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        if($row['user_closed']=='yes')
        return true;
        else
        return false;
    }
    public function isFriend($username_to_check){
        $usernameComma = "," .$username_to_check .",";
        if(strstr($this->user['friend_array'],$usernameComma) || $username_to_check ==$this->user['username']){
            return true;
        }else{
            return false;
        }
    }
    public function didReceiveRequest($user_from) {
		$user_to = $this->user['username'];
		$check_request_query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");
      
		if(mysqli_num_rows($check_request_query) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function didSendRequest($user_to) {
		$user_from = $this->user['username'];
		$check_request_query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");
		if(mysqli_num_rows($check_request_query) > 0) {
			return true;
		}
		else {
			return false;
		}
	}
 
}
