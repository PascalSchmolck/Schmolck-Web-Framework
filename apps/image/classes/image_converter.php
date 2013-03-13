<?php

//***************************************************************************
// schmolckCMS - PHP Content Management System
// Copyright (C) 2010 Pascal.Schmolck@Web.de
//***************************************************************************
// This file is part of schmolckCMS.
//
// schmolckCMS is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License 2 as published
// by the Free Software Foundation.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
//***************************************************************************

class IMAGE_CONVERTER{

    const EXPIRES = 2678400; // seconds

	public $file;		// string
	public $size;		// int
	public $quality;	// int
	public $cacheDir;	// string

//***************************************************************************
// *** PUBLIC

	public function getImage(){
		if(!file_exists($this->getMd5File())){
			$this->cacheImage();
		}
		$this->getCachedImage();
	}

//***************************************************************************
// *** PRIVATE

	private function getMd5File(){
		return $this->cacheDir.$this->getMd5FileName();
	}

	private function getMd5FileName(){
		return md5( $this->file.$this->size.$this->quality.filesize($this->file) );
	}

	private function cacheImage(){
		switch(exif_imagetype($this->file)){
			default:
			case IMAGETYPE_JPEG;
				$this->cacheImageJpeg();
				break;
			case IMAGETYPE_PNG;
				$this->cacheImagePng();
				break;
			case IMAGETYPE_GIF;
				$this->cacheImageGif();
				break;
		}
	}

	private function cacheImageJpeg(){
		$imageOld = ImageCreateFromJpeg($this->file);
		$oldWidth = ImagesX($imageOld);
		$oldHeight = ImagesY($imageOld);
		list($newWidth, $newHeight) = $this->getNewWidthAndHeight($oldWidth, $oldHeight);
		$imageNew = ImageCreateTrueColor($newWidth, $newHeight);
		ImageCopyResampled($imageNew, $imageOld, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);
		ImageJpeg($imageNew, $this->getMd5File(), $this->quality);
	}

	private function cacheImagePng(){
		$imageOld = ImageCreateFromPng($this->file);
		$oldWidth = ImagesX($imageOld);
		$oldHeight = ImagesY($imageOld);
		list($newWidth, $newHeight) = $this->getNewWidthAndHeight($oldWidth, $oldHeight);
		$imageNew = ImageCreateTrueColor($newWidth, $newHeight);
		ImageCopyResampled($imageNew, $imageOld, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);
		ImagePng($imageNew, $this->getMd5File());
	}

	private function cacheImageGif(){
		$imageOld = ImageCreateFromGif($this->file);
		$oldWidth = ImagesX($imageOld);
		$oldHeight = ImagesY($imageOld);
		list($newWidth, $newHeight) = $this->getNewWidthAndHeight($oldWidth, $oldHeight);
		$imageNew = ImageCreateTrueColor($newWidth, $newHeight);
		ImageCopyResampled($imageNew, $imageOld, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);
		ImageGif($imageNew, $this->getMd5File());
	}

 //***************************************************************************

	private function getNewWidthAndHeight($oldWidth, $oldHeight){
		if(!empty($this->size)){
			if($oldWidth > $oldHeight){
				$newHeight = intval(($this->size / $oldWidth) * $oldHeight);
				$newWidth = $this->size;
			}else{
				$newWidth = intval(($this->size / $oldHeight) * $oldWidth);
				$newHeight = $this->size;
			}
		}else{
			$newHeight = $oldHeight;
			$newWidth = $oldWidth;
		}
		return array($newWidth, $newHeight);
	}

	private function getCachedImage(){
		switch(exif_imagetype($this->file)){
			default:
			case IMAGETYPE_JPEG;
				$this->getCachedImageJpeg();
				break;
			case IMAGETYPE_PNG;
				$this->getCachedImagePng();
				break;
			case IMAGETYPE_GIF;
				$this->getCachedImageGif();
				break;
		}
	}

	private function getCachedImageJpeg(){
		header("Content-Type: image/jpeg");
        header("Pragma: public");
        header("Cache-Control: maxage=".IMAGE_CONVERTER::EXPIRES);
        header('Expires: ' . gmdate('D, d M Y H:i:s', time()+IMAGE_CONVERTER::EXPIRES) . ' GMT');
		ImageJpeg(ImageCreateFromJpeg($this->getMd5File()));
	}

	private function getCachedImagePng(){
		header("Content-Type: image/png");
        header("Pragma: public");
        header("Cache-Control: maxage=".IMAGE_CONVERTER::EXPIRES);
        header('Expires: ' . gmdate('D, d M Y H:i:s', time()+IMAGE_CONVERTER::EXPIRES) . ' GMT');	
		ImagePng(ImageCreateFromPng($this->getMd5File()));
	}

	private function getCachedImageGif(){
		header("Content-Type: image/gif");
        header("Pragma: public");
        header("Cache-Control: maxage=".IMAGE_CONVERTER::EXPIRES);
        header('Expires: ' . gmdate('D, d M Y H:i:s', time()+IMAGE_CONVERTER::EXPIRES) . ' GMT');	
		ImageGif(ImageCreateFromGif($this->getMd5File()));
	}

}
