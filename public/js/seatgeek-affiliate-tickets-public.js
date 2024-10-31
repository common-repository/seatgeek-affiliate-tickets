jQuery( document ).ready( function ($) {
	'use strict';
	$('.sg_events #sg_load_more').click(function(e){
		e.preventDefault();
		var count = $('.sg_events li').length;
		var performer_id = $('.sg_events').attr('performer_id');
		var total = $('.sg_events').attr('total_ev');
		if((count + 10) >= total){
			var last_one = true;
		}

		$('.sg_events #sg_load_more img').show();
		if(count != ''){
			$.ajax({
				type: "GET",
				url: sg_object.ajax_url,
				data: { action: 'sg_load_more_events', count: count,performer_id:performer_id},
				success: function(response){
					$('.sg_events #sg_load_more img').hide();
					$('.sg_events ul').append(response);
					if(last_one === true){
						$('.sg_events #sg_load_more').hide();
					}
				},
			});
		}

	});

});