<?php get_header(); ?>
	<div class="container content">
		<div class="row">
			<div class="col-sm-12">
				<?php
				if( have_posts() ) :
					echo '<ul class="gallery-archive"><li class="grid-sizer"></li><li class="gutter-sizer"></li>';
						while( have_posts() ) :
							the_post();
							echo '<li class="archive-item">';
								echo '<figure>';
									the_post_thumbnail( 'medium' );
									the_title( sprintf( '<h3 class="album-title"><a href="%s" title="%s">', esc_url( get_permalink() ), esc_attr( get_the_title() ) ), '</a></h3>' );
							echo '</li>';
						endwhile;
					echo '</ul>';
				else :
					echo apply_filters( 'sense_no_photo_message', __( 'No photo albums found.', '_sense' ) );
				endif;
				?>
			</div>
		</div>
	</div>
<?php
get_footer();