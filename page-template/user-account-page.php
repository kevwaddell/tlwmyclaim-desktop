<?php 
/*
Template Name: User Account Page
*/
?>

<?php get_header(); ?>

<main id="main" class="site-main" role="main">
	
	<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

			<article id="user-account-info" <?php post_class(); ?>>
				<?php the_content(); ?>			
			</article><!-- #post-## -->

			<?php endwhile; ?>

	<?php endif; ?>

</main><!-- .site-main -->

<?php get_footer(); ?>