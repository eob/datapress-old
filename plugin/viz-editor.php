<?
class DatapressVizEditor {

  function Bootup() {
    // Add the exhibit button 
    add_action('media_buttons', array($this, 'InsertEditorButtons'));
    add_action('wp_ajax_datapress_editor', array($this, 'OpenInClient'));
  }

  function InsertEditorButtons() {
    $editorLink = wp_guess_url() . "/wp-admin/admin-ajax.php?action=datapress_edtor";
    $imgLink = wp_guess_url() . "/wp-content/plugins/datapress/images/editor-button.png";
    $button = <<<HTML
Visualization 
<a id="loadDatapressjditor" href="$editorLink" class="thickbox" title="Add an Exhibit"><img src="$imgLink" /></a> 
HTML;
    echo $button;
  }

  function OpenInClient() {
  }

  function SaveConfiguration() {
  }


}
?>
