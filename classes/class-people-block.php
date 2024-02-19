<?php namespace WSUWP\Plugin\Local_Profiles;

class People_Block {


	public static function get_people_block_recursive( $blocks ) {

		$people_blocks = array();

		foreach ( $blocks as $block ) {

			if ( ! empty( $block['innerBlocks'] ) ) {

				$child_blocks = self::get_people_block_recursive( $block['innerBlocks'] );

				if ( ! empty( $child_blocks ) ) {

					$people_blocks = array_merge( $people_blocks, $child_blocks );

				}
			}

			if ( 'wsuwp/people-list' === $block['blockName'] ) {

				$people_blocks[] = $block;

			}
		}

		return $people_blocks;

	}


	public static function get_people_directories( $people_blocks ) {

		$directories = array();

		foreach ( $people_blocks as $people_block ) {

			if ( ! empty( $people_block['attrs']['indexProfiles'] ) && ! empty( $people_block['attrs']['custom_data_source'] ) ) {

				$directories[] = array( 'id' => false, 'source' => $people_block['attrs']['custom_data_source'] );

			} else if ( ! empty( $people_block['attrs']['indexProfiles'] ) && ! empty( $people_block['attrs']['directory'] ) ) {

				$directory_id = $people_block['attrs']['directory']['id'];

				$directories[] = $directory_id;

			}
		}

		return $directories;

	}


	public static function get_people_posts() {

		$posts = array();

		$args = array(
			'posts_per_page' => 10,
			'post_type'      => 'any',
			's'              => 'wsuwp/people-list',
		);

		$profile_query = new \WP_Query( $args );

		if ( $profile_query->have_posts() ) {

			while ( $profile_query->have_posts() ) {

				$profile_query->the_post();

				$posts[ get_the_permalink() ] = $profile_query->post;

			}
		}

		wp_reset_postdata();

		return $posts;

	}


}