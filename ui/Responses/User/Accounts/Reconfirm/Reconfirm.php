<p>Hopefully, you're here after clicking a link in your email related to regaining access to
your account.  If so, congratulations!  You're in the right place.  If not, then you're probably
in the wrong one.  Let's assume that you're in the right place and work from there.  Sound good?</p>

<p>In your email, you received a confirmation code.  Enter the email address to which your
message was sent and the code in the fields below.  Assuming we can match that information
against our databases, we'll let you enter a new password and we'll reconfirm your account.</p>

<form action="/accounts/look-up" method="post">
<fieldset id="reconfirm_account">
<legend><label>Reconfirm Account</label></legend>
<ol>
    <li>
        <?= $this->printLabel("email_address") ?>
        <input type="email" id="email_address" name="email_address" value="" class="w33">
    </li>
    <li>
        <?= $this->printLabel("reset_vector", self::OPTIONAL, "Confirmation Code") ?>
        <input type="text" id="reset_vector" name="reset_vector" value="" class="w33">
    </li>
</ol>
<button><i class="fa fa-fw fa-search"></i> Find Account</button>
</fieldset>
</form>