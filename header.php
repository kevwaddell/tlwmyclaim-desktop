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
			<div class="pg-tool-bar">
				<div class="container">
					<div class="row">
						<div class="col-xs-6">
							<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('User actions') ) : ?><?php endif; ?>	
						</div>
						<div class="col-xs-6">
								
						</div>
					</div>
				</div>
			</div>
		</header>
