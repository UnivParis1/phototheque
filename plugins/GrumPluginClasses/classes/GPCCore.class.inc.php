<?php

/* -----------------------------------------------------------------------------
  class name     : GPCCore
  class version  : 1.4.3
  plugin version : 3.5.4
  date           : 2012-07-27
  ------------------------------------------------------------------------------
  author: grum at piwigo.org
  << May the Little SpaceFrog be with you >>
  ------------------------------------------------------------------------------

  :: HISTORY

| release | date       |
| 1.0.0   | 2010/03/30 | * Update class & function names
|         |            |
| 1.1.0   | 2010/03/30 | * add the BBtoHTML function
|         |            |
| 1.2.0   | 2010/07/28 | * add the loadConfigFromFile function
|         |            |
| 1.3.0   | 2010/10/13 | * add the addHeaderCSS, addHeaderJS functions
|         |            |
| 1.3.1   | 2010/10/20 | * applyHeaderItems functions implemented with an
|         |            |   higher priority on the 'loc_begin_page_header' event
|         |            |
|         |            | * implement the getUserLanguageDesc() function, using
|         |            |   extended description function if present
|         |            |
|         |            | * implement the getPiwigoSystemPath() function
|         |            |
|         |            | * implement the rmDir() function
|         |            |
| 1.3.2   | 2011/01/28 | * implement the addUI() function
|         |            |
|         |            | * implement getMinified() & setMinifiedState() functions
|         |            |
| 1.3.3   | 2011/02/01 | * fix bug on loadConfig() function
|         |            |
|         |            | * update deleteConfig() function (allow to be used to
|         |            |   delete the GPCCore config)
|         |            |
|         |            | * mantis bug:2167
|         |            |
| 1.3.4   | 2011/02/02 | * mantis bug:2170
|         |            |   . File path for RBuilder registered plugins is corrupted
|         |            |
|         |            | * mantis bug:2178
|         |            |   . RBuilder register function don't work
|         |            |
|         |            | * mantis bug:2179
|         |            |   . JS file loaded in wrong order made incompatibility
|         |            |     with Lightbox, GMaps & ASE plugins (and probably other)
|         |            |
| 1.4.0   | 2011/04/10 | * Updated for piwigo 2.2
|         |            |
| 1.4.1   | 2011/09/19 | * Add [var] and [form_mail] markup interpreter
|         |            |
|         | 2012/05/25 | * Add GPCUserAgent class
|         |            |
|         |            | * Compatibility with jquery 1.7.2 & jquery-ui 1.8.16
|         |            |   . remove getMinified() & setMinifiedState() functions
|         |            |        (let piwigo combined function manage the minified
|         |            |         state)
|         |            |   . add manually each component for ui functionnalities
|         |            |
|         |            | * Remove google translate connector (google has changed the useage
|         |            |    and now an API key is needed)
|         |            |
|         |            | * Add js objects: inputDate, inputFilterBox, inputPages, inputSortBox, inputTag
|         |            |                   dynamicTable
|         |            |
|         |            | * AddHeaderCSS and AddJS are ignored if called in an ajax session (AJAX_CALL defined)
|         |            |
| 1.4.2   | 2012/07/27 | * AddHeaderContent can manage 'raw' content
|         |            |
| 1.4.3   | 2012/08/29 | * Add js objects: inputTreeList + inputExportBox + download
|         |            |
|         |            | * Update js objects: inputText (bug fix)
|         |            |
|         |            | * Add urlBuild function
|         |            |
|         |            |
|         |            |

  ------------------------------------------------------------------------------
    no constructor, only static function are provided
    - static function loadConfig
    - static function loadConfigFromFile
    - static function saveConfig
    - static function deleteConfig
    - static function getRegistered
    - static function getModulesInfos
    - static function register
    - static function unregister
    - static function BBtoHTML
    - static function VarToHTML
    - static function TabsToHTML
    - static function FormMailToHTML
    - static function addHeaderCSS
    - static function addHeaderJS
    - static function addUI
    - static function getUserLanguageDesc
    - static function getPiwigoSystemPath
    - static function formatOctet
    - static function rmDir
    - static function applyMarkups
    - static function setTemplateToken
    - static function addHeaderContent
    - static function urlBuild
   ---------------------------------------------------------------------- */



class GPCCore
{
  static private $piwigoSystemPath;

  static public $pluginName = "GPCCore";
  static protected $headerItems = array(
    'css' => array(),
    'js'  => array()
  );

  static public function init()
  {
    global $conf;

    self::$piwigoSystemPath=dirname(dirname(dirname(dirname(__FILE__))));

    if((isset($conf['gpc.markup.bb']) && $conf['gpc.markup.bb']) ||
       (isset($conf['gpc.markup.var']) && $conf['gpc.markup.var']) ||
       (isset($conf['gpc.markup.form']) && $conf['gpc.markup.form'])
      )
    {
      add_event_handler('render_category_name', array('GPCCore', 'applyMarkups'), EVENT_HANDLER_PRIORITY_NEUTRAL+5);
      add_event_handler('render_category_description', array('GPCCore', 'applyMarkups'), EVENT_HANDLER_PRIORITY_NEUTRAL+5, 2);
      add_event_handler('render_element_description', array('GPCCore', 'applyMarkups'), EVENT_HANDLER_PRIORITY_NEUTRAL+5);
      add_event_handler('AP_render_content', array('GPCCore', 'applyMarkups'), EVENT_HANDLER_PRIORITY_NEUTRAL+5);
    }
  }

  /* ---------------------------------------------------------------------------
   * grum plugin classes informations functions
   * -------------------------------------------------------------------------*/
  static public function getModulesInfos()
  {
    return(
      Array(
        Array('name' => "CommonPlugin", 'version' => "2.3.0"),
        Array('name' => "GPCAjax", 'version' => "3.1.0"),
        Array('name' => "GPCCategorySelector", 'version' => "1.0.1"),
        Array('name' => "GPCCompress", 'version' => "1.4.0"),
        Array('name' => "GPCCore", 'version' => "1.4.3"),
        //Array('name' => "GPCCss", 'version' => "3.1.0"),  removed with v1.4.1
        Array('name' => "GPCExport", 'version' => "1.0.0"),
        Array('name' => "GPCPagesNavigation", 'version' => "2.0.0"),
        Array('name' => "GPCPublicIntegration", 'version' => "2.0.0"),
        Array('name' => "GPCRequestBuilder", 'version' => "1.1.7"),
        Array('name' => "GPCTables", 'version' => "1.5.0"),
        Array('name' => "GPCTabSheet", 'version' => "1.1.2"),
        //Array('name' => "GPCTranslate", 'version' => "2.1.1"), doesn't exist anymore
        Array('name' => "GPCUserAgent", 'version' => "1.0.1"),
        Array('name' => "GPCUsersGroups", 'version' => "2.1.0")
      )
    );
  }


  /* ---------------------------------------------------------------------------
   * register oriented functions
   * -------------------------------------------------------------------------*/

  /**
   * register a plugin using GPC
   *
   * @param String $pluginName : the plugin name
   * @param String $release : the plugin version like "2.0.0"
   * @param String $GPCNeed : the minimal version of GPC needed by the plugin to
   *                          work
   * @return Boolean : true if registering is Ok, otherwise false
   */
  static public function register($plugin, $release, $GPCneeded)
  {
    $config=Array();
    if(!self::loadConfig(self::$pluginName, $config))
    {
      $config['registered']=array();
    }

    $config['registered'][$plugin]=Array(
      'name' => $plugin,
      'release' => $release,
      'needed' => $GPCneeded,
      'date' => date("Y-m-d"),
    );
    return(self::saveConfig(self::$pluginName, $config));
  }

  /**
   * unregister a plugin using GPC
   *
   * assume that if the plugin was not registerd before, unregistering returns
   * a true value
   *
   * @param String $pluginName : the plugin name
   * @return Boolean : true if registering is Ok, otherwise false
   */
  static public function unregister($plugin)
  {
    $config=Array();
    if(self::loadConfig(self::$pluginName, $config))
    {
      if(array_key_exists('registered', $config))
      {
        if(array_key_exists($plugin, $config['registered']))
        {
          unset($config['registered'][$plugin]);
          return(self::saveConfig(self::$pluginName, $config));
        }
      }
    }
    // assume if the plugin was not registered before, unregistering it is OK
    return(true);
  }

  /**
   * return the list of registered plugins
   * @return Array : list of registered plugins
   */
  static public function getRegistered()
  {
    $config=Array();
    if(self::loadConfig(self::$pluginName, $config))
    {
      if(array_key_exists('registered', $config))
      {
        return($config['registered']);
      }
    }
    return(Array());
  }



  /* ---------------------------------------------------------------------------
   * config oriented functions
   * -------------------------------------------------------------------------*/

  /**
   *  load config from CONFIG_TABLE into an array
   *
   * @param String $pluginName : the plugin name, must contain only alphanumerical
   *                             character
   * @param Array $config : array, initialized or not with default values ; the
   *                        config values are loaded in this value
   * @return Boolean : true if config is loaded, otherwise false
   */
  static public function loadConfig($pluginName, &$config=Array())
  {
    global $conf;

    if(!isset($conf[$pluginName.'_config']))
    {
      return(false);
    }

    $configValues = unserialize($conf[$pluginName.'_config']);
    reset($configValues);
    foreach ($configValues as $key => $val)
    {
      if(is_array($val))
      {
        foreach($val as $key2 => $val2)
        {
          $config[$key][$key2]=$val2;

          if(isset($conf['plugin.'.$pluginName]) and isset($conf['plugin.'.$pluginName][$key]) and isset($conf['plugin.'.$pluginName][$key][$key2]))
              $config[$key][$key2]=$conf['plugin.'.$pluginName][$key][$key2];
        }
      }
      else
      {
        $config[$key]=$val;
        if(isset($conf['plugin.'.$pluginName]) and isset($conf['plugin.'.$pluginName][$key]))
            $config[$key]=$conf['plugin.'.$pluginName][$key];
      }
    }

    $conf[$pluginName.'_config']=serialize($config);

    return(true);
  }

  /**
   *  load config from a file into an array
   *
   *  note : the config file is a PHP file one var $conf used as an array,
   *  like the piwigo $conf var
   *
   * @param String $fileName : the file name
   * @param Array $config : array, initialized or not with default values ; the
   *                        config values are loaded in this value
   * @return Boolean : true if config is loaded, otherwise false
   */
  static public function loadConfigFromFile($fileName, &$config=Array())
  {
    $conf=array();

    if(!is_array($config) or !file_exists($fileName))
    {
      return(false);
    }

    include_once($fileName);

    foreach($conf as $key=>$val)
    {
      $config[$key]=$val;
    }
    return(true);
  }


  /**
   * save var $my_config into CONFIG_TABLE
   *
   * @param String $pluginName : the plugin name, must contain only alphanumerical
   *                             character
   * @param Array $config : array of configuration values
   * @return Boolean : true if config is saved, otherwise false
   */
  static public function saveConfig($pluginName, $config)
  {
    global $conf;

    $sql="REPLACE INTO ".CONFIG_TABLE."
           VALUES('".$pluginName."_config', '"
           .pwg_db_real_escape_string(serialize($config))."', '')";
    $result=pwg_query($sql);
    if($result)
    {
      $conf[$pluginName.'_config']=serialize($config);
      return true;
    }
    else
    {
      return false;
    }
  }

  /**
   * delete config from CONFIG_TABLE
   *
   * @param String $pluginName : the plugin name, must contain only alphanumerical
   *                             character ; if empty, assume GPCCore config
   * @return Boolean : true if config is deleted, otherwise false
   */
  static public function deleteConfig($pluginName='')
  {
    if($pluginName=='') $pluginName=self::$pluginName;
    $sql="DELETE FROM ".CONFIG_TABLE."
          WHERE param='".$pluginName."_config'";
    $result=pwg_query($sql);
    if($result)
    { return true; }
    else
    { return false; }
  }


  /**
   * convert (light) BB tag to HTML tag
   *
   * all BB codes are not recognized, only :
   *  - [ul] [/ul]
   *  - [li] [/li]
   *  - [b] [/b]
   *  - [i] [/i]
   *  - [url] [/url]
   *  - carriage return is replaced by a <br>
   *
   * @param String $text : text to convert
   * @return String : BB to HTML text
   */
  static public function BBtoHTML($text)
  {
    $patterns = Array(
      '/\[li\](.*?)\[\/li\]\n*/im',
      '/\[b\](.*?)\[\/b\]/ism',
      '/\[i\](.*?)\[\/i\]/ism',
      '/\[p\](.*?)\[\/p\]/ism',
      '/\[url\]([\w]+?:\/\/[^ \"\n\r\t<]*?)\[\/url\]/ism',
      '/\[url=([\w]+?:\/\/[^ \"\n\r\t<]*?)\](.*?)\[\/url\]/ism',
      '/\n{0,1}\[ul\]\n{0,1}/im',
      '/\n{0,1}\[\/ul\]\n{0,1}/im',
      '/\n{0,1}\[ol\]\n{0,1}/im',
      '/\n{0,1}\[\/ol\]\n{0,1}/im',
      '/\n/im',
    );
    $replacements = Array(
      '<li>\1</li>',
      '<b>\1</b>',
      '<i>\1</i>',
      '<p>\1</p>',
      '<a href="\1">\1</a>',
      '<a href="\1">\2</a>',
      '<ul>',
      '</ul>',
      '<ol>',
      '</ol>',
      '<br>',
    );

    return(preg_replace($patterns, $replacements, $text));
  }

  /**
   * apply [var] tag
   *
   * [var=<name>]
   * with <name> :
   *  - USER
   *  - GALLERY_TITLE
   *  - NB_PHOTOS
   *  - CATEGORY
   *  - TOKEN
   *  - IP
   *
   * @param String $text : text to convert
   * @return String : processed text
   */
  static public function VarToHTML($text)
  {
    global $user, $page, $conf;

    $patterns = Array(
      '/\[var=user\]/im',
      '/\[var=gallery_title\]/im',
      '/\[var=nb_photos\]/im',
      '/\[var=category\]/im',
      '/\[var=token\]/im',
      '/\[var=ip\]/im'
    );
    $replacements = Array(
      isset($user['username'])?$user['username']:'',
      isset($conf['gallery_title'])?$conf['gallery_title']:'',
      isset($user['nb_total_images'])?$user['nb_total_images']:'',
      isset($page['category']['name'])?$page['category']['name']:'',
      get_pwg_token(),
      $_SERVER['REMOTE_ADDR']
    );

    return(preg_replace($patterns, $replacements, $text));
  }

  /**
   * apply [form_mail] tag
   *
   * @param String $text : text to convert
   * @return String : processed text
   */
  static public function FormMailToHTML($text)
  {
    global $template;

    $file=GPCCore::getPiwigoSystemPath().'/'.PWG_LOCAL_DIR.'templates/GPCFormMsg.tpl';
    if(!file_exists($file)) $file=dirname(dirname(__FILE__))."/templates/GPCFormMsg.tpl";

    $template->set_filename('gpc_form', $file);

    $template->assign('token', get_pwg_token() );

    $patterns = Array(
      '/\[form_mail\]/im'
    );
    $replacements = Array(
      $template->parse('gpc_form', true)
    );

    if(preg_match($patterns[0], $text)>0)
    {
      GPCCore::addHeaderJS('gpc.markup.formMail', GPC_PATH.'js/markup.formMail.js', array('jquery'));
      return(preg_replace($patterns, $replacements, $text));
    }
    return($text);
  }

  /**
   * apply [tab], [/tab] and [tabs] tags
   *
   * @param String $text : text to convert
   * @return String : processed text
   */
  static public function TabsToHTML($text)
  {
    $result=array();

    $tabs='';
    if(preg_match_all('/\[tab=([^(;\]).]*)(?:;(default))?;([^\].]*)\]/im', $text, $result, PREG_SET_ORDER)>0)
    {
      foreach($result as $val)
      {
        $tabs.="<li class='gpcTabSeparator'><a id='iGpcTab".$val[1]."' class='".($val[2]=='default'?'gpcTabSelected':'gpcTabNotSelected')."' tabId='#iGpcTabContent".$val[1]."'>".$val[3]."</a></li>";
      }
      $tabs="<div id='iGpcTabs'><ul>".$tabs."</ul></div>";
    }
    else return($text);

    $patterns = Array(
      '/\[tabs\]/im',
      '/\[tab=([^(;\]).]*)(?!;default);.*\]/im',
      '/\[tab=([^(;\]).]*);default;(.*)\]/im',
      '/\[\/tab\]/im'
    );
    $replacements = Array(
      $tabs,
      '<div id="iGpcTabContent\1" class="gpcTabContent" style="display:none;">',
      '<div id="iGpcTabContent\1" class="gpcTabContent">',
      '</div>'
    );

    if(preg_match($patterns[0], $text)>0)
    {
      GPCCore::addHeaderJS('gpc.markup.tabs', GPC_PATH.'js/markup.tabs.js', array('jquery'));
      GPCCore::addHeaderCSS('gpc.markup.tabs', GPC_PATH.'css/gpcTabs.css');
      return(preg_replace($patterns, $replacements, $text));
    }
    return($text);
  }

  /**
   * analyze and replace markups by their value, according to $conf parameted
   * @param String $text: text to analyze
   * @return String: analyzed text
   */
  static public function applyMarkups($text)
  {
    global $conf;

    if(isset($conf['gpc.markup.form']) && $conf['gpc.markup.form'])
    {
      $text=GPCCore::FormMailToHTML($text);
    }

    if(isset($conf['gpc.markup.tabs']) && $conf['gpc.markup.tabs'])
    {
      $text=GPCCore::TabsToHTML($text);
    }

    if(isset($conf['gpc.markup.var']) && $conf['gpc.markup.var'])
    {
      $text=GPCCore::VarToHTML($text);
    }

    if(isset($conf['gpc.markup.bb']) && $conf['gpc.markup.bb'])
    {
      $text=GPCCore::BBtoHTML($text);
    }


    return($text);
  }

  /**
   * used to add a js or css directly in the header
   * use 'raw' type to add any raw data in the header
   *
   * @param String $id : a unique id for the file
   * @param String $file : the css file
   * @param String $order: priority
   */
  static public function addHeaderContent($type, $content)
  {
    global $template;
    $null=null;

    if(defined('AJAX_CALL')) return(false); // not needed for an ajax call

    switch($type)
    {
      case 'css':
        $template->block_html_style(null, $content, $null, $null);
        break;
      case 'js':
        $template->block_html_head(null, '<script type="text/javascript">'.$content.'</script>', $null, $null);
        break;
      case 'raw':
        $template->block_html_head(null, $content);
        break;
    }
  }

  /**
   * used to add a css file in the header
   *
   * @param String $id : a unique id for the file
   * @param String $file : the css file
   * @param String $order: priority
   */
  static public function addHeaderCSS($id, $file, $order=0)
  {
    global $template;

    if(defined('AJAX_CALL')) return(false); // no CSS needed for an ajax call
    if(!array_key_exists($id, self::$headerItems['css']) and file_exists($file))
    {
      self::$headerItems['css'][$id]=$file;
      $template->func_combine_css(array('path'=>$file, 'order'=>$order), $template->smarty);
    }
  }

  /**
   * used to add a js file in the header
   *
   * @param String $id : a unique id for the file
   * @param String $file : the js file
   * @param Array $require : list of required files
   */
  static public function addHeaderJS($id, $file, $require=array())
  {
    global $template;

    if(defined('AJAX_CALL')) return(false); // no JS needed for an ajax call
    if(!array_key_exists($id, self::$headerItems['js']) and file_exists($file))
    {
      self::$headerItems['js'][$id]=$file;
      $template->scriptLoader->add($id, 0, $require, $file, 0);
    }
  }

  /**
   * add a ui component ; css & js dependencies are managed
   *
   * @param Array $list : possibles values are
   *                        - categorySelector
   *                        - dynamicTable
   *                        - inputCheckbox
   *                        - inputColorPicker
   *                        - inputColorsFB
   *                        - inputConsole
   *                        - inputDate
   *                        - inputDotArea
   *                        - inputFilterBox
   *                        - inputList
   *                        - inputNum
   *                        - inputPosition
   *                        - inputRadio
   *                        - inputSortBox
   *                        - inputStatusBar
   *                        - inputTag
   *                        - inputText
   */
  static public function addUI($list)
  {
    global $template, $lang_info;

    if(is_string($list)) $list=explode(',', $list);
    if(!is_array($list)) return(false);

    if(defined('IN_ADMIN'))
    {
      $themeFile=GPC_PATH.'css/%s_'.$template->get_themeconf('name').'.css';
    }
    else
    {
      $themeFile='themes/'.$template->get_themeconf('name').'/css/GPC%s.css';
    }

    foreach($list as $ui)
    {
      switch($ui)
      {
        case 'gpcCSS':
          $fileName='./plugins/'.basename(dirname(dirname(__FILE__))).'/css/gpc';
          self::addHeaderCSS('gpc.css', $fileName.'.css', 10);
          self::addHeaderCSS('gpc.cssT', $fileName.'_'.$template->get_themeconf('name').'.css', 15);
          break;
        case 'canvasDraw.graph':
          self::addHeaderCSS('gpc.canvasDraw', GPC_PATH.'css/canvasDraw.css');
          self::addHeaderCSS('gpc.canvasDrawT', sprintf($themeFile, 'canvasDraw'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('jquery.ui.mouse', 'themes/default/js/ui/jquery.ui.mouse.js', array('jquery.ui.widget'));
          self::addHeaderJS('gpc.canvasDraw.commonClasses', GPC_PATH.'js/CanvasDraw.CommonClasses.js', array('jquery.ui.widget'));
          self::addHeaderJS('gpc.canvasDraw.graphClasses', GPC_PATH.'js/CanvasDraw.GraphClasses.js', array('gpc.canvasDraw.commonClasses'));
          self::addHeaderJS('gpc.canvasDraw.drawing', GPC_PATH.'js/CanvasDraw.Drawing.js', array('gpc.canvasDraw.graphClasses'));
          self::addHeaderJS('gpc.canvasDraw', GPC_PATH.'js/canvasDraw.js', array('gpc.canvasDraw.drawing'));
          self::addHeaderJS('gpc.canvasDraw.drawingGraph', GPC_PATH.'js/canvasDraw.ui.drawingGraph.js', array('gpc.canvasDraw'));
          break;
        case 'categorySelector':
          self::addHeaderCSS('gpc.categorySelector', GPC_PATH.'css/categorySelector.css');
          self::addHeaderCSS('gpc.categorySelectorT', sprintf($themeFile, 'categorySelector'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('jquery.ui.mouse', 'themes/default/js/ui/jquery.ui.mouse.js', array('jquery.ui.widget'));
          self::addHeaderJS('gpc.categorySelector', GPC_PATH.'js/ui.categorySelector.js', array('jquery.ui.widget'));
          break;
        case 'inputCheckbox':
          self::addHeaderCSS('gpc.inputCheckbox', GPC_PATH.'css/inputCheckbox.css');
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('gpc.inputCheckbox', GPC_PATH.'js/ui.inputCheckbox.js', array('jquery.ui'));
          break;
        case 'inputColorPicker':
          self::addHeaderCSS('gpc.inputText', GPC_PATH.'css/inputText.css');
          self::addHeaderCSS('gpc.inputNum', GPC_PATH.'css/inputNum.css');
          self::addHeaderCSS('gpc.inputColorsFB', GPC_PATH.'css/inputColorsFB.css');
          self::addHeaderCSS('gpc.inputDotArea', GPC_PATH.'css/inputDotArea.css');
          self::addHeaderCSS('gpc.inputColorPicker', GPC_PATH.'css/inputColorPicker.css');
          self::addHeaderCSS('gpc.inputTextT', sprintf($themeFile, 'inputText'));
          self::addHeaderCSS('gpc.inputNumT', sprintf($themeFile, 'inputNum'));
          self::addHeaderCSS('gpc.inputColorsFBT', sprintf($themeFile, 'inputColorsFB'));
          self::addHeaderCSS('gpc.inputDotAreaT', sprintf($themeFile, 'inputDotArea'));
          self::addHeaderCSS('gpc.inputColorPickerT', sprintf($themeFile, 'inputColorPicker'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('jquery.ui.mouse', 'themes/default/js/ui/jquery.ui.mouse.js', array('jquery.ui.widget'));
          self::addHeaderJS('jquery.ui.position', 'themes/default/js/ui/jquery.ui.position.js', array('jquery.ui.widget'));
          self::addHeaderJS('jquery.ui.draggable', 'themes/default/js/ui/jquery.ui.draggable.js', array('jquery.ui.widget'));
          self::addHeaderJS('jquery.ui.dialog', 'themes/default/js/ui/jquery.ui.dialog.js', array('jquery.ui.widget'));
          self::addHeaderJS('jquery.ui.slider', 'themes/default/js/ui/jquery.ui.slider.js', array('jquery.ui.widget'));
          self::addHeaderJS('gpc.inputText', GPC_PATH.'js/ui.inputText.js', array('jquery.ui.widget'));
          self::addHeaderJS('gpc.inputNum', GPC_PATH.'js/ui.inputNum.js', array('jquery.ui.widget'));
          self::addHeaderJS('gpc.inputColorsFB', GPC_PATH.'js/ui.inputColorsFB.js', array('jquery.ui.widget'));
          self::addHeaderJS('gpc.inputDotArea', GPC_PATH.'js/ui.inputDotArea.js', array('jquery.ui.widget'));
          self::addHeaderJS('gpc.inputColorPicker', GPC_PATH.'js/ui.inputColorPicker.js', array('jquery.ui.slider','gpc.inputText','gpc.inputNum','gpc.inputColorsFB','gpc.inputDotArea'));
          break;
        case 'inputColorsFB':
          self::addHeaderCSS('gpc.inputColorsFB', GPC_PATH.'css/inputColorsFB.css');
          self::addHeaderCSS('gpc.inputColorsFBT', sprintf($themeFile, 'inputColorsFB'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('gpc.inputColorsFB', GPC_PATH.'js/ui.inputColorsFB.js', array('jquery.ui.widget'));
          break;
        case 'inputConsole':
          self::addHeaderCSS('gpc.inputConsole', GPC_PATH.'css/inputConsole.css');
          self::addHeaderCSS('gpc.inputConsoleT', sprintf($themeFile, 'inputConsole'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('gpc.inputConsole', GPC_PATH.'js/ui.inputConsole.js', array('jquery.ui.widget'));
          break;
        case 'inputDate':
          self::addHeaderCSS('jquery.ui.datepicker', 'themes/default/js/ui/theme/jquery.ui.datepicker.css');
          self::addHeaderCSS('gpc.inputDate', GPC_PATH.'css/inputDate.css');
          self::addHeaderCSS('gpc.inputDateT', sprintf($themeFile, 'inputDate'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget',     'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('jquery.ui.datepicker', 'themes/default/js/ui/jquery.ui.datepicker.js', array('jquery.ui.widget'));
          self::addHeaderJS('jquery.ui.datepicker-'.$lang_info['code'], self::getPiwigoSystemPath().'themes/default/js/ui/i18n/jquery.ui.datepicker-'.$lang_info['code'].'.js');
          self::addHeaderJS('gpc.inputDate', GPC_PATH.'js/ui.inputDate.js', array('jquery.ui.widget'));
          break;
        case 'inputDotArea':
          self::addHeaderCSS('gpc.inputDotArea', GPC_PATH.'css/inputDotArea.css');
          self::addHeaderCSS('gpc.inputDotAreaT', sprintf($themeFile, 'inputDotArea'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('gpc.inputDotArea', GPC_PATH.'js/ui.inputDotArea.js', array('jquery.ui.widget'));
          break;
        case 'inputExportBox':
          self::addHeaderCSS('gpc.inputText', GPC_PATH.'css/inputText.css');
          self::addHeaderCSS('gpc.inputTextT', sprintf($themeFile, 'inputText'));
          self::addHeaderCSS('gpc.inputList', GPC_PATH.'css/inputList.css');
          self::addHeaderCSS('gpc.inputListT', sprintf($themeFile, 'inputList'));
          self::addHeaderCSS('gpc.inputExportBox', GPC_PATH.'css/inputExportBox.css');
          self::addHeaderCSS('gpc.inputExportBoxT', sprintf($themeFile, 'inputExportBox'));

          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));

          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('jquery.ui.mouse', 'themes/default/js/ui/jquery.ui.mouse.js', array('jquery.ui.widget'));
          self::addHeaderJS('jquery.ui.position', 'themes/default/js/ui/jquery.ui.position.js', array('jquery.ui.mouse'));
          self::addHeaderJS('jquery.ui.resizable', 'themes/default/js/ui/jquery.ui.resizable.js', array('jquery.ui.position'));
          self::addHeaderJS('jquery.ui.draggable', 'themes/default/js/ui/jquery.ui.draggable.js', array('jquery.ui.resizable'));
          self::addHeaderJS('jquery.ui.sortable', 'themes/default/js/ui/jquery.ui.sortable.js', array('jquery.ui.draggable'));
          self::addHeaderJS('jquery.ui.dialog', 'themes/default/js/ui/jquery.ui.dialog.js', array('jquery.ui.sortable'));

          self::addHeaderJS('gpc.inputText', GPC_PATH.'js/ui.inputText.js', array('jquery.ui.dialog'));
          self::addHeaderJS('gpc.inputList', GPC_PATH.'js/ui.inputList.js', array('jquery.ui.dialog'));
          self::addHeaderJS('gpc.inputExportBox', GPC_PATH.'js/ui.inputExportBox.js', array('jquery.ui.dialog'));
          break;
        case 'inputFilterBox':
          self::addHeaderCSS('jquery.ui.datepicker', 'themes/default/js/ui/theme/jquery.ui.datepicker.css');
          self::addHeaderCSS('gpc.inputNum', GPC_PATH.'css/inputNum.css');
          self::addHeaderCSS('gpc.inputNumT', sprintf($themeFile, 'inputNum'));
          self::addHeaderCSS('gpc.inputDate', GPC_PATH.'css/inputDate.css');
          self::addHeaderCSS('gpc.inputDateT', sprintf($themeFile, 'inputDate'));
          self::addHeaderCSS('gpc.inputText', GPC_PATH.'css/inputText.css');
          self::addHeaderCSS('gpc.inputTextT', sprintf($themeFile, 'inputText'));
          self::addHeaderCSS('gpc.inputList', GPC_PATH.'css/inputList.css');
          self::addHeaderCSS('gpc.inputListT', sprintf($themeFile, 'inputList'));
          self::addHeaderCSS('gpc.inputFilterBox', GPC_PATH.'css/inputFilterBox.css');
          self::addHeaderCSS('gpc.inputFilterBoxT', sprintf($themeFile, 'inputFilterBox'));

          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));

          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('jquery.ui.mouse', 'themes/default/js/ui/jquery.ui.mouse.js', array('jquery.ui.widget'));
          self::addHeaderJS('jquery.ui.position', 'themes/default/js/ui/jquery.ui.position.js', array('jquery.ui.mouse'));
          self::addHeaderJS('jquery.ui.resizable', 'themes/default/js/ui/jquery.ui.resizable.js', array('jquery.ui.position'));
          self::addHeaderJS('jquery.ui.draggable', 'themes/default/js/ui/jquery.ui.draggable.js', array('jquery.ui.resizable'));
          self::addHeaderJS('jquery.ui.sortable', 'themes/default/js/ui/jquery.ui.sortable.js', array('jquery.ui.draggable'));
          self::addHeaderJS('jquery.ui.dialog', 'themes/default/js/ui/jquery.ui.dialog.js', array('jquery.ui.sortable'));
          self::addHeaderJS('jquery.ui.datepicker', 'themes/default/js/ui/jquery.ui.datepicker.js', array('jquery.ui.widget'));
          self::addHeaderJS('jquery.ui.datepicker-'.$lang_info['code'], self::getPiwigoSystemPath().'themes/default/js/ui/i18n/jquery.ui.datepicker-'.$lang_info['code'].'.js');

          self::addHeaderJS('gpc.inputNum', GPC_PATH.'js/ui.inputNum.js', array('jquery.ui.dialog'));
          self::addHeaderJS('gpc.inputList', GPC_PATH.'js/ui.inputList.js', array('jquery.ui.dialog'));
          self::addHeaderJS('gpc.inputText', GPC_PATH.'js/ui.inputText.js', array('jquery.ui.dialog'));
          self::addHeaderJS('gpc.inputDate', GPC_PATH.'js/ui.inputDate.js', array('jquery.ui.dialog'));
          self::addHeaderJS('gpc.inputFilterBox', GPC_PATH.'js/ui.inputFilterBox.js', array('jquery.ui.dialog'));
          break;
        case 'inputList':
          self::addHeaderCSS('gpc.inputList', GPC_PATH.'css/inputList.css');
          self::addHeaderCSS('gpc.inputListT', sprintf($themeFile, 'inputList'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('jquery.ui.button', 'themes/default/js/ui/jquery.ui.button.js', array('jquery.ui'));
          self::addHeaderJS('gpc.inputList', GPC_PATH.'js/ui.inputList.js', array('jquery.ui.widget'));
          break;
        case 'inputNum':
          self::addHeaderCSS('gpc.inputNum', GPC_PATH.'css/inputNum.css');
          self::addHeaderCSS('gpc.inputNumT', sprintf($themeFile, 'inputNum'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('jquery.ui.mouse', 'themes/default/js/ui/jquery.ui.mouse.js', array('jquery.ui.widget'));
          self::addHeaderJS('jquery.ui.slider', 'themes/default/js/ui/jquery.ui.slider.js', array('jquery.ui.widget'));
          self::addHeaderJS('gpc.inputNum', GPC_PATH.'js/ui.inputNum.js', array('jquery','jquery.ui.slider'));
          break;
        case 'inputPages':
          self::addHeaderCSS('gpc.inputPages', GPC_PATH.'css/inputPages.css');
          self::addHeaderCSS('gpc.inputPagesT', sprintf($themeFile, 'inputPages'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('gpc.inputPages', GPC_PATH.'js/ui.inputPages.js', array('jquery','jquery.ui.widget'));
          break;
        case 'inputPath':
          self::addHeaderCSS('gpc.inputPath', GPC_PATH.'css/inputPath.css');
          self::addHeaderCSS('gpc.inputPathT', sprintf($themeFile, 'inputPath'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('gpc.inputPath', GPC_PATH.'js/ui.inputPath.js', array('jquery','jquery.ui.widget'));
          break;
        case 'inputPosition':
          self::addHeaderCSS('gpc.inputPosition', GPC_PATH.'css/inputPosition.css');
          self::addHeaderCSS('gpc.inputPositionT', sprintf($themeFile, 'inputPosition'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('gpc.inputPosition', GPC_PATH.'js/ui.inputPosition.js', array('jquery.ui.widget'));
          break;
        case 'inputRadio':
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('gpc.inputRadio', GPC_PATH.'js/ui.inputRadio.js', array('jquery.ui.widget'));
          break;
        case 'inputSortBox':
          self::addHeaderCSS('gpc.inputSortBox', GPC_PATH.'css/inputSortBox.css');
          self::addHeaderCSS('gpc.inputSortBoxT', sprintf($themeFile, 'inputSortBox'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('jquery.ui.mouse', 'themes/default/js/ui/jquery.ui.mouse.js', array('jquery.ui.widget'));
          self::addHeaderJS('jquery.ui.position', 'themes/default/js/ui/jquery.ui.position.js', array('jquery.ui.mouse'));
          self::addHeaderJS('jquery.ui.draggable', 'themes/default/js/ui/jquery.ui.draggable.js', array('jquery.ui.position'));
          self::addHeaderJS('jquery.ui.sortable', 'themes/default/js/ui/jquery.ui.sortable.js', array('jquery.ui.draggable'));
          self::addHeaderJS('jquery.ui.dialog', 'themes/default/js/ui/jquery.ui.dialog.js', array('jquery.ui.sortable'));
          self::addHeaderJS('gpc.inputSortBox', GPC_PATH.'js/ui.inputSortBox.js', array('jquery.ui.dialog'));
          break;
        case 'inputStatusBar':
          self::addHeaderCSS('gpc.inputStatusBar', GPC_PATH.'css/inputStatusBar.css');
          self::addHeaderCSS('gpc.inputStatusBarT', sprintf($themeFile, 'inputStatusBar'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('gpc.inputStatusBar', GPC_PATH.'js/ui.inputStatusBar.js', array('jquery.ui.widget'));
          break;
        case 'inputSwitchButton':
          self::addHeaderCSS('gpc.inputSwitchButton', GPC_PATH.'css/inputSwitchButton.css');
          self::addHeaderCSS('gpc.inputSwitchButtonT', sprintf($themeFile, 'inputSwitchButton'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('gpc.inputSwitchButton', GPC_PATH.'js/ui.inputSwitchButton.js', array('jquery.ui.widget'));
          break;
        case 'inputTag':
          self::addHeaderCSS('gpc.inputTag', GPC_PATH.'css/inputTag.css');
          self::addHeaderCSS('gpc.inputTagT', sprintf($themeFile, 'inputTag'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('gpc.inputTag', GPC_PATH.'js/ui.inputTag.js', array('jquery.ui.widget'));
          break;
        case 'inputText':
          self::addHeaderCSS('gpc.inputText', GPC_PATH.'css/inputText.css');
          self::addHeaderCSS('gpc.inputTextT', sprintf($themeFile, 'inputText'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('gpc.inputText', GPC_PATH.'js/ui.inputText.js', array('jquery.ui.widget'));
          break;
        case 'inputTreeList':
          self::addHeaderCSS('gpc.inputTreeList', GPC_PATH.'css/inputTreeList.css');
          self::addHeaderCSS('gpc.inputTreeListT', sprintf($themeFile, 'inputTreeList'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('gpc.inputTreeList', GPC_PATH.'js/ui.inputTreeList.js', array('jquery.ui.widget'));
          break;
        case 'simpleTip':
          self::addHeaderCSS('gpc.simpleTip', GPC_PATH.'css/simpleTip.css');
          self::addHeaderCSS('gpc.simpleTipT', sprintf($themeFile, 'simpleTip'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('gpc.simpleTip', GPC_PATH.'js/simpleTip.js', array('jquery.ui.widget'));
          break;
        case 'download':
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('gpc.download', GPC_PATH.'js/ui.download.js', array('jquery'));
          break;
        case 'dynamicTable':
          self::addHeaderCSS('jquery.ui.datepicker', 'themes/default/js/ui/theme/jquery.ui.datepicker.css');
          self::addHeaderCSS('gpc.inputNum', GPC_PATH.'css/inputNum.css');
          self::addHeaderCSS('gpc.inputNumT', sprintf($themeFile, 'inputNum'));
          self::addHeaderCSS('gpc.inputDate', GPC_PATH.'css/inputDate.css');
          self::addHeaderCSS('gpc.inputDateT', sprintf($themeFile, 'inputDate'));
          self::addHeaderCSS('gpc.inputText', GPC_PATH.'css/inputText.css');
          self::addHeaderCSS('gpc.inputTextT', sprintf($themeFile, 'inputText'));
          self::addHeaderCSS('gpc.inputList', GPC_PATH.'css/inputList.css');
          self::addHeaderCSS('gpc.inputListT', sprintf($themeFile, 'inputList'));
          self::addHeaderCSS('gpc.inputSortBox', GPC_PATH.'css/inputSortBox.css');
          self::addHeaderCSS('gpc.inputSortBoxT', sprintf($themeFile, 'inputSortBox'));
          self::addHeaderCSS('gpc.inputFilterBox', GPC_PATH.'css/inputFilterBox.css');
          self::addHeaderCSS('gpc.inputFilterBoxT', sprintf($themeFile, 'inputFilterBox'));
          self::addHeaderCSS('gpc.inputPages', GPC_PATH.'css/inputPages.css');
          self::addHeaderCSS('gpc.inputPagesT', sprintf($themeFile, 'inputPages'));
          self::addHeaderCSS('gpc.dynamicTable', GPC_PATH.'css/dynamicTable.css');
          self::addHeaderCSS('gpc.dynamicTableT', sprintf($themeFile, 'dynamicTable'));

          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));

          self::addHeaderJS('jquery.ui.mouse', 'themes/default/js/ui/jquery.ui.mouse.js', array('jquery.ui.widget'));
          self::addHeaderJS('jquery.ui.position', 'themes/default/js/ui/jquery.ui.position.js', array('jquery.ui.mouse'));
          self::addHeaderJS('jquery.ui.resizable', 'themes/default/js/ui/jquery.ui.resizable.js', array('jquery.ui.position'));
          self::addHeaderJS('jquery.ui.draggable', 'themes/default/js/ui/jquery.ui.draggable.js', array('jquery.ui.resizable'));
          self::addHeaderJS('jquery.ui.sortable', 'themes/default/js/ui/jquery.ui.sortable.js', array('jquery.ui.draggable'));
          self::addHeaderJS('jquery.ui.dialog', 'themes/default/js/ui/jquery.ui.dialog.js', array('jquery.ui.sortable'));
          self::addHeaderJS('jquery.ui.datepicker', 'themes/default/js/ui/jquery.ui.datepicker.js', array('jquery.ui.widget'));
          self::addHeaderJS('jquery.ui.datepicker-'.$lang_info['code'], self::getPiwigoSystemPath().'themes/default/js/ui/i18n/jquery.ui.datepicker-'.$lang_info['code'].'.js');

          self::addHeaderJS('gpc.inputNum', GPC_PATH.'js/ui.inputNum.js', array('jquery.ui.dialog'));
          self::addHeaderJS('gpc.inputList', GPC_PATH.'js/ui.inputList.js', array('jquery.ui.dialog'));
          self::addHeaderJS('gpc.inputText', GPC_PATH.'js/ui.inputText.js', array('jquery.ui.dialog'));
          self::addHeaderJS('gpc.inputDate', GPC_PATH.'js/ui.inputDate.js', array('jquery.ui.dialog'));
          self::addHeaderJS('gpc.inputFilterBox', GPC_PATH.'js/ui.inputFilterBox.js', array('jquery.ui.dialog'));
          self::addHeaderJS('gpc.inputSortBox', GPC_PATH.'js/ui.inputSortBox.js', array('jquery.ui.dialog'));
          self::addHeaderJS('gpc.inputPages', GPC_PATH.'js/ui.inputPages.js', array('jquery.ui.dialog'));
          self::addHeaderJS('gpc.dynamicTable', GPC_PATH.'js/ui.dynamicTable.js', array('jquery.ui.dialog'));
          break;
        case 'progressArea':
          self::addHeaderCSS('gpc.progressArea', GPC_PATH.'css/progressArea.css');
          self::addHeaderCSS('gpc.progressAreaT', sprintf($themeFile, 'progressArea'));
          self::addHeaderJS('jquery.ui', 'themes/default/js/ui/jquery.ui.core.js', array('jquery'));
          self::addHeaderJS('jquery.ui.widget', 'themes/default/js/ui/jquery.ui.widget.js', array('jquery.ui'));
          self::addHeaderJS('jquery.ui.mouse', 'themes/default/js/ui/jquery.ui.mouse.js', array('jquery.ui.widget'));
          self::addHeaderJS('jquery.ui.position', 'themes/default/js/ui/jquery.ui.position.js', array('jquery.ui.mouse'));
          self::addHeaderJS('jquery.ui.draggable', 'themes/default/js/ui/jquery.ui.draggable.js', array('jquery.ui.position'));
          self::addHeaderJS('jquery.ui.sortable', 'themes/default/js/ui/jquery.ui.sortable.js', array('jquery.ui.draggable'));
          self::addHeaderJS('jquery.ui.dialog', 'themes/default/js/ui/jquery.ui.dialog.js', array('jquery.ui.sortable'));
          self::addHeaderJS('gpc.progressArea', GPC_PATH.'js/ui.progressArea.js', array('jquery.ui.dialog'));
          break;
        case 'timer':
          self::addHeaderJS('gpc.timer', GPC_PATH.'js/ui.timer.js', array('jquery'));
          break;
      }
    }
  }


  /**
   * build an url from given properties
   *
   * @param String $urlType: type of url to build
   * @param Array $properties: properties used to build url
   * @return String: url, or empty string if not possible to build it
   */
  static public function urlBuild($type, $properties=array())
  {
    $returned='';
    switch($type)
    {
      case 'admin.picture':
        if(isset($properties['pictureId']))
        {
          $returned='./admin.php?page=photo-'.$properties['pictureId'];
        }
        break;
      case 'admin.category':
      case 'admin.album':
        if(isset($properties['categoryId']))
        {
          $returned='./admin.php?page=album-'.$properties['categoryId'];
        }
        break;
    }
    return($returned);
  }


  /**
   * use the extended description get_user_language_desc() function if exist
   * otherwise returns the value
   *
   * @param String $value : value to translate
   * @return String : translated value
   */
  static public function getUserLanguageDesc($value)
  {
    if(function_exists('get_user_language_desc'))
    {
      return(get_user_language_desc($value));
    }
    else
    {
      return($value);
    }
  }


  /**
   * remove a path recursively
   *
   * @param String $directory : directory to remove
   * @param Bool $removePath : if set to true, remove the path himself, if set
   *                           to false, remove only file & sub-directories
   * @return Bool : true if directory was succesfully removed, otherwise false
   */
  static public function rmDir($directory, $removePath=true)
  {
    $directory=rtrim($directory, '\/').'/';
    $returned=true;
    if(file_exists($directory) and is_dir($directory) and $directory!='./' and $directory!='../')
    {
      $dhandle=scandir($directory);
      foreach($dhandle as $file)
      {
        if($file!='.' and $file!='..' )
        {
          if(is_dir($directory.$file))
          {
            $returned=self::rmDir($directory.$file, true) & $returned;
          }
          else
          {
            $returned=unlink($directory.$file) & $returned;
          }
        }
      }
      if($returned and $removePath) $returned=rmdir($directory);
    }
    return($returned);
  }


  /**
   * returns the piwigo system path
   * @return String
   */
  static public function getPiwigoSystemPath()
  {
    return(self::$piwigoSystemPath);
  }


 /**
  * formats a file size into a human readable size
  *
  * @param String $format : "A"  : auto
  *                         "Ai" : auto (io)
  *                         "O"  : o
  *                         "K"  : Ko
  *                         "M"  : Mo
  *                         "G"  : Go
  *                         "Ki" : Kio
  *                         "Mi" : Mio
  *                         "Gi" : Gio
  * @param String $thsep : thousand separator
  * @param Integer $prec : number of decimals
  * @param Bool $visible : display or not the unit
  * @return String : a formatted file size
  */
 static public function formatOctet($octets, $format="Ai", $thsep="", $prec=2, $visible=true)
 {
  if($format=="Ai")
  {
   if($octets<1024)
   { $format="O"; }
   elseif($octets<1024000)
   { $format="Ki"; }
   elseif($octets<1024000000)
   { $format="Mi"; }
   else
   { $format="Gi"; }
  }
  elseif($format=="A")
  {
   if($octets<1000)
   { $format="O"; }
   elseif($octets<1000000)
   { $format="Ki"; }
   elseif($octets<1000000000)
   { $format="Mi"; }
   else
   { $format="Gi"; }
  }

  switch($format)
  {
   case "O":
    $unit="o"; $div=1;
    break;
   case "K":
    $unit="Ko"; $div=1000;
    break;
   case "M":
    $unit="Mo"; $div=1000000;
    break;
   case "G":
    $unit="Go"; $div=1000000000;
    break;
   case "Ki":
    $unit="Kio"; $div=1024;
    break;
   case "Mi":
    $unit="Mio"; $div=1024000;
    break;
   case "Gi":
    $unit="Gio"; $div=1024000000;
    break;
  }

  $returned=number_format($octets/$div, $prec, '.', $thsep);
  if($visible) $returned.=' '.$unit;
  return($returned);
 } //function formatOctet


 /**
  * affect a valid token in a template var {$token}
  */
 static public function setTemplateToken()
 {
   global $template;

   $template->assign('token', get_pwg_token());
 }


} //class

GPCCore::init();

?>
