<?php

namespace MoviePlugin\Classes;


class InstallDemo {

	private $created_posts_array = [];

	public function __construct() {
		$this->create_posts();
		add_action( "init", function () {
			foreach ( $this->created_posts_array as $post_id ) {
				$this->create_meta_data( $post_id );
			}
		}, 20 );
		update_option( 'MoviePlugin_demo_content_add', false );
	}

	private function add_term( $name, $tax, $post_id ) {
		$out_arr = wp_insert_term( $name, $tax, [ 'name' => $name ] );
		if ( ! is_wp_error ( $out_arr ) ) {
			wp_set_object_terms(
				$post_id,
				$name,
				$tax
			);
		}
	}

	private function create_meta_data( $post_id ) {

		$date_rand = rand( 1980, 2018 );
		$this->add_term( strval( $date_rand ), 'years', $post_id );

		$actors = [
			'Sean Penn',
			'Richard Gere',
			'Arnold Schwarzenegger',
			'Angelina Jolie',
			'Brad Pitt',
			'Sylvester Stallone',
			'Dwayne Johnson',
			'Matt Damon',
			'Daniel Day-Lewis',
			'Anthony Hopkins',
			'Christoph Waltz',
			'Colin Firth',
			'Christian Bale',
			'Liam Neeson',
			'Ralph Fiennes'
		];

		$this->add_term( $actors[ array_rand( $actors ) ], 'actors', $post_id );

		$geners = [
			'Action',
			'Adult',
			'Adventure',
			'Comedy',
			'Comedy Drama',
			'Crime',
			'Drama',
			'Epic',
			'Fantasy',
			'Historical Film',
			'Horror',
			'Musical',
			'Mystery',
			'Romance',
			'Science Fiction',
			'Spy Film',
			'Thriller',
			'War',
			'Western'
		];

		$this->add_term( $geners[ array_rand( $geners ) ], 'genres', $post_id );

		$countries = [
			'Afghanistan',
			'Albania',
			'Algeria',
			'Cambodia',
			'Cameroon',
			'Canada',
			'Denmark',
			'Djibouti',
			'Dominica',
			'East Timor',
			'Ecuador',
			'Egypt',
			'El Salvador',
			'Fiji',
			'Finland',
			'France',
			'Gabon',
			'Gambia',
			'Georgia',
			'Haiti',
			'Holy See',
			'Honduras',
			'Iceland',
			'India',
			'Indonesia',
			'Jamaica',
			'Japan',
			'Jordan',
			'Kazakhstan',
			'Kenya',
			'Kiribati',
			'Laos',
			'Latvia',
			'Lebanon',
			'Macau',
			'Macedonia',
			'Madagascar',
			'Namibia',
			'Nauru',
			'Nepal',
			'Netherlands',
			'Oman',
			'Pakistan',
			'Palau',
			'Palestinian Territories',
			'Qatar',
			'Romania',
			'Russia',
			'Rwanda',
			'Saint Kitts ',
			'Saint Lucia',
			'Saint Vincent ',
			'Taiwan',
			'Tajikistan',
			'Tanzania',
			'Thailand',
			'Uganda',
			'Ukraine',
			'United Arab Emirates',
			'Vanuatu',
			'Venezuela',
			'Vietnam',
			'Yemen',
			'Zambia',
			'Zimbabwe'
		];

		$this->add_term( $countries[ array_rand( $countries ) ], 'countries', $post_id );

		$rand_price = rand( 10, 100 );
		add_post_meta( $post_id, '_price', $rand_price, true );

		add_post_meta( $post_id, '_date', "{$date_rand}-01-01", true );
	}

	private function create_posts() {
		for ( $i = 0; $i ++ < 7; ) {
			$post_id                     = $this->add_new_post(
				"Movie -  {$i}",
				"<p>Movie Content - {$i}</p>",
				"Movie excerpt {$i}"
			);
			$this->created_posts_array[] = $post_id;
		}

	}

	private function add_new_post( $title, $content, $excerpt ) {
		$post_data = [
			'post_type'    => 'movie',
			'post_title'   => $title,
			'post_content' => $content,
			'excerpt'      => $excerpt,
			'post_status'  => 'publish',
		];

		return wp_insert_post( $post_data );
	}


}