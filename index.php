<?php
header("Access-Control-Allow-Origin: *");
// function 
class tqb {
	public static function POST($key) {
	$key = addslashes(stripslashes($key));
	$key = ($key);
	return $key;
	}
}
date_default_timezone_set('Asia/Ho_Chi_Minh');
if($_REQUEST){ // yêu cầu
	$return = array('error' => 0); //
	$act = $_REQUEST['act']; // action
	// Users
	if ($act === 'user-register') {
		$username = tqb::POST($_POST['username']);
		$email = tqb::POST($_POST['email']);
		$password = tqb::POST($_POST['password']);
		//$return['error'] = 1;
		// kiểm tra tên
		$name = explode("_", $username);
		// kiểm tra tên
		$check_name = '/^[a-zA-Z]+$/';
		if(!preg_match($check_name, $name[0])) {
		$return['error'] = 1;
			$return['msg'] = "Tên nhân vật không hợp lệ ( Ho_Ten )!";
			die(json_encode($return));
		} else {
				if(!preg_match($check_name, $name[1])){
				$return['error'] = 1;
				$return['msg'] = "Tên nhân vật không hợp lệ ( Ho_Ten )!";
			die(json_encode($return));
			}
		}
		$result['user'] = $name[0].'_'.$name[1];
		$result['pass'] = strtoupper(hash('whirlpool',$password));
		$result['pass1'] = $password;
		die(json_encode($result));
		//
		$return['msg'] = 'Tài khoản: '.$username.'<br>Email: '.$email.'<br>Mật khẩu: '.$password;
		die(json_encode($return));
		$act = 'user-query';
	}
	if ($act === 'user-query') { // if ($act === 'user-query')
		$username = tqb::POST($_POST['username']);
		$email = tqb::POST($_POST['email']);
		$password = tqb::POST($_POST['password']);
		$pass1 = tqb::POST($_POST['pass1']);
		$count = tqb::POST($_POST['count']);
		$ipallow = tqb::POST($_POST['ipallow']);
		$ip = tqb::POST($_POST['ip']);
		$ip2 = $_SERVER["REMOTE_ADDR"];
		//$return['error'] = 1;
		//$result['user'] = $name[0].'_'.$name[1];
		//$result['pass'] = strtoupper(hash('whirlpool',$password));
		//$result['pass1'] = $password;
		//die(json_encode($result));
		//
		// DB connect
		$conn = mysqli_connect($_POST['host'],$_POST['user'],$_POST['pass'],$_POST['db']);
		mysqli_set_charset($conn, "utf8");
		// Check connection
        if (mysqli_connect_errno())
          {
                $return['error'] = '1';
              $return['msg'] = "Không thể kết nối với MySQL: " . mysqli_connect_error();
              die(json_encode($return));
          }
		//
		/*if($ip = $_SERVER["REMOTE_ADDR"])
		{
		    $return['error'] = 1;
			$return['msg'] = 'Đã xảy ra lỗi với địa chỉ IP của bạn!';
			die(json_encode($return));
		}*/
		$result = mysqli_query($conn, "SELECT COUNT(*), IP FROM accounts WHERE IP = '$ip2'");
		$x2 = mysqli_fetch_assoc($result);
		if($ipallow != $x2['IP'])
		{
    		if($x2['COUNT(*)'] >= $count)
    		{
    			$return['error'] = 1;
    			$return['msg'] = 'Bạn không thể tạo thêm tài khoản!';
    			die(json_encode($return));
    		}
		}
        
		$result = mysqli_query($conn, "SELECT COUNT(*) FROM accounts WHERE Username = '$username'");
		$x = mysqli_fetch_assoc($result);
		$result = mysqli_query($conn, "SELECT COUNT(*) FROM accounts WHERE Email='$email'");
		$x1 = mysqli_fetch_assoc($result);
		if($x['COUNT(*)'] != '0')
		{
			$return['error'] = 1;
			$return['msg'] = 'Tài khoản đã tồn tại!';
			die(json_encode($return));
		} else if($x1['COUNT(*)'] != '0') {
			$return['error'] = 1;
			$return['msg'] = 'Địa chỉ email đã tồn tại!';
			die(json_encode($return));
		}
		$date = date("Y-m-d H:i:s", time());
		$query = "INSERT INTO `accounts`(`Username`,`Key`,`Email`,`RegiDate`, `IP`) VALUES('".$username."','".$password."','".$email."','".$date."', '".$ip2."');";
		if(mysqli_query($conn, $query))
		{
			$return['msg'] = 'Tài khoản: '.$username.'<br> Email: '.$email.'<br> Mật khẩu: '.$pass1;
		//	$return['msg'] = 'null';
			die(json_encode($return));
		} else { 
			$return['error'] = 1;
			$return['msg'] = 'Lỗi';
			die(json_encode($return));
		} 
	//	    $return['msg']
	//	 $return['msg'] = 'Tài khoản: '.$username.'<br> Email: '.$email.'<br> Mật khẩu: '.$pass1;

       // die(json_encode($return));
	}
	if ($act === 'check-server') { 
	    phpinfo();
	    
	}
	
	
}
