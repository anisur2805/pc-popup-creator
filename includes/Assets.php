<?php

namespace ARPC\Popup;

/**
 *
 */
class Assets {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	public function get_scripts() {
		return array(
			'plain-modal'         => array(
				'src'     => ARPC_ASSETS . '/js/jquery.plainmodal.min.js',
				'version' => filemtime( ARPC_PATH . '/assets/js/jquery.plainmodal.min.js' ),
				'deps'    => array( 'jquery' ),
			),

			'arpc-main'           => array(
				'src'     => ARPC_ASSETS . '/js/popup-main.js',
				'version' => filemtime( ARPC_PATH . '/assets/js/popup-main.js' ),
				'deps'    => array( 'jquery' ),
			),

			'arpc-metabox-script' => array(
				'src'     => ARPC_ASSETS . '/js/metabox.js',
				'version' => filemtime( ARPC_PATH . '/assets/js/metabox.js' ),
				'deps'    => array( 'jquery' ),
			),

			'arpc-modal-form'     => array(
				'src'     => ARPC_ASSETS . '/js/popup-form.js',
				'version' => filemtime( ARPC_PATH . '/assets/js/popup-form.js' ),
				'deps'    => array( 'jquery' ),
			),

			'arpc-tabbed'         => array(
				'src'     => ARPC_ASSETS . '/js/tabbed.js',
				'version' => filemtime( ARPC_PATH . '/assets/js/tabbed.js' ),
				'deps'    => array(),
			),
			'admin-subscriber'    => array(
				'src'     => ARPC_ASSETS . '/js/admin-subscriber.js',
				'version' => filemtime( ARPC_PATH . '/assets/js/admin-subscriber.js' ),
				'deps'    => array( 'jquery', 'wp-util' ),
			),

		);
	}

	public function get_styles() {
		return array(
			'arpc-metabox'     => array(
				'src'     => ARPC_ASSETS . '/css/metabox.css',
				'version' => filemtime( ARPC_PATH . '/assets/css/metabox.css' ),
			),

			'arpc-admin-style' => array(
				'src'     => ARPC_ASSETS . '/css/admin-style.css',
				'version' => filemtime( ARPC_PATH . '/assets/css/admin-style.css' ),
			),

			'arpc-style'       => array(
				'src'     => ARPC_ASSETS . '/css/puc-style.css',
				'version' => filemtime( ARPC_PATH . '/assets/css/puc-style.css' ),
			),
		);
	}

	public function enqueue_assets() {
		wp_enqueue_style( 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&display=swap' );
		$scripts = $this->get_scripts();

		foreach ( $scripts as $handle => $script ) {
			$deps = isset( $script['deps'] ) ? $script['deps'] : false;
			wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
		}

		$styles = $this->get_styles();

		foreach ( $styles as $handle => $style ) {
			$deps = isset( $style['deps'] ) ? $style['deps'] : false;
			wp_register_style( $handle, $style['src'], $deps, $style['version'] );
		}

		wp_localize_script(
			'arpc-modal-form',
			'arpcModalForm',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'success' => __( 'Thanks for subscribe', 'arpc-popup-creator' ),
				'error'   => __( 'Something went wrong in Front area', 'arpc-popup-creator' ),
			)
		);

		wp_localize_script(
			'admin-subscriber',
			'arpcAdminSub',
			array(
				'nonce'   => wp_create_nonce( 'admin-subscriber' ),
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'confirm' => __( 'Are you sure?', 'arpc-popup-creator' ),
				'success' => __( 'Thanks for subscribe', 'arpc-popup-creator' ),
				'error'   => __( 'Something went wrong', 'arpc-popup-creator' ),
			)
		);
	}
}
