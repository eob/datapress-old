<?

class Exhibit {

  static function IdForPost() {
    global $wpdb;
		$postid = $_GET['post'];
    if ($postid == NULL) {
      return NULL;
    }
    $table = DatapressConfig::PostsExhibitsTable();
    $exhibitid = $wpdb->get_var("SELECT exhibitid FROM $table WHERE postid=$postid ;");
    if (!($exhibitid == 0)) {
      return $exhibitid;
    }
    return NULL;
	}

}

?>
