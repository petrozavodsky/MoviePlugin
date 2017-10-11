<?php

/*
Plugin Name: Movie Plugin
Plugin URI: http://alkoweb.ru
Author: Petrozavodsky
Author URI: http://alkoweb.ru
*/

require_once( "includes/Autoloader.php" );


use MoviePlugin\Autoloader;

new Autoloader( __FILE__, 'MoviePlugin' );


use MoviePlugin\Base\Wrap;
use MoviePlugin\Classes\AddPostType;
use MoviePlugin\Classes\InstallDemo;
use MoviePlugin\Classes\TaxonomyWrap;
use MoviePlugin\Classes\MetaBox;
use MoviePlugin\Classes\TemplateRouter;

class MoviePlugin extends Wrap {
	public $version = '1.1.1';
	public static $textdomine;
	public static $post_type = 'movie';

	public function __construct() {
		self::$textdomine = $this->setTextdomain();

		new AddPostType(
			self::$post_type,
			[
				'name'               => __( 'Movies', self::$textdomine ),
				'singular_name'      => __( 'Movie', self::$textdomine ),
				'add_new'            => __( 'Add new', self::$textdomine ),
				'add_new_item'       => __( 'Add new Movie', self::$textdomine ),
				'edit_item'          => __( 'Edit Movie', self::$textdomine ),
				'new_item'           => __( 'New Movie', self::$textdomine ),
				'view_item'          => __( 'View Movie', self::$textdomine ),
				'search_items'       => __( 'Search Movie', self::$textdomine ),
				'not_found'          => __( 'Movie no found', self::$textdomine ),
				'not_found_in_trash' => __( 'No movies found in trash', self::$textdomine ),
				'menu_name'          => __( 'Movies', self::$textdomine )
			],
			'dashicons-video-alt'
		);
		add_action( 'init', [ __CLASS__, 'add_taxonomy' ], 0 );

		new MetaBox(
			self::$post_type
		);

		new TemplateRouter();

		if ( get_option( 'MoviePlugin_demo_content_add', false ) ) {
			new InstallDemo();
		}
	}

	public static function add_taxonomy() {

		new TaxonomyWrap(
			"genres",
			self::$post_type,
			[
				'name'                       => __( 'Genres', self::$textdomine ),
				'singular_name'              => __( 'Genre', self::$textdomine ),
				'search_items'               => __( 'Search genres', self::$textdomine ),
				'popular_items'              => __( 'Popular genres', self::$textdomine ),
				'all_items'                  => __( 'All genres', self::$textdomine ),
				'edit_item'                  => __( 'Edit genres', self::$textdomine ),
				'update_item'                => __( 'Update genres', self::$textdomine ),
				'add_new_item'               => __( 'Add new genres', self::$textdomine ),
				'new_item_name'              => __( 'New genres name', self::$textdomine ),
				'separate_items_with_commas' => __( 'Separate genres with commas', self::$textdomine ),
				'add_or_remove_items'        => __( 'Add or remove genres', self::$textdomine ),
				'choose_from_most_used'      => __( 'Choose from the most used genres', self::$textdomine ),
				'menu_name'                  => __( 'Genres', self::$textdomine )
			] );

		new TaxonomyWrap(
			"countries",
			self::$post_type,
			[
				'name'                       => __( 'Countries', self::$textdomine ),
				'singular_name'              => __( 'Country', self::$textdomine ),
				'search_items'               => __( 'Search countries', self::$textdomine ),
				'popular_items'              => __( 'Popular countries', self::$textdomine ),
				'all_items'                  => __( 'All countries', self::$textdomine ),
				'edit_item'                  => __( 'Edit countries', self::$textdomine ),
				'update_item'                => __( 'Update countries', self::$textdomine ),
				'add_new_item'               => __( 'Add new country', self::$textdomine ),
				'new_item_name'              => __( 'New country name', self::$textdomine ),
				'separate_items_with_commas' => __( 'Separate countries with commas', self::$textdomine ),
				'add_or_remove_items'        => __( 'Add or remove countries', self::$textdomine ),
				'choose_from_most_used'      => __( 'Choose from the most used countries', self::$textdomine ),
				'menu_name'                  => __( 'Countries', self::$textdomine )
			] );

		new TaxonomyWrap(
			"years",
			self::$post_type,
			[
				'name'                       => __( 'Years', self::$textdomine ),
				'singular_name'              => __( 'Year', self::$textdomine ),
				'search_items'               => __( 'Search years', self::$textdomine ),
				'popular_items'              => __( 'Popular years', self::$textdomine ),
				'all_items'                  => __( 'All years', self::$textdomine ),
				'edit_item'                  => __( 'Edit years', self::$textdomine ),
				'update_item'                => __( 'Update years', self::$textdomine ),
				'add_new_item'               => __( 'Add new years', self::$textdomine ),
				'new_item_name'              => __( 'New years name', self::$textdomine ),
				'separate_items_with_commas' => __( 'Separate years with commas', self::$textdomine ),
				'add_or_remove_items'        => __( 'Add or remove years', self::$textdomine ),
				'choose_from_most_used'      => __( 'Choose from the most used years', self::$textdomine ),
				'menu_name'                  => __( 'Years', self::$textdomine )
			] );


		new TaxonomyWrap(
			"actors",
			self::$post_type,
			[
				'name'                       => __( 'Actors', self::$textdomine ),
				'singular_name'              => __( 'Actor', self::$textdomine ),
				'search_items'               => __( 'Search actors', self::$textdomine ),
				'popular_items'              => __( 'Popular actors', self::$textdomine ),
				'all_items'                  => __( 'All actors', self::$textdomine ),
				'edit_item'                  => __( 'Edit actors', self::$textdomine ),
				'update_item'                => __( 'Update actors', self::$textdomine ),
				'add_new_item'               => __( 'Add new actor', self::$textdomine ),
				'new_item_name'              => __( 'New actor name', self::$textdomine ),
				'separate_items_with_commas' => __( 'Separate actor with commas', self::$textdomine ),
				'add_or_remove_items'        => __( 'Add or remove actor', self::$textdomine ),
				'choose_from_most_used'      => __( 'Choose from the most used actors', self::$textdomine ),
				'menu_name'                  => __( 'Actors', self::$textdomine )
			] );
	}

}


register_activation_hook( __FILE__, function () {
	update_option( 'MoviePlugin_demo_content_add', true );
} );

register_deactivation_hook( __FILE__, function () {
	delete_option( 'MoviePlugin_demo_content_add' );
} );

function MoviePlugin__init() {
	new MoviePlugin();
}

add_action( 'plugins_loaded', 'MoviePlugin__init', 30 );
