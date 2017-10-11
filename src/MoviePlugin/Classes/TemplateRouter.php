<?php

namespace MoviePlugin\Classes;


use MoviePlugin;
use MoviePlugin\Utils\Assets;

class TemplateRouter {
	use Assets;

	public function __construct() {
			add_filter( 'template_include', [ $this, 'router' ] );
	}


	public function router( $template ) {
		if ( is_singular( MoviePlugin::$post_type ) ) {
			return $this->plugin_dir() . "templates/single.php";
		}

		if ( is_tax( "genres" ) || is_tax( "countries" ) || is_tax( "years" ) || is_tax( "actors" ) ) {
			return $this->plugin_dir() . "templates/archive.php";
		}

		return $template;
	}

}