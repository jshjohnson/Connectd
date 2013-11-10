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

	    $.get("assets/ajax/form.php", function(data){
		    $("body").append(data);
    		$(".overlay").click(function(e) {
			    if (e.target == this) {
			        $(this).remove();
			    }
			});
		});
	});
});
