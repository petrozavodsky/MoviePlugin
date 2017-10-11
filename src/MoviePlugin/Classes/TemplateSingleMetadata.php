<?php


namespace MoviePlugin\Classes;


use MoviePlugin;
use MoviePlugin\Utils\Assets;

class TemplateSingleMetadata {

	use Assets;

	public function __construct() {
		add_action( 'MoviePlugin__after', [ $this, 'template_path' ] );
		$this->addCss( 'SingleMetadata' );
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
        <div class="movieplugin__single-metadata-items">
            <div class="movieplugin__single-metadata-item">
				<?php the_terms( get_the_ID(), 'countries', '<strong>' . __( 'Country: ', MoviePlugin::$textdomine ) . '</strong>', ',' ); ?>
            </div>

            <div class="movieplugin__single-metadata-item">

				<?php the_terms( get_the_ID(), 'genres', '<strong>' . __( 'Genre: ', MoviePlugin::$textdomine ) . '</strong>', ',' ); ?>
            </div>

            <div class="movieplugin__single-metadata-item">
                <span class="label label-info">
				<?php _e( '<strong>Release date: </strong>', MoviePlugin::$textdomine ); ?><?php echo $date; ?>
                    <i class="fa fa-calendar"></i>
                </span>
            </div>

            <div class="movieplugin__single-metadata-item">

                <span class="label label-primary">
				<?php _e( '<strong>Price: </strong>', MoviePlugin::$textdomine ); ?><?php echo $price; ?>
                    <i class="fa fa-dollar"></i>
                </span>
            </div>

        </div>
		<?php
	}

}