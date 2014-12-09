<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php ActivityLog('Info', curPageURL(), 'PayPal Called',  NULL, NULL); ?>
<?php

/*  PHP Paypal IPN Integration Class Demonstration File
 *  4.16.2005 - Micah Carrick, email@micahcarrick.com
 *
 *  This file demonstrates the usage of paypal.class.php, a class designed  
 *  to aid in the interfacing between your website, paypal, and the instant
 *  payment notification (IPN) interface.  This single file serves as 4 
 *  virtual pages depending on the "action" varialble passed in the URL. It's
 *  the processing page which processes form data being submitted to paypal, it
 *  is the page paypal returns a user to upon success, it's the page paypal
 *  returns a user to upon canceling an order, and finally, it's the page that
 *  handles the IPN request from Paypal.
 *
 *  I tried to comment this file, aswell as the acutall class file, as well as
 *  I possibly could.  Please email me with questions, comments, and suggestions.
 *  See the header of paypal.class.php for additional resources and information.
*/


// Setup class
require_once('paypal.class.php');  // include the class file
$p = new paypal_class;             // initiate an instance of the class
//$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
            
// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

// if there is not action variable, set the default action of 'process'
if (empty($_GET['action'])) $_GET['action'] = 'process';  

switch ($_GET['action']) {
    
   case 'process':      // Process and order...

      // There should be no output at this point.  To process the POST data,
      // the submit_paypal_post() function will output all the HTML tags which
      // contains a FORM which is submited instantaneously using the BODY onload
      // attribute.  In other words, don't echo or printf anything when you're
      // going to be calling the submit_paypal_post() function.
 
      // This is where you would have your form validation  and all that jazz.
      // You would take your POST vars and load them into the class like below,
      // only using the POST values instead of constant string expressions.
 
      // For example, after ensureing all the POST variables from your custom
      // order form are valid, you might have:
      //
      // $p->add_field('first_name', $_POST['first_name']);
      // $p->add_field('last_name', $_POST['last_name']);
     

      $p->add_field('cmd', '_xclick-subscriptions');
//      $p->add_field('business', 'admin_1223600237_biz@thevacationcalendar.com');
      $p->add_field('business', 'payment@thevacationcalendar.com');
      $p->add_field('return', $this_script.'?action=success');
      $p->add_field('cancel_return', $this_script.'?action=cancel');
      $p->add_field('notify_url', $this_script.'?action=ipn');
      $p->add_field('item_name', 'The Vacation Calendar Annual Subscription');
      $p->add_field('lc', 'US');
      $p->add_field('a1', '0');
      $p->add_field('p1', '1');
      $p->add_field('t1', 'D');
      $p->add_field('a3', '20.00');
      $p->add_field('currency_code', 'USD');
      $p->add_field('src', '1');
      $p->add_field('p3', '1');
      $p->add_field('t3', 'Y');
      $p->add_field('sra', '1');
      $p->add_field('custom', $_POST['houseid']);
//      $p->add_field('usr_manage', '1');
      
           
   //   $p->add_field('no_shipping', '1');

      $p->submit_paypal_post(); // submit the fields to paypal
      //$p->dump_fields();      // for debugging, output a table of all the fields
      break;
      
   case 'success':      // Order was successful...
   
      // This is where you would probably want to thank the user for their order
      // or what have you.  The order information at this point is in POST 
      // variables.  However, you don't want to "process" the order until you
      // get validation from the IPN.  That's where you would have the code to
      // email an admin, update the database with payment status, activate a
      // membership, etc.  
 
      echo "<html><head><LINK href=\"BeachStyle.css\" rel=\"stylesheet\" type=\"text/css\"><title>Success</title></head><body>";
      include("Navigation.php");
	  echo "<table border=\"0\" align=\"center\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"><tr valign=\"bottom\" align=\"center\" height=\"45\"><td colspan=\"4\"><table cellpadding=\"0\" cellspacing=\"0\" width=\"95%\" border=\"0\">";
	  echo "<tr><td class=\"Heading\"><br/><br/><br/><br/><br/>Thank you for your order! You will be redirected to the log in page in 3 seconds. Please log in with your admin user to continue setting up your vacation home.</td><tr></table></td></tr></table></body></html>";
      include("Footer.php");
	  
      echo "<meta http-equiv=\"Refresh\" content=\"3; url=index.php\"/>";
 //     foreach ($_POST as $key => $value) { echo "$key: $value<br/>"; }
 			
      echo "</body></html>";
      
      // You could also simply re-direct them to another page, or your own 
      // order status page which presents the user with the status of their
      // order based on a database (which can be modified with the IPN code 
      // below).
      
      break;
      
   case 'cancel':       // Order was canceled...

      // The order was canceled before being completed.
 
      echo "<html><head><title>Canceled</title></head><body><h3>The order was canceled.</h3>";
      echo "</body></html>";
      
      break;
      
   case 'ipn':          // Paypal is calling page for IPN validation...
   
      // It's important to remember that paypal calling this script.  There
      // is no output here.  This is where you validate the IPN data and if it's
      // valid, update your database to signify that the user has payed.  If
      // you try and use an echo or printf function here it's not going to do you
      // a bit of good.  This is on the "backend".  That is why, by default, the
      // class logs all IPN data to a text file.
      
      if ($p->validate_ipn()) {
  
			  
			  
			  
					   
			/////////////////////////////////////////////////
			/////////////Begin Script below./////////////////
			/////////////////////////////////////////////////
			
			
			// assign posted variables to local variables
			$item_name = $p->ipn_data['item_name'];
			$business = $p->ipn_data['business'];
			$item_number = $p->ipn_data['item_number'];
			$payment_status = $p->ipn_data['payment_status'];
			$mc_gross = $p->ipn_data['mc_gross'];
			$payment_currency = $p->ipn_data['mc_currency'];
			$txn_id = $p->ipn_data['txn_id'];
			$receiver_email = $p->ipn_data['receiver_email'];
			$receiver_id = $p->ipn_data['receiver_id'];
			$quantity = $p->ipn_data['quantity'];
			$num_cart_items = $p->ipn_data['num_cart_items'];
			$payment_date = $p->ipn_data['payment_date'];
			$first_name = $p->ipn_data['first_name'];
			$last_name = $p->ipn_data['last_name'];
			$payment_type = $p->ipn_data['payment_type'];
			$payment_status = $p->ipn_data['payment_status'];
			$payment_gross = $p->ipn_data['payment_gross'];
			$payment_fee = $p->ipn_data['payment_fee'];
			$settle_amount = $p->ipn_data['settle_amount'];
			$memo = $p->ipn_data['memo'];
			$payer_email = $p->ipn_data['payer_email'];
			$txn_type = $p->ipn_data['txn_type'];
			$payer_status = $p->ipn_data['payer_status'];
			$address_street = $p->ipn_data['address_street'];
			$address_city = $p->ipn_data['address_city'];
			$address_state = $p->ipn_data['address_state'];
			$address_zip = $p->ipn_data['address_zip'];
			$address_country = $p->ipn_data['address_country'];
			$address_status = $p->ipn_data['address_status'];
			$item_number = $p->ipn_data['item_number'];
			$tax = $p->ipn_data['tax'];
			$option_name1 = $p->ipn_data['option_name1'];
			$option_selection1 = $p->ipn_data['option_selection1'];
			$option_name2 = $p->ipn_data['option_name2'];
			$option_selection2 = $p->ipn_data['option_selection2'];
			$for_auction = $p->ipn_data['for_auction'];
			$invoice = $p->ipn_data['invoice'];
			$custom = $p->ipn_data['custom'];
			$notify_version = $p->ipn_data['notify_version'];
			$verify_sign = $p->ipn_data['verify_sign'];
			$payer_business_name = $p->ipn_data['payer_business_name'];
			$payer_id =$p->ipn_data['payer_id'];
			$mc_currency = $p->ipn_data['mc_currency'];
			$mc_fee = $p->ipn_data['mc_fee'];
			$exchange_rate = $p->ipn_data['exchange_rate'];
			$settle_currency  = $p->ipn_data['settle_currency'];
			$parent_txn_id  = $p->ipn_data['parent_txn_id'];
			$pending_reason = $p->ipn_data['pending_reason'];
			$reason_code = $p->ipn_data['reason_code'];
			
			
			// subscription specific vars
			
			$subscr_id = $p->ipn_data['subscr_id'];
			$subscr_date = $p->ipn_data['subscr_date'];
			$subscr_effective  = $p->ipn_data['subscr_effective'];
			$period1 = $p->ipn_data['period1'];
			$period2 = $p->ipn_data['period2'];
			$period3 = $p->ipn_data['period3'];
			$amount1 = $p->ipn_data['amount1'];
			$amount2 = $p->ipn_data['amount2'];
			$amount3 = $p->ipn_data['amount3'];
			$mc_amount1 = $p->ipn_data['mc_amount1'];
			$mc_amount2 = $p->ipn_data['mc_amount2'];
			$mc_amount3 = $p->ipn_data['mcamount3'];
			$recurring = $p->ipn_data['recurring'];
			$reattempt = $p->ipn_data['reattempt'];
			$retry_at = $p->ipn_data['retry_at'];
			$recur_times = $p->ipn_data['recur_times'];
			$username = $p->ipn_data['username'];
			$password = $p->ipn_data['password'];
			
			//auction specific vars
			
			$for_auction = $p->ipn_data['for_auction'];
			$auction_closing_date  = $p->ipn_data['auction_closing_date'];
			$auction_multi_item  = $p->ipn_data['auction_multi_item'];
			$auction_buyer_id  = $p->ipn_data['auction_buyer_id'];
			
			
	
			
			$fecha = date("m")."/".date("d")."/".date("Y");
			$fecha = date("Y").date("m").date("d");
			
			//check if transaction ID has been processed before
			$checkquery = "select txnid from paypal_payment_info where txnid='".$txn_id."'";
			$sihay = mysql_query($checkquery);
			if (!$sihay)
			{
				ActivityLog('Error', curPageURL(), 'Select txnid Info for PayPal',  $checkquery, mysql_error());
				die("Duplicate txn id check query failed:<br/>" . mysql_error() . "<br/>" . mysql_errno());
			}
			$nm = mysql_num_rows($sihay);
		
		
			if ($nm == 0){
			
			//execute query
			
			
			 $strQuery = "insert into paypal_payment_info(paymentstatus,buyer_email,firstname,lastname,street,city,state,zipcode,country,mc_gross,mc_fee,itemnumber,itemname,os0,on0,os1,on1,quantity,memo,paymenttype,paymentdate,txnid,pendingreason,reasoncode,tax,datecreation) values ('".$payment_status."','".$payer_email."','".$first_name."','".$last_name."','".$address_street."','".$address_city."','".$address_state."','".$address_zip."','".$address_country."','".$mc_gross."','".$mc_fee."','".$item_number."','".$item_name."','".$option_name1."','".$option_selection1."','".$option_name2."','".$option_selection2."','".$quantity."','".$memo."','".$payment_type."','".$payment_date."','".$txn_id."','".$pending_reason."','".$reason_code."','".$tax."','".$fecha."')";
			 $result = mysql_query($strQuery);
			 if (!$result)
			 {
				ActivityLog('Error', curPageURL(), 'Insert PayPal Payment info to Active - Subscribing for PayPal',  $strQuery, mysql_error());
			 	die("Default - paypal_payment_info, Query failed:<br/>" . mysql_error() . "<br/>" . mysql_errno());
			 }
			
			
			 // send an email in any case
			 echo "Verified";
			//	 mail("noreply@thevacationcalendar.com", "VERIFIED IPN", "$res\n $req\n $strQuery\n $struery\n  $strQuery2");
		}
		else {
			// send an email
		//	mail("noreply@thevacationcalendar.com", "VERIFIED DUPLICATED TRANSACTION", "$res\n $req \n $strQuery\n $struery\n  $strQuery2");
		}
			
		//subscription handling branch
		if ( $txn_type == "subscr_signup"  ||  $txn_type == "subscr_payment"  ) {
			
			// insert subscriber payment info into paypal_payment_info table
//			$strQuery = "insert into paypal_payment_info(paymentstatus,buyer_email,firstname,lastname,street,city,state,zipcode,country,mc_gross,mc_fee,memo,paymenttype,paymentdate,txnid,pendingreason,reasoncode,tax,datecreation, custom) values ('".$payment_status."','".$payer_email."','".$first_name."','".$last_name."','".$address_street."','".$address_city."','".$address_state."','".$address_zip."','".$address_country."','".$mc_gross."','".$mc_fee."','".$memo."','".$payment_type."','".$payment_date."','".$txn_id."','".$pending_reason."','".$reason_code."','".$tax."','".$fecha."','".$custom."')";
//			$result = mysql_query($strQuery) or die("Subscription - paypal_payment_info, Query failed:<br/>" . mysql_error() . "<br/>" . mysql_errno());
	
	
			// insert subscriber info into paypal_subscription_info table
			$strQuery2 = "insert into paypal_subscription_info(subscr_id , sub_event, subscr_date ,subscr_effective,period1,period2, period3, amount1 ,amount2 ,amount3,  mc_amount1,  mc_amount2,  mc_amount3, recurring, reattempt,retry_at, recur_times, username ,password, payment_txn_id, subscriber_emailaddress, datecreation, custom) values ('".$subscr_id."', '".$txn_type."','".$subscr_date."','".$subscr_effective."','".$period1."','".$period2."','".$period3."','".$amount1."','".$amount2."','".$amount3."','".$mc_amount1."','".$mc_amount2."','".$mc_amount3."','".$recurring."','".$reattempt."','".$retry_at."','".$recur_times."','".$username."','".$password."', '".$txn_id."','".$payer_email."','".$fecha."','".$custom."')";
			$result = mysql_query($strQuery2);
			if (!$result)
			{
				ActivityLog('Error', curPageURL(), 'Insert PayPal Subscribe info to Active - Subscribing for PayPal',  $strQuery2, mysql_error());
				die("Subscription - paypal_subscription_info, Query failed:<br/>" . mysql_error() . "<br/>" . mysql_errno());
			}
	
	
			mail("noreply@thevacationcalendar.com", "VERIFIED IPN", "$res\n $req\n $strQuery\n $struery\n  $strQuery2");
			
			         // Payment has been recieved and IPN is verified.  This is where you
			  // update your database to activate or process the order, or setup
			  // the database with the user's order details, email an administrator,
			  // etc.  You can access a slew of information via the ipn_data() array.
	   
			  // Check the paypal documentation for specifics on what information
			  // is available in the IPN POST variables.  Basically, all the POST vars
			  // which paypal sends, which we send back for validation, are now stored
			  // in the ipn_data() array.
	   
		 
			 $UpdateHouseQuery = "UPDATE House SET Status = 'A',
							Audit_user_name = 'PAYPAL' WHERE HouseId = ".$custom;
	 //		mail("admin@thevacationcalendar.com", "UPDATE HOUSE QUERY", $UpdateHouseQuery);
	 
			 if (!mysql_query( $UpdateHouseQuery ))
			 {
				ActivityLog('Error', curPageURL(), 'Update House info to Active - Subscribing for PayPal',  $UpdateHouseQuery, mysql_error());
				 mail("admin@thevacationcalendar.com", "UPDATE HOUSE QUERY FAILED", mysql_error());
	 // SEND FAILURE EMAIL
			 }
			 
			 $UpdateUserQuery = "UPDATE user SET is_confirmed = 1,
							Audit_user_name = 'PAYPAL'
							WHERE role= 'Administrator' AND HouseId = ".$custom;
	 //		mail("admin@thevacationcalendar.com", "UPDATE USER QUERY", $UpdateUserQuery);
			 
			 if (!mysql_query( $UpdateUserQuery ))
			 {
				ActivityLog('Error', curPageURL(), 'Update User info to Active - Subscribing for PayPal',  $UpdateUserQuery, mysql_error());
				 mail("admin@thevacationcalendar.com", "UPDATE USER QUERY FAILED", mysql_error());
	 // SEND FAILURE EMAIL
			 }
	 
	 
	   
			  // For this example, we'll just email ourselves ALL the data.
			  $subject = 'Instant Payment Notification - Recieved Payment';
			  $to = 'admin@thevacationcalendar.com';    //  your email
			  $body =  "An instant payment notification was successfully received\n";
			  $body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
			  $body .= " at ".date('g:i A')."\n\nDetails:\n";
			  
			  foreach ($p->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
			  mail("admin@thevacationcalendar.com", "Completed Setup of House ".$custom, "Start spreading the news");
	  
	
		}
		//subscription handling branch
		elseif ( $txn_type == "subscr_cancel"  ) {
			
			// insert subscriber info into paypal_subscription_info table
			$strQuery2 = "insert into paypal_subscription_info(subscr_id , sub_event, subscr_date ,subscr_effective,period1,period2, period3, amount1 ,amount2 ,amount3,  mc_amount1,  mc_amount2,  mc_amount3, recurring, reattempt,retry_at, recur_times, username ,password, payment_txn_id, subscriber_emailaddress, datecreation, custom) values ('".$subscr_id."', '".$txn_type."','".$subscr_date."','".$subscr_effective."','".$period1."','".$period2."','".$period3."','".$amount1."','".$amount2."','".$amount3."','".$mc_amount1."','".$mc_amount2."','".$mc_amount3."','".$recurring."','".$reattempt."','".$retry_at."','".$recur_times."','".$username."','".$password."', '".$txn_id."','".$payer_email."','".$fecha."','".$custom."')";
			$result = mysql_query($strQuery2);
			if (!$result)
			{
				ActivityLog('Error', curPageURL(), 'Insert PayPal Subscription info to Cancelled for PayPal',  $strQuery2, mysql_error());
				die("Subscription - paypal_subscription_info, Query failed:<br/>" . mysql_error() . "<br/>" . mysql_errno());
			}
	
		
				// insert subscriber info into paypal_subscription_info table
			$UpdateHouseQuery = "UPDATE House SET Status = 'C',
							Audit_user_name = 'PAYPAL' WHERE HouseId = ".$custom;
	
			if (!mysql_query( $UpdateHouseQuery ))
			{
				ActivityLog('Error', curPageURL(), 'Update House to Cancelled for PayPal',  $UpdateHouseQuery, mysql_error());
				mail("admin@thevacationcalendar.com", "UPDATE HOUSE QUERY FAILED", mysql_error());
			}
			
			$UpdateUserQuery = "UPDATE user SET is_confirmed = 0,
							Audit_user_name = 'PAYPAL'
							WHERE role= 'Administrator' AND HouseId = ".$custom;
			
			if (!mysql_query( $UpdateUserQuery ))
			{
				ActivityLog('Error', curPageURL(), 'Update User to Cancelled for PayPal',  $UpdateUserQuery, mysql_error());
				mail("admin@thevacationcalendar.com", "UPDATE USER QUERY FAILED", mysql_error());
			}
	
			mail("admin@thevacationcalendar.com", "USER CANCELLED for House ".$custom, "$res\n $req\n $strQuery\n $struery\n  $strQuery2");
	
		}


   }
   
   break;

 }  
  
  

?>