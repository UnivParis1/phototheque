/**
 * -----------------------------------------------------------------------------
 * file: markup.tabs.js
 * file version: 1.0.0
 * date: 2011-09-21
 *
 * JS file provided by the piwigo's plugin "GrumPluginClasses"
 *
 * -----------------------------------------------------------------------------
 * Author     : Grum
 *   email    : grum@piwigo.com
 *   website  : http://www.grum.fr
 *
 *   << May the Little SpaceFrog be with you ! >>
 * -----------------------------------------------------------------------------
 */
 $(window).bind('load',
  function ()
  {
    $('#iGpcTabs a').bind('click',
      function ()
      {
        if($(this).hasClass('gpcTabSelected')) return(false);

        $('#iGpcTabs a.gpcTabSelected').removeClass('gpcTabSelected').addClass('gpcTabNotSelected');
        $(this).removeClass('gpcTabNotSelected').addClass('gpcTabSelected');

        $('div.gpcTabContent').css('display', 'none');

        $($(this).attr('tabId')).css('display', 'block');
      }
    );
  }
);