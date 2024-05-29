<?php
// +-----------------------------------------------------------------------+
// | Read Metadata plugin for piwigo  by TEMMII                            |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2016-2023 ddtddt               http://temmii.com/piwigo/ |
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

//add admin menu
/*
add_event_handler('get_admin_plugin_menu_links', 'read_metadata_admin_menu');
function read_metadata_admin_menu($menu){
    $menu[] = array(
        'NAME' => l10n('Read metadata'),
        'URL' => READ_METADATA_ADMIN,
    );
     return $menu;
}
*/
add_event_handler('loc_begin_admin_page', 'read_metadataprefiltre',60);

function read_metadataprefiltre(){
  global $template;
  $template->set_prefilter('picture_modify', 'read_metadataprefiltreT');

  if (isset($_GET['page']) and 'photo' == $_GET['page'])
  {
    $template->assign(
      array(
        'U_SHOWMETADATA' => 'admin.php?page=plugin-read_metadata&amp;showmetadata='.$_GET['image_id'],
        )
      );
  }
}

function read_metadataprefiltreT($content){
  $search = '#        </div>
      </div>
    </div>


    <p>
      <strong>#';
  
  $replacement = '        </div>
      </div>
    </div>


    <p>
      <strong>
	<a class="icon-eye" href="{$U_SHOWMETADATA}">{\'Show metadata\'|@translate}</a><br><br>
';

  return preg_replace($search, $replacement, $content);
	}
