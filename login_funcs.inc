<?php

function mysqli_result($res, $row, $field=0) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
} 

// A string used for md5 encryption.  You could move it to a file 
// outside the web tree for more security.
$supersecret_hash_padding = 'A string that is used to pad out short strings for md5 encryption.';


$LOGGED_IN = false;
unset($LOGGED_IN);


function user_isloggedin() {
  // This function will only work with superglobal arrays, because
  // I'm not passing in any values or declaring globals
  global $supersecret_hash_padding, $LOGGED_IN;

  // Have we already run the hash checks? 
  // If so, return the pre-set var
  if (isSet($LOGGED_IN)) {
    return $LOGGED_IN;
  }
  if (isset($_SESSION['user_name']) && isset($_SESSION['id_hash'])) 
  {
	  if ($_SESSION['user_name'] && $_SESSION['id_hash']) {
		$hash = md5($_SESSION['user_name'].$supersecret_hash_padding);
		if ($hash == $_SESSION['id_hash']) {
		  return true;
		} else {
		  return false;
		}
	  } else {
		return false;
	  }
	}
	else 
	{
		return false;
	}
}


function user_login() {
  // This function will only work with superglobal arrays, because
  // I'm not passing in any values or declaring globals
	if (isset($_POST['guestpass'])) 
	{
		if (strlen($_POST['guestpass']) > 0) 
		{
			$user_name = 'guest';
			$password = $_POST['guestpass'];
		}
		else
		{
			 if (!$_POST['user_name'] || !$_POST['password']) 
			 {
				$feedback = 'ERROR - Missing username or password';
				return $feedback;
			 }
			 else 
			 {
				$user_name = strtolower($_POST['user_name']);
				$password = $_POST['password'];
			 }
		}
	} 
	else 
	{
		 if (!$_POST['user_name'] || !$_POST['password']) 
		 {
			$feedback = 'ERROR - Missing username or password';
			return $feedback;
		 }
		 else 
		 {
			$user_name = strtolower($_POST['user_name']);
			$password = $_POST['password'];
		 }
	}
	$houseid = $_POST['SelectedHouse'];

	// Don't need to trim because extra spaces should fail for this
	// Don't need to addslashes because single quotes aren't allowed
	// Don't need to addslashes because we'll be hashing it

	$crypt_pwd = md5($password);
	$query = "SELECT u.user_name, u.is_confirmed, u.role, u.user_id OwnerId, u.first_name, u.last_name, u.email, h.Status, h.HouseName 
			  FROM user u, House h
			  WHERE u.user_name = '$user_name'
			  AND u.password = '$crypt_pwd'
			  AND u.houseid = $houseid
			  AND u.houseid = h.houseid";
			  
//echo '<br/><br/>';			  
//echo $query;
//echo '<br/><br/>';			  

			  
	$result = mysqli_query( $GLOBALS['link'], $query);
	if (!$result) 
	{
		ActivityLog('Error', curPageURL(), 'Select Login Info',  $query, mysqli_error($GLOBALS['link']));
		$feedback = 'ERROR - Unable to log un';
		return $feedback;
	}	
	elseif (mysqli_num_rows($result) < 1)
	{
		ActivityLog('Warn', curPageURL(), 'Select Login Info',  $query, mysqli_error($GLOBALS['link']));
		$feedback = 'ERROR - User not found or password incorrect';
		return $feedback;
	} 
	else 
	{
		if ((mysqli_result($result, 0, 'is_confirmed') == '1') && (mysqli_result($result, 0, 'Status') == 'A')) 
		{
			$role = mysqli_result($result, 0, 'role');
			$OwnerId = mysqli_result($result, 0, 'OwnerId');
			$FirstName = mysqli_result($result, 0, 'first_name');
			$LastName = mysqli_result($result, 0, 'last_name');	       
			$Email = mysqli_result($result, 0, 'email');	
			$HouseName = mysqli_result($result, 0, 'HouseName');			
			user_set_tokens($user_name, $role, $OwnerId, $FirstName, $LastName, $Email, $houseid, $HouseName);
			return 1;
		} 
		elseif (mysqli_result($result, 0, 'Status') != 'A')
		{
			$SelectedHouse =  $_POST['HousePick'][0];
			$feedback = 'Subscription has not been set up through PayPal<br/><br/>To sign up, please click here:<br/><br/>
			<form id="form_id" action="paypal_renew.php" method="post" ><input type="hidden" name="houseid" value='.$SelectedHouse.'></input>
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="">
			<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"></form>';
			return $feedback;
		}
		else
		{
			$feedback = 'User has not confirmed account';
			return $feedback;
		}
	}  
}


function user_logout() {
	$_SESSION['user_name'] = '';
	$_SESSION['id_hash'] = '';
	$_SESSION['Role'] = '';	
	$_SESSION['HouseId'] = '';		
	$_SESSION['OwnerId'] = '';			
	session_destroy();
}


function user_set_tokens($user_name_in, $role_in, $ownerid_in, $FirstName, $LastName, $Email, $houseid, $HouseName) {
  global $supersecret_hash_padding;
  if (!$user_name_in) {
    $feedback =  'ERROR - No username';
    return false;
  }
  $user_name = strtolower($user_name_in);
  $id_hash = md5($user_name.$supersecret_hash_padding);

//echo "SETTING SESISIONS";

//	session_start(); 

	if ($ownerid_in == '')
	{
		$ownerid_in = 0;
	}
	
    $_SESSION['OwnerId'] = $ownerid_in;
    $_SESSION['user_name'] = $user_name;
    $_SESSION['HouseId'] = $houseid;
    $_SESSION['HouseName'] = $HouseName;	
	$_SESSION['id_hash'] = $id_hash;
	$_SESSION['Role'] = $role_in;
	$_SESSION['FirstName'] = $FirstName;
	$_SESSION['LastName'] = $LastName;
	$_SESSION['Email'] = $Email;
	
	
}

?>
