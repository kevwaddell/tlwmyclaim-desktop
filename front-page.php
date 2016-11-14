<?php get_header(); ?>
<?php $banner_img = get_field( 'hp_banner_img', 'options' ); ?>
	<main id="main" class="site-main" role="main">
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
					<?php if (is_user_logged_in()) { 
					$dashboard_pg = get_page_by_path( 'dashboard' );
					?>
					
					<div class="hp-banner jumbotron wht-border-bottom" style="background-image: url(<?php echo $banner_img; ?>)">
						<div class="container">
						<?php the_content(); ?>	
						<a href="<?php echo get_permalink($dashboard_pg->ID ); ?>" class="btn btn-default btn-block btn-lg">Account <?php echo get_the_title($dashboard_pg->ID); ?> <i class="fa fa-chevron-right pull-right"></i></a>
						</div>
					</div>
					
					<?php } else {
					$login_pg = get_page_by_path( 'login' );
					$banner_intro = get_field( 'hp_banner_intro', 'options' );
					?>
					
					<div class="hp-banner jumbotron wht-border-bottom" style="background-image: url(<?php echo $banner_img; ?>)">
						<div class="container">
						<?php echo $banner_intro; ?>
						<a href="<?php echo get_permalink( $login_pg->ID ); ?>" class="btn btn-default btn-block btn-lg">Login now <i class="fa fa-chevron-right pull-right"></i></a>
						</div>
					</div>

					<?php }	?>
			
				</article><!-- #post-## -->
			
			
			<?php endwhile; ?>

		<?php endif; ?>
	</main><!-- .site-main -->

<?php get_footer(); ?>