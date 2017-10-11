<?php

namespace MoviePlugin\Classes;

use MoviePlugin;
use MoviePlugin\Utils\Assets;


class MetaBox {
	use Assets;
	private $pos_type;
	private $field_name = 'meta_data';
	public static $price = '_price';
	public static $date = '_date';

	public function __construct( $pos_type ) {
		$this->pos_type = $pos_type;

		add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ], 1 );
		add_action( 'save_post', [ $this, 'save' ], 0 );
		$this->date_picker();


	}

	public function date_picker() {

		$this->addJs(
			'meta-box-date-picker',
			'admin',
			[
				'jquery',
				'jquery-ui-core',
				'jquery-ui-datepicker'
			]
		);

		$this->addCss(
			'jquery-ui-datepicker-custom-css',
			'admin'
		);


	}


	public function add_meta_box() {

		add_meta_box(
			$this->pos_type . '_meta_box_extra_fields',
			__( 'Extra fields', MoviePlugin::$textdomine ),
			[
				$this,
				'html'
			],
			$this->pos_type,
			'side',
			'high'
		);

	}

	public function html( $post ) {
		?>
        <p>
            <label>
				<?php _e( "Price:", MoviePlugin::$textdomine ); ?> <br/>
                <input type="number" name="<?php echo $this->field_name; ?>[<?php echo self::$price;?>]"
                       value="<?php echo get_post_meta( $post->ID, self::$price, 1 ); ?>" style="width: 100%;display: block;"/>
            </label>
        </p>

        <p>
            <label>
				<?php _e( "Release date:", MoviePlugin::$textdomine ); ?> <br/>
                <input class="move-date-picker" type="date" name="<?php echo $this->field_name; ?>[<?php echo self::$date;?>]"
                       value="<?php echo get_post_meta( $post->ID, self::$date, 1 ); ?>" style="width: 100%;display: block;"/>
            </label>
        </p>

        <input type="hidden" name="<?php echo $this->field_name . '_nonce'; ?>"
               value="<?php echo wp_create_nonce( __FILE__ ); ?>" style="width: 100%;display: block;"/>
		<?php
	}

	public function save( $post_id ) {
		if ( ! isset( $_POST[ $this->field_name . '_nonce' ] ) || ! wp_verify_nonce( $_POST[ $this->field_name . '_nonce' ], __FILE__ ) || ! isset( $_POST[ $this->field_name ] ) ) {
			return false;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || ! current_user_can( 'edit_post', $post_id ) ) {
			return false;
		}

		$_POST[ $this->field_name ] = array_map( 'trim', $_POST[ $this->field_name ] );
		foreach ( $_POST[ $this->field_name ] as $key => $value ) {
			if ( empty( $value ) ) {
				delete_post_meta( $post_id, $key );
				continue;
			}
			update_post_meta( $post_id, $key, $value );
		}

		return $post_id;
	}
}
