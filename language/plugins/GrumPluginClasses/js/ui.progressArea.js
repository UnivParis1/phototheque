/**
 * -----------------------------------------------------------------------------
 * file: ui.progressArea.js
 * file version: 1.0.0
 * date: 2012-07-13
 *
 * A jQuery plugin provided by the piwigo's plugin "GrumPluginClasses"
 *
 * -----------------------------------------------------------------------------
 * Author     : Grum
 *   email    : grum@piwigo.com
 *   website  : http://photos.grum.fr
 *   PWG user : http://forum.piwigo.org/profile.php?id=3706
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
 * | 1.0.0   | 2012/07/13 | first release
 * |         |            |
 * |         |            |
 * |         |            |
 * |         |            |
 * |         |            |
 * |         |            |
 *
 */



(
  function($)
  {
    /*
     * plugin 'public' functions
     */
    var publicMethods =
    {
      init : function (opt)
        {
          return this.each(function()
            {
              // default values for the plugin
              var $this=$(this),
                  timeStamp=new Date(),
                  data = $this.data('options'),
                  objects = $this.data('objects'),
                  properties = $this.data('properties'),
                  options =
                    {
                      text:'',
                      workInProgress:false,
                      global:{
                          visible:true,
                          showPercent:true,
                          percentDecimal:2,
                          value:0,
                          maxValue:100,
                          text:'',
                          complete:null,
                          change:null
                      },
                      detail:{
                          visible:false,
                          showPercent:true,
                          percentDecimal:2,
                          value:0,
                          maxValue:100,
                          text:'',
                          complete:null,
                          change:null
                      }
                    };

              // if options given, merge it
              // if(opt) $.extend(options, opt); ==> options are set by setters

              $this.data('options', options);


              if(!properties)
              {
                $this.data('properties',
                  {
                    globalTime:{
                        totalExecution:0,
                        lastExecution:0,
                        start:0
                      },
                    detailTime:{
                        totalExecution:0,
                        lastExecution:0,
                        start:0
                      }
                  }
                );
                properties=$this.data('properties');
              }

              if(!objects)
              {
                objects =
                  {
                    text:$('<div/>',
                        {
                          'class':'ui-progressArea-text'
                        }
                      ),
                    globalText:$('<div/>',
                        {
                          'class':'ui-progressArea-globalText'
                        }
                      ),
                    detailText:$('<div/>',
                        {
                          'class':'ui-progressArea-detailText'
                        }
                      ),
                    globalBar:$('<div/>',
                        {
                          'class':'ui-progressArea-globalBar'
                        }
                      ),
                    detailBar:$('<div/>',
                        {
                          class:'ui-progressArea-detailBar'
                        }
                      ),
                    globalBarProgress:$('<div/>',
                        {
                          class:'ui-progressArea-globalBarProgress'
                        }
                      ),
                    detailBarProgress:$('<div/>',
                        {
                          class:'ui-progressArea-detailBarProgress'
                        }
                      ),
                    globalBarText:$('<div/>',
                        {
                          class:'ui-progressArea-globalBarText'
                        }
                      ),
                    detailBarText:$('<div/>',
                        {
                          class:'ui-progressArea-detailBarText'
                        }
                      ),
                    workInProgress:$('<div/>',
                        {
                          class:'ui-progressArea-workInProgress'
                        }
                      )
                  };

                $this
                  .html('')
                  .addClass('ui-progressArea')
                  .append(objects.text)
                  .append(objects.globalText)
                  .append(objects.globalBar
                            .append(objects.globalBarProgress)
                            .append(objects.globalBarText)
                         )
                  .append(objects.detailText)
                  .append(objects.detailBar
                            .append(objects.detailBarProgress)
                            .append(objects.detailBarText)
                         )
                  .append(objects.workInProgress);

                $this.data('objects', objects);
              }

              privateMethods.setOptions($this, opt);
            }
          );
        }, // init
      destroy : function ()
        {
          return this.each(
            function()
            {
              // default values for the plugin
              var $this=$(this),
                  objects = $this.data('objects');
              objects.text.remove();
              objects.globalText.remove();
              objects.detailText.remove();
              objects.globalBarText.remove();
              objects.globalBarProgress.remove();
              objects.globalBar.remove();
              objects.detailBarText.remove();
              objects.detailBarProgress.remove();
              objects.detailBar.remove();
              objects.workInProgress.remove();

              delete objects.text;
              delete objects.globalText;
              delete objects.detailText;
              delete objects.globalBarText;
              delete objects.globalBarProgress;
              delete objects.globalBar;
              delete objects.detailBarText;
              delete objects.detailBarProgress;
              delete objects.detailBar;
              delete objects.workInProgress;

              $this.removeClass('ui-progressArea');
            }
          );
        }, // destroy

      options: function (value)
        {
          return(
            this.each(
              function()
              {
                privateMethods.setOptions($(this), value);
              }
            )
          );
        }, // options

      // hide progress information: progress bar and work in progress
      hideProgress: function ()
        {
          return(
            this.each(
              function()
              {
                privateMethods.hideProgress($(this));
              }
            )
          );
        }, //hideProgress

       // hide progress information: progress bar and work in progress
      workInProgress: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setWorkInProgress($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.workInProgress);
          }
        }, //workInProgress

      // set or return the value for global progress bar text
      globalText: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setText($(this), 'global', value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.global.text);
          }
        }, // globalText

      // set or return the value for detail progress bar text
      detailText: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setText($(this), 'detail', value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.detail.text);
          }
        }, // detailText

      // set or return the value for generic text
      text: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setText($(this), 'generic', value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.text);
          }
        }, // text



      // set or return the value for global progress bar
      globalValue: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setGlobalValue($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.global.value);
          }
        }, // globalValue

      // set or return the value for detail progress bar
      detailValue: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setDetailValue($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.detail.value);
          }
        }, // detailValue


      // set or return the max value for global progress bar
      globalMaxValue: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setGlobalMaxValue($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.global.maxValue);
          }
        }, // globalMaxValue

      // set or return the max value for detail progress bar
      detailMaxValue: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setDetailMaxValue($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.detail.maxValue);
          }
        }, // detailMaxValue


      // return the execution times
      executionTime: function (value)
        {
          var properties=this.data('properties');
          switch(value)
          {
            case 'resetGlobal':
              return(
                this.each(
                  function()
                  {
                    privateMethods.resetTime($(this), 'global');
                  }
                )
              );
              break;
            case 'resetDetail':
              return(
                this.each(
                  function()
                  {
                    privateMethods.resetTime($(this), 'detail');
                  }
                )
              );
              break;
            case 'global':
              return(
                {
                  totalExecution:properties.globalTime.totalExecution,
                  lastExecution:properties.globalTime.lastExecution
                }
              );
              break;
            case 'detail':
              return(
                {
                  totalExecution:properties.detailTime.totalExecution,
                  lastExecution:properties.detailTime.lastExecution
                }
              );
              break;
            default:
              return(
                {
                  global:
                    {
                      totalExecution:properties.globalTime.totalExecution,
                      lastExecution:properties.globalTime.lastExecution
                    },
                  detail:
                    {
                      totalExecution:properties.detailTime.totalExecution,
                      lastExecution:properties.detailTime.lastExecution
                    }
                }
              );
              break;
          }
        } // executionTime

    }; // methods


    /*
     * plugin 'private' methods
     */
    var privateMethods =
    {
      setOptions : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          if(!$.isPlainObject(value)) return(false);

          properties.initialized=false;

          privateMethods.setText(object, 'generic', (value.text!=null)?value.text:options.text);
          privateMethods.setWorkInProgress(object, (value.workInProgress!=null)?value.workInProgress:options.workInProgress);
          privateMethods.setProperties(object, 'global', (value.global!=null)?value.global:options.global);
          privateMethods.setProperties(object, 'detail', (value.detail!=null)?value.detail:options.detail);

          privateMethods.resetTime(object, 'detail');
          privateMethods.resetTime(object, 'global');

          privateMethods.updateBar(object, 'global');
          privateMethods.updateBar(object, 'detail');

          privateMethods.showWorkInProgress(object);

          properties.initialized=true;
        },


      setWorkInProgress: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if(!properties.initialized || value!=options.workInProgress)
          {
            options.workInProgress=value;
            privateMethods.showWorkInProgress(object);
          }
          return(options.workInProgress);
        }, // setWorkInProgress

      setText: function (object, target, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          switch(target)
          {
            case 'global':
              if(!properties.initialized || value!=options.global.text)
              {
                options.global.text=value;
                objects.globalText.html(options.global.text);
              }

              return(options.global.text);
              break;
            case 'detail':
              if(!properties.initialized || value!=options.detail.text)
              {
                options.detail.text=value;
                objects.detailText.html(options.detail.text);
              }

              return(options.detail.text);
              break;
            case 'generic':
              if(!properties.initialized || value!=options.text)
              {
                options.text=value;
                objects.text.html(options.text);
              }

              return(options.text);
              break;
          }
        }, // setText


      /**
       * set properties for global/detail options
       *
       * @param String target: 'global' or 'detail'
       */
      setProperties: function (object, target, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects'),
              tmpValue={
                visible:true,
                value:0,
                maxValue:100,
                text:'',
                complete:null,
                change:null
              };

          if(!properties.initialized &&
              (target=='global' || target=='detail') &&
              $.isPlainObject(value)
          )
          {
            if(value.visible!=null &&
                (value.visible==true || value.visible==false)
              )
                tmpValue.visible=value.visible;

            if(value.maxValue!=null &&
               value.maxValue>=0)
                tmpValue.maxValue=value.maxValue;

            if(value.value!=null &&
               value.value>=0 &&
               value.value<=tmpValue.maxValue)
                tmpValue.value=value.value;

            if(value.text!=null)
                tmpValue.text=value.text;

            if(value.complete!=null &&
                $.isFunction(value.complete))
              tmpValue.complete=value.complete;

            if(value.change!=null &&
                $.isFunction(value.change))
              tmpValue.change=value.change;

            if(value.showPercent!=null &&
                (value.showPercent==true || value.showPercent==false)
              )
                tmpValue.showPercent=value.showPercent;

            if(value.percentDecimal!=null &&
               value.percentDecimal>=0 && value.percentDecimal<=2)
                tmpValue.percentDecimal=value.percentDecimal;
          }

          switch(target)
          {
            case 'global':
              options.global.visible=tmpValue.visible;
              options.global.value=tmpValue.value;
              options.global.maxValue=tmpValue.maxValue;
              options.global.text=tmpValue.text;
              options.global.showPercent=tmpValue.showPercent;
              options.global.percentDecimal=tmpValue.percentDecimal;

              privateMethods.setEventComplete(object, 'global', tmpValue.complete);
              privateMethods.setEventChange(object, 'global', tmpValue.change);

              objects.globalText
                .html(options.global.text)
                .css('display', options.global.visible?'block':'none');
              objects.globalBar.css('display', options.global.visible?'block':'none');
              privateMethods.updateBar(object, 'global');
              return(options.global);
              break;
            case 'detail':
              options.detail.visible=tmpValue.visible;
              options.detail.value=tmpValue.value;
              options.detail.maxValue=tmpValue.maxValue;
              options.detail.text=tmpValue.text;
              options.detail.showPercent=tmpValue.showPercent;
              options.detail.percentDecimal=tmpValue.percentDecimal;

              privateMethods.setEventComplete(object, 'detail', tmpValue.complete);
              privateMethods.setEventChange(object, 'detail', tmpValue.change);

              objects.detailText
                .html(options.detail.text)
                .css('display', options.detail.visible?'block':'none');
              objects.detailBar.css('display', options.detail.visible?'block':'none');
              privateMethods.updateBar(object, 'detail');
              return(options.detail);
              break;
            default:
              return(null);
              break;
          }
        }, // setProperties


      setGlobalValue : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          if(value!=options.global.value && value>=0 && value<=options.global.maxValue)
          {

            options.global.value=value;
            privateMethods.updateBar(object, 'global');

            properties.globalTime.lastExecution=Date.now()-properties.globalTime.start;
            properties.globalTime.totalExecution+=properties.globalTime.lastExecution;
            properties.globalTime.start=Date.now();

            if(options.global.value==options.global.maxValue && options.global.complete!=null)
            {
              object.trigger('progressAreaCompleteglobal',
                {
                  lastExecution:properties.globalTime.lastExecution,
                  totalExecution:properties.globalTime.totalExecution
                }
              );
            }
            else if(options.global.change!=null)
            {
              object.trigger('progressAreaChangeglobal',
                {
                  currentValue:options.global.value,
                  lastExecution:properties.globalTime.lastExecution,
                  totalExecution:properties.globalTime.totalExecution
                }
              );
            }
          }

          return(options.global.value);
        }, // setGlobalValue

      setDetailValue : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          if(value!=options.detail.value && value>=0 && value<=options.detail.maxValue)
          {
            options.detail.value=value;
            privateMethods.updateBar(object, 'detail');

            properties.detailTime.lastExecution=Date.now()-properties.detailTime.start;
            properties.detailTime.totalExecution+=properties.detailTime.lastExecution;
            properties.detailTime.start=Date.now();

            properties.globalTime.lastExecution+=properties.detailTime.lastExecution;
            properties.globalTime.totalExecution+=properties.detailTime.lastExecution;

            if(options.detail.value==options.detail.maxValue && options.detail.complete!=null)
            {
              object.trigger('progressAreaCompletedetail',
                {
                  lastExecution:properties.detailTime.lastExecution,
                  totalExecution:properties.detailTime.totalExecution,
                  globalLastExecution:properties.globalTime.lastExecution,
                  globalTotalExecution:properties.globalTime.totalExecution
                }
              );
            }
            else if(options.detail.change!=null)
            {
              object.trigger('progressAreaChangedetail',
                {
                  currentValue:options.detail.value,
                  lastExecution:properties.detailTime.lastExecution,
                  totalExecution:properties.detailTime.totalExecution,
                  globalLastExecution:properties.globalTime.lastExecution,
                  globalTotalExecution:properties.globalTime.totalExecution
                }
              );
            }

            if(options.detail.value==options.detail.maxValue)
              privateMethods.resetTime(object, 'detail');
          }

          return(options.detail.value);
        }, // setDetailValue


      setGlobalMaxValue : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          if(value!=options.global.maxValue && value>=0 && value>=options.global.value)
          {
            options.global.maxValue=value;
            privateMethods.updateBar(object, 'global');
          }

          return(options.global.maxValue);
        }, // setGlobalMaxValue

      setDetailMaxValue : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          if(value!=options.detail.maxValue && value>=0 && value>=options.detail.value)
          {
            options.detail.maxValue=value;
            privateMethods.updateBar(object, 'detail');
          }

          return(options.detail.maxValue);
        }, // setDetailMaxValue


      setEventComplete : function (object, target, value)
        {
          var options=object.data('options');

          object.unbind('progressAreaComplete'+target);
          switch(target)
          {
            case 'global':
              options.global.complete=value;
              if(value) object.bind('progressAreaCompleteglobal', options.global.complete);
              return(options.global.complete);
              break;
            case 'detail':
              options.detail.complete=value;
              if(value) object.bind('progressAreaCompletedetail', options.detail.complete);
              return(options.detail.complete);
              break;
          }
        }, //setEventComplete

      setEventChange : function (object, target, value)
        {
          var options=object.data('options');

          object.unbind('progressAreaChange'+target);
          switch(target)
          {
            case 'global':
              options.global.change=value;
              if(value) object.bind('progressAreaChangeglobal', options.global.change);
              return(options.global.change);
              break;
            case 'detail':
              options.detail.change=value;
              if(value) object.bind('progressAreaChangedetail', options.detail.change);
              return(options.detail.change);
              break;
          }
        }, //setEventChange


      updateBar : function (object, target)
        {
          var objects=object.data('objects'),
              options=object.data('options'),
              properties=object.data('properties'),
              percent=0,
              targetObj=null,
              barObj=null,
              textObj=null,
              progressObj=null;

          switch(target)
          {
            case 'global':
              targetObj=options.global;
              barObj=objects.globalBar;
              textObj=objects.globalBarText;
              progressObj=objects.globalBarProgress;
              break;
            case 'detail':
              targetObj=options.detail;
              barObj=objects.detailBar;
              textObj=objects.detailBarText;
              progressObj=objects.detailBarProgress;
              break;
            default:
              return(false);
              break;
          }

          if(targetObj.maxValue>0)
            percent=100*targetObj.value/targetObj.maxValue;

          switch(targetObj.percentDecimal)
          {
            case 0:
              percent=Math.round(percent);
              break;
            case 1:
              percent=Math.round(percent*10)/10;
              break;
            case 2:
              percent=Math.round(percent*100)/100;
              break;
          }

          progressObj.css(
            {
              'width': Math.round(barObj.width()*percent/100)+'px',
              'height': barObj.innerHeight()
            }
          );

          if(targetObj.showPercent)
            textObj
              .css('width', barObj.width())
              .html(percent.toFixed(targetObj.percentDecimal)+'%');
        }, //updateBar


      hideProgress : function (object)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          objects.globalBar.css('display', 'none');
          objects.globalText.css('display', 'none');

          objects.detailBar.css('display', 'none');
          objects.detailText.css('display', 'none');

          objects.workInProgress.css('display', 'none');
        }, //hideProgress

      showWorkInProgress : function (object)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if(options.workInProgress)
          {
            bgPosition=(object.width()/2-8)+'px 8px';

            objects.workInProgress.css(
              {
                'display': 'block',
                'background-position': bgPosition
              }
            );
          }
          else
          {
            objects.workInProgress.css('display', 'none');
          }
        }, //showWorkInProgress


      resetTime : function(object, target)
        {
          var properties=object.data('properties');

          switch(target)
          {
            case 'global':
              properties.globalTime.totalExecution=0;
              properties.globalTime.lastExecution=0;
              properties.globalTime.start=Date.now();
              break;
            case 'detail':
              properties.detailTime.totalExecution=0;
              properties.detailTime.lastExecution=0;
              properties.detailTime.start=Date.now();
              break;
          }
        } // resetTime


    };

    $.fn.progressArea = function(method)
    {
      if(publicMethods[method])
      {
        return publicMethods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
      }
      else if(typeof method === 'object' || ! method)
      {
        return publicMethods.init.apply(this, arguments);
      }
      else
      {
        $.error( 'Method ' +  method + ' does not exist on jQuery.progressArea' );
      }
    } // $.fn.progressArea

  }
)(jQuery);

/**
 * open a modal dialog box for progression
 */
$.dialogProgressArea = function (opt)
{
  var options=
        {
          width:350,
          height:200,
          title:'Progression',
          buttons:
            {
              ok:'Ok'
            },
          text:'',
          progressBar:
            {
              global:null,
              detail:null
            },
         close:null,
        },
      objects=
        {
          dialogBox:$('<div/>'),
          pArea:$('<div/>')
        },
      properties=
        {
          complete:null
        },

  setOptions = function (opt)
    {
      if(opt.width!=null && opt.width>0) options.width=opt.width;
      if(opt.height!=null && opt.height>0) options.height=opt.height;
      if(opt.title) options.title=opt.title;
      if(opt.buttons && opt.buttons.ok) options.buttons.ok=opt.buttons.ok;
      if(opt.text) options.text=opt.text;

      if($.isPlainObject(opt.progressBar) &&
         $.isPlainObject(opt.progressBar.global))
            options.progressBar.global=opt.progressBar.global;
      if($.isPlainObject(opt.progressBar) &&
         $.isPlainObject(opt.progressBar.detail))
            options.progressBar.detail=opt.progressBar.detail;

      if(opt.close && $.isFunction(opt.close)) options.close=opt.close;

      if($.isFunction(options.progressBar.global.complete))
        properties.complete=options.progressBar.global.complete;

      options.progressBar.global.complete=function (event, value)
        {
          objects.pArea.progressArea('hideProgress');
          if(properties.complete) properties.complete(event, value);
          objects.dialogBox.parent().find('div.ui-dialog-buttonpane button').css('visibility', 'visible');
        }
    },

  initDialog = function ()
    {
      var dialogOpt={},
          dialogButtons={};

      dialogButtons[options.buttons.ok] = function (event)
        {
          if(options.close) options.close(event);
          $(this).dialog('close');
        };

      dialogOpt=
          {
            width:options.width,
            height:options.height,
            closeOnEscape:false,
            closeText:'',
            dialogClass:'ui-dialogProgressArea',
            modal:true,
            resizable:false,
            title:options.title,
            buttons:dialogButtons,
            open: open= function ()
                    {
                      objects.pArea
                        .progressArea(
                          {
                            text:options.text,
                            workInProgress:true,
                            global:options.progressBar.global,
                            detail:options.progressBar.detail
                          }
                        );
                    },
            close: function ()
                    {
                      objects.pArea.progressArea('destroy').remove();
                      $(this).dialog('destroy').remove();
                    }
          };

      objects.dialogBox
        .append(objects.pArea)
        .dialog(dialogOpt);
    };

  setOptions(opt);
  initDialog();

  return(objects.pArea);
} // $.dialogProgressArea
