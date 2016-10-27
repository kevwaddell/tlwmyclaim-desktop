<?php get_header(); ?>

	<main id="main" class="site-main" role="main">
		<div class="container">
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			
				<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>
			
			</article><!-- #post-## -->

			<?php endwhile; ?>

		<?php endif; ?>
		</div>
	</main><!-- .site-main -->

<?php get_footer(); ?>