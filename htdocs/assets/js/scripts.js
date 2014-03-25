// Document Ready
$(document).ready(function() {

	$('.alert').slideDown().delay(1000).slideUp();
	// HTML5 placeholder support
	$("input, textarea").placeholder();

	// Target radios / checkboxes
	$("input[type=radio]").parents('li').addClass('radio');
	$("input[type=checkbox]").parents('li').addClass('checkbox');

	// SVG fallback
	if (!Modernizr.svg) {
	    $('img[src$=".svg"]').each(function(){
	        $(this).attr('src', $(this).attr('src').replace('.svg', '.png'));
	    });
	}

	$(".menu-trigger").click(function(e) {
		e.preventDefault();
		$(".header__nav").slideToggle(400);
	});

	// Window Load
	$(window).bind("load", function() {
		// Fade container on load to combat FOUT
		// $(".site-wrap").animate({ opacity: 1 }, 'slow');
	});

	$('#email-input').live('change', function() {
		console.log('Change');
		
		$(this).prev('.message').remove();

	    $.ajax({
	        url: ""+baseUrl+"assets/ajax/db_check.php",
	        data: {
	            'email' : $('#email-input').val()
	        },
	        dataType: 'json',
	        success: function(data) {
	            if(data.result) {
	            	// Email taken
	            	$('<p class=\"message message--error zero-bottom\">Email already taken</p>').hide().insertBefore("#email-input").fadeIn();
	            }
	            else {
	            	// Email available
	            	$('<p class=\"message message--success zero-bottom\">Email available</p>').hide().insertBefore("#email-input").fadeIn();
	            }
	        },
	        error: function(data){
	        	console.log('Error');
	        }
	    });
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
				// $(".site-wrap").addClass("blur");
	    		$(".overlay").add(".cancel-trigger").click(function(e) {
				    if (e.target == this) {
				        $(this).remove();
				        $(".site-wrap").removeClass("blur")
				    }
				});
			});
		});
	}
	//Staging
	overlay($(".apply-trigger"), ""+baseUrl+"/assets/ajax/apply.php");
	// overlay($(".hire-trigger"), ""+baseUrl+"/assets/ajax/hire.php");
	overlay($(".post-job-trigger"), ""+baseUrl+"/assets/ajax/post-job.php");
	// overlay($(".collaborate-trigger"), ""+baseUrl+"/assets/ajax/collaborate.php");
	overlay($(".search-trigger"), ""+baseUrl+"/assets/ajax/search.php");
	overlay($(".dev-skills-trigger"), ""+baseUrl+"/assets/ajax/dev-skills.php");
	overlay($(".des-skills-trigger"), ""+baseUrl+"/assets/ajax/des-skills.php");
	overlay($(".login-trigger"), ""+baseUrl+"/assets/ajax/login.php");

});
