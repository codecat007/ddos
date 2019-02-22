<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Paginator
  {
      public $items_per_page;
      public $items_total;
      public $num_pages;
      public $limit;
      public $default_ipp;
      private $mid_range;
      private $low;
      private $high;
      private $return;
      private $querystring;
      private $current_page;
      
      
      /**
       * Paginator::__construct()
       * 
       * @return
       */
      function __construct()
      {
          $this->current_page = 1;
          $this->mid_range = 7;
          $this->items_per_page = (!empty($_GET['ipp'])) ? sanitize($_GET['ipp']) : $this->default_ipp;
      }
      
      /**
       * Paginator::paginate()
       * 
       * @param bool $path
       * @return
       */
      function paginate()
      {		  
          if (!is_numeric($this->items_per_page) || $this->items_per_page <= 0)
              $this->items_per_page = $this->default_ipp;
          $this->num_pages = ceil($this->items_total / $this->items_per_page);
          
          $this->current_page = intval(sanitize(get('pg')));
          if ($this->current_page < 1 or !is_numeric($this->current_page))
              $this->current_page = 1;
          if ($this->current_page > $this->num_pages)
              $this->current_page = $this->num_pages;
          $prev_page = $this->current_page - 1;
          $next_page = $this->current_page + 1;
          
          if ($_GET) {
              $args = explode("&amp;", $_SERVER['QUERY_STRING']);
              foreach ($args as $arg) {
                  $keyval = explode("=", $arg);
                  if ($keyval[0] != "pg" && $keyval[0] != "ipp")
                      $this->querystring .= "&amp;" . sanitize($arg);
              }
          }
          
          if ($_POST) {
              foreach ($_POST as $key => $val) {
                  if ($key != "pg" && $key != "ipp")
                      $this->querystring .= "&amp;$key=" . sanitize($val);
              }
          }
          
          if ($this->num_pages > 1) {
              if ($this->current_page != 1 && $this->items_total >= $this->default_ipp) {
                  $this->return = "<a href=\"$_SERVER[PHP_SELF]?pg=$prev_page&amp;ipp=$this->items_per_page$this->querystring\" class=\"number\">Prev</a>";
              } else {
                  $this->return = "Prev&nbsp;&nbsp;";
              }
              
              $this->start_range = $this->current_page - floor($this->mid_range / 2);
              $this->end_range = $this->current_page + floor($this->mid_range / 2);
              
              if ($this->start_range <= 0) {
                  $this->end_range += abs($this->start_range) + 1;
                  $this->start_range = 1;
              }
              if ($this->end_range > $this->num_pages) {
                  $this->start_range -= $this->end_range - $this->num_pages;
                  $this->end_range = $this->num_pages;
              }
              $this->range = range($this->start_range, $this->end_range);
              
              for ($i = 1; $i <= $this->num_pages; $i++) {
                  if ($this->range[0] > 2 && $i == $this->range[0])
                      $this->return .= " ... ";
                  
                  if ($i == 1 or $i == $this->num_pages or in_array($i, $this->range)) {
                      if ($i == $this->current_page) {
                          $this->return .= "<a href=\"#\" title=\"Go To $i of $this->num_pages\" class=\"number current tooltip\">$i</a>";
                      } else {
                          $this->return .= "<a class=\"number tooltip\" title=\"Go To $i of $this->num_pages\" href=\"$_SERVER[PHP_SELF]?pg=$i&amp;ipp=$this->items_per_page$this->querystring\">$i</a>";
                      }
                  }
                  if ($this->range[$this->mid_range - 1] < $this->num_pages - 1 && $i == $this->range[$this->mid_range - 1])
                      $this->return .= " ... ";
              }
              if ($this->current_page != $this->num_pages && $this->items_total >= $this->default_ipp) {
                  $this->return .= "<a href=\"$_SERVER[PHP_SELF]?pg=$next_page&amp;ipp=$this->items_per_page$this->querystring\" class=\"number\">Next</a>\n";
              } else {
                  $this->return .= "Next";
              }
          } else {
              for ($i = 1; $i <= $this->num_pages; $i++) {
                  if ($i == $this->current_page) {
                      $this->return .= "<a href=\"#\" class=\"current\">$i</a>";
                  } else {
                      $this->return .= "<a class=\"number\" href=\"$_SERVER[PHP_SELF]?pg=$i&amp;ipp=$this->items_per_page$this->querystring\">$i</a>";
                  }
              }
          }
          $this->low = ($this->current_page - 1) * $this->items_per_page;
          $this->high = $this->current_page * $this->items_per_page - 1;
          $this->limit = " LIMIT $this->low,$this->items_per_page";
      }
      
      /**
       * Paginator::items_per_page()
       * 
       * @return
       */
      public function items_per_page()
      {
          $items = '';
          $ipp_array = array(10, 25, 50, 100);
          foreach ($ipp_array as $ipp_opt)
              $items .= ($ipp_opt == $this->items_per_page) ? "<option selected=\"selected\" value=\"$ipp_opt\">$ipp_opt</option>\n" : "<option value=\"$ipp_opt\">$ipp_opt</option>\n";
          return "<strong>Items Per Page</strong>: <select class=\"select\" onchange=\"window.location='$_SERVER[PHP_SELF]?pg=1&amp;ipp='+this[this.selectedIndex].value+'$this->querystring';return false\">$items</select>\n";
      }
      
      /**
       * Paginator::jump_menu()
       * 
       * @return
       */
      public function jump_menu()
      {
          $option = '';
          for ($i = 1; $i <= $this->num_pages; $i++) {
              $option .= ($i == $this->current_page) ? "<option value=\"$i\" selected=\"selected\">$i</option>\n" : "<option value=\"$i\">$i</option>\n";
          }
          return "<strong>Go To</strong>: <select class=\"select\" onchange=\"window.location='$_SERVER[PHP_SELF]?pg='+this[this.selectedIndex].value+'&amp;ipp=$this->items_per_page$this->querystring';return false\">$option</select>\n";
      }
      
      /**
       * Paginator::display_pages()
       * 
       * @return
       */
      function display_pages()
      {
          return($this->items_total > $this->default_ipp) ? $this->return : "";
      }
  }
?>