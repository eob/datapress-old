<?php

/*
 * Big Todo list:
 *
 * 0. Prefix the CSS so that you won't hijack wordpress styles
 * 1. Plugin activation: create the tables in the DB if not exist
 * 2. Admin head: print out the schemas
 * 3. After the post save (so when a new post has an ID now)
 *    - blow away associated data items
 *    - save all data items in the form
 * 4. On admin head or the data editor body, print out the table of existing data items
 *
 * --> fully functional w/o ability to add new schema items or fetch feed of data
 *
 * 5. Data feed -> create URL which queries the data items (all, to start.. eventually we'll have filters)
 *    and prints it in exhibit format.
 * 6. schema editor on plugin options page
 *
 */
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

  function Install() {
    $this->CreateTableIfNotExist(); 
  }

  /*
   * Creates the table to store the bits of data associated with each post
   * Table 1: Schemas
   *   * id (int)
   *   * name (varchar)
   *   * fields (string -- contains json)
   *
   * Table 2: Instances
   *   * id (int)
   *   * post_id (int)
   *   * schema_id (int, may be 0 if free-hand)
   *   * type (varchar, replicated here because they may have made it up on spot)
   *   * fields (string -- contains json)
   *
   */
  function CreateTableIfNotExist() {
    // TODO: Check if tables above exist. If not, create them.
    // TODO: Add a few example schemas (ex: book, class, whatevs)
  }

  /*
   * This function gets called inside the <HEAD> element of a logged in author.
   * Anything echoed here goes into the <HEAD>
   */
  function AdminHead() {

    if (!$guessurl = site_url())
      $guessurl = wp_guess_url();
    $baseuri = $guessurl;
    $pluginUrl = trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/datapress';
    // TOOD:
    // load schemas from db table
    $headHtml = <<<HTML
<script type='text/javascript' src='$pluginUrl/lib/js/bootstrap-modal.js'></script>
<script type='text/javascript' src='$pluginUrl/lib/js/bootstrap-twipsy.js'></script>
<script type='text/javascript' src='$pluginUrl/lib/js/bootstrap-popover.js'></script>
<link href="$pluginUrl/lib/css/bootstrap.min.css" rel="stylesheel" />
<script>
// Schema stuff could go here.
</script>
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
