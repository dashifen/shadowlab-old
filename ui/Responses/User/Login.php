<?php if ($this->attempts >= 5) { ?>
    <p>Unfortunately, you have attempted to log in <?= $this->attempts ?> times.  We've locked your
    access until you close and re-open your browser to help ensure the security of the system.  Reboot
    your browser and then try again.  If this problem persists, track down Dash and he'll check into
    the code to see what he messed up.</p>
<?php } else { ?>
    <form method="post" action="/authenticate">

    <fieldset id="login-form">
    <legend><label for="login-form">Log In to Continue</label></legend>

    <?php if ($this->heading != 'Login Failed') { ?>
        <p>Enter your account credentials below to log in.  Wait... you don't have credentials?  Well, then
        you're out of luck.  The ShadowLab is not yet open for business so only a select, lucky few have access.
        Think you should be one of them?  You're not.  Dash knows who his people are and they already have
        access.</p>
    <?php } else { ?>
        <p>We were unable to log you in using the credentials you entered on the previous screen.  Try to log in
        again.
    <?php } ?>

    <ol>
        <li>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= $this->username?>" class="w33">
        </li>
        <li>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="" class="w33">
        </li>
    </ol>

    <button>
        <i class="fa fa-fw fa-sign-in"></i>
        Log In
    </button>

    </fieldset>
    </form>
<?php } ?>