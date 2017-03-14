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
<?php
if (is_page()) {
$page = get_page($post->ID);
$page_class = $page->post_name.'-pg';		
}
if (is_single()) {
$page_class = 'case-details-pg';	
}
if (is_home()) {
$page_class = 'cases-pg';	
}	
if (is_author()) {
$page_class = 'clients-pg';	
}		
?>

<?php if ( is_user_logged_in() ) { 
$user_id = get_current_user_id();	
$user_firstname = get_user_meta( $user_id, 'first_name', true ); 
$user_lastname = get_user_meta( $user_id, 'last_name', true ); 	
$user_type = get_user_meta( $user_id, 'user_type', true); 
$user_name_tag = $user_firstname. " " .$user_lastname;
	if ($user_type == 'ref') {
	$user_name_tag =  get_user_meta( $user_id, 'company_name', true );
	}
} ?>
<body <?php body_class($page_class); ?>>

<?php if ( is_user_logged_in() ) { ?>	
<nav id="main-nav" class="nav-closed">
	<?php if (current_user_can('administrator')) { ?>
	<?php wp_nav_menu(array( 'container_class' => 'admin-links', 'theme_location' => 'admin-menu', 'fallback_cb' => false ) ); ?>
	<?php } else { ?>
		<?php if ($user_type == 'ref') { ?>
		<?php wp_nav_menu(array( 'container_class' => 'ref-links', 'theme_location' => 'referer-menu', 'fallback_cb' => false ) ); ?>	
		<?php } else { ?>
		<?php wp_nav_menu(array( 'container_class' => 'user-links', 'theme_location' => 'user-menu', 'fallback_cb' => false ) ); ?>	
		<?php } ?>
	<?php } ?>
	<button id="close-nav-btn" class="btn btn-block"><span class="sr-only">Close navigation</span><i class="fa fa-angle-right fa-lg"></i></button>
</nav>
<?php } ?>
	
<div id="page" class="site">
	
	<div id="content" class="site-content">
		
		<header id="masthead">
			<div class="container">
				<div class="row">
					<div class="col-xs-4">
						<?php if ( is_user_logged_in() ) { ?>
						<div class="user-name">
							<i class="fa fa-user-circle"></i>
							<strong><?php echo $user_name_tag; ?></strong>
						</div>	
						<?php } ?>
					</div>
					<div class="col-xs-4">
						<div class="logo">
							<a href="<?php echo get_option('home'); ?>/" class="text-hide">
								<?php bloginfo('name'); ?>
							</a>
							<span><?php bloginfo('description'); ?></span>
						</div>	
					</div>
					<div class="col-xs-4">
						<?php if ( is_user_logged_in() ) { ?>
						<div class="main-nav-btn-wrap pull-right">
							<span>Menu</span>
							<button id="nav-btn" class="btn"><i class="fa fa-bars fa-lg"></i></button>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php get_template_part( 'parts/global/col', 'strip' ); ?>
		</header>
