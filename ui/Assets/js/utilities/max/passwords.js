$(document).ready(function() {
    var Passwords = Class.extend({
        init: function ()
        {
            $("#password").keyup($.proxy(this.checkStrength, this));
            $("#confirmation").keyup($.proxy(this.confirm, this));
        },

        checkStrength: function()
        {
            var password = $("#password").val();

            var lower  = $(".lower  i");
            var upper  = $(".upper  i");
            var number = $(".number i");
            var length = $(".length i");

            password.match(/[a-z]/) ? this.tick(lower)  : this.untick(lower);
            password.match(/[A-Z]/) ? this.tick(upper)  : this.untick(upper);
            password.match(/[0-9]/) ? this.tick(number) : this.untick(number);
            password.length >= 10   ? this.tick(length) : this.untick(length);
        },

        confirm: function()
        {
            var password = $("#password").val();
            var confirmation = $("#confirmation").val();
            var confirmation_message = $(".confirmation");

            if (password == confirmation) {
                this.success(confirmation_message).text("Passwords Match");
            } else {
                this.warning(confirmation_message).text("Passwords Don't Match");
            }
        },

        tick:    function(element) { return this.toggle(element, "fa-close", "fa-check"); },
        untick:  function(element) { return this.toggle(element, "fa-check", "fa-close"); },
        success: function(element) { return this.toggle(element, "warning",  "success");  },
        warning: function(element) { return this.toggle(element, "success",  "warning");  },

        toggle: function(element, remove, add)
        {
            return $(element).removeClass(remove).addClass(add);
        }
    });

    Passwords = new Passwords();
});
