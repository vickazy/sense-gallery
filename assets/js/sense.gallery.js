(function($){
	'use_strict';

	var $grid = $('.sense-gallery').imagesLoaded( function() {

		$grid.masonry({
			itemSelector: '.gallery-item',
			columnWidth: '.grid-sizer',
			gutter: '.gutter-sizer',
			percentPosition: true,
			stamp: '.stamp'
		});
	});

	var $archive_grid = $('.gallery-archive').imagesLoaded( function() {

		$archive_grid.masonry({
			itemSelector: '.archive-item',
			columnWidth: '.grid-sizer',
			gutter: '.gutter-sizer',
			percentPosition: true,
			stamp: '.stamp'
		});
	});

})(jQuery);