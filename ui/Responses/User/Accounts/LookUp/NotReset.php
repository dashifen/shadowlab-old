<p>Unfortunately, we were unable to reset your account due to some sort of problem when interacting
with the database.  Hopefully, it was just a temporary glitch; click the button below to try again.
If you only end up back here again, then it must be something else.  Contact Dash and he'll try to
figure out what's going on.</p>

<form action="/accounts/look-up" method="post">
<input type="hidden" id="email_address" name="email_addrtess" value="<?= $this->getValue("email_address") ?>">
<button><i class="fa fa-fw fa-envelope-o"></i> Reset Account</button>
</form>