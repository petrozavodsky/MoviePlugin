<?php


namespace MoviePlugin\Classes;


use MoviePlugin;
use MoviePlugin\Utils\Assets;

class TemplateSingleMetadata {

	use Assets;

	public function __construct() {
		add_action( 'MoviePlugin__after', [ $this, 'template_path' ] );
		$a = $this->addCss( 'SingleMetadata' );
		d( $a );
	}


	public function template_path() {
		if ( is_singular( MoviePlugin::$post_type ) ) {

			$this->show();
		}
	}

	private function show() {
		$price = get_post_meta( get_the_ID(), MetaBox::$price, true );
		$date  = get_post_meta( get_the_ID(), Metabox::$date, true );
		?>
        <div class="movieplugin__single-metadata-title">
			<?php _e( 'Additional Information', MoviePlugin::$textdomine ); ?>
        </div>
        <div class="MoviePlugin__single-metadata-items">
            <div class="MoviePlugin__single-metadata-item">
				<?php the_terms( get_the_ID(), 'countries', '<strong>' . __( 'Country: ', MoviePlugin::$textdomine ) . '</strong>', ',' ); ?>
            </div>

            <div class="MoviePlugin__single-metadata-item">

				<?php the_terms( get_the_ID(), 'genres', '<strong>' . __( 'Genre: ', MoviePlugin::$textdomine ) . '</strong>', ',' ); ?>
            </div>

            <div class="MoviePlugin__single-metadata-item">
				<?php _e( '<strong>Release date: </strong>', MoviePlugin::$textdomine ); ?><?php echo $date; ?>
            </div>

            <div class="MoviePlugin__single-metadata-item">
				<?php _e( '<strong>Price: </strong>', MoviePlugin::$textdomine ); ?><?php echo $price; ?>
            </div>

        </div>
		<?php
	}

}