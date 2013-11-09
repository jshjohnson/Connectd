// @codekit-prepend "plugins.js"

// Document Ready
$(document).ready(function() {
	// HTML5 placeholder support
	$("input, textarea").placeholder();

	// Target radios / checkboxes
	$("input[type=radio]").parents('li').addClass('radio');
	$("input[type=checkbox]").parents('li').addClass('checkbox');

	// FitVids
	$(".container").fitVids();

	// Overlay

	$(".button-trigger").on('click', function(e) {
		e.preventDefault();

		var docHeight = $(document).height();

	   $("body").append("" +
	    "<section class='overlay'>" +
	    "<div class='overlay__inner'>" +
	    "<h2 class='overlay__title'>You’re one message away...</h2>" +
	    "<form action=''>" +
	    "<textarea name='message' id='' cols='30' rows='15' placeholder='Write anything here that you think the freelancer will need to know about your project. The more detailed, the better!'></textarea>" +
	    "<div class='button-container'>" +
	    "<input class='submit' type='submit' value='Send'>" +
	    "</div>" +
	    "</form>" +
	    "</div>" +
	    "</section>");

	   	$(".overlay").height(docHeight);

		$(".overlay").click(function(e) {
		    if (e.target == this) {
		        $(this).remove();
		    }
		});
	});
});
