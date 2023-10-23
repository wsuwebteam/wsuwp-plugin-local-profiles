<?php namespace WSUWP\Plugin\Local_Profiles;

class Scripts {

	
	public static function add_local_editor_script() {


		wp_add_inline_script(
			'wsuwp-plugin-gutenberg-editor-scripts',
			'const wsuPluginLocalProfilesEditor = ' . json_encode( array( 'showProfiles' => true,) ),
			'before'
		);

	}

	public static function init() {

		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'add_local_editor_script' ), 20 );

	}

}

Scripts::init();
