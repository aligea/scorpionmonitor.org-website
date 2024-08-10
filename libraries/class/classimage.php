<?php
/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
* 
* This program is free software; you can redistribute it and/or 
* modify it under the terms of the GNU General Public License 
* as published by the Free Software Foundation; either version 2 
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of 
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
* GNU General Public License for more details: 
* http://www.gnu.org/licenses/gpl.html
*
*/
 
class SimpleImage {
   
   var $image;
   var $image_type;
 
   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
		 header("Content-Type: image/jpeg");
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
		 header("Content-Type: image/GIF");
         imagegif($this->image);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
		 header("Content-Type: image/PNG");
         imagepng($this->image);
      }   
   }
   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   function resizePNG($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   
   
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   }      

  public function watermark($i, $options = array()) {
    // merge in the options
    $options = array_merge_recursive_distinct(
      (is_array($this->options['watermark'])) ? $this->options['watermark'] : array(),
      (is_array($options)) ? $options : array()
    );
    
    if (!file_exists($i)) {
      throw new Exception('Image::watermark: Missing watermark image \''.$i.'\'.');
    }
    
    $dest = $this->current;
    
    // load the watermark
    $watermark = new Image($i);
    
    // determine the offset
    if (!isset($options['offsetX']) || !isset($options['offsetY'])) {
      $offsetX = intval(($this->currentX / 2) - ($watermark->currentX / 2));
      $offsetY = intval(($this->currentY / 2) - ($watermark->currentY / 2));

    } else {
      $offsetX = $options['offsetX'];
      $offsetY = $options['offsetY'];
    }
    
    // overlay it
    if (!empty($options['repeatX']) && !empty($options['repeatY'])) {
      $offsetX = $offsetY = 0;
      
      // rows
      for ($i = $offsetY; $i < $this->currentY; $i += $watermark->y) {
        // cols
        for ($j = $offsetX; $j < $this->currentX; $j += $watermark->x) {
          if (!imagecopy($dest, $watermark->resource(), $j, $i, 0, 0, $watermark->x, $watermark->y)) {
            throw new Exception('Image::scale: Error watermarking image.');
          }
        }
      }
      
    } elseif (!empty($options['repeatX'])) {
      $offsetX = 0;
      
      for ($i = $offsetX; $i <= $this->currentX; $i += $watermark->x) {
        if (!imagecopy($dest, $watermark->resource(), $i, $offsetY, 0, 0, $watermark->x, $watermark->y)) {
          throw new Exception('Image::scale: Error watermarking image.');
        }
      }
      
    } elseif (!empty($options['repeatY'])) {
      $offsetY = 0;
      
      for ($i = $offsetY; $i <= $this->currentY; $i += $watermark->y) {
        if (!imagecopy($dest, $watermark->resource(), $offsetX, $i, 0, 0, $watermark->x, $watermark->y)) {
          throw new Exception('Image::scale: Error watermarking image.');
        }
      }
      
    } else {
      if (!imagecopy($dest, $watermark->resource(), $offsetX, $offsetY, 0, 0, $watermark->x, $watermark->y)) {
        throw new Exception('Image::scale: Error watermarking image.');
      }
    }

    $this->current = $dest;
    
    return $dest;
  }
  


}
?>