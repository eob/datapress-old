<?php
/*
Plugin Name: Datapress
Plugin URI: http://projects.csail.mit.edu/datapress
Description: Create, share, and visualize data inside your blog
Version: 1.5
Author: The Haystack Group @ MIT
Author URI: http://haystack.csail.mit.edu/
*/

include_once("data-editor.php");
//include_once("viz-editor.php");

class Datapress {
  
  var $viz_editor;
  var $data_editor;

  function Datapress() {
 //   $this->viz_editor = new DatapressVizEditor();
    $this->data_editor = new DatapressDataEditor();
  }

  function Bootup() {
    register_activation_hook(__FILE__, array($this, 'Install'));
    //  $this->viz_editor->Bootup();
    $this->data_editor->Bootup();
  }

  function Install() {
    $this->data_editor->Install();
  }
}

$datapress = new Datapress();
$datapress->Bootup();


?>
