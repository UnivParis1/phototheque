/**
 * -----------------------------------------------------------------------------
 * file: ui.inputPath.js
 * file version: 1.0.0
 * date: 2012-07-24
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
 * | 1.0.0   | 2012/07/24 | first release
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
          return this.each(
            function()
            {
              // default values for the plugin
              var $this=$(this),
                  timeStamp=new Date(),
                  data = $this.data('options'),
                  //objects = $this.data('objects'), // no objects! they're all created dynamically
                  properties = $this.data('properties'),
                  options =
                    {
                      firstLevelClickable:1, // all item with a level stricly lower than this value are not clickable
                      autoSetLevel:true, // if true, when item is clicked, level is set to item level
                      separator:'/',
                      click:null
                    };

              // if options given, merge it
              // if(opt) $.extend(options, opt); ==> options are set by setters

              $this.data('options', options);

              if(!properties)
              {
                $this.data('properties',
                  {
                    objectId:'ip'+Math.ceil(timeStamp.getTime()*Math.random()),
                    level:0,
                    items:[]
                  }
                );
                properties=$this.data('properties');
              }

              $this
                .html('')
                .addClass('ui-inputPath');

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
              for(var i=0;i<objects.length;i++)
              {
                objects[i].unbind('click.inputPath').remove();
              }
              $this
                .removeData()
                .css(
                  {
                    width:'',
                    height:''
                  }
                );
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

      push: function (value)
        {
          return(
            this.each(
              function()
              {
                privateMethods.push($(this), value);
              }
            )
          );
        }, // push

      pop: function ()
        {
          return(
            this.each(
              function()
              {
                privateMethods.pop($(this));
              }
            )
          );
        }, // pop

      separator: function (value)
        {
          if(value!=null)
          {
            // set separator
            return(
              this.each(
                function()
                {
                  privateMethods.setSeparator($(this), value);
                }
              )
            );
          }
          else
          {
            // return the current separator
            var options=this.data('options');

            if(properties)
            {
              return(options.separator);
            }
            else
            {
              return(null);
            }
          }
        }, // separator

      level: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setLevel($(this), value);
                }
              )
            );
          }
          else
          {
            // return the selected value
            var properties=this.data('properties');

            if(properties)
            {
              return(properties.level);
            }
            else
            {
              return(null);
            }
          }
        }, // level

      firstLevelClickable : function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setFirstLevelClickable($(this), value);
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
              return(options.firstLevelClickable);
            }
            else
            {
              return(null);
            }
          }
        }, // level

      itemId: function (value)
        {
          if(value!=null && $.isPlainObject(value))
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setItemId($(this), value);
                }
              )
            );
          }
          else
          {
            // return the item from is id
            return(privateMethods.getItemId($(this), value));
          }
        }, // itemId


      itemLevel: function (value)
        {
          if(value!=null && $.isPlainObject(value))
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setItemLevel($(this), value);
                }
              )
            );
          }
          else
          {
            // return the item from the level value
            return(privateMethods.getItemLevel($(this), value));
          }
        }, // itemId


      click: function (value)
        {
          if(value!=null && $.isFunction(value))
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setEventClick($(this), value);
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
              return(options.click);
            }
            else
            {
              return(null);
            }
          }
        } // click

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

          privateMethods.setFirstLevelClickable(object, (value.firstLevelClickable!=null)?value.firstLevelClickable:options.firstLevelClickable);
          privateMethods.setSeparator(object, (value.separator!=null)?value.separator:options.separator);
          privateMethods.setAutoSetLevel(object, (value.autoSetLevel!=null)?value.autoSetLevel:options.autoSetLevel);

          privateMethods.setEventClick(object, (value.click!=null)?value.click:options.click);

          properties.initialized=true;
        },


      setAutoSetLevel : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if((!properties.initialized || value!=options.autoSetLevel) &&
              (value==true || value==false)
            )
          {
            options.autoSetLevel=value;
          }

          return(options.autoSetLevel);
        }, //setAutoSetLevel

      setSeparator : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if(!properties.initialized || value!=options.separator)
          {
            options.separator=value;
            object.find('.ui-inputPath-separator').html(options.separator);
          }

          return(options.separator);
        }, //setSeparator

      push : function (object, value)
        {
          var cssClass='ui-inputPath-itemSelectable',
              objSep=null,
              objItem=null,
              item={id:'', label:'', url:'', level:0},
              properties=object.data('properties'),
              options=object.data('options');

          if($.isPlainObject(value) &&
             value.id!=null &&
             value.id!='' &&
             value.label!=null &&
             value.label!='' &&
             privateMethods.getItemId(object, value.id)==null) // don't accept the same Id twice
          {
            item.id=value.id;
            item.label=value.label;
            if(value.url!=null) item.url=value.url;

            properties.level++;
            item.level=properties.level;

            if(properties.level>1)
            {
              // add a separator before the item only if the item is not the first item
              objSep=$('<span/>',
                        {
                          'class':'ui-inputPath-separator',
                          'id':properties.objectId+'-sep-'+properties.level
                        }
                      )
                      .html(options.separator);
              object.append(objSep);
            }

            if(properties.level<options.firstLevelClickable)
            {
              object.find('.ui-inputPath-item')
                      .addClass('ui-inputPath-itemNotSelectable')
                      .removeClass('ui-inputPath-item');
            }
            else
            {
              object.find('.ui-inputPath-item')
                      .addClass('ui-inputPath-itemSelectable')
                      .removeClass('ui-inputPath-item')
                      .bind('click.inputPath', object, privateMethods.bindClick);
            }

            objItem=$('<span/>',
                        {
                          'class':'ui-inputPath-item',
                          'id':properties.objectId+'-item-'+properties.level,
                          'ip-level':properties.level
                        }
                      )
                      .html(item.label);

            object.append(objItem);

            properties.items.push(item);

            return(true);
          }
          return(false);
        }, // push

      pop : function (object)
        {
          var objSep=null,
              objItem=null
              properties=object.data('properties');

          if(properties.level>0) // level=0 means no items...
          {
            $('#'+properties.objectId+'-item-'+properties.level).remove();
            $('#'+properties.objectId+'-sep-'+properties.level).remove();

            properties.items.pop();
            properties.level--;

            $('#'+properties.objectId+'-item-'+properties.level)
                .addClass('ui-inputPath-item')
                .removeClass('ui-inputPath-itemSelectable ui-inputPath-itemNotSelectable')
                .unbind('click.inputPath');
            return(true);
          }
          return(false);
        }, // pop

      setLevel : function (object, value)
        {
          var properties=object.data('properties');

          if(value>=0 && value<properties.level)
          {
            while(properties.level>value)
            {
              privateMethods.pop(object);
            }
          }
          return(properties.level)
        }, // setLevel

      setFirstLevelClickable : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if(!properties.initialized || value>0 && value!=options.firstLevelClickable)
          {
            options.firstLevelClickable=value;

            object.find('.ui-inputPath-itemSelectable').each(
              function (index)
              {
                if($(this).attr('ip-level')<options.firstLevelClickable)
                {
                  $(this)
                    .addClass('ui-inputPath-itemNotSelectable')
                    .removeClass('ui-inputPath-itemSelectable')
                    .unbind('click.inputPath');
                }
              }
            );
            object.find('.ui-inputPath-itemNotSelectable').each(
              function (index)
              {
                if($(this).attr('ip-level')>=options.firstLevelClickable)
                {
                  $(this)
                    .addClass('ui-inputPath-itemSelectable')
                    .removeClass('ui-inputPath-itemNotSelectable')
                    .bind('click.inputPath', object, privateMethods.bindClick);
                }
              }
            );
          }
          return(options.firstLevelClickable)
        }, // setLevel

      setItemId : function (object, value)
        {
          var properties=object.data('properties');

          if(value!=null &&
             $.isPlainObject(value) &&
             value.id!=null &&
             value.id!='' &&
             value.label!=null &&
             value.label!=''
          )

          for(var i=0;i<properties.items.length;i++)
          {
            if(properties.items[i].id==value.id)
            {
              properties.items[i].label=value.label;
              if(value.url!=null) properties.items[i].url=value.url;

              return(properties.items[i]);
            }
          }
          return(null);
        }, // setItemId

      getItemId : function (object, value)
        {
          var properties=object.data('properties');

          if(value!=null)
          {
            for(var i=0;i<properties.items.length;i++)
            {
              if(properties.items[i].id==value)
                return(properties.items[i]);
            }
          }
          return(null);
        }, // getItemId

      setItemLevel : function (object, value)
        {
          var properties=object.data('properties');

          if(value!=null &&
             $.isPlainObject(value) &&
             value.level!=null &&
             value.level>0 &&
             value.label!=null &&
             value.label!=''
          )

          for(var i=0;i<properties.items.length;i++)
          {
            if(properties.items[i].level==value.level)
            {
              properties.items[i].label=value.label;
              if(value.url!=null) properties.items[i].url=value.url;

              $('#'+properties.objectId+'-item-'+properties.items[i].level).html(value.label);

              return(properties.items[i]);
            }
          }
          return(null);
        }, // setItemLevel

      getItemLevel : function (object, value)
        {
          var properties=object.data('properties');

          if(value!=null)
          {
            for(var i=0;i<properties.items.length;i++)
            {
              if(properties.items[i].level==value)
                return(properties.items[i]);
            }
          }
          return(null);
        }, // getItemLevel

      setEventClick : function (object, value)
        {
          var options=object.data('options');

          options.click=value;
          object.unbind('inputPathClick');
          if(value) object.bind('inputPathClick', options.click);
          return(options.click);
        }, // setEventClick

      bindClick : function (event)
        {
          // event.data = object
          var options=event.data.data('options');

          if(options.click)
          {
            var item=privateMethods.getItemLevel(event.data, $(this).attr('ip-level'));

            if(options.autoSetLevel)
              privateMethods.setLevel(event.data, item.level);

            event.data.trigger('inputPathClick', item);
          }
        }

    };


    $.fn.inputPath = function(method)
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
        $.error( 'Method ' +  method + ' does not exist on jQuery.inputPath' );
      }
    } // $.fn.inputPath

  }
)(jQuery);


