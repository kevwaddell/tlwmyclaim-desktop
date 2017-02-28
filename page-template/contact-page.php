<?php 
/*
Template Name: Contact us page
*/
?>
<?php get_header(); ?>

	<main id="main" class="site-main" role="main">
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				
				<div class="jumbotron wht-border-bottom text-center">
					<div class="container">
						<?php the_content(); ?>	
					</div>
				</div>
				
				<article <?php post_class(); ?>>
					<div class="container">
						<?php gravity_form( 1, false, false, false, $field_values, true ); ?>
					</div>			
				</article><!-- #post-## -->
			
			
			<?php endwhile; ?>

		<?php endif; ?>
	</main><!-- .site-main -->

<?php get_footer(); ?>