<?php 

namespace HOdonto\Service;

use Rain\Tpl;

class Page {

  private $tpl;
  private $options = [];
  private $defaults = [
    "sys" => true,
    "header" => true,
    "footer" => true,
    "data" => []
  ];
  
  public function __construct($opts = array(), $tpl_dir = "/views/")
  {
    $this->options = array_merge($this->defaults, $opts);

    $config = array(
    "tpl_dir" => $_SERVER["DOCUMENT_ROOT"].$tpl_dir,
    "cache_dir" => $_SERVER["DOCUMENT_ROOT"]."/tmp/views-cache/",
    "debug" => false
    );

    echo '-log2-';
    print_r($config);
    echo '-log2-';

    Tpl::configure( $config );
    $this->tpl = new Tpl();
    $this->setData($this->options["data"]);
    $this->setData(['lang' => $_COOKIE['lang']]);
    if ($this->options["sys"] === true) $this->tpl->draw("sys");
    if ($this->options["header"] === true) $this->tpl->draw("header");
  }

  private function setData($data = array())
  {
    foreach ($data as $key => $value) {
      $this->tpl->assign($key, $value);
    }
  }

  public function setTpl($name, $data = array(), $returnHTML = false)
  {
    $this->setData($data);
    echo '-log3-';
    echo $name;
    return $this->tpl->draw($name, $returnHTML);
  }

  public function __destruct()
  {
    if ($this->options["footer"] === true) $this->tpl->draw("footer");
  }
}

?>