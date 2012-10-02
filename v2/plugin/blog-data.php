<?php

class DatapressDataExporter {
  
  function BasicBlogData() {
    $ret = array();
    $ret["charset"] = bloginfo('charset');
    $ret["name"] = bloginfo('name');
    $ret["description"] = bloginfo('description');
    $ret["url"] = bloginfo('url');
    return $ret; 
  }

  function MainPage() {
    $ret = array();
    $ret["blog"] = $this->BasicBlogData();
    echo json_encode($ret); 
  }
}

?>

