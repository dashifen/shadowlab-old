<p>We could not find an account that uses the email address <em><?= $this->getValue("email_address") ?></em>.
Please double-check that you've entered your address correctly.  If so, maybe you used a different one for your
ShadowLab account?  If you continue to have difficulty reseting your account, drop a line to Dash and he'll
look it up for you.</p>

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