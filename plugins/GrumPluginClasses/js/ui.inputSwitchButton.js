/**
 * -----------------------------------------------------------------------------
 * file: ui.inputSwitchButton.js
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
 * | 1.0.0   | 2011/06/18 | first release
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
          return this.each(
            function()
            {
              // default values for the plugin
              var $this=$(this),
                  data = $this.data('options'),
                  objects = $this.data('objects'),
                  properties = $this.data('properties'),
                  options =
                    {
                      values:
                        {
                          checked:'yes',
                          unchecked:'no'
                        },
                      change:null,
                      group:''
                    };

              // if options given, merge it
              // if(opt) $.extend(options, opt); ==> options are set by setters

              $this
                .data('options', options)
                .addClass('ui-inputSwitchButton ui-inputSwitchButton-unchecked');

              if(!properties)
              {
                $this.data('properties',
                  {
                    initialized:false,
                    checked:false
                  }
                );
                properties=$this.data('properties');
              }


              $this.bind('click.inputSwitchButton',
                function (event)
                {
                  privateMethods.switchValue($this);
                }
              );

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
              var $this=$(this);

              $this
                .unbind('.inputSwitchButton')
                .removeData()
                .removeClass('ui-inputSwitchButton ui-inputSwitchButton-unchecked ui-inputSwitchButton-checked');
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

      disabled: function (value)
        {
          if(value!=null)
          {
            return(
              this.each(
                function()
                {
                  privateMethods.setDisabled($(this), value);
                }
              )
            );
          }
          else
          {
            return(privateMethods.getDisabled($(this)));
          }
        }, // disabled

      values: function (values)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setValues($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            // return the selected tags
            return(options.values);
          }
      },

      switchValue: function ()
        {
          return(
            this.each(
              function()
              {
                privateMethods.switchValue($(this));
              }
            )
          );

        }, // value

      value: function (value)
        {
          var properties=this.data('properties');

          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setValue($(this), value, true);
                }
              )
            );
          }
          else
          {
            var options = this.data('options');

            return(properties.checked?options.values.checked:options.values.unchecked);
          }

        }, // value

      group: function (value)
        {
          var options=this.data('options');

          if(value!=null)
          {
            // set selected group
            return(
              this.each(
                function()
                {
                  privateMethods.setGroup($(this), value);
                }
              )
            );
          }
          else
          {
            return(options.group);
          }

        }, // group

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

          privateMethods.setGroup(object, (value.group!=null)?value.group:options.group, true);
          privateMethods.setValue(object, (value.value!=null)?value.value:options.value, true);
          privateMethods.setEventChange(object, (value.change!=null)?value.change:options.change);

          properties.initialized=true;
        },

      setValues : function (object, value)
        {
          var options=object.data('options');

          if(value.checked!=null) options.values.checked=value.checked;
          if(value.unchecked!=null) options.values.unchecked=value.unchecked;

          return(options.values);
        }, //setValues


      setGroup: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if(options.group!=value)
          {
            if(options.group!="")
            {
              var listGroup=$(document).data('isbGroup_'+options.group),
                  p=-1;
              if(listGroup==null) listGroup=[];
              p=$.inArray(object.attr('id'), listGroup);
              if(p>-1) listGroup.splice(p,1);
              $(document).data('isbGroup_'+options.group, listGroup);
            }
            options.group=value;
            listGroup=$(document).data('isbGroup_'+value);
            if(listGroup==null) listGroup=[];
            listGroup.push(object.attr('id'));
            $(document).data('isbGroup_'+value, listGroup);
          }
        },

      switchValue: function (object)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if(options.values.checked==properties.checked)
          {
            privateMethods.setValue(object, options.values.unchecked, true);
          }
          else
          {
            privateMethods.setValue(object, options.values.checked, true);
          }
        },

      setValue : function (object, value, apply)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if(options.values.checked==value)
          {
            if(options.group!="")
            {
              listGroup=$(document).data('isbGroup_'+options.group);
              if(listGroup==null) listGroup=[];
              for(i=0;i<listGroup.length;i++)
              {
                if(listGroup[i]!=object.attr('id')) $('#'+listGroup[i]).inputSwitchButton('value', options.values.unchecked);
              }
            }

            object
              .addClass('ui-inputSwitchButton-checked')
              .removeClass('ui-inputSwitchButton-unchecked');
            properties.checked=value;
          }
          else if(options.values.unchecked==value)
          {
            object
              .addClass('ui-inputSwitchButton-unchecked')
              .removeClass('ui-inputSwitchButton-checked');
            properties.checked=value;
          }

          if(options.change) object.trigger('inputSwitchButtonChange', {checked:value});

          return(true);
        }, //setValue

      setEventChange : function (object, value)
        {
          var options=object.data('options');

          options.change=value;
          object.unbind('inputSwitchButtonChange');
          if(value) object.bind('inputSwitchButtonChange', options.change);
          return(options.change);
        }

    };


    $.fn.inputSwitchButton = function(method)
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
        $.error( 'Method ' +  method + ' does not exist on jQuery.inputSwitchButton' );
      }
    } // $.fn.inputSwitchButton

  }
)(jQuery);


