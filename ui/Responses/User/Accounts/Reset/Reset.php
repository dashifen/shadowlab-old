<p>Use the form below to reset your account.  Enter the email address you used when creating
your account or the one used when it was created for you.  Regardless, we'll look up your
account and send you more information by email.</p>

<form action="/accounts/look-up" method="post">
<fieldset id="reset_account">
<legend><label>Reset Account</label></legend>
<ol>
    <li>
        <?= $this->printLabel("email_address") ?>
        <input type="email" id="email_address" name="email_address" value="" class="w33">
    </li>
</ol>
<button><i class="fa fa-fw fa-envelope-o"></i> Reset Account</button>
</fieldset>
</form>