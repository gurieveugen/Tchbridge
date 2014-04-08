<div class="lightbox" style="display: none" id="sign-in">
	<div class="text">
		<h2>Sign In</h2>
		<a href="#" onclick="showHide(true, ['#sign-up', '.lightbox-mask']); return false;">I need to sign up</a>
	</div>
	<form id="form-sign-in" action="<?php bloginfo('url'); ?>/wp-login.php" method="post" name="loginform" class="form-sign form-sign-in">
		<span class="input person">
			<input type="text" placeholder="Username" name="log">
		</span>
		<span class="input key">
			<input type="password" placeholder="Password" name="pwd" >
		</span>
		<input type="hidden" name="redirect_to" value="<?php echo getRegistrationRedirectURL(); ?>"/>
		<div class="text-center">
			<button type="submit" class="btn pink big"><span>login</span><i class="pensil"></i></button>
			<div class="forgot-link"><a href="#" onclick="showHide(true, ['#forgot-password', '.lightbox-mask']); return false;" class="pink">Forgot Password</a></div>
		</div>
		
		<p class="error-password" style="display: none">The password you entered is incorrect.</p>
	</form>
</div>
<div class="lightbox" style="display: none" id="sign-up">
	<div class="text">
		<h2>Sign Up</h2>
		<h5>To track progress, save and share responses.</h5>
		<p>Already have an account?<br><a href="#" onclick="showHide(true, ['#sign-in', '.lightbox-mask']); return false;">Sign In</a></p>
	</div>
	<form id="form-sign-up" action="<?php bloginfo('url'); ?>/wp-login.php?action=register" method="post" class="form-sign form-sign-up">
		<span class="input person">
			<input type="text" placeholder="Full Name" name="full_name">
		</span>
		<span class="input mail">
			<input type="email" placeholder="Email Address" name="user_email">
		</span>
		<span class="input person">
			<input type="text" placeholder="Username" name="user_login" required>
		</span>
		<span class="input key">
			<input type="password" placeholder="Password" name="password">
		</span>
		<div class="select-block">
			<span class="input people">
				<select name="employment" id="employment-control">
					<option value="Affiliation">Affiliation</option>
					<option value="The Society of Women Engineers">The Society of Women Engineers</option>
					<option value="National Girls Collaborative Project">National Girls Collaborative Project</option>
					<option value="Girl Scouts">Girl Scouts</option>
					<option value="Other">Other</option>
				</select>
			</span>
			<input type="text" class="select-input" style="display: none;" placeholder="Please Specify" id="please-specify">
		</div>
		<div class="text-center">
			<button type="submit" class="btn big"><span>signup</span><i class="pensil"></i></button>
			<p class="text-terms">By signing up, you are agreeing to our <a href="#" class="pink">Terms of Use</a>.</p>
		</div>
		<input type="hidden" name="redirect_to" value="<?php echo getRegistrationRedirectURL(); ?>"/>
		
		<p class="error-user" style="display: none">That username is already taken, please choose another.</p>
	</form>
</div>
<div class="lightbox" style="display: none" id="forgot-password">
	<div class="text">
		<h2>Forgot Password</h2>
		<h5>Please enter your username or email address. You will receive a link to create a new password via email.</h5>		
	</div>
	<form id="form-forgot-password" action="<?php bloginfo('url'); ?>/wp-login.php?action=register" method="post" class="form-sign form-sign-up">		
		<span class="input mail">
			<input type="email" placeholder="E-mail" name="email">
		</span>		
		<div class="text-center">
			<button type="submit" class="btn big"><span>Get New Password</span></button>		
		</div>	
		<p class="error-user" style="display: none"></p>
	</form>
</div>
<div class="lightbox-mask" style="display: none"></div>