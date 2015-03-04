var Summarize = Class.extend({
	"init": function() {
		$("table.summarized").click(function(event, element) {
			var clicked = element ? $(element) : $(event.target);
			
			// if the element that was clicked is the anchor element within a summary's header, then
			// we'll want to show the description.
			
			if(clicked.is("tr.summary th a")) {
				var summary = clicked.parents("tr");
				
				// armed with our summary, we can grab the descriptions.  then, we want to see if
				// the description is visible or not.  we use that boolean below to toggle classes on
				// our summary and description.
				
				var description = summary.nextUntil("tr:not(.description)");
				var visible = description.hasClass("hidden");
				
				// this toggles the .hidden, .b, and .clicked classes on the description, summary, and 
				// summary respectively based on the visibility status of the description.  the first 
				// will show/hide the description while the second just makes the screen look prettier.
				// the third, though, is important to "know" which descriptions should and should not be
				// visible as other behaviors occur. 
				
				description.toggleClass("hidden", !visible);
				summary.toggleClass("clicked", visible).toggleClass("b", !visible);
				
				// at this point, this event is handled and we don't want the browser to take any sort
				// of action related to this click. 
				
				event.stopPropagation();
				event.preventDefault();
				return false;
			}
		});
		
		// wihtout these lines, when people use the searchbar on the screen descriptions would become
		// visible.  the searchbar:* actions are fired from within the object defined in ./searchbar.js.
		
		$("form.searchbar").on("searchbar:after", this.hide_descriptions);
		$("form.searchbar").on("searchbar:reset", this.hide_descriptions);
	},
	
	hide_descriptions: function() {
		$("table.searchable tr.description").each(function() {
			if(!$(this).prev("tr").hasClass("clicked")) $(this).addClass("hidden");
		});
	}
});

$(document).ready(function() { Summarize = new Summarize(); });