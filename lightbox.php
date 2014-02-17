<div class="lightbox" style="display: none" id="sign-in">
	<div class="text">
		<h2>Sign In</h2>
		<a href="#" onclick="showHide(true, ['#sign-up', '.lightbox-mask']); return false;">I need to sign up</a>
	</div>
	<form action="/wp-login.php" method="post" name="loginform" class="form-sign form-sign-in">
		<span class="input person">
			<input type="text" placeholder="Username" name="log">
		</span>
		<span class="input key">
			<input type="password" placeholder="Password" name="pwd">
		</span>
		<div class="text-center">
			<button type="submit" class="btn pink big"><span>login</span><i class="pensil"></i></button>
			<div><a href="/wp-login.php?action=lostpassword"class="pink">Forgot Password</a></div>
		</div>
	</form>
</div>
<div class="lightbox" style="display: none" id="sign-up">
	<div class="text">
		<h2>Sign Up</h2>
		<h5>To track progress, save and share responses.</h5>
		<p>Already have an account?<br><a href="#" onclick="showHide(true, ['#sign-in', '.lightbox-mask']); return false;">Sign In</a></p>
	</div>
	<form action="http://site10.miydim.com/wp-login.php?action=register" method="post" class="form-sign form-sign-up">
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
			<p>By signing up, you are agreeing to our <a href="#" class="pink">Terms of Use</a>.</p>
		</div>
	</form>
</div>
<div class="lightbox-mask" style="display: none"></div>