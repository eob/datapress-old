<?php
class DatapressDataEditor {

  /*
   * Called every time Datapress loads (which is every time a WordPress request is handled
   */ 
  function Bootup() {
    // Add the exhibit button 
    add_action("admin_init", array($this, 'AdminInit'));
    add_action('wp_ajax_fetch_item_schemas', array(self, 'SupportedSchemas') ); 
  }

  /*
   * Perform any initialization relevant to administrative users
   */ 
  function AdminInit() {
    foreach (array('post','page') as $type) {
      add_meta_box('datapress_data_editor',
                   'Add Data',
                   array($this, 'DisplayEditor'),
                   $type,
                   'normal',
                   'high');
    }
    // Tell it to load the Twitter Bootstrap libraries
    add_action('admin_head', array($this, 'AdminHead'));
    add_action('save_post', array($this, 'SaveData'));
  }


  function AdminHead() {

    if (!$guessurl = site_url())
      $guessurl = wp_guess_url();
    $baseuri = $guessurl;
    $pluginUrl = trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/datapress';

    $headHtml = <<<HTML
<script type='text/javascript' src='$pluginUrl/lib/js/bootstrap-modal.js'></script>
<script type='text/javascript' src='$pluginUrl/lib/js/bootstrap-twipsy.js'></script>
<script type='text/javascript' src='$pluginUrl/lib/js/bootstrap-popover.js'></script>
<link href="$pluginUrl/lib/css/bootstrap.min.css" rel="stylesheel" />
HTML;
    echo($headHtml);
  }
  /*
   * Display the contents of the data editor box, inside the post/page
   * authoring page.
   */
  function DisplayEditor() {
    $editorHtml = <<<HTML
##INCLUDE:data-editor/editor.html:data-editor-list
HTML;
    $editorModal = <<<HTML
##INCLUDE:data-editor/editor.html:data-editor-modal
HTML;
    $inputHtml = <<<HTML
##INCLUDE:data-editor/editor.html:data-editor-input
HTML;
     $inputJs = <<<HTML
##INCLUDE:data-editor/editor.html:data-editor-js
HTML;
 
    echo $editorModal;
   echo $editorHtml; 
    echo $inputHtml;
    echo $inputJs;
  
  }

  function SaveData() {
   // The user is saving a post. So save the data from the data editor here.
  }

  function GetData() {
  }

  function SupportedSchemas() {
    header('Cache-Control: no-cache, must-revalidate');
    header('Content-type: application/json');
    $schemasJson = <<<HTML
{
  'test':'foo'
}
HTML;
    echo $schemasJson;
  }

}
?>
