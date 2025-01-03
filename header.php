<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package outside-test
 */
$get_setting = ot_theme_setting();
$site_logo =  get_template_directory_uri() . '/assets/dist/images/logo.svg' ;

if ($get_setting && is_array($get_setting) && !empty($get_setting['header_logo']) && !empty($get_setting['header_logo'])) {
	$site_logo = $get_setting['header_logo'];
}
// pr($get_setting['mobile_nav_slider']);
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header id="masthead" class="site-header">
		<div class="top-bar-area">
			<div class="container">
				<div class="row">
					<div class="content-wrap">
						<?php echo $get_setting['notice_content'];?>
						<i class="icon icon-close close-top-bar"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="logo-area">
			<div class="container">
				<div class="row">
					<div class="header-wrap">
						<div class="logo-wrap">
							<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">						
				
							<?php
							if (is_array($site_logo) && !empty($site_logo['url'])) {
							?>
							<img src="<?php echo esc_url($site_logo['url']); ?>" loading="lazy" alt="<?php echo esc_attr($site_logo['alt']); ?>">
							<?php
							} else {
								bloginfo('name');
							}
							?>
						</a>
					</div>
					<div class="menu-wrap">
						<div class="mobile-menu-btn" id="hambuger-mobile">
							<span class="toggler-icon"></span>
							<span class="toggler-icon"></span>
							<span class="toggler-icon"></span>
						</div>
						<nav id="site-navigation" class="main-navigation">
							<?php 
							ot_get_menu_layout_column_nav($get_setting['first_level_nav']);
							?>
						</nav><!-- #site-navigation -->
					</div>
				</div>
			</div>			
		</div>
	</header><!-- #masthead -->
	

