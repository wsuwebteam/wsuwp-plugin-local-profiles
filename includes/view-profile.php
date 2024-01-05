<?php namespace WSUWP\Plugin\Local_Profiles;

class View_Profile {

	protected static $profiles = array();

	public static function init() {

		add_filter( 'query_vars', function ( $query_vars ) {
			$query_vars[] = 'wsuprofile';
			return $query_vars;
		} );

		add_filter( 'the_title', array( __CLASS__, 'filter_title' ), 1 );

		add_filter( 'wp_nav_menu_items', array( __CLASS__, 'add_menu_fitler' ), 10, 2 );

		add_filter( 'pre_wp_nav_menu', array( __CLASS__, 'remove_menu_fitler' ), 10, 2 );

		add_filter( 'the_content', array( __CLASS__, 'filter_content' ), 1 );

		add_action( 'init', array( __CLASS__, 'add_rewrite' ), 1 );

	}

	public static function remove_menu_fitler( $nav_menu, $args ) {

		// we are working with menu, so remove the title filter
		remove_filter( 'the_title', array( __CLASS__, 'filter_title' ), 1 );

		return $nav_menu;

	}


	public static function add_menu_fitler( $items, $args ) {

		// we are done working with menu, so add the title filter back
		add_filter( 'the_title', array( __CLASS__, 'filter_title' ), 1 );

		return $items;

	}


	public static function filter_title( $title ) {

		$profile_nid = get_query_var( 'wsuprofile', false );

		if ( ! is_admin() && is_main_query() && ! empty( $profile_nid ) ) {

				$profile = self::get_profile( $profile_nid );

				$title = $profile->get( 'name' );

		}

		return $title;

	}


	protected static function get_profile( $nid ) {

		if ( array_key_exists( $nid, self::$profiles ) ) {

			return self::$profiles[ $nid ];

		} else {

			global $post;

			$people_blocks = People_Block::get_people_block_recursive( parse_blocks( $post->post_content ) );

			$profile_source = false;

			if ( ! empty( $people_blocks ) && ! empty( $people_blocks[0]['attrs']['custom_data_source'] ) ) {

				$profile_source = $people_blocks[0]['attrs']['custom_data_source'];

			}

			$profile = new Profile( $nid, $profile_source );

			self::$profiles[ $nid ] = $profile;

			return $profile;

		}

	}


	public static function filter_content( $content ) {

		$profile_nid = get_query_var( 'wsuprofile', false );

		if ( ! is_admin() && is_main_query() && ! empty( $profile_nid ) && is_singular() ) {

			$profile = self::get_profile( $profile_nid );

			if ( $profile ) {

				ob_start();

				include Plugin::get( 'dir' ) . '/templates/profile.php';

				$content = ob_get_clean();

			}
		}

		return $content;

	}

	public static function add_rewrite() {

		add_rewrite_rule(
			'(.?.+?)/wsu-profile/([a-z0-9_.-]+)/?$',
			'index.php?pagename=$matches[1]&wsuprofile=$matches[2]',
			'top'
		);

	}


	public static function flush_add_rewrite() {

		self::add_rewrite();
	
		// Flush the rewrite rules
		flush_rewrite_rules();

	}

}


View_Profile::init();
