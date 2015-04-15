jQuery(function() {
		jQuery( "#accordion" ).accordion({
			collapsible: true,
			active: false
		});
});

jQuery('h3').on( 'click', function(){
	jQuery( 'h3' ).css({ 'background-color' : '#1ec888'  });
	jQuery( this ).css({ 'background-color' : '#1ec808'  });
})

function mode(mode){
	var short = jQuery('#shortcode').val('[sepideman_ad mode="' + mode + '"]');
}

function basic(size){
	jQuery( '#shortcode' ).val('[sepideman_ad mode="basic" size="' + size + '"]');
}

function static(size, pos){
	jQuery( '#shortcode' ).val('[sepideman_ad mode="static" size="' + size + '" pos="' + pos + '"]');
}