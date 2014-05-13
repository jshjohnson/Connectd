// Document Ready
(function($) {
	$(".alert").addClass("fadeInDownBig").delay(2000).queue(function(next){
	    $(this).addClass("fadeOutUpBig");
		next();
	});

	// SVG fallback
	if (!Modernizr.svg) {
	    $('img[src$=".svg"]').each(function(){
	        $(this).attr('src', $(this).attr('src').replace('.svg', '.png'));
	    });
	};

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
	            	$('<p class=\"message message--tooltip message--error\">Email already taken</p>').insertBefore("#email-input").hide().fadeIn().addClass("shake");
	            }
	            else if (!data.result && $this.val() != '') {
	            	// Email available
	            	$('<p class=\"message message--tooltip message--success\">Email available</p>').insertBefore("#email-input").addClass("fadeIn").delay(4000).queue(function(next){
					    $(this).addClass("fadeOut");
					    next();
					});
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
	            	$('<p class=\"message message--tooltip message--error\">Psst. Passwords must contain at least one uppercase character and at least one number.</p>').insertBefore("#password-input").hide().fadeIn().addClass("shake");
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
		
		$param.each(function() {
			$(this).on('click', function(e) {
			e.preventDefault();
			    $.get($file, function(data){
				    $(data).appendTo("body").show();
				   	$('.overlay').children().show().addClass("bounceIn");
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
		});
	};
	//Staging
	overlay($(".apply-trigger"), ""+baseUrl+"assets/ajax/apply.php");
	overlay($(".hire-trigger"), ""+baseUrl+"assets/ajax/hire.php");
	overlay($(".post-job-trigger"), ""+baseUrl+"assets/ajax/post-job.php");
	overlay($(".collaborate-trigger"), ""+baseUrl+"assets/ajax/collaborate.php");
	overlay($(".dev-skills-trigger"), ""+baseUrl+"assets/ajax/dev-skills.php");
	overlay($(".des-skills-trigger"), ""+baseUrl+"assets/ajax/des-skills.php");
	overlay($(".login-trigger"), ""+baseUrl+"assets/ajax/login.php");
	overlay($(".delete-trigger"), ""+baseUrl+"assets/ajax/delete-user.php");
	overlay($(".delete-job-trigger"), ""+baseUrl+"assets/ajax/delete-job.php");

	$.ajax({
		url: ""+baseUrl+"assets/ajax/skill-check.php", 
		dataType: 'json', 
		success: function(r){
			skills = r;
		}
	});

})(jQuery);

window.addEvent('load', function(){

	function waitForElement(){
		if(typeof skills !== "undefined"){
			var t2 = new TextboxList('form_tags_input_2', {
				unique: true,
				maxLength: 6,
				bitsOptions:{
					editable:{addKeys: 188}
				}
			});
			t2.setValues(skills);
		}else {
			setTimeout(function(){
				waitForElement();
			},250);
		}
	}

	waitForElement();
});