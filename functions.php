<?php
/**
 * outside-test functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package outside-test
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function outside_test_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on outside-test, use a find and replace
		* to change 'outside-test' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'outside-test', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'outside-test' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'outside_test_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'outside_test_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function outside_test_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'outside_test_content_width', 640 );
}
add_action( 'after_setup_theme', 'outside_test_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function outside_test_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'outside-test' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'outside-test' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'outside_test_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function outside_test_scripts() {
	wp_enqueue_style('slick-slider-style', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), _S_VERSION);
    wp_enqueue_style('outside-test-main-style', get_template_directory_uri() . '/assets/dist/css/style.css', array(), _S_VERSION);

	wp_enqueue_style( 'outside-test-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'outside-test-style', 'rtl', 'replace' );

	 wp_enqueue_script('jquery');   
	wp_enqueue_script('jquery-migrate', 'https://code.jquery.com/jquery-migrate-3.0.1.min.js', array(), _S_VERSION);
    wp_enqueue_script('slick-slider-js', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array(), _S_VERSION, true);

	 wp_enqueue_script('outside-test-js', get_template_directory_uri() . '/assets/js/scripts.js', array(), _S_VERSION, true);
	wp_localize_script('outside-test-js', 'ajax_posts', array(
        'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
    ));
}
add_action( 'wp_enqueue_scripts', 'outside_test_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


/*
* Register Custom Post Type
*/
require get_template_directory() . '/inc/cpt.php';

/*
* Create Admin Page
*/
require get_template_directory() . '/inc/admin/admin.php';

/*
Gutenberg Blocks
*/
require get_template_directory() . '/inc/gutenberg-blocks.php';

add_image_size('thumb-178-252', 178, 252, false);
add_image_size('thumb-579-257', 579, 257, false);
add_image_size('thumb-195x222', 195, 222, false);

if (!function_exists('pr')) {
    function pr($data, $msg = null){
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if ($msg) {
            die($msg);
        }
    }
}

if (!function_exists('gutenberg_preview')) {
    function gutenberg_preview($gutenberg_preview){
        if ($gutenberg_preview) {
            echo '<div data="gutenberg-preview-img">' . $gutenberg_preview . '</div>';
        }
    }
}


if (!function_exists('get_block_data')) {
    function get_block_data($block){
        $return_array = array();
        $block_id = $block['id'];
        $block_class = '';
        if (!empty($block['anchor'])) {
            $block_id = $block['anchor'];
        }
        if (!empty($block['className'])) {
            $block_class = $block['className'];
        }
        $return_array['id'] = $block_id;
        $return_array['class'] = $block_class;
        return $return_array;
    }
}

if (!function_exists('ot_make_link_inner')) {
    function ot_make_link_inner($link, $class, $default, $label = null){
        $return_arr['title'] = '';
        $return_arr['url'] = '';
        $return_arr['target'] = '';
        $return_arr['html'] = '';
        if (is_array($link)) {
            if (array_key_exists('title', $link) && !empty($link['title'])) {
                $return_arr['title'] = $link['title'];
            } else {
                $return_arr['title'] = $label;
            }
            if (array_key_exists('url', $link) && !empty($link['url'])) {
                $return_arr['url'] = $link['url'];
            } else {
                $return_arr['url'] = '#';
            }
            if (array_key_exists('target', $link) && !empty($link['target'])) {
                $return_arr['target'] = 'target="' . $link['target'] . '"';
            } else {
                $return_arr['target'] = '';
            }
            $title = '';
            if( $class != 'link-round' ){

                $title = $return_arr['title'];
            }

            $return_arr['html'] = '
                <a href="' . esc_url($return_arr['url']) . '" class="' . esc_attr($class) . '" ' . esc_attr($return_arr['target']) . ' title="' . $title . '">
                ' . html_entity_decode($title) . '
            </a>
            ';
        }
        return $return_arr;
    }
}

if (!function_exists('ot_get_image')) {
    function ot_get_image($image_data, $thumb, $size, $empty = null){
        $return_img = array();
        if ($empty == null) {
            $return_img['url'] = '//via.placeholder.com/' . $size;
        }
        if ($image_data) {
            if (is_array($image_data)) {
                if ($size == 'url') {
                    $return_img['url'] = $image_data['url'];
                } else {
                    $return_img['url'] = $image_data['sizes'][$thumb];
                }
                $return_img['alt'] = $image_data['alt'];
            } elseif (is_numeric($image_data)) {
                $get_img = wp_get_attachment_image_src($image_data, $thumb);
                if (is_array($get_img) && !empty($get_img[0])) {
                    $return_img['url'] = $get_img[0];
                }
                $return_img['alt'] = get_bloginfo('name');
            } else {
                $return_img['url'] = $image_data;
                $return_img['alt'] = get_bloginfo('name');
            }
           
        }
        return $return_img;
    }
}

if (!function_exists('ot_add_custom_upload_mimes')) {
    function ot_add_custom_upload_mimes($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';

        return $mimes;
    }
    add_filter('upload_mimes', 'ot_add_custom_upload_mimes');

}

if (!function_exists('ot_svg_thumb_display')) {
    function ot_svg_thumb_display()
    {
        echo '<style>
            td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail { 
            width: 100% !important; 
            height: auto !important; 
            }
        </style>';
    }
    add_action('admin_head', 'ot_svg_thumb_display');
}

if (!function_exists('ot_theme_setting')) {
    function ot_theme_setting()
    {
        $get_setting = get_field('theme_setting', 'option');
        return $get_setting;
    }
}

if (!function_exists('ot_get_menu_layout_column_nav')) {
	function ot_get_menu_layout_column_nav($data){
		$get_setting = ot_theme_setting();
		if( $data ){
		?>
		<div class="menu-main-menu-container">
			<?php get_mobile_nav_slider($get_setting['mobile_nav_slider']); ?>	
			<ul id="primary-menu" class="menu">
				<?php 
				foreach($data as $t=>$top_item){ 
					$has_sub = '';
					$tag = '';
					if( $top_item['header_navigation_column'] ){
						$has_sub = 'has-sub-menu';
					}
					if( $top_item['menu_conditions']['hide_on_desktop'] ){
						$has_sub .= ' desktop-hide';
					}
					if( $top_item['menu_conditions']['is_new'] ){
						$tag = '<span class="item-tag">New!</span>';
					}

					// $active = '';
					// if( $t == 0 ){
					// 	$has_sub .= ' active';
					// }

				?>
					<li class="menu-item <?php echo $has_sub; ?>">
						<div class="item-wrap">
							<?php
							$link = ot_make_link_inner($top_item['first_level_nav_item'], '', '', '');
							echo $link['html'];
							echo $tag;
							?>
						</div>
						<?php
						if( $top_item['header_navigation_column'] ){
						?>
						<div class="sub-menu-wrap">
							<div class="container">		
								<div class="sub-menu-container">
									<i class="icon icon-left go-back-btn desktop-hide"></i>											
									<?php
									foreach( $top_item['header_navigation_column'] as $nav_sub=>$sub_item){
										if( $sub_item['acf_fc_layout'] == 'column_nav'){
											get_menu_layout_column_nav($sub_item);
										} elseif( $sub_item['acf_fc_layout'] == 'playbox_layout'){
											get_menu_layout_slider($sub_item);
										} elseif( $sub_item['acf_fc_layout'] == 'tab_layout'){
											get_menu_layout_tab($sub_item);
										}
									}
									?>
								</div>
						</div>
						</div>
						<?php
						}
						?>
					</li>
				<?php
				}
				?>
				</li>
			</ul>
		</div>
		<?php
		}
	}
}

if (!function_exists('get_menu_layout_column_nav')) {
	function get_menu_layout_column_nav($sub_item){
		?>
		<div class="sub-menu-item layout-column">
			<?php
			if( $sub_item['column_title'] ){
			?>
				<div class="layout-title"><?php echo $sub_item['column_title'];?></div>
			<?php
			}
			?>
			<?php
			if( $sub_item['menu_item'] ){
			?>
				<div class="layout-menu-item-wrap">
					<ul>
					<?php
					foreach( $sub_item['menu_item'] as $menu_item){
						$featured = '';
						if( $menu_item['is_featured'] ){
							$featured = 'is-featured';
						}
					?>
						<li class="sub-menu-link-item <?php echo $featured?>">
							<?php
							$link = ot_make_link_inner($menu_item['item_text'], '', '', '');
							echo $link['html'];
							?>
						</li>
					<?php
					}
					?>
					</ul>
				</div>
			<?php
			}
			?>
		</div>
		<?php
	}
}
if (!function_exists('get_menu_layout_slider')) {
	function get_menu_layout_slider($sub_item){
		?>
		<div class="sub-menu-item layout-slider">
			<?php
			if( $sub_item['column_title'] ){
			?>
				<div class="layout-title">
				<?php echo $sub_item['column_title'];?>
				<?php
				if($sub_item['link']){
				?>
					<span class="slider-link desktop-hide">
						<?php
						$link = ot_make_link_inner($sub_item['link'], '', '', '');
						echo $link['html'];
						?>
					</span>
				<?php
				}
				?>
				</div>
			<?php
			}
			?>
			<?php
			$show_item = 2;
			if( $sub_item['slide_to_show'] ){
				$show_item = $sub_item['slide_to_show'];
			}
			if( $sub_item['Choose_Playbox'] ){
			?>
				<div class="layout-slider-wrap">
					<div class="layout-slider-init" data-show="<?php echo $show_item; ?>">
						<?php
						foreach( $sub_item['Choose_Playbox'] as $play_box){
							if(get_the_post_thumbnail_url($play_box->ID, 'thumb-195x222')){
								$img_url = get_the_post_thumbnail_url($play_box->ID, 'thumb-195x222');
							} else{
								$img_url = 'https://placehold.co/195x222';
							}
						?>
							<div class="item">
								<div class="img-wrap">
                                    <img src="<?php echo $img_url; ?>" loading="lazy" alt="<?php echo $play_box->post_title; ?>">									
								</div>
								<div class="content-wrap">
									<?php
									if( get_field('playbox_tag', $play_box->ID) ){
									?>
										<div class="tag-wrap">
											<?php echo get_field('playbox_tag', $play_box->ID); ?>
										</div>
									<?php
									}
									?>
									<div class="title-wrap">
										<?php echo $play_box->post_title; ?>
									</div>
									<?php
									if( get_field('playbox_amount', $play_box->ID) ){
									?>
										<div class="price-wrap">
											<?php echo get_field('playbox_amount', $play_box->ID); ?>
										</div>
									<?php
									}
									?>
								</div>
							</div>
						<?php
						}
						?>
					</div>
				</div>
			<?php
			}
			?>
		</div>
		<?php
	}
}

if (!function_exists('get_menu_layout_tab')) {
	function get_menu_layout_tab($sub_item){
		?>
		<div class="sub-menu-item layout-tab">
			<div class="tabs">
				<input type="radio" name="tabs" id="tabone" checked="checked">
				<?php
				if( $sub_item['tab_title_1'] ){
				?>
					<label for="tabone"><?php echo $sub_item['tab_title_1'];?></label>
				<?php
				}
				?>
				<div class="tab">
					<?php get_menu_tab_content($sub_item['tab_repeater']); ?>
				</div>

				<input type="radio" name="tabs" id="tabtwo">
				<?php
				if( $sub_item['tab_title_2'] ){
				?>
					<label for="tabtwo"><?php echo $sub_item['tab_title_2'];?></label>
				<?php
				}
				?>
				<div class="tab">
					<?php get_menu_tab_content($sub_item['tab_repeater_second']); ?>
				</div>

			</div>
		</div>
		<?php
	}
}

if (!function_exists('get_menu_tab_content')) {
	function get_menu_tab_content($data){
		if( $data){
		?>
			<div class="tab-content">
				<?php
				foreach( $data as $tab_item ){
					$image = ot_get_image($tab_item['tab_image'], 'large', 'large', 'empty');	
					$link = ot_make_link_inner($tab_item['tab_text'], 'block-link', '', '');	
				?>
					<div class="tab-item">
						<?php echo $link['html']; ?>
						<div class="img-wrap">
							<img src="<?php echo esc_url($image['url']); ?>" loading="lazy" alt="<?php echo esc_url($image['alt']); ?>" />
						</div>
						<div class="item-text">
							<?php		
							echo $link['title'];
							?>
						</div>
						
					</div>
				<?php
				}
				?>
			</div>
		<?php
		}
	}
}
if (!function_exists('get_mobile_nav_slider')) {
	function get_mobile_nav_slider($data){
		?>
		<div class="menu-slider desktop-hide">
			<?php
			if( $data['nav_title'] ){
			?>
				<div class="layout-title">
				<?php echo $data['nav_title'];?>
				<?php
				if($data['shop_all_text']){
				?>
					<span class="slider-link">
						<?php
						$link = ot_make_link_inner($data['shop_all_text'], '', '', '');
						echo $link['html'];
						?>
					</span>
				<?php
				}
				?>
				</div>
			<?php
			}
			?>
			<?php
	
			if( $data['select_best_sellers'] ){
			?>
				<div class="menu-slider-wrap">
					<div class="menu-slider-init">
						<?php
						foreach( $data['select_best_sellers'] as $play_box){
							if(get_the_post_thumbnail_url($play_box->ID, 'thumb-195x222')){
								$img_url = get_the_post_thumbnail_url($play_box->ID, 'thumb-195x222');
							} else{
								$img_url = 'https://placehold.co/195x222';
							}
						?>
							<div class="item">
								<div class="img-wrap">
                                    <img src="<?php echo $img_url; ?>" loading="lazy" alt="<?php echo $play_box->post_title; ?>">									
								</div>
							</div>
						<?php
						}
						?>
					</div>
				</div>
			<?php
			}
			?>
		</div>
		<?php
	}
}