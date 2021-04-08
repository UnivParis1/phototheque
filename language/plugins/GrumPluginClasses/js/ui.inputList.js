/**
 * -----------------------------------------------------------------------------
 * file: ui.inputList.js
 * file version: 1.0.1
 * date: 2012-05-25
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
 * | 1.0.0   | 2010/10/10 | first release
 * |         |            |
 * | 1.0.1   | 2012/06/18 | * fix bug with jquery 1.7.2
 * |         |            |   . display list now works :)
 * |         |            |
 * |         |            | * improve memory managment
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
                      serverUrl:'',
                      postData:{},
                      autoLoad:true,
                      listMaxWidth:0,
                      listMaxHeight:0,
                      multiple:false,
                      downArrow:'', //&dArr;
                      popupMode:'click',
                      colsWidth:[],
                      colsDisplayed:[],
                      colsCss:[],
                      disabled:false,
                      popup:null,
                      change:null,
                      load:null,
                      returnMode:'selected'
                    };

              // if options given, merge it
              // if(opt) $.extend(options, opt); ==> options are set by setters

              $this.data('options', options);

              if(!properties)
              {
                $this.data('properties',
                  {
                    objectId:'il'+Math.ceil(timeStamp.getTime()*Math.random()),
                    index:-1,
                    initialized:false,
                    selectorVisible:false,
                    items:[],
                    mouseOver:false,
                    isValid:true,
                    firstPopup:true
                  }
                );
                properties=$this.data('properties');
              }

              if(!objects)
              {
                objects =
                  {
                    container:$('<div/>',
                        {
                          'class':'ui-inputList',
                          tabindex:0,
                          css:{
                            width:'100%'
                          }
                        }
                    ).bind('click.inputList',
                        function ()
                        {
                          privateMethods.displaySelector($this, !$this.data('properties').selectorVisible);
                          //$(this).focus();  // if get the focus, it hide the dorp-down list.. ?
                        }
                      ),
                    containerValue:$('<div/>',
                      {
                        html: '&nbsp;',
                        'class':'ui-inputList-value',
                        css:{
                          overflow:'hidden'
                        }
                      }
                    ),
                    containerList:null,
                    containerArrow:$('<div/>',
                      {
                        html: '&dArr;',
                        'class':'ui-inputList-arrow',
                        css: {
                          'float':'right',
                          cursor:'pointer'
                        }
                      }
                    ).bind('mousedown',
                        function ()
                        {
                          $(this).addClass('ui-inputList-arrow-active');
                        }
                    ).bind('mouseup',
                        function ()
                        {
                          $(this).removeClass('ui-inputList-arrow-active');
                        }
                    ),
                    listContainer:$('<div/>',
                        {
                          html: "",
                          'class':'ui-inputList-list',
                          css: {
                            overflow:"auto",
                            display:'none',
                            position:'absolute'
                          }
                        }
                    ),
                    list:$('<ul/>',
                      {
                        css: {
                          listStyle:'none',
                          padding:'0px',
                          margin:'0px'
                        }
                      }
                    )
                  };
              }

              $this.data('objects', objects);
              privateMethods.setOptions($this, opt);

              if($this.text()!='')
              {
                var tmp=$.parseJSON($.trim($this.text())),
                    selectedValues=[],
                    values=[];

                if($.isArray(tmp))
                {
                  values=tmp;
                }
                else if(tmp.values!=null)
                {
                  values=tmp.values;
                }

                if(tmp.selected!=null) selectedValues=tmp.selected;

                privateMethods.setItems($this, values);
                privateMethods.setValue($this, selectedValues);

              }

              $this
                .html('')
                .append(objects.container.append(objects.containerArrow).append(objects.containerValue))
                .append(objects.listContainer.append(objects.list));

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
                  properties = $this.data('properties'),
                  objects = $this.data('objects');
              objects.container.unbind().remove();
              objects.list.children().unbind();
              objects.listContainer.unbind().remove();
              $(document).unbind('focusout.'+properties.objectId+' focusin.'+properties.objectId);
              $this
                .removeData()
                .unbind('.inputList')
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
          return this.each(function()
            {
              privateMethods.setOptions($(this), value);
            }
          );
        }, // autoLoad

      autoLoad: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setAutoLoad($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.autoLoad);
            }
            else
            {
              return(true);
            }
          }
        }, // autoLoad

      listMaxWidth: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setListMaxWidth($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.listMaxWidth);
            }
            else
            {
              return(0);
            }
          }
        }, // listMaxWidth

      listMaxHeight: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setListMaxHeight($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.listMaxHeight);
            }
            else
            {
              return(0);
            }
          }
        }, // listMaxHeight

      serverUrl: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setServerUrl($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.serverUrl);
            }
            else
            {
              return('');
            }
          }
        }, // serverUrl

      postData: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setPostData($(this), value, true);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.postData);
          }
        }, // postData

      cols: function ()
        {
          var options=this.data('options'),
              properties=this.data('properties');

          if(!options.multiple)
          {
            return(properties.items[properties.index].cols);
          }
          else
          {
            var listCols=[];
            for(var i=0;i<properties.index.length;i++)
            {
              listCols.push(properties.items[properties.index[i]].cols);
            }
            return(listCols);
          }
        }, // name

      popupMode: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setPopupMode($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.popupMode);
            }
            else
            {
              return(0);
            }
          }
        }, // popupMode

      downArrow: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setDownArrow($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.downArrow);
            }
            else
            {
              return('');
            }
          }
        }, // downArrow


      returnMode: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setReturnMode($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.returnMode);
            }
            else
            {
              return('selected');
            }
          }
        }, // returnMode

      colsWidth: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setColsWidth($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.colsWidth);
            }
            else
            {
              return('');
            }
          }
        }, // colsWidth

      colsDisplayed: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setColsDisplayed($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.colsDisplayed);
            }
            else
            {
              return('');
            }
          }
        }, // colsDisplayed

      colsCss: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setColsCss($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.colsCss);
            }
            else
            {
              return('');
            }
          }
        }, // colsCss


      items: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setItems($(this), value);
              }
            );
          }
          else
          {
            var properties = this.data('properties');

            if(properties)
            {
              return(properties.items);
            }
            else
            {
              return('');
            }
          }
        }, //items

      value: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setValue($(this), value);
              }
            );
          }
          else
          {
            // return the selected value
            var properties=this.data('properties'),
                options = this.data('options');

            if(properties && properties.index!=null && !options.multiple && properties.index>-1 && properties.index<properties.items.length)
            {
              return(properties.items[properties.index].value);
            }
            else if(properties && properties.index!=null && options.multiple)
            {
              var returned=[];
              if(options.returnMode=='selected')
              {
                for(var i=0;i<properties.index.length;i++)
                {
                  if(properties.index[i]>-1 && properties.index[i]<properties.items.length)
                    returned.push(properties.items[properties.index[i]].value);
                }
              }
              else
              {
                for(var i=0;i<properties.items.length;i++)
                {
                  if($.inArray(i, properties.index)==-1)
                    returned.push(properties.items[i].value);
                }
              }
              return(returned);
            }
            else
            {
              return(null);
            }
          }
        }, // value

      isValid: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setIsValid($(this), value);
              }
            );
          }
          else
          {
            // return the selected tags
            var properties=this.data('properties');
            return(properties.isValid);
          }
        }, // isValid

      load: function (value)
        {
          /*
           * two functionnalities :
           *  - if value is set, use it to set the load event function
           *  - if no value, loads data from server
           */
          if(value && $.isFunction(value))
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setEventLoad($(this), value);
              }
            );
          }
          else
          {
            // loads data from server
            privateMethods.load(this);
          }
        },

      popup: function (value)
        {
          if(value && $.isFunction(value))
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setEventPopup($(this), value);
              }
            );
          }
          else
          {
            // return the selected value
            var options=this.data('options');

            if(options)
            {
              return(options.popup);
            }
            else
            {
              return(null);
            }
          }
        }, // popup

      change: function (value)
        {
          if(value && $.isFunction(value))
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setEventChange($(this), value);
              }
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
        }, // popup

      numberOfItems: function ()
        {
          var properties=this.data('properties');

          if(properties)
          {
            return(properties.items.length);
          }
          else
          {
            return(null);
          }
        }, // numberOfItems

      properties: function (value)
        {
          var properties=this.data('properties'),
              options=this.data('options');

          if(properties && value==':first' && properties.items.length>0)
          {
            return(properties.items[0]);
          }
          else if(properties && properties.index!=null && (value==':selected' || value==null) && properties.items.length>0)
          {
            if(!options.multiple && properties.index>-1 && properties.index<properties.items.length)
            {
              return(properties.items[properties.index]);
            }
            else if(options.multiple)
            {
              var returned=[];
              for(var i=0;i<properties.index.length;i++)
              {
                if(properties.index[i]>-1 && properties.index<properties.items.length)
                  returned.push(properties.items[properties.index[i]]);
              }
              return(returned);
            }
            return(null);
          }
          else if(properties && value!=null)
          {
            var index=privateMethods.findIndexByValue(this, value);
            if(index>-1)
            {
              return(properties.items[index]);
            }
            return(null);
          }
          else
          {
            return(null);
          }
        } // properties
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

          privateMethods.setReturnMode(object, (value.returnMode!=null)?value.returnMode:options.returnMode);
          privateMethods.setAutoLoad(object, (value.autoLoad!=null)?value.autoLoad:options.autoLoad);
          privateMethods.setListMaxWidth(object, (value.listMaxWidth!=null)?value.listMaxWidth:options.listMaxWidth);
          privateMethods.setListMaxHeight(object, (value.listMaxHeight!=null)?value.listMaxHeight:options.listMaxHeight);
          privateMethods.setPostData(object, (value.postData!=null)?value.postData:options.postData);
          privateMethods.setServerUrl(object, (value.serverUrl!=null)?value.serverUrl:options.serverUrl);
          privateMethods.setPopupMode(object, (value.popupMode!=null)?value.popupMode:options.popupMode);
          privateMethods.setDownArrow(object, (value.downArrow!=null)?value.downArrow:options.downArrow);
          privateMethods.setEventPopup(object, (value.popup!=null)?value.popup:options.popup);
          privateMethods.setEventChange(object, (value.change!=null)?value.change:options.change);
          privateMethods.setEventLoad(object, (value.load!=null)?value.load:options.load);
          privateMethods.setColsWidth(object, (value.colsWidth!=null)?value.colsWidth:options.colsWidth);
          privateMethods.setColsDisplayed(object, (value.colsDisplayed!=null)?value.colsDisplayed:options.colsDisplayed);
          privateMethods.setColsCss(object, (value.colsCss!=null)?value.colsCss:options.colsCss);
          privateMethods.setItems(object, (value.items!=null)?value.items:options.items);
          privateMethods.setMultiple(object, (value.multiple!=null)?value.multiple:options.multiple); // can be set only at the initialization

          if(options.autoLoad && options.serverUrl!='')
          {
            privateMethods.load(object, (value.value!=null)?value.value:null);
          }
          else
          {
            privateMethods.setValue(object, (value.value!=null)?value.value:null);
          }

          properties.initialized=true;
        },

      setIsValid : function (object, value)
        {
          var objects=object.data('objects'),
              properties=object.data('properties');

          if(properties.isValid!=value)
          {
            properties.isValid=value;
            if(properties.isValid)
            {
              objects.container.removeClass('ui-error');
            }
            else
            {
              objects.container.addClass('ui-error');
            }
          }
          return(properties.isValid);
        },

      setAutoLoad : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if((!properties.initialized || options.autoLoad!=value) && (value==true || value==false))
          {
            options.autoLoad=value;
          }
          return(options.autoLoad);
        },

      setReturnMode : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if((!properties.initialized || options.returnMode!=value) && (value=='selected' || value=='notSelected'))
          {
            options.returnMode=value;
          }
          return(options.returnMode);
        },

      setColsWidth : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              width=0;

          if((!properties.initialized || options.colsWidth!=value) && $.isArray(value))
          {
            options.colsWidth=value;
          }
          return(options.colsWidth);
        },

      setColsDisplayed : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if((!properties.initialized || options.colsDisplayed!=value) && $.isArray(value))
          {
            options.colsDisplayed=value;
          }
          return(options.colsDisplayed);
        },

      setColsCss : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if((!properties.initialized || options.colsCss!=value) && $.isArray(value))
          {
            options.colsCss=value;
          }
          return(options.colsCss);
        },

      setListMaxWidth : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if((!properties.initialized || options.listMaxWidth!=value) && value>=0)
          {
            options.listMaxWidth=value;
            if(options.listMaxWidth>0)
            {
              objects.listContainer.css('max-width', options.listMaxWidth+'px');
            }
            else
            {
              objects.listContainer.css('max-width', '');
            }
          }
          return(options.listMaxWidth);
        },

      setListMaxHeight : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if((!properties.initialized || options.listMaxHeight!=value) && value>=0)
          {
            options.listMaxHeight=value;
            if(options.listMaxHeight>0)
            {
              objects.listContainer.css('max-height', options.listMaxHeight+'px');
            }
            else
            {
              objects.listContainer.css('max-height', '');
            }
          }
          return(options.listMaxHeight);
        },

      setServerUrl : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if(!properties.initialized || options.serverUrl!=value)
          {
            options.serverUrl=value;
            if(options.autoLoad && properties.initialized) privateMethods.load(object);
          }
          return(options.serverUrl);
        },

      setPostData : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          if(!properties.initialized || value!=options.postData)
          {
            options.postData=value;
          }

          return(options.postData);
        }, // setPostData

      setMultiple : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if((!properties.initialized || options.multiple!=value) && (value==true || value==false))
          {
            if(!value)
            {
              properties.index=-1;
              if(objects.containerList!=null)
              {
                objects.containerList.remove();
                objects.containerList=null;
              }
            }
            else
            {
              properties.index=[];
              objects.listContainer.addClass('ui-inputList-multiple');
              if(objects.containerList==null)
              {
                objects.containerList=$('<ul/>',
                  {
                    html:'<li>&nbsp;</li>'
                  }
                );
                objects.containerValue.html('').append(objects.containerList);
              }
            }
            options.multiple=value;
          }
          return(options.multiple);
        }, //setMultiple

      setPopupMode : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if((!properties.initialized || options.popupMode!=value) && (value=='click' || value=='mouseout'))
          {
            options.popupMode=value;

            if(value=='mouseout')
            {
              objects.listContainer
                .unbind('mouseleave.inputList')
                .unbind('mouseenter.inputList')
                .bind('mouseleave.inputList',
                  function ()
                  {
                    privateMethods.displaySelector(object, false);
                  }
                );
            }
            else
            {
              objects.listContainer
                .unbind('mouseleave.inputList')
                .bind('mouseleave.inputList',
                  function ()
                  {
                    properties.mouseOver=false;
                  }
                )
                .bind('mouseenter.inputList',
                  function ()
                  {
                    properties.mouseOver=true;
                  }
                );
                $(document).bind('focusout.'+properties.objectId+' focusin.'+properties.objectId,
                  function (event)
                  {
                    if($.isPlainObject(properties) && !properties.mouseOver) privateMethods.displaySelector(object, false);
                    event.stopPropagation();
                  }
              );
            }
          }
          return(options.popupMode);
        }, //setPopupMode

      setDownArrow : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if(!properties.initialized || options.downArrow!=value)
          {
            options.downArrow=value;
            objects.containerArrow.html(options.downArrow);
          }
          return(options.downArrow);
        }, //setDownArrow

      setItems : function (object, value)
        {
          var properties=object.data('properties');

          if(value=='' || value==null)
          {
            value=[];
          }
          else if(!$.isArray(value))
          {
            try
            {
              value=$.parseJSON($.trim(value));
            }
            catch (e)
            {
              return(false);
            }
          }

          privateMethods.listClear(object);
          if(value.length>0) privateMethods.listAddItems(object, value);
        },


      setValue : function (object, value, trigger)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects'),
              index=-1;

          re=/^(:invert|:all|:none)(?:(=|<|>)(\d+))$/i;
          target=re.exec(value);
          if(target!=null) value=target[1];

          switch(value)
          {
            case ':first':
              if(properties.items.length>0) index=0;
              break;
            case ':last':
              index=properties.items.length-1;
              break;
            case ':invert':
              if(!options.multiple) return(false);
              properties.index=[];
              objects.list.find('.ui-inputList-item').each(
                function ()
                {
                  var $this=$(this),
                      apply=true;

                  if(target!=null)
                  {
                    switch(target[2])
                    {
                      case '=':
                        apply=($this.attr('level')==target[3]);
                        break;
                      case '>':
                        apply=($this.attr('level')>=target[3]);
                        break;
                      case '<':
                        apply=($this.attr('level')<=target[3]);
                        break;
                    }
                  }

                  if(apply)
                  {
                    if($this.hasClass('ui-inputList-selected-item'))
                    {
                      $this.removeClass('ui-inputList-selected-item');
                    }
                    else
                    {
                      $this.addClass('ui-inputList-selected-item');
                      tmp=privateMethods.findIndexByValue(object, $this.attr('idvalue'));
                      if(tmp>-1) properties.index.push(tmp);
                    }
                  }
                }
              );
              privateMethods.setValue(object, [], false);
              return(false);
              break;
            case ':none':
              if(!options.multiple) return(false);

              properties.index=[];
              objects.list.find('.ui-inputList-selected-item').each(
                function ()
                {
                  var $this=$(this),
                      apply=true;

                  if(target!=null)
                  {
                    switch(target[2])
                    {
                      case '=':
                        apply=($this.attr('level')==target[3]);
                        break;
                      case '>':
                        apply=($this.attr('level')>=target[3]);
                        break;
                      case '<':
                        apply=($this.attr('level')<=target[3]);
                        break;
                    }
                  }

                  if(apply) $this.removeClass('ui-inputList-selected-item');
                }
              );
              privateMethods.setValue(object, [], false);
              return(false);
              break;
            case ':all':
              if(!options.multiple) return(false);
              properties.index=[];
              objects.list.find('.ui-inputList-item').each(
                function ()
                {
                  var $this=$(this),
                      apply=true;

                  if(target!=null)
                  {
                    switch(target[2])
                    {
                      case '=':
                        apply=($this.attr('level')==target[3]);
                        break;
                      case '>':
                        apply=($this.attr('level')>=target[3]);
                        break;
                      case '<':
                        apply=($this.attr('level')<=target[3]);
                        break;
                    }
                  }
                  if(apply)
                  {
                    tmp=privateMethods.findIndexByValue(object, $this.attr('idvalue'));
                    if(tmp>-1) properties.index.push(tmp);

                    $this.addClass('ui-inputList-selected-item');
                  }
                }
              );
              privateMethods.setValue(object, [], false);
              return(false);
              break;
            default:
              if($.isArray(value) && options.multiple)
              {
                index=[];
                for(var i=0;i<value.length;i++)
                {
                  tmp=privateMethods.findIndexByValue(object, value[i]);
                  if(tmp>-1) index.push(tmp);
                }
              }
              else
              {
                index=privateMethods.findIndexByValue(object, value);
              }

              break;
          }

          if(!options.multiple && (!properties.initialized || properties.index!=index) && index>-1)
          {
            objects.list.find('.ui-inputList-selected-item').removeClass('ui-inputList-selected-item');
            objects.list.find('[idvalue="'+value+'"]').addClass('ui-inputList-selected-item');
            properties.index=index;

            privateMethods.setItemContent(object, index, objects.containerValue);
            if(trigger) object.trigger('inputListChange', [properties.items[properties.index].value]);
            if(properties.index>-1) return(properties.items[properties.index].value);
          }
          else if(options.multiple)
          {
            if(!$.isArray(index))
            {
              if(index<0 || index==null) return(-1);
              index=[index];
            }
            tmp=[];
            for(var i=0;i<index.length;i++)
            {
              var item=objects.list.find('[idvalue="'+properties.items[index[i]].value+'"]');
              tmp.push(properties.items[index[i]].value);
              if(item.hasClass('ui-inputList-selected-item'))
              {
                item.removeClass('ui-inputList-selected-item');

                tmpIndex=$.inArray(index[i] ,properties.index);
                if(tmpIndex>-1) properties.index.splice(tmpIndex, 1);
              }
              else
              {
                item.addClass('ui-inputList-selected-item');
                properties.index.push(index[i]);
              }
            }
            objects.containerList.html('');
            objects.list.children('.ui-inputList-selected-item').each(
              function ()
              {
                var value=$(this).attr('idvalue'),
                    index=privateMethods.findIndexByValue(object, value),
                    li=$('<li/>',
                    {
                      'class':'ui-inputList-selected-item'
                    }
                  );
                privateMethods.setItemContent(object, index, li);
                objects.containerList.append(
                  li.prepend(
                    $('<span/>',
                      {
                        'html':'x',
                        'class':'ui-inputList-delete-item'
                      }
                     ).bind('click.inputList',
                        {object:object, value:value},
                        function (event)
                        {
                          event.stopPropagation();
                          privateMethods.setValue(event.data.object, event.data.value, true);
                        }
                      )
                  )
                );
              }
            );

            if(objects.containerList.children().length==0) objects.containerList.append('<li>&nbsp;</li>');

            if(trigger) object.trigger('inputListChange', [tmp]);
            return(tmp);
          }
          return(null);
        },

      displaySelector : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects'),
              scrollBarWidth=0;

          if(properties.selectorVisible!=value)
          {
            properties.selectorVisible=value;

            if(properties.selectorVisible && properties.items.length>0)
            {
              var index=0;
              objects.listContainer
                .css(
                  {
                    display:'block',
                    'min-width':objects.listContainer.parent().css('width')
                  }
                );

              if($.isArray(properties.index))
              {
                if (properties.index.length>0) index=properties.index[0];
              }
              else if(properties.index>-1)
              {
                index=properties.index;
              }

              scrollBarWidth=objects.listContainer.width()-objects.list.width();
              if(scrollBarWidth>0 && properties.firstPopup)
              {
                objects.listContainer.width(objects.listContainer.width()+scrollBarWidth);
                properties.firstPopup=false;
              }

              objects.listContainer.scrollTop(objects.listContainer.scrollTop()+objects.list.find('[idValue="'+properties.items[index].value+'"]').position().top);
            }
            else
            {
              objects.listContainer.css('display', 'none');
            }
            if(options.popup) object.trigger('inputListPopup', [properties.selectorVisible]);
          }
          return(properties.selectorVisible);
        },

      load : function (object, defaultValue)
        {
          // load datas from server through an asynchronous ajax call
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if(options.serverUrl=='') return(false);

          $.ajax(
            {
              type: "POST",
              url: options.serverUrl,
              data:options.postData,
              async: true,
              success: function(msg)
                {
                  privateMethods.setItems(object, msg);

                  properties.initialized=false;
                  if(options.multiple)
                  {
                    if(defaultValue!=null)
                    {
                      privateMethods.setValue(object, defaultValue);
                    }
                    else
                    {
                      privateMethods.setValue(object, ':none');
                    }
                  }
                  else
                  {
                    if(defaultValue!=null)
                    {
                      privateMethods.setValue(object, defaultValue);
                    }
                    else
                    {
                      privateMethods.setValue(object, ':first');
                    }
                  }
                  properties.initialized=true;

                  if(options.load) object.trigger('inputListLoad');
                },
              error: function(msg)
                {
                  objects.listContainer.html('Error ! '+msg);
                }
            }
         );
        },

      listClear : function (object)
        {
          // clear the items list
          var objects=object.data('objects'),
              options=object.data('options'),
              properties=object.data('properties');

          objects.list.children().unbind();
          objects.list.html('');
          if(options.multiple)
          {
            properties.index=[];
          }
          else
          {
            properties.index=-1;
          }
          properties.items=[];
          properties.firstPopup=true;
        },

      listAddItems : function (object, listItems)
        {
          // add the items to the items list
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects'),
              width=0;

          for(var i=0;i<listItems.length;i++)
          {
            properties.items.push(
              {
                value:listItems[i].value,
                cols:listItems[i].cols
              }
            );

            var content=$('<div/>',
                      {
                        'class':'ui-inputList-value'
                      }
                    ),
                li=$('<li/>',
                      {
                        'class':'ui-inputList-item',
                        'idValue':listItems[i].value
                      }
                    ).bind('click.inputList',
                        {object:object},
                        function (event)
                        {
                          privateMethods.setValue(event.data.object, $(this).attr('idValue'), true);
                          if(options.multiple)
                          {
                          }
                          else
                          {
                            privateMethods.displaySelector(event.data.object, false);
                          }

                          if(options.multiple) objects.container.focus();
                        }
                      );

            for(var j=0;j<listItems[i].cols.length;j++)
            {
              content.append($('<span/>',
                  {
                    html:listItems[i].cols[j],
                    css:
                      {
                        width:privateMethods.getColWidth(object, j)
                      },
                    'class':privateMethods.getColCss(object, j)
                  }
                )
              );
            }

            li.append(content);
            if(options.multiple)
            {
              li.children().prepend('<div class="ui-inputList-check"></div>');
            }
            objects.list.append(li);
          }
        },

      findIndexByValue : function (object, value)
        {
          /*
           * search an item inside the item list and return the index
           * in the array
           */
          var properties=object.data('properties');

          for(var i=0;i<properties.items.length;i++)
          {
            if(properties.items[i].value==value) return(i);
          }
          return(-1);
        },

      setEventPopup : function (object, value)
        {
          var options=object.data('options');

          options.popup=value;
          object.unbind('inputListPopup');
          if(value) object.bind('inputListPopup', options.popup);
          return(options.popup);
        },

      setEventChange : function (object, value)
        {
          var options=object.data('options');

          options.change=value;
          object.unbind('inputListChange');
          if(value) object.bind('inputListChange', options.change);
          return(options.change);
        },

      setEventLoad : function (object, value)
        {
          var options=object.data('options');

          options.load=value;
          object.unbind('inputListLoad');
          if(value) object.bind('inputListLoad', options.load);
          return(options.load);
        },

      getColWidth : function (object, index)
        {
          var options=object.data('options');

          if(index>=0 && index<options.colsWidth.length && options.colsWidth[index]!='' && options.colsWidth[index]!=0)
          {
            return(options.colsWidth[index]+'px');
          }
          return('');
        },

      getColCss : function (object, index)
        {
          var options=object.data('options');

          if(index>=0 && index<options.colsCss.length)
          {
            return(options.colsCss[index]);
          }
          return('');
        },

      getColContent : function (object, itemIndex, index)
        {
          var properties=object.data('properties');

          if(index>=0 && index<=properties.items[itemIndex].cols.length)
          {
            return(properties.items[itemIndex].cols[index]);
          }
          return('');
        },

      setItemContent : function (object, index, container)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              colContent='',
              colsDisplayed=[];

          container.html('');

          if(options.colsDisplayed.length==0)
          {
            for(var j=0;j<properties.items[index].cols.length;j++)
            {
              colsDisplayed.push(j);
            }
          }
          else
          {
            colsDisplayed=options.colsDisplayed;
          }

          for(var j=0;j<colsDisplayed.length;j++)
          {
            colContent=privateMethods.getColContent(object, index, colsDisplayed[j]);

            if(colContent!=null)
            {
              container.append($('<span/>',
                  {
                    'html':colContent,
                    css:
                      {
                        width:privateMethods.getColWidth(object, colsDisplayed[j])
                      },
                    'class':privateMethods.getColCss(object, colsDisplayed[j])
                  }
                )
              );
            }
          }
        }
    };


    $.fn.inputList = function(method)
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
        $.error( 'Method ' +  method + ' does not exist on jQuery.inputList' );
      }
    } // $.fn.inputList

  }
)(jQuery);


