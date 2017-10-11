<?php

namespace MoviePlugin\Classes;


class TaxonomyWrap {

	private $post_type;
	private $taxonomy;
	private $labels;
	private $options;

	public function __construct( $taxonomy_slug, $post_type, $labels, $options = [] ) {
		$this->post_type = $post_type;
		$this->taxonomy  = $taxonomy_slug;
		$this->labels    = $labels;
		$this->options   = $options;
		$this->add_tax();
	}

	public function add_tax() {

		$args = [
			'labels'       => $this->labels,
			'show_ui'      => true,
			'query_var'    => true,
			'hierarchical' => false,
			'rewrite'      => [ 'slug' => $this->taxonomy ],
		];

		register_taxonomy(
			$this->taxonomy,
			$this->post_type,
			array_merge(
				$args,
				$this->options
			)
		);

	}
}