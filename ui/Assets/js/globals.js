var Globals = Class.extend({
	"init": function() {
		$("form.searchbar").on("searchbar:after", this.zebra);
		$("form.searchbar").on("searchbar:reset", this.zebra);
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
	}
	
});

$(document).ready(function() { Globals = new Globals(); });