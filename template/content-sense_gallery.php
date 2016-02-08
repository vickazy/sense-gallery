<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<ul class="sense-gallery">
		<li class="grid-sizer"></li>
		<li class="gutter-sizer"></li>
		<li class="stamp">
			<header class="entry-header">
				<?php
					$post_id = get_the_ID();
					the_title('<h3 class="album-title">', '</h3>');
					the_content();
				?>
				<a class="all-galleries" href="<?php echo esc_url( home_url( '/sense-galleries' ) ); ?>"><?php echo __( '&larr; View all albums', 'sense' ); ?></a>

			</header><!-- .entry-header -->
		</li>

		<li>
			<div class="entry-content">
				<?php
					/* translators: %s: Name of current post */
					if ( metadata_exists( 'post', $post_id, '_sense_photos' ) ) {
						$sense_album = get_post_meta( $post_id, '_sense_photos', true );
					} else {
						// Backwards compat
						$attachment_ids = get_posts( 'post_parent=' . $post_id . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&meta_key=_woocommerce_exclude_image&meta_value=0' );
						$attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
						$sense_album = implode( ',', $attachment_ids );
					}

					$attachments = array_filter( explode( ',', $sense_album ) );

					if ( ! empty( $attachments ) ) {
						foreach ( $attachments as $attachment_id ) {
							echo '
								<li data-image_id="' . esc_attr( $attachment_id ) . '" class="gallery-item">
									<a  data-lightbox="' . sanitize_title( get_the_title() ) . '" data-title="' . get_the_title() . '" href="' . wp_get_attachment_url( $attachment_id ) . '">' . wp_get_attachment_image( $attachment_id, 'medium' ) . '</a>
								</li>';
						}
					}
				?>
			</div><!-- .entry-content -->
		</li>
	</ul>

	<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?>

	<footer class="entry-footer">
		<?php _sense_entry_meta(); ?>
		<?php edit_post_link( __( 'Edit', '_sense' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
