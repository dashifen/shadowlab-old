var Globals = Class.extend({
	"init": function() {
        var searchbar = $("form.searchbar");
        if (searchbar.length) {
            searchbar.on("searchbar:after", this.zebra);
            searchbar.on("searchbar:reset", this.zebra);
        }

		this.dialog = $("#dialog").dialog({
			"close": function() { $("#dialog .observed").off(".dialog"); },
			"draggable": false, "resizable": false, "autoOpen": false, "closeOnEscape": false, "modal": true,
			"height": "auto", "maxHeight": 600, "width": 600,
		});
		
		$("a.dialog").click($.proxy(this.loadDialog, this));
        $("form[method=post]").each(this.setPostFlag);
	},
	
	"zebra": function() {
		$("table.searchable tbody tr:visible").each(function(i) {
			var summary = $(this);
			var description = summary.next("tr");
			var add_class = i%2==0 ? "odd" : "even";
			var rem_class = add_class == "odd" ? "even" : "odd";
			
			summary.removeClass(rem_class).addClass(add_class);
			description.removeClass(rem_class).addClass(add_class);
		});
	},
	
	"loadDialog": function(event) {
		event.stopPropagation();
		event.preventDefault();
		
		var a     = $(event.target);
		var url   = $.url(a.attr("href"));
		var name  = url.param()["name"];
        var title = url.param()["title"];
		var href  = url.attr("path") + " #" + name;
		
		this.dialog.load(href, null, function(text) {
			
			this.dialog.dialog("option", "title", title);
			this.dialog.dialog("option", "dialogClass", "");
			this.dialog.dialog("open");
			
		}.bind(this));
	},

    "setPostFlag": function(i, poster) {
        if (poster.isPost) return;
        var input = $('<input type="hidden" id="isPost" name="isPost" value="true">');
        $(poster).append(input);
    }
});

$(document).ready(function() { Globals = new Globals(); });