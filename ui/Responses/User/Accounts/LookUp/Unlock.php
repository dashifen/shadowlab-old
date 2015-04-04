<?php if (sizeof($this->errors) == 0) { ?>
    <p>Great news!  We found your account.  Even better:  your confirmation code matched the one
        in our database.  That means, either you're the account's owner or you cleverly (and likely
        illegally) hacked the owner's email all for the purpose of gaining access to this system.
        That seems like a lot of work for little benefit, so we'll assume you're not a nefarious
        hacker.</p>

    <p>To finally fully reset and unlock your account, enter a new password in the
        fields below.  Passwords have to contain <strong>lower case and capital letters</strong>,
        <strong>at least one number</strong>, and must be at least ten characters long.  We recommend
        that you stick some punctuation in there, too.  Regardless, enter your new password twice
        below, click the button, and you'll be good to go.</p>
<?php } else { ?>
    <p>Unfortunately, we were unable to unlock your account.  If your password was invalid, it'll
        tell you so below.  Just enter an appropriate one and click the button to continue.  But,
        it's also possible that we had trouble updating your valid password on the server side.  If
        there's no error message below, then just try entring the same password as last time and
        we'll try to save it again.  If you only end up right back here a second time, then contact
        Dash and he'll see what's going on.</p>
<?php } ?>

<form action="/accounts/unlock" method="post">
    <fieldset id="save-password">
        <legend><label>Enter a Password</label></legend>

        <ol>
            <li>
                <?= $this->printLabel("password", self::OPTIONAL, "Enter a Password") ?>
                <input type="password" id="password" name="password" value="" class="w33">
                <ul class="password-strength">
                    <li class="lower"><i class="fa fa-fw fa-close"></i> a-z</li>
                    <li class="upper"><i class="fa fa-fw fa-close"></i> A-Z</li>
                    <li class="number"><i class="fa fa-fw fa-close"></i> 0-9</li>
                    <li class="length"><i class="fa fa-fw fa-close"></i> Length &ge; 10</li>
                </ul>
            </li>
            <li>
                <?= $this->printLabel("confirmation", self::OPTIONAL, "Confirm Password") ?>
                <input type="password" id="confirmation" name="confirmation" value="" class="w33">
                <span class="password-strength confirmation"></span>
            </li>
        </ol>

        <input type="hidden" id="user_id" name="user_id" value="<?= $this->user_id ?>">
        <button type="submit"><i class="fa fa-fw fa-unlock"></i> Unlock Account<i></button>
    </fieldset>

    <script type="text/javascript" src="/assets/js/utilities/passwords.min.js"></script>