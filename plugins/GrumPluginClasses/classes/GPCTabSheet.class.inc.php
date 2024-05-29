<?php
/* -----------------------------------------------------------------------------
  class name     : GPCTabSheet
  class version  : 1.1.2
  plugin version : 3.5.3
  date           : 2012-08-14
  ------------------------------------------------------------------------------
  author: grum at piwigo.org
  << May the Little SpaceFrog be with you >>
  ------------------------------------------------------------------------------

  :: HISTORY

| release | date       |
| 1.0.0   | 2010/04/18 | * create class
|         |            |
| 1.1.0   | 2010/06/20 | * add possibility to manage the class names for tabs
|         |            |
| 1.1.1   | 2010/10/01 | * add attribute 'id' for tabs (<li> items)
|         |            |
| 1.1.2   | 2012/08/14 | * bug:2723 - set select() function to be compatible with
|         |            |   piwigo 2.4.3
|         |            |
|         |            |

  ------------------------------------------------------------------------------

   this class provides base functions to manage tabsheet navigation

   this class extends the Piwigo tabsheet class

   ---------------------------------------------------------------------- */

include_once(PHPWG_ROOT_PATH.'admin/include/tabsheet.class.php');

class GPCTabSheet extends tabsheet
{
  protected $classes;
  protected $id;
  protected $tplFile;
  protected $selectedTabClasses='selected_tab';
  protected $unselectedTabClasses='normal_tab';
  protected $normalTabClasses='';


  /*
    $name is the tabsheet's name inside the template .tpl file
    $titlename in the template is affected by $titlename value
  */
  public function __construct($name = 'TABSHEET', $titlename = 'TABSHEET_TITLE', $classes="", $id="", $tplFile="")
  {
    parent::__construct($name, $titlename);
    $this->classes=$classes;
    $this->id=$id;
    $this->set_id($this->id);
    $this->setTplFile($tplFile);
  }


  function add($name, $caption, $url, $selected = false, $onClick='')
  {
    if(parent::add($name,$caption,$url,$selected))
    {
      $this->sheets[$name]['onClick'] = $onClick;
      return(true);
    }
    return(false);
  }

  public function setClasses($classes)
  {
    $this->classes=$classes;
    return($this->classes);
  }

  public function getClasses()
  {
    return($this->classes);
  }

  public function setTabsClasses($state, $classes)
  {
    if($state=='unselected')
    {
      $this->unselectedTabClasses=$classes;
      return($this->unselectedTabClasses);
    }
    elseif($state=='selected')
    {
      $this->selectedTabClasses=$classes;
      return($this->selectedTabClasses);
    }
    elseif($state=='normal')
    {
      $this->normalTabClasses=$classes;
      return($this->normalTabClasses);
    }
    return("");
  }

  public function getTabsClasses($state)
  {
    if($state=='unselected')
    {
      return($this->unselectedTabClasses);
    }
    elseif($state=='selected')
    {
      return($this->selectedTabClasses);
    }
    elseif($state=='normal')
    {
      return($this->normalTabClasses);
    }
    return("");
  }

  public function setId($id)
  {
    $this->id=$id;
    return($this->id);
  }

  public function getId()
  {
    return($this->id);
  }

  public function setTplFile($fileName)
  {
    if(file_exists($fileName) or $fileName=="")
    {
      $this->tplFile=$fileName;
    }
    return($this->tplFile);
  }

  public function getTplFile()
  {
    return($this->tplFile);
  }


  public function select($name)
  {
    /*
     * override the tabsheet->select() function (to fix bug:2723)
     */
    if($this->id!='')
    {
      $this->sheets = trigger_change('gpc_tabsheet_before_select', $this->sheets, $this->id);
      if (!array_key_exists($name, $this->sheets))
      {
        $keys = array_keys($this->sheets);
        if(isset($keys[0]))
          $name = $keys[0];
      }
    }
    $this->selected = $name;
  }

  function set_id($id)
  {
    /*
     * override the tabsheet->select() function (to fix bug:2723)
     */
    if(method_exists('tabsheet', 'set_id'))
    {
      parent::set_id($id);
    }
    else
    {
      $this->uniqid = $id;
    }
  }

  /*
   * Build TabSheet and assign this content to current page
   *
   * Fill $this->$name {default value = TABSHEET} with HTML code for tabsheet
   * Fill $this->titlename {default value = TABSHEET_TITLE} with formated caption of the selected tab
   */
  function assign()
  {
    global $template;

    if($this->tplFile=="")
    {
      $tplFile=dirname(dirname(__FILE__)).'/templates/GPCTabSheet.tpl';
    }
    else
    {
      $tplFile=$this->tplFile;
    }

    $template->set_filename('tabsheet', $tplFile);
    $template->assign('tabsheet', $this->sheets);
    $template->assign('tabsheet_selected', $this->selected);

    $selected_tab = $this->get_selected();

    if (isset($selected_tab))
    {
      $template->assign(
        array($this->titlename => '['.$selected_tab['caption'].']'));
    }

    if($this->classes!="") $template->assign('tabsheet_classes', $this->classes);
    if($this->id!="") $template->assign('tabsheet_id', $this->id);

    $template->assign('tab_classes',
      array(
        'unselected' => $this->getTabsClasses('unselected'),
        'selected' => $this->getTabsClasses('selected'),
        'normal' => $this->getTabsClasses('normal')
      )
    );

    $template->assign_var_from_handle($this->name, 'tabsheet');
    $template->clear_assign('tabsheet');
  }
}

?>
