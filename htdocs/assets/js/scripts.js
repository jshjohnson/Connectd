
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


	$(".menu-trigger").click(function(e) {
		e.preventDefault();
		$(".header__nav").toggleClass("block");
	});

	// Overlay function

	function overlay($param, $file) {
		var docHeight = $(document).height();
		
		$param.on('click', function(e) {
			e.preventDefault();

		    $.get($file, function(data){
			    $("body").append(data);
				$(".overlay").css({
					height: docHeight,
				});
				$(".site-wrap").addClass("blur");
	    		$(".overlay").add(".cancel-trigger").click(function(e) {
				    if (e.target == this) {
				        $(this).remove();
				        $(".site-wrap").removeClass("blur")
				    }
				});
			});
		});
	}
	overlay($(".apply-trigger"), "/Connectd/htdocs/assets/ajax/apply.php");
	overlay($(".hire-trigger"), "/Connectd/htdocs/assets/ajax/hire.php");
	overlay($(".post-job-trigger"), "/Connectd/htdocs/assets/ajax/post-job.php");
	overlay($(".collaborate-trigger"), "/Connectd/htdocs/assets/ajax/collaborate.php");
	overlay($(".search-trigger"), "/Connectd/htdocs/assets/ajax/search.php");
	overlay($(".dev-skills-trigger"), "/Connectd/htdocs/assets/ajax/dev-skills.php");
	overlay($(".des-skills-trigger"), "/Connectd/htdocs/assets/ajax/des-skills.php");
	overlay($(".login-trigger"), "/Connectd/htdocs/assets/ajax/sign-in.php");

});
