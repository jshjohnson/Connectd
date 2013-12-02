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


	// Apply Overlay

	$(".apply-trigger").on('click', function(e) {
		e.preventDefault();

		var docHeight = $(document).height();

	    $.get("assets/ajax/apply.php", function(data){
		    $("body").append(data).addClass("blur");
			$(".overlay").css({
				height: docHeight,
			});
    		$(".overlay").click(function(e) {
			    if (e.target == this) {
			        $(this).remove();
			        $("body").removeClass("blur")
			    }
			});
		});
	});

	// Hire Overlay

	$(".hire-trigger").on('click', function(e) {
		e.preventDefault();

		var docHeight = $(document).height();

	    $.get("assets/ajax/hire.php", function(data){
		    $("body").append(data).addClass("blur");
			$(".overlay").css({
				height: docHeight,
			});
    		$(".overlay").click(function(e) {
			    if (e.target == this) {
			        $(this).remove();
			        $("body").removeClass("blur")
			    }
			});
		});
	});

	// Collaborate Overlay

	$(".collaborate-trigger").on('click', function(e) {
		e.preventDefault();

		var docHeight = $(document).height();

	    $.get("assets/ajax/collaborate.php", function(data){
		    $("body").append(data).addClass("blur");
			$(".overlay").css({
				height: docHeight,
			});
    		$(".overlay").click(function(e) {
			    if (e.target == this) {
			        $(this).remove();
			        $("body").removeClass("blur")
			    }
			});
		});
	});

	// Post job Overlay

	$(".post-job-trigger").on('click', function(e) {
		e.preventDefault();

		var docHeight = $(document).height();

	    $.get("assets/ajax/post-job.php", function(data){
		    $("body").append(data).addClass("blur");
			$(".overlay").css({
				height: docHeight,
			});
    		$(".overlay").click(function(e) {
			    if (e.target == this) {
			        $(this).remove();
			        $("body").removeClass("blur")
			    }
			});
		});
	});

	// Search Overlay

	$(".search-trigger").on('click', function(e) {
		e.preventDefault();

		var docHeight = $(document).height();

	    $.get("assets/ajax/search.php", function(data){
		    $("body").append(data).addClass("blur");
			$(".overlay").css({
				height: docHeight,
			});
    		$(".overlay").click(function(e) {
			    if (e.target == this) {
			        $(this).remove();
			        $("body").removeClass("blur")
			    }
			});
		});
	});

});
