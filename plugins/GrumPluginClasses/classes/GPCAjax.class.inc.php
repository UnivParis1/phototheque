<?php

/* -----------------------------------------------------------------------------
  class name     : GPCAjax
  class version  : 3.1.0
  plugin version : 3.5.2
  date           : 2012-06-19
  ------------------------------------------------------------------------------
  author: grum at piwigo.org
  << May the Little SpaceFrog be with you >>
  ------------------------------------------------------------------------------

  :: HISTORY

| release | date       |
| 3.0.0   | 2010/03/30 | * Update class & function names
|         |            |
| 3.1.0   | 2012/06/19 | * Check token request
|         |            |
|         |            |
|         |            |
|         |            |
|         |            |
|         |            |
|         |            |

  ------------------------------------------------------------------------------
    no constructor, only static function are provided
    - static function return_result($str)
   ---------------------------------------------------------------------- */

define('GPC_AJAX', 'ajaxfct');

class GPCAjax
{
  static public function returnResult($str)
  {
    //$chars=get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES);
    $chars['<']='<';
    $chars['>']='>';
    $chars['&']='&';
    exit(strtr($str, $chars));
  }

  /**
   * check if there's a valid token in $_REQUEST
   * if no, the GPC_AJAX call is set to empty value
   *
   * @param String $fct: the ajax function field (GPC_AJAX by default)
   * @param String $token: the token field ('token' by default) to check
   * @return Boolean: true if ok, otherwise false
   */
  static public function checkToken($fct=GPC_AJAX, $token='token')
  {
    if(!isset($_REQUEST[$token])) $_REQUEST[$token]='';
    if($fct!='' && !isset($_REQUEST[$fct])) $_REQUEST[$fct]='';

    if($_REQUEST[$token]==get_pwg_token()) return(true);

    if($fct!='') $_REQUEST[$fct]='';
    return(false);
  }
} //class

?>
