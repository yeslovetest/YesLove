<?php


class RTReactComment
{
    private $wpdb;

    private $table;
    private $wp_comment_table;
    private $wp_users_table;
    private $react_reaction_table;

    public function __construct() {
        $table_name = 'rtreact_comment';
        $wp_comment_table_name = 'comments';
        $wp_users_table_name = 'users';
        $react_reaction_table_name = 'rtreact_reaction';

        global $wpdb;

        $this->wpdb = $wpdb;

        $this->table = $wpdb->prefix . $table_name;
        $this->wp_comment_table = $wpdb->prefix . $wp_comment_table_name;
        $this->wp_users_table = $wpdb->prefix . $wp_users_table_name;
        $this->react_reaction_table = $wpdb->prefix . $react_reaction_table_name;
    }

    public function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS $this->table (
      postcomment_id bigint(20) unsigned NOT NULL,
      user_id bigint(20) unsigned NOT NULL,
      reaction_id int NOT NULL,
      PRIMARY KEY (postcomment_id, user_id)
    ) {$this->wpdb->get_charset_collate()};";

        return $this->wpdb->query($sql);
    }

    public function dropTable() {
        $sql = "DROP TABLE IF EXISTS $this->table";

        return $this->wpdb->query($sql);
    }

    public function create($postcomment_user_reaction) {
        $format = ['%d', '%d', '%d'];

        // number of affected rows on successful replace (1 if only insert, 1 more for each delete if replace), false on error
        $result = $this->wpdb->replace($this->table, $postcomment_user_reaction, $format);

        if ($result) {
            return $this->wpdb->insert_id;
        }

        return false;
    }

    /**
     * @param array $data
     *
     * @return bool|int
     */
    public function delete($data) {
        $format = ['%d', '%d', '%d'];

        // number of affected rows on successful delete, false on error
        return $this->wpdb->delete($this->table, $data, $format);
    }

    /**
     * @param int $id
     *
     * @return array|object|null
     */
    public function getReactions($id) {
        $sql = "SELECT id, name, image_url, COUNT(id) AS reaction_count FROM $this->table
              INNER JOIN $this->react_reaction_table ON $this->table.reaction_id=$this->react_reaction_table.id
              WHERE postcomment_id=%d
              GROUP BY $this->react_reaction_table.id
              ORDER BY reaction_count ASC";

        return $this->wpdb->get_results(
            $this->wpdb->prepare($sql, [$id])
        );
    }

    public function getUsersByPostCommentReaction($id, $reaction_id) {
        $sql = "SELECT user_id FROM $this->table
              INNER JOIN $this->react_reaction_table ON $this->table.reaction_id=$this->react_reaction_table.id
              WHERE postcomment_id=%d AND reaction_id=%d";

        return $this->wpdb->get_results(
            $this->wpdb->prepare($sql, [$id, $reaction_id])
        );
    }

    public function deleteUserReactions($user_id) {
        $format = ['%d'];

        // number of affected rows on successful delete, false on error
        $result = $this->wpdb->delete($this->table, ['user_id' => $user_id], $format);

        return $result;
    }
}