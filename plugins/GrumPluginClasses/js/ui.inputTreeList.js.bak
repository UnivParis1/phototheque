/**
 * -----------------------------------------------------------------------------
 * file: ui.inputTreeList.js
 * file version: 1.0.0
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
 * see ui.inputTreeList.help.txt for help about this plugin
 *
 * :: HISTORY ::
 *
 * | release | date       |
 * | 1.0.0   | 2012/08/25 | * first release - fork from ui.categorySelector object
 * |         |            |
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
                      triggerChange:'interface', // ''interface': only through user interface; 'all': when value is changed by function call
                      autoLoad:true,
                      displayNfo:true,
                      listMaxWidth:0,
                      listMaxHeight:0,
                      levelIndent:16,
                      iconWidthEC:15,
                      postUrl:'',
                      postData:{},
                      popup:null,
                      change:null,
                      load:null,
                      multiple:false,
                      popupMode:'click',
                      displayPath:false,
                      downArrow:'' //'&dArr;'
                    };

              // if options given, merge it
              // if(opt) $.extend(options, opt); ==> options are set by setters

              $this.data('options', options);


              if(!properties)
              {
                $this.data('properties',
                  {
                    objectId:'cs'+Math.ceil(timeStamp.getTime()*Math.random()),
                    index:-1,
                    initialized:false,
                    selectorVisible:false,
                    items:[],
                    mouseOver:false,
                    isValid:true
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
                          'class':'ui-inputTreeList',
                          tabindex:0,
                          css:{
                            width:'100%'
                          }
                        }
                    ).bind('click.inputTreeList',
                        function ()
                        {
                          privateMethods.displaySelector($this, !$this.data('properties').selectorVisible);
                          //$(this).focus(); // if get the focus, it hide the dorp-down list.. ?
                        }
                      ),
                    containerName:$('<div/>',
                      {
                        html: '&nbsp;',
                        'class':'ui-inputTreeList-name'
                      }
                    ),
                    containerList:null,
                    containerNfo:$('<div/>',
                      {
                        'class':'ui-inputTreeList-nfo',
                        css: {
                          'float':'right',
                          'display':(options.displayNfo)?'block':'none'
                        }
                      }
                    ),
                    containerArrow:$('<div/>',
                      {
                        html: '&dArr;',
                        'class':'ui-inputTreeList-arrow',
                        css: {
                          'float':'right',
                          cursor:'pointer'
                        }
                      }
                    ).bind('mousedown',
                        function ()
                        {
                          $(this).addClass('ui-inputTreeList-arrow-active');
                        }
                    ).bind('mouseup',
                        function ()
                        {
                          $(this).removeClass('ui-inputTreeList-arrow-active');
                        }
                    ),
                    listContainer:$('<div/>',
                        {
                          html: "",
                          'class':'ui-inputTreeList-list',
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


              if($this.html()!='') privateMethods.setItems($this, $this.html());

              $this
                .html('')
                .append(objects.container.append(objects.containerArrow).append(objects.containerNfo).append(objects.containerName))
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
                  objects = $this.data('objects');
              objects.containerName.unbind().remove();
              objects.containerList.unbind().remove();
              objects.containerNfo.unbind().remove();
              objects.containerArrow.unbind().remove();
              objects.container.unbind().remove();
              objects.list.children().unbind();
              objects.listContainer.remove();
              $(document).unbind('focusout.'+properties.objectId+' focusin.'+properties.objectId);
              $this
                .removeData()
                .unbind('.inputTreeList')
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

      triggerChange: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setTriggerChange($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.triggerChange);
            }
            else
            {
              return(true);
            }
          }
        }, // triggerChange

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

      displayNfo: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setDisplayNfo($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.displayNfo);
            }
            else
            {
              return(true);
            }
          }
        }, // displayNfo

      levelIndent: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setLevelIndent($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.levelIndent);
            }
            else
            {
              return(0);
            }
          }
        }, // levelIndent

      postUrl: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setPostUrl($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.postUrl);
            }
            else
            {
              return('');
            }
          }
        }, // postUrl

      postData: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setPostData($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.postData);
            }
            else
            {
              return('');
            }
          }
        }, // postData

      collapse: function (value)
        {
          return this.each(function()
            {
              if(!value) value=':all';
              privateMethods.setExpandCollapse($(this), value, 'C');
            }
          );
        }, // collapse

      expand: function (value)
        {
          return this.each(function()
            {
              if(!value) value=':all';
              privateMethods.setExpandCollapse($(this), value, 'E');
            }
          );
        }, // expand

      iconWidthEC: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setIconWidthEC($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.iconWidthEC);
            }
            else
            {
              return(0);
            }
          }
        }, // iconWidthEC

      name: function ()
        {
          var options=this.data('options'),
              properties=this.data('properties');

          if(!options.multiple)
          {
            return(properties.items[properties.index].name);
          }
          else
          {
            var listNames=[];
            for(var i=0;i<properties.index.length;i++)
            {
              listNames.push(properties.items[properties.index[i]].name);
            }
            return(listNames);
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

      displayPath: function (value)
        {
          if(value!=null)
          {
            return this.each(function()
              {
                privateMethods.setDisplayPath($(this), value);
              }
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.displayPath);
            }
            else
            {
              return(0);
            }
          }
        }, // displayPath

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

      value: function (value)
        {
          var options = this.data('options');

          if(value!=null)
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setValue($(this), value, (options.triggerChange=='all'));
              }
            );
          }
          else
          {
            // return the selected value
            var properties=this.data('properties');


            if(properties && properties.index!=null && !options.multiple && properties.index>-1 && properties.index<properties.items.length)
            {
              return(properties.items[properties.index].id);
            }
            else if(properties && properties.index!=null && options.multiple)
            {
              var returned=[];
              for(var i=0;i<properties.index.length;i++)
              {
                if(properties.index[i]>-1 && properties.index[i]<properties.items.length)
                  returned.push(properties.items[properties.index[i]].id);
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
            return this.each(function()
              {
                privateMethods.setIsValid($(this), value);
              }
            );
          }
          else
          {
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

      numberOfCategories: function ()
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
        }, // numberOfCategories

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
          else if(properties && value>-1)
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
        }, // numberOfCategories
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

          privateMethods.setTriggerChange(object, (value.triggerChange!=null)?value.triggerChange:options.triggerChange);
          privateMethods.setAutoLoad(object, (value.autoLoad!=null)?value.autoLoad:options.autoLoad);
          privateMethods.setDisplayNfo(object, (value.displayNfo!=null)?value.displayNfo:options.displayNfo);
          privateMethods.setListMaxWidth(object, (value.listMaxWidth!=null)?value.listMaxWidth:options.listMaxWidth);
          privateMethods.setListMaxHeight(object, (value.listMaxHeight!=null)?value.listMaxHeight:options.listMaxHeight);
          privateMethods.setLevelIndent(object, (value.levelIndent!=null)?value.levelIndent:options.levelIndent);
          privateMethods.setIconWidthEC(object, (value.iconWidthEC!=null)?value.iconWidthEC:options.iconWidthEC);
          privateMethods.setPostUrl(object, (value.postUrl!=null)?value.postUrl:options.postUrl);
          privateMethods.setPostData(object, (value.postData!=null)?value.postData:options.postData);
          privateMethods.setPopupMode(object, (value.popupMode!=null)?value.popupMode:options.popupMode);
          privateMethods.setDisplayPath(object, (value.displayPath!=null)?value.displayPath:options.displayPath);
          privateMethods.setDownArrow(object, (value.downArrow!=null)?value.downArrow:options.downArrow);
          privateMethods.setEventPopup(object, (value.popup!=null)?value.popup:options.popup);
          privateMethods.setEventChange(object, (value.change!=null)?value.change:options.change);
          privateMethods.setEventLoad(object, (value.load!=null)?value.load:options.load);
          privateMethods.setMultiple(object, (value.multiple!=null)?value.multiple:options.multiple); // can be set only at the initialization

          if(options.autoLoad) privateMethods.load(object);

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
        }, // setIsValid

      setTriggerChange : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if((!properties.initialized || options.triggerChange!=value) && (value=='interface' || value=='all'))
          {
            options.triggerChange=value;
          }
          return(options.triggerChange);
        }, // setTriggerChange

      setAutoLoad : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if((!properties.initialized || options.autoLoad!=value) && (value==true || value==false))
          {
            options.autoLoad=value;
          }
          return(options.autoLoad);
        }, // setAutoLoad


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
        }, // setListMaxWidth

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
        }, // setListMaxHeight

      setDisplayNfo : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if((!properties.initialized || options.displayNfo!=value) && (value==true || value==false))
          {
            options.displayNfo=value;
            if(options.displayNfo)
            {
              object.find('.ui-inputTreeList-nfo').show();
            }
            else
            {
              object.find('.ui-inputTreeList-nfo').hide();
            }
          }
          return(options.displayNfo);
        }, // setDisplayNfo

      setLevelIndent : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if((!properties.initialized || options.levelIndent!=value) && value>=0)
          {
            options.levelIndent=value;
            objects.list.find('.ui-inputTreeList-item div.ui-inputTreeList-expand-item').each(
              function ()
              {
                $(this).css('padding-left', (options.iconWidthEC+$(this).attr('level')*options.levelIndent)+'px');
              }
            );
          }
          return(options.levelIndent);
        }, // setLevelIndent

      setPostUrl : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if(!properties.initialized || options.postUrl!=value)
          {
            options.postUrl=value;
            if(options.autoLoad && properties.initialized) privateMethods.load(object);
          }
          return(options.postUrl);
        }, // setPostUrl

      setPostData : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if(!properties.initialized || options.postData!=value)
          {
            options.postData=value;
            if(options.autoLoad && properties.initialized) privateMethods.load(object);
          }
          return(options.postData);
        },  // setPostData

      setIconWidthEC : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if((!properties.initialized || options.iconWidthEC!=value) && value>=0)
          {
            options.iconWidthEC=value;
            objects.list.find('.ui-inputTreeList-item div.ui-inputTreeList-expand-item').each(
              function ()
              {
                $(this).css('padding-left', (options.iconWidthEC+$(this).attr('level')*options.levelIndent)+'px');
              }
            );
          }
          return(options.iconWidthEC);
        }, // setIconWidthEC

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
              objects.listContainer.addClass('ui-inputTreeList-multiple');
              if(objects.containerList==null)
              {
                objects.containerList=$('<ul/>',
                  {
                    css: {
                      listStyle:'none',
                      padding:'0px',
                      margin:'0px',
                      overflow:"auto"
                    },
                    html:'<li>&nbsp;</li>'
                  }
                );
                objects.containerName.html('').append(objects.containerList);
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
                .unbind('mouseleave.inputTreeList')
                .unbind('mouseenter.inputTreeList')
                .bind('mouseleave.inputTreeList',
                  function ()
                  {
                    privateMethods.displaySelector(object, false);
                  }
                );
            }
            else
            {
              objects.listContainer
                .unbind('mouseleave.inputTreeList')
                .bind('mouseleave.inputTreeList',
                  function ()
                  {
                    properties.mouseOver=false;
                  }
                )
                .bind('mouseenter.inputTreeList',
                  function ()
                  {
                    properties.mouseOver=true;
                  }
                );
              $(document).bind('focusout.'+properties.objectId+' focusin.'+properties.objectId,
                function (event)
                {
                  if(!properties.mouseOver) privateMethods.displaySelector(object, false);
                }
              );
            }
          }
          return(options.popupMode);
        }, //setPopupMode


      setDisplayPath : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if((!properties.initialized || options.displayPath!=value) && (value==true || value==false))
          {
            options.displayPath=value;

          }
          return(options.displayPath);
        }, //setDisplayPath

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
          var properties=object.data('properties'),
              options=object.data('options'),
              objects=object.data('objects');

          if(value=='' || value==null)
          {
            value={
              items:[]
            }
          }
          else if($.isArray(value))
          {
            value={
              items:value
            }
          }
          else
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
          if(value.items.length>0) privateMethods.listAddItems(object, value.items, objects.list);

          properties.initialized=false;
          if(options.multiple)
          {
            privateMethods.setValue(object, ':none', (options.triggerChange=='all'));
          }
          else
          {
            privateMethods.setValue(object, ':first', (options.triggerChange=='all'));
          }
          properties.initialized=true;

          if(options.load) object.trigger('inputTreeListLoad');
        }, // setItems

      /**
       * usage : see notes on the header file
       *
       * @param jQuery object : the jQuery object
       * @param String value : the filter
       * @param String mode : 'C' for collapse, 'E' for expand
       */
      setExpandCollapse : function (object, value, mode)
        {
          var objects=object.data('objects');

          /*
           *  target[1] = ':all' or itemId
           * target[2] = '=' or '<' or '>' or '+'
           * target[3] = level
           */
          re=/^(?:(:all)(?:(=|<|>|\+)(\d+))?)|(?:(\d+)(<|>|\+))?$/i;
          target=re.exec(value);

          if(target!=null)
          {
            switch(mode)
            {
              case 'C':
                applyExpandCollapse=privateMethods.applyCollapse;
                break;
              case 'E':
                applyExpandCollapse=privateMethods.applyExpand;
                break;
            }


            if(target[1]==':all')
            {
              objects.list.find('.ui-inputTreeList-expandable-item, .ui-inputTreeList-collapsable-item').each(applyExpandCollapse);
            }
            else if(target[4]!=null)
            {
              switch(target[5])
              {
                case '+':
                  objects.list.find('.ui-inputTreeList-expandable-item, .ui-inputTreeList-collapsable-item').each(privateMethods.applyCollapse);
                  objects.list.find(':has([itemId='+target[4]+'])').prev().each(privateMethods.applyExpand);
                  objects.list.find('[itemId='+target[4]+']').each(applyExpandCollapse);
                  break;
                case '>':
                  objects.list.find('[itemId='+target[4]+'] + ul').find('.ui-inputTreeList-expandable-item, .ui-inputTreeList-collapsable-item').each(applyExpandCollapse);
                  objects.list.find('[itemId='+target[4]+']').each(applyExpandCollapse);
                  break;
                case '<':
                  objects.list.find(':has([itemId='+target[4]+'])').prev().each(applyExpandCollapse);
                  objects.list.find('[itemId='+target[4]+']').each(applyExpandCollapse);
                  break;
                default:
                  objects.list.find('[itemId='+target[4]+']').each(applyExpandCollapse);
                  break;
              }
            }

          }
        }, //setExpandCollapse

      applyExpand : function (index, domElt)
        {
          privateMethods.applyExpandCollapse(index, domElt, 'E');
        }, //applyExpand

      applyCollapse : function (index, domElt)
        {
          privateMethods.applyExpandCollapse(index, domElt, 'C');
        }, //applyCollapse

      /**
       * used by the setExpandCollapse function
       * not aimed to be used directly
       */
      applyExpandCollapse : function (index, domElt, mode)
              {
                action='';
                var $domElt=$(domElt);

                if(target.length>2 && target[2]!=null && target[3]!=null)
                {
                  switch(target[2])
                  {
                    case '=':
                      if($domElt.attr('level')==target[3]) action=mode;
                      break;
                    case '>':
                      if($domElt.attr('level')>=target[3]) action=mode;
                      break;
                    case '<':
                      if($domElt.attr('level')<=target[3]) action=mode;
                      break;
                    case '+':
                      if((mode=='E' && $domElt.attr('level')<=target[3]) ||
                         (mode=='C' && $domElt.attr('level')>=target[3]))
                      {
                        action=mode;
                      }
                      else
                      {
                        action=(mode=='C')?'E':'C';
                      }
                      break;
                  }
                }
                else action=mode;

                switch(action)
                {
                  case 'C':
                    $domElt
                      .removeClass('ui-inputTreeList-expandable-item ui-inputTreeList-collapsable-item')
                      .addClass('ui-inputTreeList-expandable-item')
                      .next().hide();
                    break;
                  case 'E':
                    $domElt
                      .removeClass('ui-inputTreeList-expandable-item ui-inputTreeList-collapsable-item')
                      .addClass('ui-inputTreeList-collapsable-item')
                      .next().show();
                    break;
                }

              }, //applyExpandCollapse

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
              objects.list.find('.ui-inputTreeList-item').each(
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
                    if($this.hasClass('ui-inputTreeList-selected-item'))
                    {
                      $this
                        .removeClass('ui-inputTreeList-selected-item')
                        .addClass('ui-inputTreeList-unselected-item');
                    }
                    else
                    {
                      $this
                        .addClass('ui-inputTreeList-selected-item')
                        .removeClass('ui-inputTreeList-unselected-item');
                      tmp=privateMethods.findIndexByValue(object, $this.attr('itemId'));
                      if(tmp>-1) properties.index.push(tmp);
                    }
                  }
                }
              );
              privateMethods.setValue(object, [], (options.triggerChange=='all'));
              return(false);
              break;
            case ':none':
              if(!options.multiple) return(false);

              properties.index=[];
              objects.list.find('.ui-inputTreeList-selected-item').each(
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
                    $this
                      .removeClass('ui-inputTreeList-selected-item')
                      .addClass('ui-inputTreeList-unselected-item');
                }
              );
              privateMethods.setValue(object, [], (options.triggerChange=='all'));
              return(false);
              break;
            case ':all':
              if(!options.multiple) return(false);
              properties.index=[];
              objects.list.find('.ui-inputTreeList-item').each(
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
                    tmp=privateMethods.findIndexByValue(object, $this.attr('itemId'));
                    if(tmp>-1) properties.index.push(tmp);

                    $this
                      .addClass('ui-inputTreeList-selected-item')
                      .removeClass('ui-inputTreeList-unselected-item');
                  }
                }
              );
              privateMethods.setValue(object, [], (options.triggerChange=='all'));
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
            objects.list.find('.ui-inputTreeList-selected-item')
              .removeClass('ui-inputTreeList-selected-item')
              .addClass('ui-inputTreeList-unselected-item');

            objects.list.find('[itemId="'+value+'"]')
              .addClass('ui-inputTreeList-selected-item')
              .removeClass('ui-inputTreeList-unselected-item');

            title=privateMethods.getParentName(object, objects.list.find('[itemId="'+value+'"] div.ui-inputTreeList-name')).replace('&amp;', '&').replace('&gt;', '>').replace('&lt;', '<');

            if(!options.displayPath)
            {
              path=properties.items[properties.index].name;
            }
            else
            {
              path=title;
            }

            properties.index=index;
            objects.containerName.html(path).attr('title', title);
            objects.containerNfo.html(properties.items[properties.index].nfo);
            if(trigger && options.change) object.trigger('inputTreeListChange', [properties.items[properties.index].id]);
            if(properties.index>-1) return(properties.items[properties.index].id);
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
              var item=objects.list.find('[itemId="'+properties.items[index[i]].id+'"]');

              if(item.hasClass('ui-inputTreeList-selected-item'))
              {
                item
                  .removeClass('ui-inputTreeList-selected-item')
                  .addClass('ui-inputTreeList-unselected-item');

                tmpIndex=$.inArray(index[i] ,properties.index);
                if(tmpIndex>-1) properties.index.splice(tmpIndex, 1);
              }
              else
              {
                item
                  .addClass('ui-inputTreeList-selected-item')
                  .removeClass('ui-inputTreeList-unselected-item');

                properties.index.push(index[i]);
              }
              tmp.push(properties.items[index[i]].id);
            }
            objects.containerList.html('');
            objects.list.find('.ui-inputTreeList-selected-item div.ui-inputTreeList-name').each(
              function ()
              {
                var path='';

                title=privateMethods.getParentName(object, $(this)).replace('&amp;', '&').replace('&gt;', '>').replace('&lt;', '<');
                if(!options.displayPath)
                {
                  path=$(this).html();
                }
                else
                {
                  path=title;
                }

                objects.containerList.append(
                  $('<li/>',
                    {
                      html:path,
                      title:title,
                      'class':'ui-inputTreeList-selected-cat'
                    }
                  ).prepend(
                      $('<span/>',
                        {
                          html:'x'
                        }
                       ).bind('click.inputTreeList',
                          {object:object, value:$(this).parent().parent().attr('itemId')},
                          function (event)
                          {
                            event.stopPropagation();
                            privateMethods.setValue(event.data.object, event.data.value, true);
                          }
                        )
                      )
                )
              }
            );

            if(objects.containerList.children().length==0) objects.containerList.append('<li>&nbsp;</li>');

            if(trigger && options.change) object.trigger('inputTreeListChange', [tmp]);
            return(tmp);
          }
          return(null);
        }, //setValue

      getParentName : function (object, item)
      {
        if(item==null || item.length==0) return('');
        foundItem=item.parent().parent().parent().prev().find('div.ui-inputTreeList-name');

        if(foundItem.length==0) return(item.html());

        return(privateMethods.getParentName(object, foundItem)+' / '+item.html());
      }, // getParentName

      displaySelector : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

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
              objects.listContainer.scrollTop(objects.listContainer.scrollTop()+objects.list.find('[itemId="'+properties.items[index].id+'"]').position().top);
            }
            else
            {
              objects.listContainer.css('display', 'none');
            }
            if(options.popup) object.trigger('inputTreeListPopup', [properties.selectorVisible]);
          }
          return(properties.selectorVisible);
        }, // displaySelector

      load : function (object)
        {
          // load datas from server through an asynchronous ajax call
          var options=object.data('options'),
              objects=object.data('objects');

          if(options.postUrl=='') return(false);

          $.ajax(
            {
              type: "POST",
              url: options.postUrl,
              async: true,
              data:options.postData,
              success: function(msg)
                {
                  privateMethods.setItems(object, msg);
                },
              error: function(msg)
                {
                  objects.listContainer.html('Error ! '+msg);
                },
            }
         );
        }, // load

      listClear : function (object)
        {
          // clear the item list
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
        }, // listClear

      listAddItems : function (object, listItems, parent)
        {
          // add the items to the item list
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          var previousLevel=-1;
          for(var i=0;i<listItems.length;i++)
          {
            properties.items.push(
              {
                id:listItems[i].id,
                level:listItems[i].level,
                name:listItems[i].name,
                nfo:listItems[i].nfo,
                childs:listItems[i].childs.length
              }
            );

            if(options.displayNfo)
            {
              nfo="<div class='ui-inputTreeList-nfo'>"+listItems[i].nfo+"</div>";
            }
            else
            {
              nfo="";
            }

            var spaceWidth = listItems[i].level*options.levelIndent,
                li=$('<li/>',
                      {
                        'class':'ui-inputTreeList-item ui-inputTreeList-unselected-item',
                        html:"<div>"+nfo+"<div class='ui-inputTreeList-name'>"+listItems[i].name+"</div></div>",
                        itemId:listItems[i].id,
                        level:listItems[i].level,
                        css:{
                          'padding-left':spaceWidth+'px'
                        }
                      }
                    ).bind('click.inputTreeList',
                        {object:object, expandArea: spaceWidth+options.iconWidthEC, nbchilds:listItems[i].childs.length },
                        function (event)
                        {
                          event.layerX=event.pageX-$(event.currentTarget).offset().left;
                          event.layerY=event.pageY-$(event.currentTarget).offset().top;
                          if(event.layerX<event.data.expandArea && event.data.nbchilds>0 )
                          {
                            if($(this).hasClass('ui-inputTreeList-expandable-item'))
                            {
                              $(this)
                                .removeClass('ui-inputTreeList-expandable-item')
                                .addClass('ui-inputTreeList-collapsable-item')
                                .next().show();
                            }
                            else
                            {
                              $(this)
                                .removeClass('ui-inputTreeList-collapsable-item')
                                .addClass('ui-inputTreeList-expandable-item')
                                .next().hide();
                            }
                          }
                          else
                          {
                            privateMethods.setValue(event.data.object, $(this).attr('itemId'), true);
                            if(options.multiple)
                            {
                            }
                            else
                            {
                              privateMethods.displaySelector(event.data.object, false);
                            }
                          }

                          if(options.multiple) objects.container.focus();
                        }
                      );
            /*
            if(listItems[i].childs.length>0)
            {
              li.addClass('ui-inputTreeList-collapsable-item').css('background-position', (options.levelIndent*listItems[i].level)+'px 0px');
            }
            */

            if(options.multiple)
            {
              li.children().prepend('<div class="ui-inputTreeList-check"></div>');
            }

            parent.append(li);

            if(listItems[i].childs.length>0)
            {
              li.addClass('ui-inputTreeList-expandable-item')
                .children().prepend('<div class="ui-inputTreeList-expand-item"></div>');

              var ul=$('<ul/>',
                        {
                          'class':'ui-inputTreeList-group',
                          css: {
                            listStyle:'none',
                            padding:'0px',
                            margin:'0px',
                            'font-size':(100-listItems[i].level*2)+'%'
                          }
                        }
                      );
              li.after(ul);
              privateMethods.listAddItems(object, listItems[i].childs, ul);
            }
            else
            {
              li.css('padding-left', (spaceWidth+options.iconWidthEC)+'px');
            }

          }
        }, // listAddItems

      findIndexByValue : function (object, value)
        {
          /*
           * search an item inside the items list and return the index
           * in the array
           */
          var properties=object.data('properties');

          for(var i=0;i<properties.items.length;i++)
          {
            if(properties.items[i].id==value) return(i);
          }
          return(-1);
        }, // findIndexByValue

      setEventPopup : function (object, value)
        {
          var options=object.data('options');

          options.popup=value;
          object.unbind('inputTreeListPopup');
          if(value) object.bind('inputTreeListPopup', options.popup);
          return(options.popup);
        }, // setEventPopup

      setEventChange : function (object, value)
        {
          var options=object.data('options');

          options.change=value;
          object.unbind('inputTreeListChange');
          if(value) object.bind('inputTreeListChange', options.change);
          return(options.change);
        }, // setEventChange

      setEventLoad : function (object, value)
        {
          var options=object.data('options');

          options.load=value;
          object.unbind('inputTreeListLoad');
          if(value) object.bind('inputTreeListLoad', options.load);
          return(options.load);
        } // setEventLoad
    };


    $.fn.inputTreeList = function(method)
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
        $.error( 'Method ' +  method + ' does not exist on jQuery.inputTreeList' );
      }
    } // $.fn.inputTreeList

  }
)(jQuery);


