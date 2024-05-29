<?php
/* -----------------------------------------------------------------------------
  class name     : GPCCompress
  class version  : 1.0.0
  plugin version : 3.5.4
  date           : 2012-09-03
  ------------------------------------------------------------------------------
  author: grum at piwigo.org
  << May the Little SpaceFrog be with you >>
  ------------------------------------------------------------------------------

  :: HISTORY

| release | date       |
| 1.0.0   | 2012/09/03 | * New class
|         |            |
|         |            |
|         |            |
|         |            |

  ------------------------------------------------------------------------------
    no constructor, only static function are provided
    - static function availableMethods
    - static function gzip
    - static function gunzip
    - static function bzip2
    - static function bunzip2
   ---------------------------------------------------------------------- */

include_once('GPCCore.class.inc.php');
@include_once(GPCCore::getPiwigoSystemPath().'/admin/include/pclzip.lib.php');

class GPCCompress {

  /**
   * return an array of available methods for compression
   * current values are:
   *    'zip'  for zip files
   *    'gz'   for gzip files
   *    'bz2'  for bzip2 files
   *
   * @return Array
   */
  static public function availableMethods()
  {
    $returned=array();

    if(class_exists('PclZip')) $returned[]='zip';
    if(function_exists('gzopen')) $returned[]='gz';
    if(function_exists('bzopen')) $returned[]='bz2';

    return($returned);
  }

  /**
   * compress $fileName to $compressedFile in gz format
   *
   * @param String $fileName: source file to be compressed
   * @param String $compressedFile: destination file compressed
   * @param Integer $compressionLevel: level compression 0 (none) to 9 (high)
   * @return Boolean: true if Ok, otherwise false
   */
  static public function gzip($fileName, $compressedFile, $compressionLevel=6)
  {
    if(!function_exists('gzopen')) return(false);
    if(!file_exists($fileName)) return(false);
    if(file_exists($compressedFile)) unlink($compressedFile);
    if(file_exists($compressedFile)) return(false);

    $fHandleSrc=fopen($fileName, 'r');
    if($fHandleSrc)
    {
      $fHandleDest=gzopen($compressedFile, 'w'.$compressionLevel);

      if($fHandleDest)
      {
        while(!feof($fHandleSrc))
        {
          $fContent=fread($fHandleSrc, 1048576);
          gzwrite($fHandleDest, $fContent);
        }
        gzclose($fHandleDest);
        fclose($fHandleSrc);
        return(true);
      }
      fclose($fHandleSrc);
    }
    return(false);
  }


  /**
   * uncompress $fileName in gz format to $uncompressedFile
   *
   * @param String $fileName: source file be uncompressed (in gzformat)
   * @param String $uncompressedFile: destination file uncompressed
   * @return Boolean: true if Ok, otherwise false
   */
  static public function gunzip($fileName, $uncompressedFile)
  {
    if(!function_exists('gzopen')) return(false);
    if(!file_exists($fileName)) return(false);
    if(file_exists($uncompressedFile)) unlink($uncompressedFile);
    if(file_exists($uncompressedFile)) return(false);

    $fHandleSrc=gzopen($fileName, 'r');
    if($fHandleSrc)
    {
      $fHandleDest=fopen($uncompressedFile, 'w');

      if($fHandleDest)
      {
        while(!feof($fHandleSrc))
        {
          $fContent=gzread($fHandleSrc, 8192);
          fwrite($fHandleDest, $fContent);
        }
        fclose($fHandleDest);
        gzclose($fHandleSrc);
        return(true);
      }
      gzclose($fHandleSrc);
    }
    return(false);
  }


  /**
   * compress $fileName to $compressedFile in bz2 format
   *
   * @param String $fileName: source file to be compressed
   * @param String $compressedFile: destination file compressed
   * @return Boolean: true if Ok, otherwise false
   */
  static public function bzip2($fileName, $compressedFile)
  {
    if(!function_exists('bzopen')) return(false);
    if(!file_exists($fileName)) return(false);
    if(file_exists($compressedFile)) unlink($compressedFile);
    if(file_exists($compressedFile)) return(false);

    $fHandleSrc=fopen($fileName, 'r');
    if($fHandleSrc)
    {
      $fHandleDest=bzopen($compressedFile, 'w');

      if($fHandleDest)
      {
        while(!feof($fHandleSrc))
        {
          $fContent=fread($fHandleSrc, 8192);
          bzwrite($fHandleDest, $fContent);
        }
        bzclose($fHandleDest);
        fclose($fHandleSrc);
        return(true);
      }
      fclose($fHandleSrc);
    }
    return(false);
  }


  /**
   * uncompress $fileName in bz2 format to $uncompressedFile
   *
   * @param String $fileName: source file be uncompressed (in bz2 format)
   * @param String $uncompressedFile: destination file uncompressed
   * @return Boolean: true if Ok, otherwise false
   */
  static public function bunzip2($fileName, $uncompressedFile)
  {
    if(!function_exists('bzopen')) return(false);
    if(!file_exists($fileName)) return(false);
    if(file_exists($uncompressedFile)) unlink($uncompressedFile);
    if(file_exists($uncompressedFile)) return(false);

    $fHandleSrc=bzopen($fileName, 'r');
    if($fHandleSrc)
    {
      $fHandleDest=fopen($uncompressedFile, 'w');

      if($fHandleDest)
      {
        while(!feof($fHandleSrc))
        {
          $fContent=bzread($fHandleSrc, 8192);
          fwrite($fHandleDest, $fContent);
        }
        fclose($fHandleDest);
        bzclose($fHandleSrc);
        return(true);
      }
      bzclose($fHandleSrc);
    }
    return(false);
  }


  /**
   * Encapsulate the PclZip class for a simpler useage
   * compress $filesNames to $compressedFile in zip format
   *
   * @param Array $filesNames: source files to be compressed
   * @param String $compressedFile: destination file compressed
   * @param Integer $compressionLevel: level compression 0 (none) to 9 (high)
   * @return Boolean: true if Ok, otherwise false
   */
  static public function zip($filesNames, $compressedFile, $addedPath='', $removedPath='')
  {
    if(is_array($filesNames) and count($filesNames)==0) return(false);
    if(!is_array($filesNames) and !file_exists($filesNames)) return(false);
    if(file_exists($compressedFile)) unlink($compressedFile);
    if(file_exists($compressedFile)) return(false);

    if(!is_array($filesNames))
      $filesNames=array($filesNames);

    $files=array();
    foreach($filesNames as $file)
    {
      if(file_exists($file)) $files[]=$file;
    }

    if(count($filesNames)==0) return(false);

    $zipFile=new PclZip($compressedFile);
    $result=$zipFile->create($filesNames, $addedPath, $removedPath);
    if($result==0) return(false);
    return(true);
  }


  /**
   * Encapsulate the PclZip class for a simpler useage
   * uncompress $compressedFile in zip format to $destination
   *
   * @param String $fileName: source file be uncompressed (in zip format)
   * @param String $destination: destination file uncompressed
   * @return Boolean: true if Ok, otherwise false
   */
  static public function unzip($fileName, $destination)
  {
    if(!file_exists($fileName)) return(false);
    $zipFile=new PclZip($fileName);

    $result=$zipFile->extract($destination);
  }

}


?>