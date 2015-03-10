var Searchbar = Class.extend({
	init: function() {
		// in order to work, we need both a searchbar element and a searchable one.  we'll look for those 
		// elements first and, if we find them, then we can continue.		
		
		this.searchbar  = $("form.searchbar");
		this.searchable = $("table.searchable");
		if(this.searchbar.length==0 || this.searchable.length==0) return;
		this.search = $.proxy(this.search, this);
		this.reset  = $.proxy(this.reset,  this);
		
		// if we're still executing, then we want to observe the field elements within the searchbar for some events.  
		// the specific events change based on what type of fields we encounter but we always call the search method.  
		
		this.fields = this.searchbar.find(":input").each(function(i, element) {
			switch(element.type) {
				case "text": $(element).keyup(this.search);        break;
				case "select-one": $(element).change(this.search); break;
				case "checkbox": $(element).click(this.search);    break;
				case "reset": $(element).click(this.reset);        break;
			}			
		}.bind(this));
		
		// here, if our URL has search parameters specified in the querystring, we'll parse those values and perform
		// a search based on them.  this is handy when linking in between the pages of our site and automatically showing
		// a subset of a fully searchable set.
		
		if($.url && typeof($.url)=="function") {
			var parameters = $.url().param();
			var perform_search = false;
			
			for(var field in parameters) {
				var value = parameters[field];
				var input = this.searchbar.find("input[name=" + field + "]");
				if(input.length != 0) {
					perform_search = true;
					input.val(value);
				}
			}
			
			if(perform_search) {
				this.search();
				var rows = this.searchable.find("tbody tr:visible");
				if(rows.length == 1) {
					var a = rows.find("th a").get(0);
					this.searchable.trigger("click", [a]);
				}
			}
		}
		
	},
	
	search: function(event) {
		// when we're searching, we want to loop over our searchbar and use any values we find within it to limit
		// the displayed table rows.  we use AND logic here -- if we've entered something into a text field and 
		// selected something else, both must match in order to show a table row.  or, if the table row doesn't 
		// match even one of our criteria, then it is hidden.
		
		this.searchbar.trigger("searchbar:before", [ event ]);
		if(event && event.isPropagationStopped && event.isPropagationStopped()) return;
				
		var rows = this.searchable.find("tbody tr").removeClass("hidden");
		rows.each(function(i, element) {
			// our rows all have HTML5 data- attributes that we compare against the similarly named properties of
			// our criteria in order to determine whether or not each individual row should be shown or hidden.
			
			var show = true;
			var row = $(element);
			this.fields.each(function() {
				var field = $(this);
				var type = field.context.type;
				if(type == "reset") return;
				
				var value = type=="checkbox" ? field.context.checked : field.val();
				if(!value || value.length == 0 || value == "all") return;
				
				// if we haven't left our anonymous function at this time, then we want to compare our value against
				// the row's data with the same name as the field's ID.  if this is a text field, we use a regular 
				// expression to match.  otherwise, we check for equality.
					
				var name = field.attr("id");
				if(type != "text") {
					// if there's a name + "-list" data setting, then we want to use the is() method to determine
					// if our value is a part of that list.  otherwise, we'll simply look for a match to our value.
					
					if(row.data(name + "-list")) show = show && row.is("[data-" + name + "-list~=" + value + "]");
					else show = show && row.data(name) == value;
				} else {
					// this try block helps to avoid bad regular expressions based on wacky user entry.  if we 
					// throw an exception within, we just skip this criterion.
					
					try { 
						var pattern  = new RegExp(value.replace(/\(|\)/g, "_"), "i");
						var row_data = row.data(name).replace(/\(|\)/g, "_");
						show = show && row_data.match(pattern);
					} catch(e) { console.log(e); }
				}
			});
			
			if(!show) row.addClass("hidden");
		}.bind(this));
		
		this.searchbar.trigger("searchbar:after");
	},
	
	reset: function() {
		this.searchbar.closest("form").get(0).reset();
		this.searchable.find("tbody tr.hidden").removeClass("hidden");
		this.searchbar.trigger("searchbar:reset");
		return false;
	}
});


$(document).ready(function() { Searchbar = new Searchbar(); });