<?php namespace WSUWP\Plugin\Local_Profiles;

class Plugin {


	public static function get( $property ) {

		switch ( $property ) {

			case 'version':
				return WSUWPPLUGINLOCALPROFILES;

			case 'dir':
				return plugin_dir_path( dirname( __FILE__ ) );

			case 'url':
				return plugin_dir_url( dirname( __FILE__ ) );

			default:
				return '';

		}

	}

	public static function init() {

		$class_dir = self::get( 'dir' ) . '/classes';

		require_once $class_dir . '/class-directory.php';
		require_once $class_dir . '/class-people-block.php';
		require_once $class_dir . '/class-people-sitemap.php';
		require_once $class_dir . '/class-profile.php';

		require_once __DIR__ . '/sitemap.php';
		require_once __DIR__ . '/view-profile.php';
		require_once __DIR__ . '/scripts.php';

	}

}

Plugin::init();
