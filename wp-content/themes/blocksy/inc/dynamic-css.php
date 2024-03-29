<?php
/**
 * Dynamic CSS helpers
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

class Blocksy_Dynamic_Css {
	private $has_enqueued_backend_styles = false;

	public function __construct() {
		add_action('customize_save_after', function () {
			do_action('blocksy:dynamic-css:refresh-caches');
		});

		add_action('blocksy:dynamic-css:refresh-caches', function () {
			$this->maybe_set_global_styles_descriptor();
		});

		add_filter(
			'customize_render_partials_response',
			function ($response, $obj, $partials) {
				$css_output = blocksy_get_all_dynamic_styles_for([
					'context' => 'inline'
				]);

				$css = $css_output['css'];
				$tablet_css = $css_output['tablet_css'];
				$mobile_css = $css_output['mobile_css'];

				blocksy_theme_get_dynamic_styles([
					'name' => 'global-inline',
					'css' => $css,
					'mobile_css' => $mobile_css,
					'tablet_css' => $tablet_css,
					'context' => 'inline',
					'chunk' => 'inline',
					'forced_call' => true
				]);

				$response['ct_dynamic_css'] = [
					'desktop' => $css->build_css_structure(),
					'tablet' => $tablet_css->build_css_structure(),
					'mobile' => $mobile_css->build_css_structure()
				];

				return $response;
			},
			10, 3
		);

		add_action('wp_print_scripts', function () {
			if (! is_admin()) {
				return;
			}

			if ($this->has_enqueued_backend_styles) {
				return;
			}

			$this->has_enqueued_backend_styles = true;
			$this->load_backend_dynamic_css();
		});
	}

	public function load_frontend_css($args = []) {
		$args = wp_parse_args($args, [
			'descriptor' => null
		]);

		if (! $args['descriptor']) {
			return;
		}

		$descriptor = $args['descriptor'];

		$no_script_url = get_template_directory_uri() . '/static/bundle/no-scripts.css';
		echo "<noscript><link rel='stylesheet' href='" . $no_script_url . "' type='text/css' /></noscript>\n";

		if (! empty($descriptor['styles']['desktop'])) {
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * The variable used here has the value escaped properly.
			 */
			echo '<style id="ct-main-styles-inline-css">';
			echo $descriptor['styles']['desktop'];
			echo "</style>\n";
		}

		if (! empty(trim($descriptor['styles']['tablet']))) {
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * The variable used here has the value escaped properly.
			 */
			echo '<style id="ct-main-styles-tablet-inline-css" media="(max-width: 999.98px)">';
			echo $descriptor['styles']['tablet'];
			echo "</style>\n";
		}

		if (! empty(trim($descriptor['styles']['mobile']))) {
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * The variable used here has the value escaped properly.
			 */
			echo '<style id="ct-main-styles-mobile-inline-css" media="(max-width: 689.98px)">';
			echo $descriptor['styles']['mobile'];
			echo "</style>\n";
		}
	}

	public function get_dynamic_styles_descriptor() {
		$google_fonts = [];

		$styles = [
			'desktop' => '',
			'tablet' => '',
			'mobile' => ''
		];

		// Global Styles
		$global_styles_descriptor = $this->maybe_get_global_styles_descriptor();

		if ($global_styles_descriptor['styles']) {
			$styles['desktop'] .= $global_styles_descriptor['styles']['desktop'];
			$styles['tablet'] .= $global_styles_descriptor['styles']['tablet'];
			$styles['mobile'] .= $global_styles_descriptor['styles']['mobile'];
		}

		$google_fonts = $global_styles_descriptor['google_fonts'];

		// Inline styles
		$css = new Blocksy_Css_Injector();
		$tablet_css = new Blocksy_Css_Injector();
		$mobile_css = new Blocksy_Css_Injector();

		blocksy_theme_get_dynamic_styles([
			'name' => 'global-inline',
			'css' => $css,
			'mobile_css' => $mobile_css,
			'tablet_css' => $tablet_css,
			'context' => 'inline',
			'chunk' => 'inline',
			'forced_call' => true
		]);

		$styles['desktop'] .= $css->build_css_structure();
		$styles['tablet'] .= $tablet_css->build_css_structure();
		$styles['mobile'] .= $mobile_css->build_css_structure();

		// Metabox
		if (is_singular()) {
			$single_styles_descriptor = $this->maybe_get_single_post_styles_descriptor();

			$styles['desktop'] .= $single_styles_descriptor['styles']['desktop'];
			$styles['tablet'] .= $single_styles_descriptor['styles']['tablet'];
			$styles['mobile'] .= $single_styles_descriptor['styles']['mobile'];

			foreach ($single_styles_descriptor['google_fonts'] as $single_gf => $v) {
				foreach ($v as $variation) {
					if (! isset($google_fonts[$single_gf])) {
						$google_fonts[$single_gf] = [$variation];
					} else {
						$google_fonts[$single_gf][] = $variation;
					}

					$google_fonts[$single_gf] = array_unique(
						$google_fonts[$single_gf]
					);
				}
			}
		}

		return [
			'google_fonts' => $google_fonts,
			'styles' => $styles
		];
	}

	public function maybe_get_single_post_styles_descriptor() {
		$post_atts = blocksy_get_post_options();
		$post_id = get_the_ID();

		$styles_descriptor = blocksy_akg('styles_descriptor', $post_atts, null);

		if (! $styles_descriptor) {
			$styles_descriptor = $this->maybe_set_single_post_styles_descriptor([
				'post_id' => $post_id,
				'atts' => $post_atts
			]);

			$post_atts['styles_descriptor'] = $styles_descriptor;

			update_post_meta(
				$post_id,
				'blocksy_post_meta_options',
				$post_atts
			);
		}

		return $styles_descriptor;
	}

	public function maybe_set_single_post_styles_descriptor($args = []) {
		$args = wp_parse_args($args, [
			'post_id' => null,
			'atts' => []
		]);

		$descriptor = [
			'styles' => [
				'desktop' => '',
				'tablet' => '',
				'mobile' => ''
			],
			'google_fonts' => []
		];

		$m = new Blocksy_Fonts_Manager();

		$css = new Blocksy_Css_Injector([
			'fonts_manager' => $m
		]);
		$tablet_css = new Blocksy_Css_Injector([
			'fonts_manager' => $m
		]);
		$mobile_css = new Blocksy_Css_Injector([
			'fonts_manager' => $m
		]);

		blocksy_theme_get_dynamic_styles([
			'name' => 'singular',
			'css' => $css,
			'mobile_css' => $mobile_css,
			'tablet_css' => $tablet_css,
			'context' => 'inline',
			'chunk' => 'inline',
			'forced_call' => true,
			'atts' => $args['atts'],
			'prefix' => blocksy_manager()
				->screen
				->get_admin_prefix(get_post_type($args['post_id']))
		]);

		$descriptor['styles']['desktop'] .= $css->build_css_structure();
		$descriptor['styles']['tablet'] .= $tablet_css->build_css_structure();
		$descriptor['styles']['mobile'] .= $mobile_css->build_css_structure();

		$descriptor['google_fonts'] = $m->get_matching_google_fonts();

		return $descriptor;
	}

	public function maybe_get_global_styles_descriptor() {
		$global_styles_descriptor = get_transient(
			'blocksy_dynamic_styles_descriptor'
		);

		$has_files = blocksy_has_css_in_files();

		$doing_debug = false;

		if ($doing_debug) {
			return $this->maybe_set_global_styles_descriptor();
		}

		if ($global_styles_descriptor !== false) {
			if ($has_files) {
				$global_styles_descriptor['styles'] = null;
				return $global_styles_descriptor;
			}

			if (
				! $has_files
				&&
				$global_styles_descriptor['styles']
			) {
				return $global_styles_descriptor;
			}
		}

		return $this->maybe_set_global_styles_descriptor();
	}

	public function maybe_set_global_styles_descriptor() {
		$global_styles_descriptor = [
			'google_fonts' => [],
			'styles' => null
		];

		$m = new Blocksy_Fonts_Manager();

		$inline_styles = blocksy_get_all_dynamic_styles_for([
			'context' => 'global',
			'fonts_manager' => $m
		]);

		if (! blocksy_has_css_in_files()) {
			$global_styles_descriptor['styles'] = [
				'desktop' => '',
				'tablet' => '',
				'mobile' => ''
			];

			$global_styles_descriptor['styles']['desktop'] .= trim(
				$inline_styles['css']->build_css_structure()
			);
			$global_styles_descriptor['styles']['tablet'] .= trim(
				$inline_styles['tablet_css']->build_css_structure()
			);
			$global_styles_descriptor['styles']['mobile'] .= trim(
				$inline_styles['mobile_css']->build_css_structure()
			);
		}

		$global_styles_descriptor['google_fonts'] = $m->get_matching_google_fonts();

		set_transient(
			'blocksy_dynamic_styles_descriptor',
			$global_styles_descriptor,
			12 * MONTH_IN_SECONDS
		);

		return $global_styles_descriptor;
	}


	public function load_backend_dynamic_css() {
		$css = new Blocksy_Css_Injector();
		$tablet_css = new Blocksy_Css_Injector([
			'selector_prefix' => '.ct-tablet-view'
		]);
		$mobile_css = new Blocksy_Css_Injector([
			'selector_prefix' => '.ct-mobile-view'
		]);

		do_action(
			'blocksy:admin-dynamic-css:enqueue',
			[
				'context' => 'inline',
				'css' => $css,
				'tablet_css' => $tablet_css,
				'mobile_css' => $mobile_css
			]
		);

		blocksy_theme_get_dynamic_styles([
			'name' => 'admin-global',
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'context' => 'inline',
			'chunk' => 'admin'
		]);

		$all_global_css = trim($css->build_css_structure());
		$all_tablet_css = trim($tablet_css->build_css_structure());
		$all_mobile_css = trim($mobile_css->build_css_structure());

		if (! empty($all_global_css)) {
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * The variable used here has the value escaped properly.
			 */
			echo '<style id="ct-main-styles-inline-css">';
			echo $all_global_css;
			echo $all_tablet_css;
			echo $all_mobile_css;
			echo "</style>\n";
		}
	}
}

if (! function_exists('blocksy_has_css_in_files')) {
	function blocksy_has_css_in_files() {
		return apply_filters('blocksy:dynamic-css:has_files_cache', false);
	}
}

if (! function_exists('blocksy_get_all_dynamic_styles_for')) {
	function blocksy_get_all_dynamic_styles_for($args = []) {
		$args = wp_parse_args(
			$args,
			[
				'context' => null,
				'fonts_manager' => null
			]
		);

		$css = new Blocksy_Css_Injector([
			'fonts_manager' => $args['fonts_manager']
		]);
		$mobile_css = new Blocksy_Css_Injector([
			'fonts_manager' => $args['fonts_manager']
		]);
		$tablet_css = new Blocksy_Css_Injector([
			'fonts_manager' => $args['fonts_manager']
		]);

		blocksy_theme_get_dynamic_styles([
			'name' => 'global',
			'css' => $css,
			'mobile_css' => $mobile_css,
			'tablet_css' => $tablet_css,
			'context' => $args['context'],
			'chunk' => 'global',
			'forced_call' => true
		]);

		do_action(
			'blocksy:global-dynamic-css:enqueue',
			[
				'context' => $args['context'],
				'css' => $css,
				'tablet_css' => $tablet_css,
				'mobile_css' => $mobile_css
			]
		);

		return [
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css
		];
	}
}

if (! function_exists('blocksy_get_dynamic_css_file_content')) {
	function blocksy_get_dynamic_css_file_content($args = []) {
		$args = wp_parse_args(
			$args,
			[
				'context' => null,
			]
		);

		$css_output = blocksy_get_all_dynamic_styles_for([
			'context' => $args['context']
		]);

		$css = $css_output['css'];
		$tablet_css = $css_output['tablet_css'];
		$mobile_css = $css_output['mobile_css'];

		// $content = "/* Desktop CSS */";
		$content = '';
		$content .= trim($css->build_css_structure());

		// $content .= "\n\n/* Tablet CSS */\n";
		$content .= "@media (max-width: 999.98px) {";
		$content .= "  " . trim($tablet_css->build_css_structure());
		$content .= "}";

		// $content .= "\n\n/* Mobile CSS */\n";
		$content .= "@media (max-width: 689.98px) {";
		$content .= trim($mobile_css->build_css_structure());
		$content .= "}";

		return $content;
	}
}

if (! function_exists('blocksy_dynamic_styles_should_call')) {
	function blocksy_dynamic_styles_should_call($args = []) {
		$args = wp_parse_args(
			$args,
			[
				'context' => null,
				'chunk' => null,
				'forced_call' => false
			]
		);

		if (! $args['context']) {
			throw new Error('$context not provided. This is required!');
		}

		if (! $args['chunk']) {
			throw new Error('$chunk not provided. This is required!');
		}

		if (!$args['forced_call'] && blocksy_has_css_in_files()) {
			if ($args['context'] === 'inline') {
				if ($args['chunk'] === 'global' || $args['chunk'] === 'woocommerce') {
					return false;
				}
			}

			if ($args['context'] === 'files:global') {
				if ($args['chunk'] === 'woocommerce') {
					if (! class_exists('WooCommerce')) {
						return false;
					}
				} else {
					if ($args['chunk'] !== 'global') {
						return false;
					}
				}
			}
		}

		return true;
	}
}

/**
 * Evaluate a file with dynamic styles.
 *
 * @param string $name Name of dynamic CSS file.
 * @param array $variables list of data to pass in file.
 * @throws Error When $css not provided.
 */
if (! function_exists('blocksy_theme_get_dynamic_styles')) {
	function blocksy_theme_get_dynamic_styles($args = []) {
		$args = wp_parse_args(
			$args,
			[
				'path' => null,
				'name' => '',
				'css' => null,

				'context' => null,
				'chunk' => null,
				'forced_call' => false,
				'prefixes' => null
			]
		);

		if (! isset($args['css'])) {
			throw new Error('$css instance not provided. This is required!');
		}

		if (! blocksy_dynamic_styles_should_call($args)) {
			return;
		}

		if (! $args['path']) {
			$args['path'] = get_template_directory() . '/inc/dynamic-styles/' . $args['name'] . '.php';
		}

		if (! $args['prefixes']) {
			blocksy_get_variables_from_file($args['path'], [], $args);
		} else {
			foreach ($args['prefixes'] as $prefix) {
				blocksy_get_variables_from_file(
					$args['path'],
					[],
					array_merge($args, [
						'prefix' => $prefix
					])
				);
			}
		}
	}
}

