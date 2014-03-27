// Document Ready
$(document).ready(function() {
	$(".alert").addClass("fadeInDownBig").delay(2000).queue(function(next){
	    $(this).addClass("fadeOutUpBig");
	    next();
	});

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

		var $this = $(this);
	
		$this.removeClass("invalid").prev('.message').addClass("fadeOut").remove();

	    $.ajax({
	        url: ""+baseUrl+"assets/ajax/email-check.php",
	        data: {
	            'email' : $('#email-input').val()
	        },
	        dataType: 'json',
	        success: function(data) {
	            if(data.result && $this.val() != '') {
	            	// Email taken
	            	$('#email-input').addClass("invalid");
	            	$('<p class=\"message message--error zero-bottom\">Email already taken</p>').insertBefore("#email-input").hide().fadeIn().addClass("shake");
	            }
	            else if (!data.result && $this.val() != '') {
	            	// Email available
	            	$('<p class=\"message message--success zero-bottom\">Email available</p>').insertBefore("#email-input").addClass("fadeIn");
	            }
	        },
	        error: function(data){
	        	console.log('Error');
	        }
	    });
	});

	$('#password-input').live('change', function() {
		
		var $this = $(this);

		$this.removeClass("invalid").prev('.message--error').remove();

	    $.ajax({
	        url: ""+baseUrl+"assets/ajax/password-check.php",
	        data: {
	            'password' : $('#password-input').val()
	        },
	        dataType: 'json',
	        success: function(data) {
	            if(!data.result && $this.val() != '') {
	            	$('#password-input').addClass("invalid").prev('.message').remove();
	            	$('<p class=\"message message--error zero-bottom\">Psst. Passwords must contain at least one uppercase character and at least one number.</p>').insertBefore("#password-input").hide().fadeIn().addClass("shake");
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
			    $(data).appendTo("body").show();
			   	$('.overlay').children().show().addClass("fadeInDownBig");
				$(".overlay").css({
					height: docHeight,
				});
	    		$(".overlay").add(".cancel-trigger").click(function(e) {
				    if (e.target == this) {
						$('.overlay').remove();
				    }
				});
				$('.cancel-trigger').click(function(e){
					e.preventDefault();
					$('.overlay').remove();
				});
			});
		});
	}
	//Staging
	overlay($(".apply-trigger"), ""+baseUrl+"assets/ajax/apply.php");
	overlay($(".hire-trigger"), ""+baseUrl+"assets/ajax/hire.php");
	overlay($(".post-job-trigger"), ""+baseUrl+"assets/ajax/post-job.php");
	overlay($(".collaborate-trigger"), ""+baseUrl+"assets/ajax/collaborate.php");
	overlay($(".search-freelancer-trigger"), ""+baseUrl+"assets/ajax/search-freelancers.php");
	overlay($(".search-employer-trigger"), ""+baseUrl+"assets/ajax/search-employers.php");
	overlay($(".dev-skills-trigger"), ""+baseUrl+"assets/ajax/dev-skills.php");
	overlay($(".des-skills-trigger"), ""+baseUrl+"assets/ajax/des-skills.php");
	overlay($(".login-trigger"), ""+baseUrl+"assets/ajax/login.php");

});