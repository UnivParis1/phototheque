/**
 * -----------------------------------------------------------------------------
 * file: markup.formMail.js
 * file version: 1.0.0
 * date: 2011-09-20
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

    $('#iSubmit').bind('click',
      function ()
      {
        var data = {
              email:$('#iEmail').val(),
              subject:$('#iSubject').val(),
              msg:$('#iMessageContent').val(),
              token:$('#iToken').val(),
              ajaxfct:"public.contact.sendMsg"
            };

        $.ajax(
          {
            type: "POST",
            url: "plugins/GrumPluginClasses/gpc_ajax.php",
            async: true,
            data: data,
            success:
              function(msg)
              {
                result=$.parseJSON(msg);
                if(result.result)
                {
                  $('#iGpcFormMail').html(result.msg);
                }
                else
                {
                  alert(result.msg);
                }
              }
          }
        );
      }
    );

  }
);
