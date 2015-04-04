<p>Unfortunately, we were unable to find your account.  Hopefully this was simply because of a typo
in your email address or your confirmation code.  We've replaced the informatino that you entered on
the previes page in the fields below.  Double check that you entered everything correctly, make any
necessary changes, and then click the button to try and find your account again.  If you try again
and you only end up back here again, contact Dash and he'll try to figure out what's going on.</p>

<form action="/accounts/look-up" method="post">
    <fieldset id="reconfirm_account">
        <legend><label>Reconfirm Account</label></legend>
        <ol>
            <li>
                <?= $this->printLabel("email_address") ?>
                <input type="email" id="email_address" name="email_address" value="<?= $this->getValue("email_address") ?>" class="w33">
            </li>
            <li>
                <?= $this->printLabel("reset_vector", self::OPTIONAL, "Confirmation Code") ?>
                <input type="text" id="reset_vector" name="reset_vector" value="<?= $this->getValue("reset_vector") ?>" class="w33">
            </li>
        </ol>
        <button><i class="fa fa-fw fa-search"></i> Find Account</button>
    </fieldset>
</form>