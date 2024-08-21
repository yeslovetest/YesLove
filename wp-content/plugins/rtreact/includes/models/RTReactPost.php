<?php


class RTReactPost {
	private $wpdb;

	private $table;
	private $wp_post_table;
	private $wp_users_table;
	private $rtreact_reaction_table;

	public function __construct() {
		$table_name                  = 'rtreact_post';
		$wp_post_table_name          = 'posts';
		$wp_users_table_name         = 'users';
		$rtreact_reaction_table_name = 'rtreact_reaction';

		global $wpdb;

		$this->wpdb = $wpdb;

		$this->table                  = $wpdb->prefix . $table_name;
		$this->wp_post_table          = $wpdb->prefix . $wp_post_table_name;
		$this->wp_users_table         = $wpdb->prefix . $wp_users_table_name;
		$this->rtreact_reaction_table = $wpdb->prefix . $rtreact_reaction_table_name;
	}

	public function createTable() {
		$sql = "CREATE TABLE IF NOT EXISTS $this->table (
      post_id bigint(20) unsigned NOT NULL,
      user_id bigint(20) unsigned NOT NULL,
      reaction_id int NOT NULL,
      PRIMARY KEY (post_id, user_id)
    ) {$this->wpdb->get_charset_collate()};";

		return $this->wpdb->query( $sql );
	}

	public function dropTable() {
		$sql = "DROP TABLE IF EXISTS $this->table";

		return $this->wpdb->query( $sql );
	}

	/**
	 * Create post reaction for user
	 *
	 * @param $data
	 *
	 * @return int|false
	 */
	public function create( $data ) {
		$data   = wp_parse_args( $data, [
			'user_id'     => 0,
			'post_id'     => 0,
			'reaction_id' => 0
		] );

		$format = [ '%d', '%d', '%d' ];

		return $this->wpdb->replace( $this->table, $data, $format );
	}

	/**
	 * Delete post reaction by user
	 *
	 * @param array $data
	 *
	 * @return bool|int
	 */
	public function delete( $data ) {
		$format = [ '%d', '%d', '%d' ];

		// number of affected rows on successful delete, false on error
		$result = $this->wpdb->delete( $this->table, $data, $format );

		return $result;
	}

	public function getReactions( $post_id ) {
		$sql = "SELECT id, name, image_url, COUNT(id) AS reaction_count FROM $this->table
              INNER JOIN $this->rtreact_reaction_table ON $this->table.reaction_id=$this->rtreact_reaction_table.id
              WHERE post_id=%d
              GROUP BY $this->rtreact_reaction_table.id
              ORDER BY reaction_count ASC";

		return $this->wpdb->get_results(
			$this->wpdb->prepare( $sql, [ $post_id ] )
		);
	}

	public function getUsersByPostReaction( $post_id, $reaction_id ) {
		$sql = "SELECT user_id FROM $this->table
              INNER JOIN $this->rtreact_reaction_table ON $this->table.reaction_id=$this->rtreact_reaction_table.id
              WHERE post_id=%d AND reaction_id=%d";

		return $this->wpdb->get_results(
			$this->wpdb->prepare( $sql, [ $post_id, $reaction_id ] )
		);
	}

	public function deleteUserReactions( $user_id ) {
		$format = [ '%d' ];

		// number of affected rows on successful delete, false on error
		$result = $this->wpdb->delete( $this->table, [ 'user_id' => $user_id ], $format );

		return $result;
	}
}
