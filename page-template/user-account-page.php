<?php 
/*
Template Name: User Account Page
*/
?>

<?php get_header(); ?>

<main id="main" class="site-main" role="main">
	<div class="container">
	<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

			<article id="user-account-info" <?php post_class(); ?>>
				<?php the_content(); ?>	
				<div class="rule"></div>
				<?php echo do_shortcode( "[theme-my-login]" ) ?>			
			</article><!-- #post-## -->

			<?php endwhile; ?>

	<?php endif; ?>
	</div>
</main><!-- .site-main -->

<?php get_footer(); ?>