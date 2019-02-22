<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Image
  {
      public $FileName;
      public $FileSize;
      public $FileType;
      public $newWidth = 100;
      public $newHeight = 100;
      public $TmpName;
      public $PicDir;
      private $MaxFileSize = 2000000;
	  private $AllowedExtentions = array("image/png", "image/gif", "image/jpeg", "image/pjpeg", "image/jpg", "image/x-png");
      private $ImageQuality = 85;
      private $ImageQualityPng = 3;
      
      /**
       * Image::Image()
       *
       * @param mixed $FileName
       * @return
       */
      function __construct($FileName)
      {
          $this->FileName = $FileName;
      }
      
      /**
       * Image::GetFileExtention()
       *
       * @param mixed $FileName
       * @return
       */
      function GetFileExtention($FileName)
      {
          if ($this->AllowedExtentions) {
              return true;
          } else {
              return false;
          }
      }
      
      /**
       * Image::ExistFile()
       *
       * @return
       */
      function ExistFile()
      {
          $fileexist = $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . '/' . $this->PicDir . $this->FileName;
          if (file_exists($fileexist)) {
              return true;
          }
      }
      
      /**
       * Image::GetError()
       *
       * @param mixed $error
       * @return
       */
      function GetError($error)
      {
          switch ($error) {
              case 0:
                  echo "Error: Invalid file type <strong>$this->FileType</strong>! Allowed type: .jpg, .jpeg, .gif, .png <strong>$this->FileName</strong><br />";
                  break;
                  
              case 1:
                  echo "Error: File <strong>$this->FileSize</strong> is too large!<br />";
                  break;
                  
              case 2:
                  echo "Error: Please, select a file for uploading!<br>";
                  break;
                  
              case 3:
                  echo "Error: File <strong>$this->FileName</strong> already exist!<br />";
                  break;
          }
      }
      
      /**
       * Image::Resize()
       *
       * @return
       */
      function Resize($method)
      {
          if (empty($this->TmpName)) {
              echo $this->GetError(2);
          } elseif ($this->FileSize > $this->MaxFileSize) {
              echo $this->GetError(1);
          } elseif ($this->GetFileExtention($this->FileName) == false) {
              echo $this->GetError(0);
          } elseif ($this->ExistFile()) {
              echo $this->GetError(3);
          } else {
              $ext = explode(".", $this->FileName);
              $ext = end($ext);
              $ext = strtolower($ext);
              
              // Get new sizes
              list($width_orig, $height_orig) = getimagesize($this->TmpName);
              $ratio_orig = $width_orig / $height_orig;
              
              if ($method == 1) {
                  if ($this->newWidth && !$this->newHeight) {
                      $this->newHeight = floor($height_orig * ($this->newWidth / $width_orig));
                  } elseif ($this->newHeight && !$this->newWidth)
                      $this->newWidth = floor($width_orig * ($this->newHeight / $height_orig));
              } else {
                  if ($this->newWidth / $this->newHeight > $ratio_orig) {
                      $this->newWidth = $this->newHeight * $ratio_orig;
                  } else
                      $this->newHeight = $this->newWidth / $ratio_orig;
              }
              
              $normal = imagecreatetruecolor($this->newWidth, $this->newHeight);
			  switch ($ext) {
				  case "jpg":
					  $source = imagecreatefromjpeg($this->TmpName);
					  break;
				  case "gif":
					   $source = imagecreatefromgif($this->TmpName);
					  break;
				  case "png":
					  $source = imagecreatefrompng($this->TmpName);
					  break;
			  }
              
              $white = imagecolorallocate($normal, 255, 255, 255);
              imagefill($normal, 0, 0, $white);
              
              if ($method == 1) {
                  $origin_x = 0;
                  $origin_y = 0;
                  
                  $src_x = $src_y = 0;
                  $src_w = $width_orig;
                  $src_h = $height_orig;
                  
                  $cmp_x = $width_orig / $this->newWidth;
                  $cmp_y = $height_orig / $this->newHeight;
                  
                  if ($cmp_x > $cmp_y) {
                      $src_w = round($width_orig / $cmp_x * $cmp_y);
                      $src_x = round(($width_orig - ($width_orig / $cmp_x * $cmp_y)) / 2);
                  } elseif ($cmp_y > $cmp_x) {
                      $src_h = round($height_orig / $cmp_y * $cmp_x);
                      $src_y = round(($height_orig - ($height_orig / $cmp_y * $cmp_x)) / 2);
                  }
                  
                  imagecopyresampled($normal, $source, $origin_x, $origin_y, $src_x, $src_y, $this->newWidth, $this->newHeight, $src_w, $src_h);
              } else {
                  imagecopyresampled($normal, $source, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $width_orig, $height_orig);
              }
              imagecolortransparent($normal, $white);

			  switch ($ext) {
				  case "jpg":
					  imagejpeg($normal, "$this->PicDir/$this->FileName", "$this->ImageQuality");
					  break;
				  case "gif":
					   imagegif($normal, "$this->PicDir/$this->FileName", "$this->ImageQuality");
					  break;
				  case "png":
					  imagepng($normal, "$this->PicDir/$this->FileName", "$this->ImageQualityPng");
					  break;
			  }
              
              imagedestroy($source);
          }
      }
      
      /**
       * Image::Save()
       *
       * @return
       */
      function Save()
      {
          if (empty($this->TmpName)) {
              echo $this->GetError(2);
          } elseif ($this->FileSize > $this->MaxFileSize) {
              echo $this->GetError(1);
          } elseif ($this->GetFileExtention($this->FileName) == false) {
              echo $this->GetError(0);
          } elseif ($this->ExistFile()) {
              echo $this->GetError(3);
          }
          
          else {
              copy($this->TmpName, $this->PicDir . $this->FileName);
          }
      }
  }
?>