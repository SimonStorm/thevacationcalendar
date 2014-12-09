<?php

require_once('register_funcs.inc');

function user_change_password () {

$HouseId = $_SESSION['HouseId'];

  // Do new passwords match?
  if ($_POST['new_password1'] && ($_POST['new_password1'] == $_POST['new_password2'])) {
    // Is password long enough?
    if (strlen($_POST['new_password1']) >= 6) {
      // Is the old password correct?
      if (strlen($_POST['old_password']) > 1) {
        $change_user_name = strtolower($_SESSION['user_name']);
        $old_password = $_POST['old_password'];
	$crypt_pass = md5($old_password);
        $new_password1 = $_POST['new_password1'];
        $query = "SELECT * 
                  FROM user
                  WHERE user_name = '$change_user_name'
                  AND password = '$crypt_pass'";
        $result = mysql_query($query);
		  if (!$result)
		  {
   			ActivityLog('Error', curPageURL(), 'Select user info for new password',  $query, mysql_error());
		  }
		  elseif (mysql_num_rows($result) < 1) {
            ActivityLog('Error', curPageURL(), 'User not found or bad password',  $query, NULL);
            $feedback = 'ERROR - User not found or bad password';
            return $feedback;
        } else {
	         $crypt_newpass = md5($new_password1);
          $query = "UPDATE user
                    SET password = '$crypt_newpass',
							Audit_user_name = '".$_SESSION['user_name']."',
							Audit_Role = '".$_SESSION['Role']."',
							Audit_FirstName = '".$_SESSION['FirstName']."',
							Audit_LastName = '".$_SESSION['LastName']."', 
							Audit_Email = '".$_SESSION['Email']."'
                    WHERE user_name = '$change_user_name'
                    AND password = '$crypt_pass'
                    AND HouseId = ".$HouseId;
          $result = mysql_query($query);
		  if (!$result)
		  {
   			ActivityLog('Error', curPageURL(), 'Update user with new password',  $query, mysql_error());
            $feedback = 'ERROR - Problem updating password';
            return $feedback;
          } else {
            return 1;
          }
        }
      } else {
        $feedback = 'ERROR - Please enter old password';
        return $feedback;
      }
    } else {
      $feedback .= 'ERROR - New password not long enough';
      return false;
    }
  } else {
    $feedback = 'ERROR - Your passwords do not match';
    return $feedback;
  }
}


function user_change_email() {
  global $supersecret_hash_padding;

$HouseId = $_SESSION['HouseId'];

  if (validate_email($_POST['new_email'])) {
    $hash = md5($_POST['new_email'].$supersecret_hash_padding);
    $server = $_SERVER['HTTP_HOST'];

    // Send out a new confirm email with a new hash
    $user_name = strtolower($_SESSION['user_name']);
    $password1 = $_POST['password1'];
    $crypt_pass = md5($password1);
    $email = $_POST['new_email'];
    $query = "UPDATE user
              SET confirm_hash = '$hash',
                  is_confirmed = 1,
                  email = '$email',
					Audit_user_name = '".$_SESSION['user_name']."',
					Audit_Role = '".$_SESSION['Role']."',
					Audit_FirstName = '".$_SESSION['FirstName']."',
					Audit_LastName = '".$_SESSION['LastName']."', 
					Audit_Email = '".$_SESSION['Email']."'
              WHERE user_name = '$user_name'
              AND password = '$crypt_pass'
              AND HouseId = ".$HouseId;
    $result = mysql_query($query);
		  if (!$result)
		  {
			  ActivityLog('Error', curPageURL(), 'Set new email',  $query, mysql_error());
		  }
		  elseif (mysql_affected_rows() < 1) {
            ActivityLog('Error', curPageURL(), 'Wrong password',  $query, NULL);
            $feedback = 'ERROR - Problem updating password';
            return $feedback;
		} else {
		  // Send the confirmation email
		  $encoded_email = urlencode($_POST['new_email']);
      $mail_body = <<< EOMAILBODY
Thank you for registering for The Vacation Calendar.  Click this link to confirm your registration:

http://$server/confirm.php?hash=$hash&email=$encoded_email

Once you see a confirmation message, follow the link to log into The Vacation Calendar website with the username and password you created.
EOMAILBODY;

// We don't want to make them change emails
//      mail($email, 'The Vacation Calendar Email Change Confirmation', $mail_body, 'From: noreply@TheVacationCalendar.com');
      // If you use email rather than password cookies,
      // uncomment the following line
      // user_set_tokens($user_name);
      return 1;
    }
  } else {
    $feedback = 'ERROR - New email address is invalid';
    return $feedback;
  }
}

?>