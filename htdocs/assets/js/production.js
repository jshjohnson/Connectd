/* http://mths.be/placeholder v2.0.7 by @mathias */
;(function(f,h,$){var a='placeholder' in h.createElement('input'),d='placeholder' in h.createElement('textarea'),i=$.fn,c=$.valHooks,k,j;if(a&&d){j=i.placeholder=function(){return this};j.input=j.textarea=true}else{j=i.placeholder=function(){var l=this;l.filter((a?'textarea':':input')+'[placeholder]').not('.placeholder').bind({'focus.placeholder':b,'blur.placeholder':e}).data('placeholder-enabled',true).trigger('blur.placeholder');return l};j.input=a;j.textarea=d;k={get:function(m){var l=$(m);return l.data('placeholder-enabled')&&l.hasClass('placeholder')?'':m.value},set:function(m,n){var l=$(m);if(!l.data('placeholder-enabled')){return m.value=n}if(n==''){m.value=n;if(m!=h.activeElement){e.call(m)}}else{if(l.hasClass('placeholder')){b.call(m,true,n)||(m.value=n)}else{m.value=n}}return l}};a||(c.input=k);d||(c.textarea=k);$(function(){$(h).delegate('form','submit.placeholder',function(){var l=$('.placeholder',this).each(b);setTimeout(function(){l.each(e)},10)})});$(f).bind('beforeunload.placeholder',function(){$('.placeholder').each(function(){this.value=''})})}function g(m){var l={},n=/^jQuery\d+$/;$.each(m.attributes,function(p,o){if(o.specified&&!n.test(o.name)){l[o.name]=o.value}});return l}function b(m,n){var l=this,o=$(l);if(l.value==o.attr('placeholder')&&o.hasClass('placeholder')){if(o.data('placeholder-password')){o=o.hide().next().show().attr('id',o.removeAttr('id').data('placeholder-id'));if(m===true){return o[0].value=n}o.focus()}else{l.value='';o.removeClass('placeholder');l==h.activeElement&&l.select()}}}function e(){var q,l=this,p=$(l),m=p,o=this.id;if(l.value==''){if(l.type=='password'){if(!p.data('placeholder-textinput')){try{q=p.clone().attr({type:'text'})}catch(n){q=$('<input>').attr($.extend(g(this),{type:'text'}))}q.removeAttr('name').data({'placeholder-password':true,'placeholder-id':o}).bind('focus.placeholder',b);p.data({'placeholder-textinput':q,'placeholder-id':o}).before(q)}p=p.removeAttr('id').hide().prev().attr('id',o).show()}p.addClass('placeholder');p[0].value=p.attr('placeholder')}else{p.removeClass('placeholder')}}}(this,document,jQuery));

/* FitVids 1.0 - http://fitvidsjs.com */
(function(e){e.fn.fitVids=function(t){var n={customSelector:null},r=document.createElement("div"),i=document.getElementsByTagName("base")[0]||document.getElementsByTagName("script")[0];r.className="fit-vids-style";r.innerHTML="&shy;<style>.fluid-width-video-wrapper{width: 100%;                              position: relative;padding: 0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position: absolute;top: 0;left: 0;width: 100%;height: 100%;}</style>";i.parentNode.insertBefore(r,i);t&&e.extend(n,t);return this.each(function(){var t=["iframe[src*='player.vimeo.com']","iframe[src*='www.youtube.com']","iframe[src*='www.kickstarter.com']","object","embed"];n.customSelector&&t.push(n.customSelector);var r=e(this).find(t.join(","));r.each(function(){var t=e(this);if(this.tagName.toLowerCase()=="embed"&&t.parent("object").length||t.parent(".fluid-width-video-wrapper").length)return;var n=this.tagName.toLowerCase()=="object"||t.attr("height")?t.attr("height"):t.height(),r=t.attr("width")?t.attr("width"):t.width(),i=n/r;if(!t.attr("id")){var s="fitvid"+Math.floor(Math.random()*999999);t.attr("id",s)}t.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top",i*100+"%");t.removeAttr("height").removeAttr("width")})})}})(jQuery);

/* Expanding Textareas - https://github.com/bgrins/ExpandingTextareas */
;(function(e){typeof define=="function"&&define.amd?define(["jquery"],e):e(jQuery)})(function(e){function s(){e(this).closest(".expandingText").find("div").text(this.value+" ");e(this).trigger("resize.expanding")}e.expandingTextarea=e.extend({autoInitialize:!0,initialSelector:"textarea.expanding",opts:{resize:function(){}}},e.expandingTextarea||{});var t=["lineHeight","textDecoration","letterSpacing","fontSize","fontFamily","fontStyle","fontWeight","textTransform","textAlign","direction","wordSpacing","fontSizeAdjust","wordWrap","word-break","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth","paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","boxSizing","webkitBoxSizing","mozBoxSizing","msBoxSizing"],n={position:"absolute",height:"100%",resize:"none"},r={visibility:"hidden",border:"0 solid",whiteSpace:"pre-wrap"},i={position:"relative"};e.fn.expandingTextarea=function(o){var u=e.extend({},e.expandingTextarea.opts,o);if(o==="resize")return this.trigger("input.expanding");if(o==="destroy"){this.filter(".expanding-init").each(function(){var t=e(this).removeClass("expanding-init"),n=t.closest(".expandingText");n.before(t).remove();t.attr("style",t.data("expanding-styles")||"").removeData("expanding-styles")});return this}this.filter("textarea").not(".expanding-init").addClass("expanding-init").each(function(){var o=e(this);o.wrap("<div class='expandingText'></div>");o.after("<pre class='textareaClone'><div></div></pre>");var a=o.parent().css(i),f=a.find("pre").css(r);o.data("expanding-styles",o.attr("style"));o.css(n);e.each(t,function(e,t){var n=o.css(t);f.css(t)!==n&&f.css(t,n)});o.bind("input.expanding propertychange.expanding keyup.expanding",s);s.apply(this);u.resize&&o.bind("resize.expanding",u.resize)});return this};e(function(){e.expandingTextarea.autoInitialize&&e(e.expandingTextarea.initialSelector).expandingTextarea()})});


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
	overlay($(".apply-trigger"), "/../../assets/ajax/apply.php");
	overlay($(".hire-trigger"), "/../../assets/ajax/hire.php");
	overlay($(".post-job-trigger"), "/../../assets/ajax/post-job.php");
	overlay($(".collaborate-trigger"), "/../../assets/ajax/collaborate.php");
	overlay($(".search-trigger"), "/../../assets/ajax/search.php");
	overlay($(".dev-skills-trigger"), "/../../assets/ajax/dev-skills.php");
	overlay($(".des-skills-trigger"), "/../../assets/ajax/des-skills.php");
	overlay($(".login-trigger"), "/../../assets/ajax/sign-in.php");

});
