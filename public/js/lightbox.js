$(document).ready(function(){
	var $createOverlay = function(){
		$('<div class="lightbox-overlay"></div>').appendTo($("body"));
		var $lightboxOverlayHeight = $(document).height();
		$(".lightbox-overlay").css("height", $lightboxOverlayHeight);
	};

	var $showImage = function($imagePath){
		var $image = '<div class="lightbox-image-container"><img src="'+ $imagePath +'"/></div>'; 
		$($image).hide().appendTo($("body")).fadeIn(700,"swing");
	}; 

	var $closePopUp = function(){
		var $closeButton = '<button class="close-button">Close</button>';
		$($closeButton).appendTo(".lightbox-image-container");
	};

	$("a[rel=lightbox]").click(function(e){
		var $imagePath = $(this).attr("href");
		$createOverlay();	
		$showImage($imagePath);
		$closePopUp();
		e.preventDefault();
	});

	$(document).on("click", ".close-button", function(){
		$(".lightbox-overlay, .lightbox-image-container").fadeOut(600, function() {
			$(this).remove();	
		});
		
	});
});
