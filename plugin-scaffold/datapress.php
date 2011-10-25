<?php
/*
Plugin Name: Datapress
Plugin URI: http://projects.csail.mit.edu/datapress
Description: Create, share, and visualize data inside your blog
Version: 1.5
Author: The Haystack Group @ MIT
Author URI: http://haystack.csail.mit.edu/
*/

include_once("datapress-editor.php");

class Datapress {
  
  var $datapress_editor;

  function Datapress() {
    $this->datapress_editor = new DatapressEditor();
  }

  function Bootup() {
    $this->datapress_editor->Bootup();
  }
}

$datapress = new Datapress();
$datapress->Bootup();

?>
