<?php


class RTReactReaction
{
    private $wpdb;

    private $table;

    public function __construct() {
        $table_name = 'rtreact_reaction';

        global $wpdb;

        $this->wpdb = $wpdb;

        $this->table = $wpdb->prefix . $table_name;
    }

    public function createTable() {
        if ($this->wpdb->get_var($this->wpdb->prepare("SHOW TABLES LIKE %s", $this->table)) !== $this->table) {
            $sql = "CREATE TABLE $this->table (
      id int NOT NULL AUTO_INCREMENT,
      name varchar(255) NOT NULL,
      image_url varchar(500) NOT NULL,
      PRIMARY KEY (id)
    ) {$this->wpdb->get_charset_collate()};";

            $this->wpdb->query($sql);

            // init reaction table
            $reaction_items = [
                [
                    'name'      => 'like',
                    'image_url' => RTREACT_PLUGIN_URL . 'img/like.png'
                ],
                [
                    'name'      => 'love',
                    'image_url' => RTREACT_PLUGIN_URL . 'img/love.png'
                ],
                [
                    'name'      => 'dislike',
                    'image_url' => RTREACT_PLUGIN_URL . 'img/dislike.png'
                ],
                [
                    'name'      => 'happy',
                    'image_url' => RTREACT_PLUGIN_URL . 'img/happy.png'
                ],
                [
                    'name'      => 'funny',
                    'image_url' => RTREACT_PLUGIN_URL . 'img/funny.png'
                ],
                [
                    'name'      => 'wow',
                    'image_url' => RTREACT_PLUGIN_URL . 'img/wow.png'
                ],
                [
                    'name'      => 'angry',
                    'image_url' => RTREACT_PLUGIN_URL . 'img/angry.png'
                ],
                [
                    'name'      => 'sad',
                    'image_url' => RTREACT_PLUGIN_URL . 'img/sad.png'
                ]
            ];

            foreach ($reaction_items as $reaction_item) {
                $this->create($reaction_item);
            }
        }
    }

    public function dropTable() {
        $sql = "DROP TABLE IF EXISTS $this->table";

        return $this->wpdb->query($sql);
    }

    public function create($reaction) {
        $format = ['%s', '%s'];

        // number of affected rows on successful insert (always 1), false on error
        $result = $this->wpdb->insert($this->table, $reaction, $format);

        if ($result) {
            return $this->wpdb->insert_id;
        }

        return false;
    }

    public function getAll() {
        $sql = "SELECT id, name, image_url FROM $this->table";

        // array with matching elements, empty array if no matching rows or database error
        return $this->wpdb->get_results($sql);
    }

    public function get($reaction_id) {
        $sql = "SELECT id, name, image_url FROM $this->table WHERE id=%d";

        return $this->wpdb->get_row(
            $this->wpdb->prepare($sql, [$reaction_id])
        );
    }

}
