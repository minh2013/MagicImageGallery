(function( $ ) {
 	$.fn.lightbox = function(options) {
  		var defaults = {
	        'overlayColor'          : 	'#000000',
	  		'overlayOpacity'		: 	'0.85', // value in between 0.00 and 1.00
	  		'effect'				: 	'fade', // options: fade, slide,
	  		'easing'				: 	'swing', // options: swing, linear
	  		'duration'				: 	'700',
	    };
  		var $settings = $.extend({}, defaults, options);
  		var $createOverlay = function(){
			$('<div class="lightbox-overlay"></div>').appendTo($("body"));
			var $lightboxOverlayHeight = $(document).height();
			$(".lightbox-overlay").css({
				'height'			: 	$lightboxOverlayHeight,
				'background-color'	: 	$settings.overlayColor,
				'opacity'			: 	$settings.overlayOpacity
			});
		};

		var $showImage = function($imagePath){
			var $image = '<div class="lightbox-image-container"><img src="'+ $imagePath +'"/></div>'; 
			var $imageAppended = $($image).hide().appendTo($("body"));
			
			if ($settings.effect != 'slide'){
				$imageAppended.fadeIn($settings.duration, $settings.easing);
			}
			if ($settings.effect == 'slide'){
				$imageAppended.slideDown($settings.duration, $settings.easing);
			}
		}; 

		var $showClosePopUpButton = function(){
			var $closeButton = '<button class="close-button">Close</button>';
			$($closeButton).appendTo(".lightbox-image-container");
		};

		var $closeButton = function(){
			$(".lightbox-image-container").on("click", ".close-button", function(){
		  		var $imageContainer = $(".lightbox-overlay, .lightbox-image-container");
				if ($settings.effect != 'slide'){
					$imageContainer.fadeOut($settings.duration, $settings.easing, function() {
						$(this).remove();	
					});
				}
				if ($settings.effect == 'slide'){
					$imageContainer.slideUp($settings.duration, $settings.easing, function() {
						$(this).remove();	
					});
				}
			});
		};

  		return this.click( function(e) {        
			var $imagePath = $(this).attr("href");
			$createOverlay();	
			$showImage($imagePath);
			$showClosePopUpButton();
			$closeButton();
			e.preventDefault();
	    });		
  	};
})( jQuery );