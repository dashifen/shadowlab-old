<?php if($this->success) { ?>
	<p>Your account has been reset.  You should shortly receive information in your email about how to create a new password
	and regain access to it.  If you don't get the message, you can return here to try and reset it again.  In doing so, you'll
	hopefully send yourself a successful message next time.  If you continue to have trouble, contact Dash and he'll work it
	out.</p>
<?php } else { ?>
	<p>Well, the good news is that your account is reset.</p>
	
	<p>The bad news is that for some reason, we couldn't send you the email with further instructions.  Some sort of server
	error occured and since the ShadowLab doesn't run it's own email servers, there's not too much we can do.  Step one is
	to try again.  Click the button below and we'll see if the problem persists.  If you do so and you only end up back 
	here a second time, then contact Dash and he'll see what he can figure out.</p>

	<form method="post" action="/accounts/look-up">
	<input type="hidden" name="email_address" value="<?= $this->getValue("email_address") ?>">
	<button><i class="fa fa-fw fa-envelope-o"></i> Reset Account</button>
	</form>
<?php } ?>