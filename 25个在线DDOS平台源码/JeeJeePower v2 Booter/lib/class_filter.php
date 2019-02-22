<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  final class Filter
  {
      public $get = array();
      public $post = array();
      public $cookie = array();
      public $files = array();
      public $server = array();
      

      /**
       * Filter::__construct()
       * 
       * @return
       */
      public function __construct()
      {
          $_GET = $this->clean($_GET);
          $_POST = $this->clean($_POST);
          $_COOKIE = $this->clean($_COOKIE);
          $_FILES = $this->clean($_FILES);
          $_SERVER = $this->clean($_SERVER);
          
          $this->get = $_GET;
          $this->post = $_POST;
          $this->cookie = $_COOKIE;
          $this->files = $_FILES;
          $this->server = $_SERVER;
      }
      
      /**
       * Filter::clean()
       * 
       * @param mixed $data
       * @return
       */
      public function clean($data)
      {
          if (is_array($data)) {
              foreach ($data as $key => $value) {
                  unset($data[$key]);
                  
                  $data[$this->clean($key)] = $this->clean($value);
              }
          } else
              $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
          
          return $data;
      }
  }
?>