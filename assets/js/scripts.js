// @codekit-prepend "plugins.js"

// Document Ready
$(document).ready(function() {
	// HTML5 placeholder support
	$("input, textarea").placeholder();
	// Flexible Textareas
	$("textarea").not(".noresize, .noresize textarea").expandingTextarea();
	// Target radios / checkboxes
	$("input[type=radio]").parents('li').addClass('radio');
	$("input[type=checkbox]").parents('li').addClass('checkbox');
	// FitVids
	$(".container").fitVids();
	// Tweak required labels (Gravity Forms)
	$(".gform_wrapper .gfield_required").html("(required)");
	// Sanitise WP content
	$("p:empty").remove();
	$(".wp-caption").removeAttr("style");
	$(".wp-content img, .wp-post-image, .wp-post-thumb").removeAttr("width").removeAttr("height");
});
