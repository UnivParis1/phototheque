<?php
/* -----------------------------------------------------------------------------
  class name     : GPCExport
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

Provided classes are:
 - GPCGenericExport: generic class, ancestor for all other class. Not to be used directly
 - GPCCSVExport: class for separated text (.csv) export
 - GPCODSExport: class for OpenDocument Spreadsheet (.ods) export
 - GPCSQLiteExport: class for SQLite (.db) export

GPCGenericExport methods:
  - public function __construct()
  - public function __destruct()
  - public function write()
  - public function setDefaultFormat()
  - public function setDefaultType
  - public function setColumnsDef()
  - public function getColumnsDef()
  - public function setOptions()
  - public function getOptions()
  - public function setFileName()
  - public function getFileName()
  - public function setFileDir()
  - public function getFileDir()
  - public function setFileMode()
  - public function getFileMode()

   ---------------------------------------------------------------------- */

include_once('GPCCore.class.inc.php');
include_once('External/odsPhpGenerator/ods.php');

/**
 * Generic class, provide generic functions for derivated classes
 */
class GPCGenericExport {
  protected $defaultFormat=array(
                'INTEGER' => '%d',
                'TEXT'    => '%s',
                'REAL'   => '%f'
              );
  protected $defaultType='TEXT';
  protected $fileName='';
  protected $fileDir='';
  protected $fileMode='w';
  protected $columnsDef=array();
  protected $options=array();

  public function __construct($file='')
  {
    if($file!='')
      $this->setFileName($file);
  }

  public function __destruct()
  {
  }

  /**
   * this methods have to be overrided to write the destination file
   *
   * @param Array $data: data to write
   * @return Boolean: true if file is written, otherwise false
   */
  public function write($data)
  {
  } //write

  /**
   * set the default format for the given type
   *
   * @param String $type: 'INTEGER', 'REAL', 'TEXT'
   * @param String $format: format to be applied (sprintf format)
   * @return Boolean: true if ok otherwise false
   */
  public function setDefaultFormat($type, $format)
  {
    $type=strtoupper($type);

    if($type=='INTEGER' or $type=='REAL' or $type=='TEXT')
    {
      $this->defaultFormat[$type]=$format;
      return(true);
    }
    return(false);
  } // setDefaultFormat

  /**
   * set the default type for file data
   *
   * @param String $type: 'INTEGER', 'REAL', 'TEXT'
   * @return String: the current default column type
   */
  public function setDefaultType($type)
  {
    $type=strtoupper($type);

    if($type=='INTEGER' or $type=='REAL' or $type=='TEXT')
    {
      $this->defaultType=$type;
    }
    return($this->defaultType);
  } // setDefaultType

  /**
   * set columns definition
   *  a definition is an array:
   *   'name'   => (String) Name of the column (mandatory)
   *   'type'   => (String) Type of column ('INTEGER', 'REAL', 'TEXT')
   *   'format' => (String) Format applied to the column (sprintf format)
   *
   *  if 'type' if not defined, the $defaultType will be used
   *  if 'format' if not defined, the $defaultFormat will be used
   *
   *  an empty array means to use default definition for the column
   *
   * @param Array $colsTypes: array of definition
   * @return Array: the current columns definition
   */
  public function setColumnsDef($columnsDef)
  {
    if(!is_array($columnsDef))
      return($this->colsTypes);

    $this->columnsDef=array();
    foreach($columnsDef as $colDef)
    {
      if(isset($colDef['name']))
      {
        $type=(isset($colDef['type']) and ($colDef['type']=='INTEGER' or $colDef['type']=='REAL' or $colDef['type']=='TEXT'))?$colDef['type']:$this->defaultType;
        $format=isset($colDef['format'])?$colDef['format']:$this->defaultFormat[$type];
        $this->columnsDef[]=array(
            'name' => $colDef['name'],
            'type' => $type,
            'format' => $format
          );
      }
    }
    return($this->columnsDef);
  } // setColumnsDef

  /**
   * get the current columns definition
   *
   * @return Array: the columns definition
   */
  public function getColumnsDef()
  {
    return($this->columnsDef);
  } // getColumnsDef

  /**
   * set options values; need to be overrided...
   *
   * @param Array $options: associative array of options
   * @return Array: current options
   */
  public function setOptions($options)
  {
    if(is_array($options))
      $this->options=$options;
    return($this->options);
  } // setOptions

  /**
   * get options values
   *
   * @param String $option: optional option key
   * @return Array: current options; if $option if set, return only the option value
   */
  public function getOptions($option=null)
  {
    if($option!=null and isset($this->options[$option]))
      return($this->options[$option]);
    return($this->options);
  } // getOptions


  /**
   * set the file name
   * if a directory is given in the filename, the $fileDir is overrided
   *
   * @param String $fileName: the file name
   * @return String: the current file name
   */
  public function setFileName($fileName)
  {
    $tmpDir=dirname($fileName);
    $tmpName=basename($fileName);
    if($tmpName!='')
      $this->fileName=$tmpName;
    if($tmpDir!='')
      $this->setFileDir($tmpDir);
    return($this->fileName);
  } // setFileName

  /**
   * get the file name
   *
   * @param Boolean $path: if true, return the file name with the complete path
   * @return String: the current file name
   */
  public function getFileName($path=false)
  {
    $returned=$this->fileName;
    if($path)
      $returned=$this->fileDir.'/'.$returned;
    return($returned);
  } // getFileName

  /**
   * set the file directory
   *
   * @param String $fileDir: the file directory
   * @return String: the current file directory
   */
  public function setFileDir($fileDir)
  {
    if($fileDir!='')
      $this->fileDir=$fileDir;
    if(substr($this->fileDir,-1)=='/')
      $this->fileDir=substr($this->fileDir,0,-1);
    return($this->fileDir);
  } // setFileDir

  /**
   * get the file directory
   *
   * @return String: the current file directory
   */
  public function getFileDir()
  {
    return($this->fileDir);
  } // getFileDir

  /**
   * set the file writting mode
   *  'a' => append data to existing file; if file doesn't exist, create it
   *  'w' => delete file if exists and create a new one
   *
   * @param String $mode: the file mode 'a' or 'w'
   * @return String: the current file mode
   */
  public function setFileMode($fileMode)
  {
    if($fileMode=='a' or $fileMode=='w')
      $this->fileMode=$fileMode;

    return($this->fileMode);
  } // setFileMode

  /**
   * get the file writting mode
   *
   * @return String: the current file mode
   */
  public function getFileMode()
  {
    return($this->fileMode);
  }
} // GPCGenericExport



/**
 * Class used to export data into CSV file
 */
class GPCCSVExport extends GPCGenericExport {
  protected $options=array(
                'separator' => ';',
                'decimalDot' => ',',
                'useQuotes' => false,
                'lineFeed' => "\x0A"
              );

  /**
   * set options values; need to be overrided...
   *
   * @param Array $options: associative array of options
   * @return Array: current options
   */
  public function setOptions($options)
  {
    if(!is_array($options))
      return($this->options);

    foreach($options as $option => $value)
    {
      switch($option)
      {
        case 'separator':
          if($value=='tab') $value=chr(9);
          $this->options[$option]=$value;
          break;
        case 'decimalDot':
          if($value=='.' or $value==',')
            $this->options[$option]=$value;
          break;
        case 'useQuotes':
          if($value==true or $value==false)
            $this->options[$option]=$value;
          break;
        case 'lineFeed':
          if($value=='unix')
          {
            $value="\x0A";
          }
          elseif($value=='windows')
          {
            $value="\x0D\x0A";
          }

          if($value=="\x0A" or $value=="\x0D\x0A")
            $this->options[$option]=$value;
          break;
      }
    }
    return($this->options);
  } // setOptions

  /**
   * write the CSV file
   *
   * @param Array $data: data to write
   * @return Boolean: true if file is written, otherwise false
   */
  public function write($data)
  {
    if(!is_array($data)) return(false);

    if(!file_exists($this->fileDir))
        mkdir($this->fileDir, 0755, true);

    $fHandle=fopen($this->getFileName(true), $this->fileMode);
    if($fHandle)
    {
      $fileContent='';
      // columns name
      $line=array();
      foreach($this->columnsDef as $column)
      {
        $value=$column['name'];
        if($this->options['useQuotes']) $value='"'.$value.'"';
        $line[]=$value;
      }
      $line=implode($this->options['separator'], $line).$this->options['lineFeed'];
      $fileContent.=$line;

      // rows
      foreach($data as $row)
      {
        $i=0;
        $line=array();
        foreach($row as $column)
        {
          $value='';
          switch($this->columnsDef[$i]['type'])
          {
            case 'INTEGER':
              $value=sprintf($this->columnsDef[$i]['format'], $column);
              break;
            case 'REAL':
              $value=sprintf($this->columnsDef[$i]['format'], $column);
              if($this->options['decimalDot']!='.')
                $value=str_replace('.', $this->options['decimalDot'], $value);
              break;
            case 'TEXT':
              $value=sprintf($this->columnsDef[$i]['format'], $column);
              if($this->options['useQuotes']) $value='"'.$value.'"';
              break;
          }
          $line[]=$value;
          $i++;
        }
        $line=implode($this->options['separator'], $line).$this->options['lineFeed'];
        $fileContent.=$line;
      }
      fwrite($fHandle, $fileContent);
      fclose($fHandle);
      return(true);
    }
    return(false);
  } //write

} // GPCCSVExport




/**
 * Class used to export data into ODS file
 */
class GPCODSExport extends GPCGenericExport {
  protected $options=array(
                'sheetName' => 'Sheet1',
                'fileTitle' => '',
                'fileSubject' => '',
                'keywords' => '',
                'comments' => ''
              );

  /**
   * set options values; need to be overrided...
   *
   * @param Array $options: associative array of options
   * @return Array: current options
   */
  public function setOptions($options)
  {
    if(!is_array($options))
      return($this->options);

    foreach($options as $option => $value)
    {
      switch($option)
      {
        case 'sheetName':
        case 'fileTitle':
        case 'fileSubject':
        case 'keywords':
        case 'comments':
          $this->options[$option]=$value;
          break;
      }
    }
    return($this->options);
  } // setOptions

  /**
   * write the ODS file
   *
   * @param Array $data: data to write
   * @return Boolean: true if file is written, otherwise false
   */
  public function write($data)
  {
    if(!is_array($data)) return(false);

    if(!file_exists($this->fileDir))
        mkdir($this->fileDir, 0755, true);

    // append mode will be managed later...
    if(file_exists($this->getFileName(true)))
      unlink($this->getFileName(true));

    $ods=new ods();

    $ods->setTitle($this->options['fileTitle']);
    $ods->setSubject($this->options['fileSubject']);
    $ods->setKeyword($this->options['keywords']);
    $ods->setDescription($this->options['comments']);

    $sheet=new odsTable($this->options['sheetName']);
    $sheet->setVerticalSplit(1);

    // columns name
    $headerStyle = new odsStyleTableCell();
    $headerStyle->setFontWeight('bold');
    $row=new odsTableRow();
    foreach($this->columnsDef as $column)
    {
      $row->addCell(new odsTableCellString($column['name'], $headerStyle));
    }
    $sheet->addRow($row);

    // rows
    $bodyStyle = new odsStyleTableCell();
    //$bodyStyle->setFontWeight('bold');
    foreach($data as $dataRow)
    {
      $i=0;
      $row=new odsTableRow();
      foreach($dataRow as $column)
      {
        switch($this->columnsDef[$i]['type'])
        {
          case 'INTEGER':
          case 'REAL':
            $cell=new odsTableCellFloat(1*sprintf($this->columnsDef[$i]['format'], $column), $bodyStyle);
            break;
          case 'TEXT':
            $cell=new odsTableCellString(sprintf($this->columnsDef[$i]['format'], $column), $bodyStyle);
            break;
          default:
            $cell=new odsTableCellEmpty();
            break;
        }
        $row->addCell($cell);
        $i++;
      }
      $sheet->addRow($row);
    }

    $ods->addTable($sheet);
    return($ods->genOdsFile($this->getFileName(true)));
  } //write

} // GPCODSExport






/**
 * Class used to export data into SQLite file
 */
class GPCSQLiteExport extends GPCGenericExport {
  protected $options=array(
                'tableName' => 'exported'
              );
  protected $dbHandle=null;

  /**
   * set options values; need to be overrided...
   *
   * @param Array $options: associative array of options
   * @return Array: current options
   */
  public function setOptions($options)
  {
    if(!is_array($options))
      return($this->options);

    foreach($options as $option => $value)
    {
      switch($option)
      {
        case 'tableName':
          $this->options[$option]=$value;
          break;
      }
    }
    return($this->options);
  } // setOptions

  /**
   * write the SQLite file
   *
   * @param Array $data: data to write
   * @return Boolean: true if file is written, otherwise false
   */
  public function write($data)
  {
    if(!is_array($data)) return(false);

    if(!file_exists($this->fileDir))
        mkdir($this->fileDir, 0755, true);


    if($this->createSQLiteFile($this->getFileName(true)))
    {
      $this->dbHandle->exec("BEGIN TRANSACTION");

      // rows
      foreach($data as $row)
      {
        $i=0;
        $line=array();
        foreach($row as $column)
        {
          $value='';
          switch($this->columnsDef[$i]['type'])
          {
            case 'INTEGER':
            case 'REAL':
              $value=sprintf($this->columnsDef[$i]['format'], $column);
              break;
            case 'TEXT':
              $value=sprintf("'".$this->columnsDef[$i]['format']."'", $this->dbHandle->escapeString($column));
              break;
          }
          $line[]=$value;
          $i++;
        }
        $sql="INSERT INTO ".$this->options['tableName']." VALUES (".implode(',', $line).");";
        $this->dbHandle->exec($sql);
      }
      $this->dbHandle->exec("COMMIT TRANSACTION");
      $this->closeSQLiteFile();
      return(true);
    }
    return(false);
  } //write

  /**
   * create the SQLite file and create the table
   *
   * @param String $fileName: SQLite file
   * @return Boolean: true if Ok, otherwise false
   */
  private function createSQLiteFile($file)
  {
    $this->dbHandle=new SQLite3($file, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);

    if($this->dbHandle)
    {
      $columns=array();
      foreach($this->columnsDef as $column)
      {
        $columns[]=" '".$column['name']."' ".$column['type'];
      }

      $sql="CREATE TABLE '".$this->options['tableName']."' (".implode(', ', $columns).");";
      $this->dbHandle->exec($sql);
      return(true);
    }
    $this->dbHandle=false;
    return(false);
  }

  /**
   * close the SQLite file
   */
  private function closeSQLiteFile()
  {
    if($this->dbHandle)
    {
      $this->dbHandle->close();
      $this->dbHandle=false;
    }
    return(true);
  }

} // GPCSQLiteExport



?>