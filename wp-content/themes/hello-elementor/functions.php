<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '3.4.4' );
define( 'EHP_THEME_SLUG', 'hello-elementor' );

define( 'HELLO_THEME_PATH', get_template_directory() );
define( 'HELLO_THEME_URL', get_template_directory_uri() );
define( 'HELLO_THEME_ASSETS_PATH', HELLO_THEME_PATH . '/assets/' );
define( 'HELLO_THEME_ASSETS_URL', HELLO_THEME_URL . '/assets/' );
define( 'HELLO_THEME_SCRIPTS_PATH', HELLO_THEME_ASSETS_PATH . 'js/' );
define( 'HELLO_THEME_SCRIPTS_URL', HELLO_THEME_ASSETS_URL . 'js/' );
define( 'HELLO_THEME_STYLE_PATH', HELLO_THEME_ASSETS_PATH . 'css/' );
define( 'HELLO_THEME_STYLE_URL', HELLO_THEME_ASSETS_URL . 'css/' );
define( 'HELLO_THEME_IMAGES_PATH', HELLO_THEME_ASSETS_PATH . 'images/' );
define( 'HELLO_THEME_IMAGES_URL', HELLO_THEME_ASSETS_URL . 'images/' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		if ( apply_filters( 'hello_elementor_register_menus', true ) ) {
			register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'hello-elementor' ) ] );
		}

		if ( apply_filters( 'hello_elementor_post_type_support', true ) ) {
			add_post_type_support( 'page', 'excerpt' );
		}

		if ( apply_filters( 'hello_elementor_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
					'navigation-widgets',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);
			add_theme_support( 'align-wide' );
			add_theme_support( 'responsive-embeds' );

			/*
			 * Editor Styles
			 */
			add_theme_support( 'editor-styles' );
			add_editor_style( 'editor-styles.css' );

			/*
			 * WooCommerce.
			 */
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', true ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_display_header_footer' ) ) {
	/**
	 * Check whether to display header footer.
	 *
	 * @return bool
	 */
	function hello_elementor_display_header_footer() {
		$hello_elementor_header_footer = true;

		return apply_filters( 'hello_elementor_header_footer', $hello_elementor_header_footer );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		if ( apply_filters( 'hello_elementor_enqueue_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor',
				HELLO_THEME_STYLE_URL . 'reset.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				HELLO_THEME_STYLE_URL . 'theme.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( hello_elementor_display_header_footer() ) {
			wp_enqueue_style(
				'hello-elementor-header-footer',
				HELLO_THEME_STYLE_URL . 'header-footer.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hello_elementor_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( ! function_exists( 'hello_elementor_add_description_meta_tag' ) ) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag() {
		if ( ! apply_filters( 'hello_elementor_description_meta_tag', true ) ) {
			return;
		}

		if ( ! is_singular() ) {
			return;
		}

		$post = get_queried_object();
		if ( empty( $post->post_excerpt ) ) {
			return;
		}

		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );

// Settings page
require get_template_directory() . '/includes/settings-functions.php';

// Header & footer styling option, inside Elementor
require get_template_directory() . '/includes/elementor-functions.php';

if ( ! function_exists( 'hello_elementor_customizer' ) ) {
	// Customizer controls
	function hello_elementor_customizer() {
		if ( ! is_customize_preview() ) {
			return;
		}

		if ( ! hello_elementor_display_header_footer() ) {
			return;
		}

		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_elementor_customizer' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check whether to display the page title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		wp_body_open();
	}
}

require HELLO_THEME_PATH . '/theme.php';

HelloTheme\Theme::instance();


// --------------------------- Post search ---------------------------------------------

add_action('wp_ajax_custom_search_posts', 'custom_search_posts');
add_action('wp_ajax_nopriv_custom_search_posts', 'custom_search_posts');

function custom_search_posts() {
    $query = isset($_GET['query']) ? sanitize_text_field($_GET['query']) : '';
    $paged = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $args = [
        'post_type' => 'post',
        's' => $query,
        'posts_per_page' => isset($_GET['per_page']) ? intval($_GET['per_page']) : 9,
        'paged' => $paged,
    ];

    $loop = new WP_Query($args);

	echo '<div class="search-results-count">' . intval( $loop->found_posts ) . ' results</div>';
	
    echo '<div class="ajax-posts">';

    if ($loop->have_posts()) {
        while ($loop->have_posts()) {
            $loop->the_post();
            ?>
			<?php
				$categories = get_the_category();
				$category_classes = array();

				if ( ! empty( $categories ) ) {
					foreach ( $categories as $category ) {
						$category_classes[] = 'category-' . sanitize_html_class( $category->slug );
					}
				}

				$category_classes_string = implode(' ', $category_classes);
			?>
			<div class="elementor elementor-3403 e-loop-item post type-post status-publish format-standard has-post-thumbnail hentry <?php echo esc_attr( $category_classes_string ); ?>" data-elementor-type="loop-item" data-elementor-post-type="elementor_library" data-custom-edit-handle="1">
<!-- 			<div data-elementor-type="loop-item" data-elementor-id="3403" class="elementor elementor-3403 e-loop-item e-loop-item-3363 post-3363 post type-post status-publish format-standard has-post-thumbnail hentry category-aerial-surveying" data-elementor-post-type="elementor_library" data-custom-edit-handle="1"> -->
				<a class="elementor-element elementor-element-9d575f8 blog-container e-flex e-con-boxed e-con e-parent e-lazyloaded" data-id="9d575f8" data-element_type="container" href="<?php the_permalink(); ?>">
					<div class="e-con-inner">
						<div class="elementor-element elementor-element-0c5ff52 e-con-full e-flex e-con e-child" data-id="0c5ff52" data-element_type="container">
							<div class="elementor-element elementor-element-63d6302 elementor-widget elementor-widget-theme-post-featured-image elementor-widget-image" data-id="63d6302" data-element_type="widget" data-widget_type="theme-post-featured-image.default">
								<div class="elementor-widget-container">
									<?php echo get_the_post_thumbnail(get_the_ID(), 'medium_large', [
										  'loading' => 'lazy',
										  'decoding' => 'async',
										  'class' => 'attachment-medium_large size-medium_large wp-image-3364',
										  'alt' => get_the_title()
										]); 
									?>														
								</div>
							</div>
							<div class="elementor-element elementor-element-897cde9 e-con-full e-flex e-con e-child" data-id="897cde9" data-element_type="container">
								<div class="elementor-element elementor-element-ecc071b post-category elementor-widget elementor-widget-post-info" data-id="ecc071b" data-element_type="widget" data-widget_type="post-info.default">
									<div class="elementor-widget-container">
										<ul class="elementor-inline-items elementor-icon-list-items elementor-post-info">
											<li class="elementor-icon-list-item elementor-repeater-item-fc1a46a elementor-inline-item" itemprop="about">
												<span class="elementor-icon-list-text elementor-post-info__item elementor-post-info__item--type-terms">
													<span class="elementor-post-info__terms-list">
														<?php
															$categories = get_the_category();
															if ( ! empty( $categories ) ) {
																echo '<span class="elementor-post-info__terms-list-item">' . esc_html( $categories[0]->name ) . '</span>';
															}
														?>
													</span>
												</span>
											</li>
										</ul>
									</div>
								</div>
								<div class="elementor-element elementor-element-27850a6 elementor-widget elementor-widget-heading" data-id="27850a6" data-element_type="widget" data-widget_type="heading.default">
									<div class="elementor-widget-container">
										<span class="elementor-heading-title elementor-size-default"><?php the_field('time_for_read'); ?></span>				
									</div>
								</div>
							</div>
							<div class="elementor-element elementor-element-1275f67 elementor-widget elementor-widget-theme-post-title elementor-page-title elementor-widget-heading" data-id="1275f67" data-element_type="widget" data-widget_type="theme-post-title.default">
								<div class="elementor-widget-container">
									<h3 class="elementor-heading-title elementor-size-default"><?php the_title(); ?></h3>				
								</div>
							</div>
							<div class="elementor-element elementor-element-5374dae elementor-widget elementor-widget-theme-post-excerpt" data-id="5374dae" data-element_type="widget" data-widget_type="theme-post-excerpt.default">
								<div class="elementor-widget-container">
									<?php the_excerpt(); ?>
								</div>
							</div>
						</div>
						<div class="elementor-element elementor-element-9defe2e e-con-full e-flex e-con e-child" data-id="9defe2e" data-element_type="container">
							<div class="elementor-element elementor-element-34d2cb0 elementor-widget elementor-widget-image" data-id="34d2cb0" data-element_type="widget" data-widget_type="image.default">
								<div class="elementor-widget-container">
									<img decoding="async" src="<?php the_field('author_photo'); ?>" title="" alt="" loading="lazy">															
								</div>
							</div>
							<div class="elementor-element elementor-element-546dc56 elementor-widget elementor-widget-heading" data-id="546dc56" data-element_type="widget" data-widget_type="heading.default">
								<div class="elementor-widget-container">
									<span class="elementor-heading-title elementor-size-default"><?php the_field('author_name'); ?></span>				
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
            <?php
        }
        wp_reset_postdata();
    } else {
        echo '<p>No results found.</p>';
    }

    echo '</div>'; // .ajax-posts

    // Пагинация
    $total_pages = $loop->max_num_pages;
	
	echo '<div id="ajax-pagination">';
		if ($total_pages > 1) {

			// Prev button — всегда видим, с not-active при первой странице
			$prev_class = ($paged <= 1) ? 'not-active' : '';
			echo '<a href="#" class="ajax-page-link prev ' . $prev_class . '" data-page="' . max(1, $paged - 1) . '">Prev</a> ';

			// Показываем первые 4 страницы
			for ($i = 1; $i <= min(4, $total_pages); $i++) {
				$active = ($i === $paged) ? 'current' : '';
				echo '<a href="#" class="ajax-page-link ' . $active . '" data-page="' . $i . '">' . $i . '</a> ';
			}

			// Если страниц больше 5 — вставляем ...
			if ($total_pages > 5) {
				echo '<span class="dots">…</span> ';
				$last_class = ($paged === $total_pages) ? 'current' : '';
				echo '<a href="#" class="ajax-page-link ' . $last_class . '" data-page="' . $total_pages . '">' . $total_pages . '</a> ';
			}

			// Next button — всегда видим, с not-active при последней странице
			$next_class = ($paged >= $total_pages) ? 'not-active' : '';
			echo '<a href="#" class="ajax-page-link next ' . $next_class . '" data-page="' . min($total_pages, $paged + 1) . '">Next</a>';
		}
	echo '</div>';

    wp_die();
}


// --------------------------- Post search ---------------------------------------------

add_action('wp_ajax_custom_search_positions', 'custom_search_positions');
add_action('wp_ajax_nopriv_custom_search_positions', 'custom_search_positions');

function custom_search_positions() {
    $query = isset($_GET['query']) ? sanitize_text_field($_GET['query']) : '';
    $paged = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $location = isset($_GET['location']) ? sanitize_text_field($_GET['location']) : '';
    $format = isset($_GET['format']) ? sanitize_text_field($_GET['format']) : '';
    $department = isset($_GET['department']) ? sanitize_text_field($_GET['department']) : '';

    $meta_query = ['relation' => 'AND'];

    if ($location !== '') {
        $meta_query[] = [
            'key' => 'location',
            'value' => $location,
            'compare' => '='
        ];
    }

    if ($format !== '') {
        $meta_query[] = [
            'key' => 'format',
            'value' => $format,
            'compare' => '='
        ];
    }

    if ($department !== '') {
        $meta_query[] = [
            'key' => 'department',
            'value' => $department,
            'compare' => '='
        ];
    }

    $args = [
        'post_type' => 'position',
        's' => $query,
        'posts_per_page' => 5,
        'paged' => $paged,
        'meta_query' => $meta_query,
    ];

    $loop = new WP_Query($args);

    echo '<div class="search-results-count">' . intval($loop->found_posts) . ' results</div>';
    echo '<div class="ajax-posts">';

    if ($loop->have_posts()) {
        while ($loop->have_posts()) {
            $loop->the_post();
            ?>
            <a href="<?php the_permalink(); ?>" class="position-card">
                <div class="position-title"><h4><?php the_title(); ?></h4></div>
                <div class="position-location"><p><?php the_field('location'); ?></p></div>
                <div class="position-format"><p><?php the_field('format'); ?></p></div>
                <div class="position-department"><p><?php the_field('department'); ?></p></div>
                <div class="position-link">
                    <img src="https://hosting221733.a151e.netcup.net/wp-content/uploads/2025/06/button.png">
                </div>
            </a>
            <?php
        }
        wp_reset_postdata();
    } else {
        echo '<div class="no-result-container"><p class="no-search-result">No results found.</p><div>';
    }

    echo '</div>';

    // Pagination
    $total_pages = $loop->max_num_pages;
    echo '<div id="ajax-pagination">';
    if ($total_pages > 1) {
        $prev_class = ($paged <= 1) ? 'not-active' : '';
        echo '<a href="#" class="ajax-page-link prev ' . $prev_class . '" data-page="' . max(1, $paged - 1) . '">Prev</a>';

        for ($i = 1; $i <= min(3, $total_pages); $i++) {
            $active = ($i === $paged) ? 'current' : '';
            echo '<a href="#" class="ajax-page-link ' . $active . '" data-page="' . $i . '">' . $i . '</a> ';
        }

        if ($total_pages > 4) {
            echo '<span class="dots">…</span>';
            $last_class = ($paged === $total_pages) ? 'current' : '';
            echo '<a href="#" class="ajax-page-link ' . $last_class . '" data-page="' . $total_pages . '">' . $total_pages . '</a> ';
        }

        $next_class = ($paged >= $total_pages) ? 'not-active' : '';
        echo '<a href="#" class="ajax-page-link next ' . $next_class . '" data-page="' . min($total_pages, $paged + 1) . '">Next</a>';
    }
    echo '</div>';

    wp_die();
}



// Shortcode filters

function render_position_filters_shortcode() {
    $position_query = new WP_Query([
    'post_type' => 'position',
    'posts_per_page' => 1,
]);

$post_id = $position_query->have_posts() ? $position_query->posts[0]->ID : null;

$location_choices   = get_field_object('location', $post_id);
$format_choices     = get_field_object('format', $post_id);
$department_choices = get_field_object('department', $post_id);

    ob_start();
    ?>
    <div class="position-filters">
		<div class="head-filters">
			<h3>
				Filters
			</h3>
			<button class="close-filters">
				<img src="https://hosting221733.a151e.netcup.net/wp-content/uploads/2025/06/Close-Icon.png" >
			</button>
		</div>
        <?php if ($location_choices && !empty($location_choices['choices'])): ?>
            <div class="filterbox-location">
                <label for="filter-location">Location</label>
                <select id="filter-location" name="location">
                    <option value="">Choose</option>
                    <?php foreach ($location_choices['choices'] as $value => $label): ?>
                        <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <?php if ($format_choices && !empty($format_choices['choices'])): ?>
            <div class="filterbox-format">
                <label for="filter-format">Format</label>
                <select id="filter-format" name="format">
                    <option value="">Choose</option>
                    <?php foreach ($format_choices['choices'] as $value => $label): ?>
                        <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <?php if ($department_choices && !empty($department_choices['choices'])): ?>
            <div class="filterbox-department">
                <label for="filter-department">Department</label>
                <select id="filter-department" name="department">
                    <option value="">Choose</option>
                    <?php foreach ($department_choices['choices'] as $value => $label): ?>
                        <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <div class="clear-box">
            <button type="button" id="reset-filters">Reset</button>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('position_filters', 'render_position_filters_shortcode');




