<?php

namespace MoviePlugin\Classes;

use MoviePlugin;

class AddPostType {
	private $post_type = 'movie';
	private $icon;
	private $labels;
	private $options;

	function __construct( $post_type, $labels, $icon, $options = [] ) {
		$this->post_type = $post_type;
		$this->labels    = $labels;
		$this->icon      = $icon;
		$this->options   = $options;

		add_action( 'init', [ $this, 'add_post_type' ] );
	}

	public function add_post_type() {

		$args = [
			'menu_position' => 3,
			'labels'             => $this->labels,
			'menu_icon'          => $this->icon,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'supports'           => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ],
			'taxonomies'         => [

			]
		];

		register_post_type(
			$this->post_type,
			array_merge(
				$args,
				$this->options
			)
		);
	}

}
