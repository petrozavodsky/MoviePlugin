<?php


namespace MoviePlugin\Classes;


use MoviePlugin;

class TemplateSingleMetadata {

	public function __construct() {
		add_action( 'MoviePlugin__after', [ $this, 'template_path' ] );
	}


	public function template_path() {
		if ( is_singular( MoviePlugin::$post_type ) ) {

			$this->show();
		}
	}

	private function show() {
		$price = MetaBox::$price;
		$date  = Metabox::$date;
		?>

		<?php the_terms( get_the_ID(), 'countries', 'Country ', ',' ); ?>
		<?php the_terms( get_the_ID(), 'genres', 'Genre', ',' ); ?>

        Release date: <?php echo $date; ?>
        Price: <?php echo $price; ?>

		<?php
	}

}