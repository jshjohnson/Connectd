// @codekit-prepend "plugins.js"

// Document Ready
$(document).ready(function() {
	// HTML5 placeholder support
	$("input, textarea").placeholder();

	// Target radios / checkboxes
	$("input[type=radio]").parents('li').addClass('radio');
	$("input[type=checkbox]").parents('li').addClass('checkbox');

	// SVG fallback
	if (!Modernizr.svg) {
	    $('img[src$=".svg"]').each(function()
	    {
	        $(this).attr('src', $(this).attr('src').replace('.svg', '.png'));
	    });
	}

	// Overlay function
	var docHeight = $(document).height();

	function overlay($param, $file) {
		$param.on('click', function(e) {
			e.preventDefault();

		    $.get($file, function(data){
			    $("body").append(data);
			    $(".site-wrap").addClass("blur");
				$(".overlay").css({
					height: docHeight,
				});
	    		$(".overlay").click(function(e) {
				    if (e.target == this) {
				        $(this).remove();
				        $(".site-wrap").removeClass("blur")
				    }
				});
			});
		});
	}

	overlay($(".apply-trigger"), "assets/ajax/apply.php");
	overlay($(".hire-trigger"), "assets/ajax/hire.php");
	overlay($(".post-job-trigger"), "assets/ajax/post-job.php");
	overlay($(".collaborate-trigger"), "assets/ajax/collaborate.php");
	overlay($(".search-trigger"), "assets/ajax/search.php");
	overlay($(".dev-skills-trigger"), "assets/ajax/dev-skills.php");
	overlay($(".des-skills-trigger"), "assets/ajax/des-skills.php");
	overlay($(".login-trigger"), "assets/ajax/sign-in.php");

});
