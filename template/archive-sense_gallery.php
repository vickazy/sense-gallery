<?php

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->
			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php twentyfifteen_post_thumbnail(); ?>
				<header class="entry-header">
					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				</header>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
			// End the loop.					
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', '_sense' ),
				'next_text'          => __( 'Next page', '_sense' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', '_sense' ) . ' </span>',
			) );

			// If no content, include the "No posts found" template.
		else :
			echo apply_filters( 'sense_no_photo_message', __( 'No photo albums found.', '_sense' ) );

		endif;
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_footer(); ?>
