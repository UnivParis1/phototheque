/**
 * -----------------------------------------------------------------------------
 * file: ui.inputSortBox.js
 * file version: 1.0.1
 * date: 2012-06-18
 *
 * A jQuery plugin provided by the piwigo's plugin "GrumPluginClasses"
 *
 * -----------------------------------------------------------------------------
 * Author     : Grum
 *   email    : grum@piwigo.com
 *   website  : http://photos.grum.fr
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
 * | 1.0.0   | 2012/06/09 | first release
 * |         |            |
 * | 1.0.1   | 2012/06/18 | * improve memory managment
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
                  data = $this.data('options'),
                  objects = $this.data('objects'),
                  properties = $this.data('properties'),
                  options =
                    {
                      mode:'normal', // normal|direction
                      chars:{
                          asc:'',
                          desc:''
                        },
                      items:[],
                      change:null
                    };

              // if options given, merge it
              // if(opt) $.extend(options, opt); ==> options are set by setters

              $this.data('options', options);


              if(!properties)
              {
                $this.data('properties',
                  {
                  }
                );
                properties=$this.data('properties');
              }

              if(!objects)
              {
                objects =
                  {
                    container:$('<ul/>',
                        {
                          'class':'ui-inputSortBox'
                        }
                    )
                  };

                $this
                  .html('')
                  .append(
                      objects.container
                        );

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
              objects.container.remove();
              $this
                .unbind('inputSortBox')
                .removeData();
              delete $this;
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


      items: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setItems($(this), value, true);
                }
              )
            );
          }
          else
          {
            // return the selected tags
            var options=this.data('options');
            return(options.items);
          }
        }, // items

      mode: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setMode($(this), value, true);
                }
              )
            );
          }
          else
          {
            // return the selected tags
            var options=this.data('options');
            return(options.mode);
          }
        }, // mode

      chars: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setChars($(this), value, true);
                }
              )
            );
          }
          else
          {
            // return the selected tags
            var options=this.data('options');
            return(options.chars);
          }
        }, // mode

      change: function (value)
        {
          if(value!=null && $.isFunction(value))
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setEventChange($(this), value);
                }
              )
            );
          }
          else
          {
            // return the selected value
            var options=this.data('options');

            if(options)
            {
              return(options.change);
            }
            else
            {
              return(null);
            }
          }
        } // change

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

          privateMethods.setChars(object, (value.chars!=null)?value.chars:options.chars);
          privateMethods.setMode(object, (value.mode!=null)?value.mode:options.mode);
          privateMethods.setItems(object, (value.items!=null)?value.items:options.items);

          privateMethods.setEventChange(object, (value.change!=null)?value.change:options.change);

          properties.initialized=true;
        },


      setItems : function (object, value)
        {
          var $this=$(this),
              options=object.data('options'),
              objects=object.data('objects'),
              charDir='',
              className='';

          /* if is_array */
          objects.container.sortable("destroy").remove('li');
          options.items=value;

          for(i=0;i<options.items.length;i++)
          {
            if(options.items[i].direction==null) options.items[i].direction='asc'

            if(options.items[i].direction=='asc')
            {
              charDir=options.chars.asc;
              className='ui-inputSortBoxAsc';
            }
            else
            {
              charDir=options.chars.desc;
              className='ui-inputSortBoxDesc';
            }

            if(options.items[i].id!=null && options.items[i].id!='' &&
               options.items[i].content!=null && options.items[i].content!='')
            {
              objects.container.append(
                $('<li/>',
                    {
                      'oId':options.items[i].id,
                      'oDir':options.items[i].direction
                    }
                ).append(
                    $('<span/>',
                        {
                          class:'ui-inputSortBoxText'
                        }
                    ).html(options.items[i].content))
                 .append(
                    $('<span/>',
                        {
                          class:className,
                          style:'display:none'
                        }
                      ).html(charDir)
                       .bind('click', function (event)
                          {
                            var p=$(this).parent(),
                                oDir=p.attr('oDir');

                            switch(oDir)
                            {
                              case 'asc':
                                  oDir='desc';
                                  $(this)
                                    .html(options.chars.desc)
                                    .toggleClass('ui-inputSortBoxAsc ui-inputSortBoxDesc');
                                break;
                              case 'desc':
                                  oDir='asc';
                                  $(this)
                                    .html(options.chars.asc)
                                    .toggleClass('ui-inputSortBoxAsc ui-inputSortBoxDesc');
                                break;
                            }

                            p.attr('oDir', oDir);

                            privateMethods.setCurrentOrder(object);
                            if(options.change)
                            {
                              object.trigger('inputSortBoxChange', {order:options.items} );
                            }
                          }
                        )
                )
              );
            }
          }

          if(options.items.length>0)
          {
            privateMethods.changeMode(object);

            objects.container.sortable(
              {
                axis:'y',
                items:'li',
                scroll:false,
                update:function (event, ui)
                  {
                    privateMethods.setCurrentOrder(object);
                    if(options.change)
                    {
                      object.trigger('inputSortBoxChange', {order:options.items} );
                    }
                  }
              }
            );
          }

          return(options.items);
        }, //setItems

      setChars: function (object, value)
        {
          var options=object.data('options');

          if(value!=null && value.asc!=null && value.desc!=null &&
            value.asc!=options.asc && value.desc!=options.desc)
          {
            options.chars.asc=value.asc;
            options.chars.desc=value.desc;
            privateMethods.changeMode(object, options.mode);
          }

          return(options.chars);
        }, // setChars

      setMode: function (object, value)
        {
          var options=object.data('options');

          if((value=='normal' || value=='direction') && value!=options.mode)
          {
            previousMode=options.mode;

            options.mode=value;
            privateMethods.changeMode(object);
          }

          return(options.mode);
        }, // setMode

      setEventChange : function (object, value)
        {
          var options=object.data('options');

          options.change=value;
          object.unbind('inputSortBoxChange');
          if(value) object.bind('inputSortBoxChange', options.change);
          return(options.change);
        },

      /*
       * apply the current order to the options.items
       */
      setCurrentOrder : function (object)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              returned=[];

          objects.container.children().each(
            function (index)
            {
              returned.push(
                {
                  id:$(this).attr('oId'),
                  content:$(this).children('span.ui-inputSortBoxText').html(),
                  direction:$(this).attr('oDir')
                }
              );
            }
          );

          options.items=returned;

          return(options.items);
        }, // setCurrentOrder

      /*
       * apply mode to DOM model
       */
      changeMode : function (object)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              displayMode='none';

          if(options.mode=='direction') displayMode='block';
          objects.container.find('span.ui-inputSortBoxAsc').attr('style', 'display:'+displayMode).html(options.chars.asc);
          objects.container.find('span.ui-inputSortBoxDesc').attr('style', 'display:'+displayMode).html(options.chars.desc);
        }
    };


    $.fn.inputSortBox = function(method)
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
        $.error( 'Method ' +  method + ' does not exist on jQuery.inputSortBox' );
      }
    } // $.fn.inputSortBox

  }
)(jQuery);



$.inputDialogSortBox = function(opt)
{
  var options=
        {
          modal:true,
          width:350,
          height:200,
          autoHeight:true,
          title:'Sort box',
          mode:'normal',
          chars:{
              asc:'', //&uArr;
              desc:'' //&dArr;
            },
          items:[],
          buttons:
            {
              ok:'Ok',
              cancel:'Cancel'
            },
          change:null
        },
      objects=
        {
          dialogBox:$('<div/>'),
          sortBox:$('<div/>', {'class':'sortBox'} )
        },

  setOptions = function (opt)
    {
      if(opt.modal==true || opt.modal==false) options.modal=opt.modal;
      if(opt.width!=null || opt.width>0) options.width=opt.width;
      if(opt.height!=null || opt.height>0) options.height=opt.height;
      if(opt.autoHeight==true || opt.autoHeight==false) options.autoHeight=opt.autoHeight;
      if(opt.mode=='normal' || opt.mode=='direction') options.mode=opt.mode;
      if(opt.chars!=null) options.chars=opt.chars;
      options.items=opt.items;
      if(opt.title) options.title=opt.title;
      if(opt.buttons && opt.buttons.ok) options.buttons.ok=opt.buttons.ok;
      if(opt.buttons && opt.buttons.cancel) options.buttons.cancel=opt.buttons.cancel;
      if(opt.change && $.isFunction(opt.change)) options.change=opt.change;
    },

  initDialog = function ()
    {
      var dialogOpt=
          {
            buttons:{},
            width:options.width,
            height:options.height,
            closeText:'x',
            dialogClass:'ui-inputDialogSortBox',
            modal:options.modal,
            resizable:false,
            title:options.title,
            open: null,
            close: function ()
                    {
                      objects.sortBox.inputSortBox('destroy').remove();
                      $(this).dialog('destroy').remove();
                    }
          };

      if(options.autoHeight)
      {
        tmpLi=$('<li/>').html('*');
        tmpUl=$('<ul/>', {class:'ui-inputSortBox', style:'visibility:hidden'}).append(tmpLi);
        $('body').append(tmpUl);

        cHeight=options.items.length*tmpLi.outerHeight(true)+25;
        tmpLi.remove();
        tmpUl.remove();
        delete tmpLi;
        delete tmpUl;
        if(cHeight>dialogOpt.height) dialogOpt.height=cHeight;
      }

      if(options.modal)
      {
        dialogOpt.buttons[options.buttons.ok]=function (event)
          {
            if(options.change)
            {
              options.change(event, objects.sortBox.inputSortBox('items') );
            }
            $(this).dialog('close');
          };

        dialogOpt.buttons[options.buttons.cancel]= function (event)
          {
            $(this).dialog('close');
          };

        dialogOpt.open= function ()
          {
            objects.sortBox
              .inputSortBox(
                {
                  mode:options.mode,
                  chars:options.chars,
                  items:options.items
                }
              );
          };
      }
      else
      {
        dialogOpt.open= function ()
          {
            objects.sortBox
              .inputSortBox(
                {
                  items:options.items,
                  mode:options.mode,
                  chars:options.chars,
                  change:function (event)
                    {
                      if(options.change)
                        {
                          options.change(event, objects.sortBox.inputSortBox('items') );
                        }
                    }
                }
              );
          };
      }

      objects.dialogBox
        .append(objects.sortBox)
        .dialog(dialogOpt);
    };

  setOptions(opt);
  initDialog();

} // $.fn.inputSortBox


