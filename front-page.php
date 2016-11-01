<?php get_header(); ?>

	<main id="main" class="site-main" role="main">
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
					<?php if (is_user_logged_in()) { ?>
					
					<div class="welcome-banner jumbotron wht-border-bottom">
						<div class="container">
						<?php the_content(); ?>	
						</div>
					</div>
					
					<?php } else {
					$login_pg = get_page_by_path( 'login' );
					$banner_img = get_field( 'hp_banner_img', 'options' );
					$banner_intro = get_field( 'hp_banner_intro', 'options' );
					?>
					
					<div class="hp-banner jumbotron wht-border-bottom" style="background-image: url(<?php echo $banner_img; ?>)">
						<div class="container">
						<?php echo $banner_intro; ?>
						<a href="<?php echo get_permalink( $login_pg->ID ); ?>" class="btn btn-default btn-block btn-lg">Login now</a>
						</div>
					</div>

					<?php }	?>
			
				</article><!-- #post-## -->
			
			
			<?php endwhile; ?>

		<?php endif; ?>
	</main><!-- .site-main -->

<?php get_footer(); ?>