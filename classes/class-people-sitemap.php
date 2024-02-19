<?php namespace WSUWP\Plugin\Local_Profiles;

class People_Sitemap extends \WP_Sitemaps_Provider {

	public function __construct() {

		$this->name = 'wsuprofiles'; // public-facing name in URLs says parent class.

	}


	public function get_url_list( $page_num, $post_type = '' ) {

		$url_list = array( array() );

		$profile_links = $this->get_profile_links();

		if ( ! empty( $profile_links ) ) {

			foreach ( $profile_links as $url => $nids ) {

				if ( ! empty( $nids ) ) {

					foreach ( $nids as $nid ) {

						$url_list[] = array( 'loc' => $url . 'wsu-profile/' . $nid );
					}
				}
			}
		}

		return ( ! empty( $url_list ) ) ? $url_list : array( array() );
	}


	public function get_max_num_pages( $subtype = '' ) {

		return 1;

	}


	public function get_profile_links() {

		$profile_links = array();

		$posts = People_Block::get_people_posts();

		$directory_nids = array();

		foreach ( $posts as $url => $post ) {

			$profile_links[ $url ] = array();

			$people_blocks = People_Block::get_people_block_recursive( parse_blocks( $post->post_content ) );

			$directories = People_Block::get_people_directories( $people_blocks );

			foreach ( $directories as $directory ) {

				$nids = Directory::get_directory_nids( $directory );

				if ( ! empty( $nids ) ) {

					foreach ( $nids as $nid ) {

						if ( ! in_array( $nid, $profile_links[ $url ], true ) ) {

							$profile_links[ $url ][] = $nid;

						}
					}
				}
			}
		}

		return $profile_links;

	}

}
