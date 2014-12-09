<?php


// A string used for md5 encryption.  You could move it to a file
// outside the web tree for more security.
$supersecret_hash_padding = 'A string that is used to pad out short strings for md5 encryption.';


function user_register() {
  // This function will only work with superglobal arrays, because
  // I'm not passing in any values or declaring globals
  global $supersecret_hash_padding;

  // Are all vars present and passwords match?
  if (strlen($_POST['user_name']) <= 25 && strlen($_POST['password1']) <= 25 && ($_POST['password1'] == $_POST['password2']) && strlen($_POST['email']) <= 50 && validate_email($_POST['email'])) {
    // Validate username and password
    if (account_namevalid($_POST['user_name']) || strlen($_POST['password1'] >= 6)) {

      $user_name = strtolower($_POST['user_name']);
      $user_name = trim($user_name);
      // Don't need to escape, because single quotes aren't allowed
      $email= $_POST['email'];
      $houseid = $_POST['houseid'];
      // Don't allow duplicate usernames or emails
      $query = "SELECT user_id
                FROM user
                WHERE (user_name = '$user_name'
                OR email = '$email')
                AND HouseId = $houseid";
      $result = mysql_query($query);
      if (!$result)
      {
      	ActivityLog('Error', curPageURL(), 'Select for duplicate username or email',  $query, mysql_error());
      }
      elseif (mysql_num_rows($result) > 0) {
		 $feedback = 'ERROR - Username or email address already exists';
        return $feedback;
      } else {
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$emailpassword = $_POST['password1'];
    $password = md5($_POST['password1']);
	$user_ip = $_SERVER['REMOTE_ADDR'];
	$server = $_SERVER['HTTP_HOST'];
		
		if (isset($_POST['confirmed']))
		  {
			$confirmed = $_POST['confirmed'];
		  }
		  else
		  {
			$confirmed = 0;
		  }
		
		if (isset($_POST['AdminOwner']))
		{
				$OwnerAdmin = "Y";
		}
		else
		{
				$OwnerAdmin = "N";
		}
		
        // Create a new hash to insert into the db and the confirmation email
        $hash = md5($email.$supersecret_hash_padding);

        $query = "INSERT INTO user (user_id, user_name, first_name, last_name, password, email, remote_addr, confirm_hash, is_confirmed, role, date_created, houseid, AdminOwner,  Audit_user_name)
                  VALUES (NULL, '$user_name', '$first_name', '$last_name', '$password', '$email', '$user_ip', '$hash', $confirmed, 'Administrator', NOW(), '$houseid', '$OwnerAdmin', 'Register Admin')";

        $result = mysql_query($query);
        if (!$result) {
          ActivityLog('Error', curPageURL(), 'Insert new Admin user',  $query, mysql_error());
          $feedback = 'ERROR - Database error';
          return $feedback;
        } else {
        
          // Send the confirmation email
          $encoded_email = urlencode($_POST['email']);

			if ($confirmed == '0')
			{
				$confirmation = "Click this link to confirm your registration: http://".$_SERVER['HTTP_HOST']."/confirm.php?hash=$hash&email=$encoded_email";
			}
			else
			{
				$confirmation = "Your account has been set up and confirmed";
			}

          $mail_body = <<< EOMAILBODY
Thank you for registering for The Vacation Calendar.  Below is your Administrator User information:

Your username is: $user_name
Your password is: $emailpassword

You can log into The Vacation Calendar website with the username and password provided using the following URL:

			 http://$server/index.php
EOMAILBODY;
  //        mail ($email, 'The Vacation Calendar Registration Confirmation', $mail_body, 'From: noreply@TheVacationCalendar.com');

	  // Give a successful registration message
          $feedback = 'YOU HAVE SUCCESSFULLY REGISTERED. A confirmation email has been sent.';
          return $feedback;
        }
      }
    } else {
      $feedback =  'ERROR - Username or password is invalid';
      return $feedback;
    }
  } else {
    $feedback = 'ERROR - Please fill in all fields correctly';
    return $feedback;
  }
}


function owner_register() {
  // This function will only work with superglobal arrays, because
  // I'm not passing in any values or declaring globals	
  global $supersecret_hash_padding;

  // Are all vars present and passwords match?
  if (strlen($_POST['user_name']) <= 25 && strlen($_POST['password1']) <= 25 && ($_POST['password1'] == $_POST['password2']) && strlen($_POST['email']) <= 50 && validate_email($_POST['email'])) {
    // Validate username and password
    if (account_namevalid($_POST['user_name']) || strlen($_POST['password1'] >= 6)) {

      $user_name = strtolower($_POST['user_name']);
      $user_name = trim($user_name);
      // Don't need to escape, because single quotes aren't allowed
      $email= $_POST['email'];
     
      
      // Don't allow duplicate usernames or emails
      $query = "SELECT user_id
                FROM user
                WHERE (user_name = '$user_name'
                OR email = '$email')
                AND houseid = ".$_SESSION["HouseId"];
      $result = mysql_query($query);
      if (!$result)
      {
      	ActivityLog('Error', curPageURL(), 'Select for duplicate Owner username or email',  $query, mysql_error());
      }
      elseif (mysql_num_rows($result) > 0) {
		 $feedback = 'ERROR - Username or email address already exists';
        return $feedback;
      } else {
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];

		if (isset($_POST['confirmed']))
		  {
			$confirmed = $_POST['confirmed'];
		  }
		  else
		  {
			$confirmed = 0;
		  }
	
	if (!isset($_POST['password1']))
	{
		// Generate a random password
		$alphanum = array('a','b','c','d','e','f','g','h','i','j','k','m','n','o','p','q','r','s','t','u','v','x','y','z','A','B','C','D','E','F','G','H','I','J','K','M','N','P','Q','R','S','T','U','V','W','X','Y','Z','2','3','4','5','6','7','8','9');
		$chars = sizeof($alphanum);
		$a = time();
		$password = "";
		mt_srand($a);
		for ($i=0; $i < 6; $i++) {
		  $randnum = intval(mt_rand(0,56));
		  $password = $password.$alphanum[$randnum];
		}
	}
	else
	{
		 $password = $_POST['password1'];
	}
		$emailpassword = $password;
		// One-way encrypt it
		
		$password = md5($emailpassword);
		$server = $_SERVER['HTTP_HOST'];
		
		$user_ip = $_SERVER['REMOTE_ADDR'];

        // Create a new hash to insert into the db and the confirmation email
        $hash = md5($email.$supersecret_hash_padding);

        $query = "INSERT INTO user (user_id, user_name, first_name, last_name, password, email, remote_addr, confirm_hash, is_confirmed, role, date_created, HouseId,  Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email)
                  VALUES (NULL, '$user_name', '$first_name', '$last_name', '$password', '$email', '$user_ip', '$hash', $confirmed, 'Owner', NOW(), ".$_SESSION["HouseId"].", '".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";


        $result = mysql_query($query);
        if (!$result) {
          ActivityLog('Error', curPageURL(), 'Insert new Owner user',  $query, mysql_error());
          $feedback = 'ERROR - Unable to insert new owner into user table';
          return $feedback;
        } else {
        
          // Send the confirmation email
          $encoded_email = urlencode($_POST['email']);

			if ($confirmed == '0')
			{
				$confirmation = "Click this link to confirm your registration: http://".$_SERVER['HTTP_HOST']."/confirm.php?hash=$hash&email=$encoded_email";
			}
			else
			{
				$confirmation = "Your account has been set up and confirmed";
			}
          $mail_body = <<< EOMAILBODY
You have been registered as an owner of The Vacation Calendar.  

$confirmation

Your username is: $user_name
Your password is: $emailpassword

Once you are confirmed, you can log into The Vacation Calendar website with the username and password provided using the following URL:

			 http://$server/index.php
EOMAILBODY;
          mail ($email, 'The Vacation Calendar Owner Registration Confirmation', $mail_body, 'From: noreply@TheVacationCalendar.com');

	  // Give a successful registration message
          $feedback = 'YOU HAVE SUCCESSFULLY REGISTERED. A confirmation email has been sent.';
          return $feedback;
        }
      }
    } else {
      $feedback =  'ERROR - Username or password is invalid';
      return $feedback;
    }
  } else {
    $feedback = 'ERROR - Please fill in all fields correctly';
    return $feedback;
  }
}


function guest_register($HouseId) {
  // This function will only work with superglobal arrays, because
  // I'm not passing in any values or declaring globals	
  global $supersecret_hash_padding;

  // Are all vars present and passwords match?
  if (strlen($_POST['HousePass']) <= 25 && ($_POST['HousePass'] == $_POST['HouseConfirm'])) {

      $user_name = 'Guest';

      // Delete user for this house id
      $query = "DELETE
                FROM user
                WHERE role = 'Guest'
                AND houseid = ".$HouseId;
      $result = mysql_query($query);

      if (!$result) {
        ActivityLog('Error', curPageURL(), 'Delete existing Guest user',  $query, mysql_error());
        $feedback = 'ERROR - Ubable to delete user';
        return $feedback;
      } else {

    	 $password = $_POST['HousePass'];

		$emailpassword = $password;
		// One-way encrypt it
		
		$password = md5($emailpassword);
		
		
		$user_ip = $_SERVER['REMOTE_ADDR'];

        $query = "INSERT INTO user (user_id, user_name, first_name, last_name, password, email, remote_addr, confirm_hash, is_confirmed, role, date_created, HouseId,  Audit_user_name)
                  VALUES (NULL, '$user_name', 'Guest', 'User', '$password', NULL, '$user_ip', NULL, 1, 'Guest', NOW(), ".$HouseId.",  'Add Guest')";
        $result = mysql_query($query);
        if (!$result) {
          ActivityLog('Error', curPageURL(), 'Insert new Guest user',  $query, mysql_error());
          $feedback = 'ERROR - Unable to create your guest account. Please email support@thevacationcalendar.com for support.';
          return $feedback;
        } else {
			
			$query = "UPDATE House SET Guest = '".$emailpassword."',
							Audit_user_name = NULL,
							Audit_Role = NULL,
							Audit_FirstName = NULL,
							Audit_LastName = NULL, 
							Audit_Email = NULL
						WHERE HouseId = ".$HouseId;

			$result = mysql_query($query);
			if (!$result) {
		        ActivityLog('Error', curPageURL(), 'Update house info with new guest password',  $query, mysql_error());
			  $feedback = 'ERROR - Unable to update house password. Please email support@thevacationcalendar.com for support.';
			  return $feedback;
			} else {
        
			  $feedback = 'YOU HAVE SUCCESSFULLY SET THE GUEST PASSWORD';
			  return $feedback;
			}
        }
      }
  } else {
    $feedback = 'ERROR - Please fill in all fields correctly';
    return $feedback;
  }
}





function user_resend() {
  // This function will only work with superglobal arrays, because
  // I'm not passing in any values or declaring globals	
  global $supersecret_hash_padding;

if (isset($_POST['user_id'])) 
{
	if ($_POST['password1'] != $_POST['password2'])
	{
		$feedback = 'ERROR - Passwords do not match';
		return $feedback;
	}
	else
	{

		// Handle submission.  This is a one-time only form
		// so there will be no problems with handling errors.
		$query = "select 1 from user where user_id = ".$_POST['user_id'];
		$result = mysql_query($query);
		  if (!$result)
		  {
			ActivityLog('Error', curPageURL(), 'Select for duplicate Owner username or email',  $query, mysql_error());
		  }
		  elseif (mysql_num_rows($result) < 1) {
			$feedback = 'ERROR - Unable to find user';
			return $feedback;
		} 
		else 
		{
			$as_email = $_POST['email'];
			$password = $_POST['password1'];
			$as_username = $_POST['user_name'];
			$as_email = addslashes($as_email);
			$is_user = mysql_num_rows($result);
		}	
		
		$server = $_SERVER['HTTP_HOST'];
		
		if ($is_user == 1) 
		{

			if ($_POST['password1'] == "")
			{
				$PassInfo = "";
			}
			else
			{
				$PassInfo = "Password: ".$password;

				// One-way encrypt password
				$crypt_pass = md5($_POST['password1']);
	
				// Create a new hash to insert into the db and the confirmation email
				$hash = md5($as_email.$supersecret_hash_padding);
	
				$query = "update user set password = '$crypt_pass', confirm_hash = '$hash',
							Audit_user_name = 'RESEND USER'
							 where user_id = ".$_POST['user_id'];
	
			   // Put password in the db
				$result = mysql_query($query);
			  if (!$result)
			  {
				ActivityLog('Error', curPageURL(), 'Update user with new password',  $query, mysql_error());
				die('Cannot complete update'); 
			  }
			}
											
			if ($_POST['confirmed'] == '0' || $_POST['sendemail'] == '1')
			{

				// Send the confirmation email
				$encoded_email = urlencode($as_email);

				if ($_POST['confirmed'] == '0')
				{
					$confirmation = "Click this link to confirm your registration: http://".$_SERVER['HTTP_HOST']."/confirm.php?hash=$hash&email=$encoded_email";
				}
				else
				{
					$confirmation = "";
				}
				
				// Send the email
				$to      = $as_email;
				$from    = "Admin@TheVacationCalendar.com";
				$subject = "Set User Profile Details";
				$msg     = <<< EOMSG

Your user information has been updated for The Vacation Calendar.  

$confirmation

			 Username: $as_username
			 
			 $PassInfo

Once you are confirmed, you can log into The Vacation Calendar website with the username and password provided using the following URL:

			 http://$server/index.php


You can go to Manage Profile to change your password:

EOMSG;

				$mailsend = mail("$to","$subject","$msg","From: $from");

				return "User information has been updated.";
			}
			else
			{
				return "User information has been updated.";
			}
		} else {
		// The email address isn't good, they lose.
		}
	}
}
}


function account_namevalid() {

  // must have at least one character
  if (strspn($_POST['user_name'],"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-") == 0) {
    return false;
  }
 
  // must contain all legal characters
  if (strspn($_POST['user_name'],"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_") != strlen($_POST['user_name'])) {
    return false;
  }

  // min and max length
  if (strlen($_POST['user_name']) < 5) {
    return false;
  }
  if (strlen($_POST['user_name']) > 25) {
    return false;
  }

  // illegal names
  if (eregi("^((root)|(bin)|(daemon)|(adm)|(lp)|(sync)|(shutdown)|(halt)|(mail)|(news)|(uucp)|(operator)|(games)|(mysql)|(httpd)|(nobody)|(dummy)|(www)|(cvs)|(shell)|(ftp)|(irc)|(debian)|(ns)|(download))$", $_POST['user_name'])) {
    return false;
  }
  if (eregi("^(anoncvs_)", $_POST['user_name'])) {
    return false;
  }

return true;
}


function validate_email($email) {
  return (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'. '@'. '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email));
}


function user_confirm() {
  // This function will only work with superglobal arrays, because
  // I'm not passing in any values or declaring globals
  global $supersecret_hash_padding;

  // Verify that they didn't tamper with the email address
  $new_hash = md5($_GET['email'].$supersecret_hash_padding);
  if ($new_hash && ($new_hash == $_GET['hash'])) {
    $query = "SELECT user_name
              FROM user
              WHERE confirm_hash = '$new_hash'";
    $result = mysql_query($query);
      if (!$result)
      {
      	ActivityLog('Error', curPageURL(), 'Select hash for user confirm',  $query, mysql_error());
      }
      elseif (mysql_num_rows($result) < 1) {
	      $feedback = 'ERROR - Hash not found';
    	  return $feedback;
    } else {
      // Confirm the email and set account to active
      $email = $_GET['email'];
      $hash = $_GET['hash'];
      $query = "UPDATE user SET email='$email', is_confirmed=1,
							Audit_user_name = 'CONFIRM USER',
					 WHERE confirm_hash='$hash'";
      $result = mysql_query($query);
      if (!$result)
      {
      	ActivityLog('Error', curPageURL(), 'Update to confirm user',  $query, mysql_error());
      }
      return 1;
    }
  } else {
    $feedback = 'ERROR - Values do not match';
    return $feedback;
  }
}

?>