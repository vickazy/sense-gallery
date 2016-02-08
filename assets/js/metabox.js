(function($){
	'use strict';

	var gallery_frame;
	var album_ids = $('#sense_photo');
	var album = $('#sense-images');

	$('#sense-upload').on( 'click', function(e){
		e.preventDefault();
		var el = $(this);

		if( gallery_frame ) {
			gallery_frame.open();
			return;
		}

		gallery_frame = wp.media({
			title: sensevar.select_text,
			button: {
				text: sensevar.btn_text
			},
			multiple: true
		});

		gallery_frame.on( 'select', function(){
			var selection = gallery_frame.state().get( 'selection' );
			var img_ids = album_ids.val();

			selection.map(function( image ){
				image = image.toJSON();
				if( image.id ){
					img_ids = img_ids ? img_ids + ',' + image.id : image.id;
					var images = image.sizes && image.sizes.thumbnail ? image.sizes.thumbnail.url : image.url;

					album.append( '<li data-image_id="' + image.id + '"><img src="' + images + '"><a href="#" class="delete">x</a></li>' );
				}
			});

			album_ids.val( img_ids );
		} );

		gallery_frame.open();
	});

	album.on( 'click', 'a.delete', function(e){
		e.preventDefault();
		var img_ids = '';
		$( this ).closest( 'li' ).remove();

		album.find( 'li' ).each(function(){
			var img_id = $(this).attr( 'data-image_id' );
			img_ids = img_ids + img_id + ',';
		});
		album_ids.val( img_ids );
	});

	album.sortable({
		items: 'li',
		cursor: 'move',
		scrollSensitivity: 40,
		forcePlaceholderSize: true,
		forceHelperSize: false,
		helper: 'clone',
		opacity: 0.65,
		update: function(){
			var img_ids = '';

			album.find( 'li' ).each(function(){
				var img_id = $(this).attr( 'data-image_id' );
				img_ids = img_ids + img_id + ',';
			});
			album_ids.val( img_ids );
		}
	});
})(jQuery);