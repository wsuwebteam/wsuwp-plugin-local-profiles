<?php namespace WSUWP\Plugin\Local_Profiles;

class Directory {

	public static function get_directory_nids( $directory, $custom_endpoint = false ) {

		$nids = array();

		if ( is_array( $directory ) ) {

			$request_url = $directory['source'];
			$directory_id = $directory['id'];

		} else {

			$request_url = ( $directory && is_numeric( $directory ) ) ? 'https://people.wsu.edu/wp-json/peopleapi/v1/people?directory=' . $directory : false;

		}

		if ( $request_url ) {

			$response = wp_remote_request( $request_url );

			if ( $response ) {

				$people = json_decode( wp_remote_retrieve_body( $response ), true );

				if ( ! empty( $people ) ) {

					foreach ( $people as $person ) {

						if ( ! empty( $person['nid'] ) ) {

							$nids[] = $person['nid'];

						}
					}
				}
			}
		}

		return $nids;

	}

}
