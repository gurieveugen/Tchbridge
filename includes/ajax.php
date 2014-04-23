<?php
// =========================================================
// REQUIRE
// =========================================================
require_once('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");


class AJAX{
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct($action)
	{			
		if(method_exists($this, $action))
		{
			$this->$action();
		}		
	}

	/**
	 * Sign up
	 */
	public function login()
	{
		$info                  = array();
		$info['user_login']    = $_POST['log'];
		$info['user_password'] = $_POST['pwd'];
		$info['remember']      = true;
		$user_signon           = wp_signon( $info, false );

		if(is_wp_error($user_signon))
		{
			$json['loggedin'] = false;
			$json['message']  = __('The password you entered is incorrect.');	    
		} 
		else 
		{
			$json['loggedin']    = true;
			$json['message']     = __('Login successful, redirecting...');	  
			$json['redirect_to'] = get_user_meta($user_signon->ID, 'default_url', true);  
		}

		echo json_encode($json);
	}

	/**
	 * Sign in
	 */
	public function registration()
	{
		$json['registered'] = false;
		$json['message']    = '';
		
		if(!strlen($_POST['fullname']))
		{
			$json['message'] = __('You must include a full name.');				
		} 
		if(!strlen($_POST['employment']) || $_POST['employment'] == 'Affiliation')
		{
			$json['message'] = __('Please select affiliation.');				
		} 
		if(strlen($_POST['pwd']) < 8)
		{
			$json['message'] = __('Password must be at least eight characters.');			
		} 	

		if(strlen($json['message']) == 0)
		{			
			$user_id = wp_create_user($_POST['log'], $_POST['pwd'], $_POST['email']); 
			if(is_wp_error($user_id))
			{			
				$json['message'] = $user_id->get_error_message();
			}
			else
			{
				update_user_meta($user_id, 'fullname', $_POST['fullname']);
		    	update_user_meta($user_id, 'employment', $_POST['employment']);

		    	wp_set_current_user($user_id);
		    	wp_set_auth_cookie($user_id, false, is_ssl());
		    	
		    	// =========================================================
		    	// SEND NOTIFICATION
		    	// =========================================================
				$user 	  = get_userdata($user_id);
				$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
				$message  = sprintf(__('New user registration on your site %s:'), $blogname) . "\r\n\r\n";
				$message .= sprintf(__('Username: %s'), $user->user_login) . "\r\n\r\n";
				$message .= sprintf(__('E-mail: %s'), $user->user_email) . "\r\n";

				@wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message);
				
				$message      = '<img src="'.get_bloginfo('template_url').'/images/email_logo_small.png" alt="Badge green"><br>';
				$message     .= 'Thank you for signing up for the Role Models Matter toolkit.  This toolkit provides fun, online training and resources for role models to develop the skills to engage youth in STEM (science, technology, engineering, and math).  Please be sure to sign in each time you visit the site so that you can save and share responses to questions within each tool.'."<br><br>\r\n\n";
				$message     .= sprintf('Username: %s', $user->user_login)."<br>\r\n";
				$message     .= sprintf('Link to Role Models Matter Toolkit: %s', 'http://techbridgegirls.org/rolemodelsmatter')."<br>\r\n";

		    	wp_mail($user->user_email, sprintf(__('[%s] Your username and password'), $blogname), $message);

		    	$json['registered'] = true;
				$json['message']    = __('Registration successful, redirecting...');	


			}
		}

		echo json_encode($json);
	}



	/**
	 * Recovery own password
	 */
	public function lostpassword()
	{
		global $wpdb;
		
		$error   = '';
		$success = '';

		$email = trim($_POST['email']);

		if(empty($email)) 
		{
			$error = 'Enter a e-mail address..';
		} 
		else if(!is_email($email)) 
		{
			$error = 'Invalid e-mail address.';
		} 
		else if(!email_exists($email))
		{
			$error = 'There is no user registered with that email address.';
		} 
		else 
		{	
			$random_password = wp_generate_password( 12, false );
			$user            = get_user_by( 'email', $email );
			$update_user     = wp_update_user( array (
				'ID'        => $user->ID, 
				'user_pass' => $random_password
			));

			
			if($update_user) 
			{
				$to        = $email;
				$subject   = 'Your new password';
				$sender    = get_option('name');
				$message   = 'Login: '.$user->user_login."\r\n<br>";
				$message  .= 'Your new password is: '.$random_password;
				$headers[] = 'MIME-Version: 1.0' . "\r\n";
				$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers[] = "X-Mailer: PHP \r\n";
				$headers[] = 'From: '.$sender.' < '.$email.'>' . "\r\n";
				$mail      = wp_mail( $to, $subject, $message, $headers );

				if($mail) $success = 'Thank you - you have been sent an email to update your password';

			} 
			else 
			{
				$error = 'Oops something went wrong updaing your account.';
			}
		}

		if(!empty($error)) 
		{
			$json['renewpassword'] = false;
			$json['message']       = $error;
		}
		else
		{
			$json['renewpassword'] = true;
			$json['message']       = $success;		
		}

		echo json_encode($json);
	}

	/**
	 * Send mail
	 */
	public function sendResponse()
	{
		global $current_user;

		$msg     = '<img src="'.get_bloginfo('template_url').'/images/email_logo_small.png" alt="Badge green"><br>';
		$msg    .= '<p>Thank you for taking the time to respond to the Role Models Matter online training questions. Below are the responses you have entered so far. You can log back into the training site at any time to change or add new responses.</p>';
		$subject = 'Role Models Matter Training Responses.';

		if(intval($_POST['all']))
		{
			foreach ($_POST['items'] as $post) 
			{
				$msg.= sprintf('<h1>%s</h1><br>', $post['title']);
				foreach ($post['items'] as $el) 
				{
					$msg.= sprintf('<h4>%s</h4><p>%s</p>', $el['question'], $el['answer']);
				}		
				$msg.= '<br><br>';
			}
		}
		else
		{
			$subject = $_POST['items']['title'];			
			$msg.= sprintf('<h1>%s</h1><br>', $_POST['items']['title']);
			foreach ($_POST['items']['items'] as $el) 
			{
				$msg.= sprintf('<h4>%s</h4><p>%s</p>', $el['question'], $el['answer']);
			}		
			$msg.= '<br><br>';
		}
		$json['sended']  = false;
		$json['message'] = 'Email not sent!';
		if(wp_mail($current_user->user_email, $subject, $msg))
		{
			$json['sended']  = true;
			$json['message'] = 'Your Role Models Matter training responses have been sent to you by email.';
		}
		echo json_encode($json);
	}
}

// =========================================================
// LAUNCH
// =========================================================
$GLOBALS['AJAX'] = new AJAX($_GET['action']);