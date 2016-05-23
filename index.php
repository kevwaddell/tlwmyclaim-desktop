<?php get_header(); ?>

	<main id="main" class="site-main" role="main">
		
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header><!-- .entry-header -->
			
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			
				<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>
			
			</article><!-- #post-## -->

			<?php endwhile; ?>

		<?php endif; ?>
		

	</main><!-- .site-main -->

<?php get_footer(); ?>