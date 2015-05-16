jQuery(function() {
		jQuery( "#accordion" ).accordion({
			collapsible: true,
			active: false
		});
});

function mode(mode){
	var short = jQuery('#shortcode').val('[sepideman_ad mode="' + mode + '"]');
}

function basic(size){
	jQuery( '#shortcode' ).val('[sepideman_ad mode="basic" size="' + size + '"]');
}

function static(size, pos){
	jQuery( '#shortcode' ).val('[sepideman_ad mode="static" size="' + size + '" pos="' + pos + '"]');
}