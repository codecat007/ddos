<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
   
  class Upload
  {
      public $FileName;
      public $NewName;
	  public $ThumbPrefix;
      public $File;
      public $NewWidth = 600;
      public $NewHeight = 600;
      public $TWidth = 100;
      public $THeight = 100;
      public $SavePath;
      public $ThumbPath;
      public $OverWrite;
      public $NameCase;
	  public $method = 1;
      
      private $Image;
      private $width;
      private $height;
      private $Error;
      
      /**
       * Upload::__construct()
       * 
       * @return
       */
      function __construct()
      {
          $this->FileName = 'imagename.jpg';
          $this->OverWrite = true;
          $this->NameCase = '';
          $this->Error = '';
          $this->NewName = '';
		  $this->ThumbPrefix = '';
		  $this->randName = '';
      }
      
      /**
       * Upload::UploadFile()
       * 
       * @return
       */
      function UploadFile()
      {
          if (is_array($this->File['name'])) {
              $this->_ArrayUpload();
          } else {
              $this->_NormalUpload();
          }
          
          return $this->Error;
      }
      
      /**
       * Upload::_ArrayUpload()
       * 
       * @return
       */
      function _ArrayUpload()
      {
          for ($i = 0; $i < count($this->File['name']); $i++) {
              
              if (!empty($this->File['name'][$i]) and $this->_FileExist($this->NewName[$i], $this->File['name'][$i]) == false) {
                  $this->_UploadImage($this->File['name'][$i], $this->File['tmp_name'][$i], $this->File['size'][$i], $this->File['type'][$i], $this->NewName[$i]);
                  
                  if (!empty($this->ThumbPath)) {
                      $this->_ThumbUpload($this->File['name'][$i], $this->File['tmp_name'][$i], $this->File['size'][$i], $this->File['type'][$i], $this->ThumbPrefix.$this->NewName[$i]);
                  }
              }
          }
      }
      
      /**
       * Upload::_NormalUpload()
       * 
       * @return
       */
      function _NormalUpload()
      {
          $_FileName = $this->File['name'];
          $_NewName = $this->NewName;
		  $_ThumbPrefix = $this->ThumbPrefix;

          if (!empty($this->File['name']) and $this->_FileExist($_NewName, $_FileName) == false) {
              $this->_UploadImage($this->File['name'], $this->File['tmp_name'], $this->File['size'], $this->File['type'], $this->NewName);
              
              if (!empty($this->ThumbPath)) {
                  $this->_ThumbUpload($this->File['name'], $this->File['tmp_name'], $this->File['size'], $this->File['type'], $this->ThumbPrefix.$this->NewName);
              }
          }
      }
      
      /**
       * Upload::_UploadImage()
       * 
       * @param mixed $FileName
       * @param mixed $TmpName
       * @param mixed $Size
       * @param mixed $Type
       * @param mixed $NewName
       * @return
       */
      function _UploadImage($FileName, $TmpName, $Size, $Type, $NewName)
      {
          list($width, $height) = getimagesize($TmpName);
          
		  $this->image = new Image($FileName);
          $this->image->newWidth = $this->NewWidth;
          $this->image->newHeight = $this->NewHeight;
          $this->image->PicDir = $this->SavePath;
          $this->image->TmpName = $TmpName;
          $this->image->FileSize = $Size;
          $this->image->FileType = $Type;
          
          $this->image->FileName = $this->_CheckName($NewName, $FileName);
          
          if ($width < $this->NewWidth and $height < $this->NewHeight) {
              $this->image->Save();
          } else {
              $this->image->Resize($this->method);
          }
      }
      
      /**
       * Upload::_ThumbUpload()
       * 
       * @param mixed $FileName
       * @param mixed $TmpName
       * @param mixed $Size
       * @param mixed $Type
       * @param mixed $NewName
       * @return
       */
      function _ThumbUpload($FileName, $TmpName, $Size, $Type, $NewName)
      {
          list($width, $height) = getimagesize($TmpName);
          
          $this->Timage = new Image($FileName); 
          $this->Timage->newWidth = $this->TWidth;
          $this->Timage->newHeight = $this->THeight;
          $this->Timage->PicDir = $this->ThumbPath;
          $this->Timage->TmpName = $TmpName;
          $this->Timage->FileSize = $Size;
          $this->Timage->FileType = $Type;
          
          $this->Timage->FileName = $this->_CheckName($NewName, $FileName);
          
          if ($width < $this->TWidth and $height < $this->THeight) {
              $this->Timage->Save();
          } else {
              $this->Timage->Resize($this->method);
          }
      }
      
      /**
       * Upload::_CheckName()
       * 
       * @param mixed $NewName
       * @param mixed $UpFile
       * @return
       */
      function _CheckName($NewName, $UpFile)
      {
          if (empty($NewName)) {
              return $this->_ChangeCase($UpFile);
          } else {
              $Ext = explode(".", $UpFile);
              $Ext = end($Ext);
              $Ext = strtolower($Ext);
              
              $NewName = $this->_ChangeCase($NewName . "." . $Ext);
			  return $NewName;
          }
      }
      
      /**
       * Upload::_ChangeCase()
       * 
       * @param mixed $FileName
       * @return
       */
      function _ChangeCase($FileName)
      {
          if ($this->NameCase == 'lower') {
              return strtolower($FileName);
          } elseif ($this->NameCase == 'upper') {
              return strtoupper($FileName);
          } else {
              return $FileName;
          }
      }
      
      /**
       * Upload::_FileExist()
       * 
       * @param mixed $_NewName
       * @param mixed $_FileName
       * @return
       */
      function _FileExist($_NewName, $_FileName)
      {
          if ($this->OverWrite == true) {
              if (file_exists($this->SavePath . $this->_CheckName($_NewName, $_FileName))) {
                  if (!unlink($this->SavePath . $this->_CheckName($_NewName, $_FileName))) {
                      $this->Error[] = "File: " .$this->_CheckName($_NewName, $_FileName) . " Cannot verwrite.";
                  } else {
                      if (file_exists($this->ThumbPath . $this->_CheckName($_NewName, $_FileName))) {
                          unlink($this->ThumbPath . $this->_CheckName($_NewName, $_FileName));
                      }
                  }
              }
          } else {
              if (file_exists($this->_CheckName($_NewName, $_FileName))) {
                  $this->Error[] = "File: " . $this->_CheckName($_NewName, $_FileName) . " aready exist";
                  return true;
              }
          }
      }
  }
?>