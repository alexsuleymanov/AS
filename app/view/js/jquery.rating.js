(function( $ ) {
	$.fn.rating = function(options) {		
		var options = $.extend({
			type: 'prod',
			id: 0,
            action: '/rating',
            width: 80,
			rated: false
        }, options);

		if(!options.rated){
			$(this).click(function(event){
				var offset = $(this).offset();
				var x = event.pageX - offset.left;

				var rating = x / options.width * 5;
				if(rating > 5) rating = 5;
				rating = Math.ceil(rating);

				var rating_img = this;
				var rating_rating = $(this).parent().children(".rating_rating");
				var rating_count = $(this).parent().children(".rating_count");

				$.get(options.action, {type: options.type, par: options.id, rating: rating}, function(data){
					rating_count.html(data.count);
					rating_rating.html(data.rating);

					$(rating_img).unbind("click");
					$(rating_img).unbind("mousemove");

					$(rating_img).attr("src", "/app/view/img/rating/"+Math.ceil(data.rating)+"stars.png");
				}, "json");
			});

			$(this).mousemove(function(event){
				var offset = $(this).offset();
				var x = event.pageX - offset.left;

				var rating = x / options.width * 5;
				if(rating > 5) rating = 5;
				rating = Math.ceil(rating);
			
				$(this).attr("src", "/app/view/img/rating/"+rating+"stars.png");
			});
		}
	};                                                                                         

})(jQuery);

