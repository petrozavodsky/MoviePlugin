<?php

namespace MoviePlugin\Classes;


use MoviePlugin;
use MoviePlugin\Utils\Assets;

class ArchiveBanners {

	use Assets;

	public static $menu_slug = 'movies_banners';
	public static $image_size = '990x90';

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_settings_page' ] );
		add_action( 'admin_init', [ $this, 'option_settings' ] );
		$this->add_style();
		$this->add_scripts();
		$this->add_image_size();

		add_action('template_redirect',[$this,'add_front_style']);

		add_action( 'MoviePlugin__archive_list_before', [ $this, 'add_archive_list_before' ] );
		add_action( 'MoviePlugin__archive_list_after', [ $this, 'add_archive_list_after' ] );

		add_action( 'admin_enqueue_scripts', function (){
			if ( ! did_action( 'wp_enqueue_media' ) ) {
				wp_enqueue_media();
			}
		} );
	}

	public function add_front_style() {
		if ( is_post_type_archive( MoviePlugin::$post_type ) ) {
			 $this->addCss( 'Banners-helper', 'header' );
		}
	}

	private function get_banner_html( $type ) {
		$options = get_option( self::$menu_slug, false );
		if ( $options !== false && is_array( $options ) && array_key_exists( "banner_archive_list_{$type}", $options ) ) {
			$id = intval( $options["banner_archive_list_{$type}"] );
			if ( wp_attachment_is( 'image', $id ) ) {
				echo "<div class='move__banner-wrap'>";
				echo wp_get_attachment_image( $id, self::$image_size );
				echo "</div>";
			}

		}
	}

	public function add_archive_list_before() {
		$this->get_banner_html( 'before' );
	}

	public function add_archive_list_after() {
		$this->get_banner_html( 'after' );
	}


	public function add_image_size() {
		add_image_size( self::$image_size, 990, 90, [ 'center', 'center' ] );
	}

	public function add_scripts() {
		$menu_slug = self::$menu_slug;
		$this->addJs( 'movies_banners_admin', "admin_print_scripts-settings_page_{$menu_slug}", [ 'jquery' ] );
	}

	public function add_style() {
		$menu_slug = self::$menu_slug;
		$this->addCss( 'movies_banners_admin-css', "admin_print_styles-settings_page_{$menu_slug}" );
	}


	public function option_settings() {


		register_setting(
			self::$menu_slug,
			self::$menu_slug,
			[
				'sanitize_callback' => function ( $input ) {
					$valid_input = [];
					foreach ( $input as $k => $v ) {
						$valid_input[ $k ] = trim( $v );
					}

					return $valid_input;
				}
			]
		);

		add_settings_section( 'movies_banners_settings', __( 'Download banners', MoviePlugin::$textdomine ), '', self::$menu_slug );

		add_settings_field(
			'banner_archive_list_before',
			__( "Banner before archive", MoviePlugin::$textdomine ),
			[ $this, 'option_display_settings' ],
			self::$menu_slug,
			'movies_banners_settings',
			[
				'id'          => 'banner_archive_list_before',
				'description' => __( 'Download banners image', MoviePlugin::$textdomine )
			]
		);

		add_settings_field(
			'banner_archive_list_after',
			__( "Banner after archive", MoviePlugin::$textdomine ),
			[ $this, 'option_display_settings' ],
			self::$menu_slug,
			'movies_banners_settings',
			[
				'id'          => 'banner_archive_list_after',
				'description' => __( 'Download banners image', MoviePlugin::$textdomine )
			]
		);
	}

	public function option_display_settings( $args ) {
		$id          = $args['id'];
		$description = $args['description'];

		$option = get_option( self::$menu_slug );

		$option[ $id ] = esc_attr( stripslashes( $option[ $id ] ) );
		echo "<div class='banner__input-wrap'>";
		echo "<input class='banner__id' type='text' id='{$id}' name='" . self::$menu_slug . "[$id]' value='{$option[$id]}' />";
		echo "<span data-mbd='{$id}' class='banner__description'>{$description}</span>";
		echo "<div class='banner__image-wrap'>";
		$this->show_admin_image( $option[ $id ] );
		echo "</div>";
		echo "</div>";

	}

	public function show_admin_image( $id ) {
		if ( wp_attachment_is( 'image', $id ) ) {
			echo wp_get_attachment_image( $id, 'thumbnail' );
		}
	}

	public function add_settings_page() {
		add_options_page(
			__( 'Banners settings', MoviePlugin::$textdomine ),
			__( 'Movies banners', MoviePlugin::$textdomine ),
			'publish_posts',
			self::$menu_slug,
			function () {
				$url = admin_url( 'options.php' );

				$title = get_admin_page_title();
				echo "<div class='wrap'>";
				echo "<h2>{$title}</h2>";
				echo "<form method='POST' action='{$url}'>";
				settings_fields( self::$menu_slug );
				do_settings_sections( self::$menu_slug );
				submit_button();
				echo "</form>";
				echo "</div>";
			}
		);

	}

}