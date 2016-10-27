<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head id="myclaim-tlwsolicitors-co-uk" data-template-set="tlw-solicitors-myclaim-theme">
	
	<meta charset="<?php bloginfo('charset'); ?>">
	
	<meta name="viewport" content ="width=device-width,user-scalable=yes" />
	
	<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/_/img/favicon.ico">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:700' rel='stylesheet' type='text/css'>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	
<div id="page" class="site">
	
	<div id="content" class="site-content">
		
		<header id="masthead">
			<div class="container">
				<div class="row">
					<div class="col-xs-4">
						
					</div>
					<div class="col-xs-4">
						<div class="logo">
							<a href="<?php echo get_option('home'); ?>/" class="text-hide">
								<?php bloginfo('name'); ?>
							</a>
							<span><?php bloginfo('description'); ?></span>
						</div>	
					</div>
				</div>
			</div>
			<?php get_template_part( 'parts/global/col', 'strip' ); ?>
			<?php if ( is_user_logged_in() ) { 
			$user_id = get_current_user_id();	
			$user_firstname = get_user_meta( $user_id, 'first_name', true ); 
			?>
			<div class="pg-tool-bar">
				<div class="container">
					<div class="row">
						<div class="col-xs-8">
							<?php wp_nav_menu(array( 'container_class' => 'user-links', 'theme_location' => 'user-menu', 'fallback_cb' => false ) ); ?>	
						</div>
						<div class="col-xs-4">
							<div class="user-name text-right"><i class="fa fa-thumbs-up"></i> Welcome <strong><?php echo $user_firstname; ?></strong></div>	
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</header>
