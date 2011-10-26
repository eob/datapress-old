<?
class DatapressDataEditor {
 
  function Bootup() {
    // Add the exhibit button 
    add_action("admin_init", array($this, 'RegisterMetaBoxes'));
  }
 
  function RegisterMetaBoxes() {
    foreach (array('post','page') as $type) {
      add_meta_box('datapress_data_editor',
                   'Add Data',
                   array($this, 'DisplayEditor'),
                   $type,
                   'normal',
                   'high');
    }
    add_action('save_post', array($this, 'SaveData'));
  }

  function DisplayEditor() {
    $editorHtml = <<<HTML
##INCLUDE:data-editor/editor.html:data-editor-list
HTML;
   echo $editorHtml; 
  }

  function SaveData() {
   // The user is saving a post. So save the data from the data editor here.
  }

  function GetData() {
  }

}
?>
