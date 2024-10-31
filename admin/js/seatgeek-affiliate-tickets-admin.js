jQuery( document ).ready( function ($) {
	'use strict';

    $('.sg_shortcodes .sg_generate').click(function(e){
        e.preventDefault();
        var performer_id = $('#sg_performer_id option:selected').val();
        var performer_name = $('#sg_performer_id option:selected').text();
        if(performer_id == ''){
            alert('Please select a performer first');
            return;
        }
        var shortcode = '<li><input type="text" disabled value="[SEATGEEK_EVENTS id='+performer_id+' name='+performer_name+']"><button class="sg_copy">Copy</button></li>';
        $('.sg_shortcodes ul').prepend(shortcode);
    });

    $(document).on("click",".sg_shortcodes .sg_copy",function(e) {
        e.preventDefault();
        var input = $(this).parent().find('input');
        console.log(input.val());
        copyToClipboard(input);
    });

    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).val()).select();
        document.execCommand("copy");
        $temp.remove();
    }

    var sg_client_id = $('.sg_client_id').val();
    $('#sg_performer_id').select2({
        placeholder: 'Select a performer',
        ajax: {
            url: 'https://api.seatgeek.com/2/performers?client_id='+sg_client_id,
            dataType: 'json',
            data: function (params) {
              var query = {
                q: params.term,
              }
              return query;
            },
            processResults: function (data) {
            	var performers = data.performers;
            	var final_array = [];
				$.each( performers, function( key, value ) {
					var per_id = value.id;
					var per_name = value.name;
				  	final_array.push({id:per_id,text:per_name});
				});
              return {
                results: final_array,
              };
            }
        }
    });

});
