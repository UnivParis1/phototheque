/**
 * -----------------------------------------------------------------------------
 * file: ui.download.js
 * file version: 1.0.0
 * date: 2012-09-04
 *
 * A jQuery plugin provided by the piwigo's plugin "GrumPluginClasses"
 *
 * -----------------------------------------------------------------------------
 * Author     : Grum
 *   email    : grum@piwigo.com
 *   website  : http://www.grum.fr
 *
 *   << May the Little SpaceFrog be with you ! >>
 * -----------------------------------------------------------------------------
 *
 *
 *
 *
 * :: HISTORY ::
 *
 * | release | date       |
 * | 1.0.0   | 2012/09/04 | first release
 * |         |            |
 * |         |            |
 * |         |            |
 * |         |            |
 * |         |            |
 * |         |            |
 *
 */



/**
 * Allows to download a file without having to open/refresh a page
 *
 * $.download(url)
 *  => download file with the given url
 *
 * @param String url: a valid url
 */
$.download = function (url)
{
  var timer=null,
      hif=null,

    /**
     * initialise the context
     */
    init = function (url)
      {
        hif=$('<iframe/>',
            {
              id:'hif',
              style:'display:none;',
              src:url
            }
          ).load(startDownload);
        $('body').append(hif);
      },

    /**
     * start file download
     */
    startDownload = function ()
      {
        timer=window.setInterval(
            function ()
            {
              window.clearInterval(timer);
              $(hif).remove();
            }, 1500
          );
      };


  init(url);
} // $.downloadUrl
