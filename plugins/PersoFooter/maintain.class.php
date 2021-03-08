<?php
// +-----------------------------------------------------------------------+
// | Perso Footer plugin for Piwigo by TEMMII                              |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2011 - 2021 ddtddt             http://temmii.com/piwigo/ |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

class PersoFooter_maintain extends PluginMaintain{
  function install($plugin_version, &$errors=array()){
    pwg_query('INSERT INTO ' . CONFIG_TABLE . ' (param,value,comment) VALUES ("persoFooter","","html displayed on the footer page of your galler...");');
  }

  function update($old_version, $new_version, &$errors=array())
  {
  }

  function uninstall()
  {
	conf_delete_param('persoFooter');
  }
}
