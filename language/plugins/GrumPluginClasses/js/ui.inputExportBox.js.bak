/**
 * -----------------------------------------------------------------------------
 * file: ui.inputExportBox.js
 * file version: 1.0.0
 * date: 2012-09-02
 *
 * A jQuery plugin provided by the piwigo's plugin "GrumPluginClasses"
 *
 * -----------------------------------------------------------------------------
 * Author     : Grum
 *   email    : grum@piwigo.com
 *   website  : http://www.grum.fr
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
 * | 1.0.0   | 2012/09/02 | first release
 * |         |            |
 * |         |            |
 * |         |            |
 * |         |            |
 * |         |            |
 * |         |            |
 *
 */

var inputExportBoxLang={
    'export':'Export',
    'name':'Name',
    'format':'Format',
    'compression':'Compression'
  };


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
                      chooseFormat:true,
                      chooseCompression:true,
                      chooseName:true,
                      formatList:[],
                      compressionList:[],
                      name:'',
                      format:'',
                      compression:''
                    };

              // if options given, merge it
              // if(opt) $.extend(options, opt); ==> options are set by setters

              $this.data('options', options);


              if(!properties)
              {
                $this.data('properties',
                  {
                    isValid:false
                  }
                );
                properties=$this.data('properties');
              }

              if(!objects)
              {
                objects =
                  {
                    content:$('<table/>',
                        {
                          'class':'ui-inputExportBox-content'
                        }
                      ),
                    nameRow:$('<tr/>',
                        {
                          'class':'ui-inputExportBox-contentRow'
                        }
                      ),
                    nameInput:$('<div/>',
                        {
                          'class':'ui-inputExportBox-inputName'
                        }
                      ),
                    formatRow:$('<tr/>',
                        {
                          'class':'ui-inputExportBox-contentRow'
                        }
                      ),
                    formatInput:$('<div/>',
                        {
                          'class':'ui-inputExportBox-inputFormat'
                        }
                      ),
                    compressionRow:$('<tr/>',
                        {
                          'class':'ui-inputExportBox-contentRow'
                        }
                      ),
                    compressionInput:$('<div/>',
                        {
                          'class':'ui-inputExportBox-inputCompression'
                        }
                      )
                  };

                $this
                  .html('')
                  .addClass('ui-inputExportBox')
                  .append(objects.content
                            .append(objects.nameRow
                                      .append($('<td/>', {'html':inputExportBoxLang['name']}))
                                      .append($('<td/>').append(objects.nameInput))
                                   )
                            .append(objects.formatRow
                                      .append($('<td/>', {'html':inputExportBoxLang['format']}))
                                      .append($('<td/>').append(objects.formatInput))
                                   )
                            .append(objects.compressionRow
                                      .append($('<td/>', {'html':inputExportBoxLang['compression']}))
                                      .append($('<td/>').append(objects.compressionInput))
                                   )
                         );

                objects.nameInput.inputText(
                  {
                    regExp:'/^([a-z0-9_\.]|-)+$/i',
                    change: function (event, value)
                      {
                        options.name=value;
                        properties.isValid=$(this).inputText('isValid');
                      }
                  }
                );
                objects.formatInput.inputList(
                  {
                    listMaxWidth:500,
                    listMaxHeight:200,
                    multiple:false,
                    colsWidth:[],
                    colsDisplayed:[0,1],
                    colsCss:["ui-inputExportBox-formatInput-value","ui-inputExportBox-formatInput-info"],
                    change: function (event, value)
                      {
                        options.format=value;
                      }
                  }
                );
                objects.compressionInput.inputList(
                  {
                    listMaxWidth:500,
                    listMaxHeight:200,
                    multiple:false,
                    colsWidth:[],
                    colsDisplayed:[0,1],
                    colsCss:["ui-inputExportBox-compressionInput-value","ui-inputExportBox-compressionInput-info"],
                    change: function (event, value)
                      {
                        options.compression=value;
                      }
                  }
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
              objects.compressionInput.inputList('destroy').remove();
              objects.compressionRow.remove();
              objects.formatInput.inputList('destroy').remove();
              objects.formatRow.remove();
              objects.nameInput.remove();
              objects.nameRow.remove();
              objects.content.remove();

              delete objects.compressionInput;
              delete objects.compressionRow;
              delete objects.formatInput;
              delete objects.formatRow;
              delete objects.nameInput;
              delete objects.nameRow;
              delete objects.content;

              $this.removeClass('ui-inputExportBox');
            }
          );
        }, // destroy

      options: function (value)
        {
          if(value!=null)
          {
            return(
              this.each(
                function()
                {
                  privateMethods.setOptions($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options);
          }
        }, // options

      // set or return the value for chooseName option
      chooseName: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setChooseName($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.chooseName);
          }
        }, // chooseName

      // set or return the value for chooseFormat option
      chooseFormat: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setChooseFormat($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.chooseFormat);
          }
        }, // chooseFormat

      // set or return the value for chooseCompression option
      chooseCompression: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setChooseCompression($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.chooseCompression);
          }
        }, // chooseCompression

      // set or return the available formats
      formatList: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setFormatList($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.formatList);
          }
        }, // formatList

      // set or return the available compression methods
      compressionList: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setCompressionList($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.compressionList);
          }
        }, // formatList


      // set or return the name
      name: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setName($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.name);
          }
        }, // name


      // set or return the selected format
      format: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setFormat($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.format);
          }
        }, // format

      // set or return the selected compression
      compression: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setCompression($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.compression);
          }
        }, // compression

      // return true if export box is filled
      isValid: function ()
        {
          var properties=this.data('properties');
          privateMethods.checkValid($(this));
          return(properties.isValid);
        },

      // add a new format to the list
      addFormat: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.addFormat($(this), value);
                }
              )
            );
          }
        }, // addFormat

      // remove a format from the list
      removeFormat: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.removeFormat($(this), value);
                }
              )
            );
          }
        }, // removeFormat

      // add a compression type to the list
      addCompression: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.addCompression($(this), value);
                }
              )
            );
          }
        }, // addCompression

      // set or return the name
      removeCompression: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.removeCompression($(this), value);
                }
              )
            );
          }
        } // removeCompression

    }; // methods


    /*
     * plugin 'private' methods
     */
    var privateMethods =
    {
      setOptions : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options'),
              objects=object.data('objects');

          if(!$.isPlainObject(value)) return(false);

          properties.initialized=false;

          privateMethods.setName(object, (value.name!=null)?value.name:options.name);
          privateMethods.setCompressionList(object, (value.compressionList!=null)?value.compressionList:options.compressionList);
          privateMethods.setFormatList(object, (value.formatList!=null)?value.formatList:options.formatList);
          privateMethods.setCompression(object, (value.compression!=null)?value.compression:options.compression);
          privateMethods.setFormat(object, (value.format!=null)?value.format:options.format);
          privateMethods.setChooseName(object, (value.chooseName!=null)?value.chooseName:options.chooseName);
          privateMethods.setChooseCompression(object, (value.chooseCompression!=null)?value.chooseCompression:options.chooseCompression);
          privateMethods.setChooseFormat(object, (value.chooseFormat!=null)?value.chooseFormat:options.chooseFormat);

          if((options.format==null || options.format=='') && options.chooseFormat)
            options.format=objects.formatInput.inputList('value', ':first').inputList('value');

          if((options.compression==null || options.compression=='') && options.chooseCompression)
            options.compression=objects.compressionInput.inputList('value', ':first').inputList('value');


          properties.initialized=true;
        },


      checkValid: function (object)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          properties.isValid=objects.nameInput.inputText('isValid', 'check').inputText('isValid');
        },

      setChooseCompression: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if((!properties.initialized || value!=options.chooseCompression) && (value==true || value==false))
          {
            options.chooseCompression=value;
            objects.compressionRow.css('display', options.chooseCompression?'table-row':'none');
          }
          return(options.chooseCompression);
        }, // setChooseCompression

      setChooseFormat: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if((!properties.initialized || value!=options.chooseFormat) && (value==true || value==false))
          {
            options.chooseFormat=value;
            objects.formatRow.css('display', options.chooseFormat?'table-row':'none');
          }
          return(options.chooseFormat);
        }, // setChooseFormat

      setChooseName: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if((!properties.initialized || value!=options.chooseName) && (value==true || value==false))
          {
            options.chooseName=value;
            objects.formatRow.css('display', options.chooseName?'table-row':'none');
          }
          return(options.chooseName);
        }, // setChooseName

      setName: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if(!properties.initialized || value!=options.name)
          {
            options.name=value;
            objects.nameInput.inputText('value', options.name);
          }
          return(options.name);
        }, // setName

      setFormat: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if(!properties.initialized || value!=null)
          {
            options.format=objects.formatInput.inputList('value', value).inputList('value');
          }
          return(options.format);
        }, // setFormat

      setCompression: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if(!properties.initialized || value!=null)
          {
            options.compression=objects.compressionInput.inputList('value', value).inputList('value');
          }
          return(options.compression);
        }, // setCompression


      setCompressionList: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if(!properties.initialized || $.isArray(value))
          {
            privateMethods.removeCompression(object, 'all');
            for(var i=0;i<value.length;i++)
            {
              privateMethods.addCompression(object, value[i]);
            }
          }
          return(options.compressionList);
        }, // setCompressionList

      setFormatList: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if(!properties.initialized || $.isArray(value))
          {
            privateMethods.removeFormat(object, 'all');
            for(var i=0;i<value.length;i++)
            {
              privateMethods.addFormat(object, value[i]);
            }
          }
          return(options.formatList);
        }, // setFormatList

      addCompression: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if($.isPlainObject(value) &&
             value.id!=null &&
             value.id!='' &&
             value.text!=null &&
             value.text!=''
            )
          {
            options.compressionList.push(
              {
                id:value.id,
                text:value.text,
                infos:(value.infos!=null)?value.infos:''
              }
            );
          }
          else if(value=='all')
          {
            options.compressionList=[];
          }
          privateMethods.applyListValues(object, 'compressionList');
        }, // addCompression

      removeCompression: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if(value!=null && value!='')
          {
            for(var i=0;i<options.compressionList.length;i++)
            {
              if(options.compressionList[i].id==value)
              {
                options.compressionList.splice(i, 1);
                privateMethods.applyListValues(object, 'compressionList');
                return(true);
              }
            }
          }
          return(false);
        }, // removeCompression

      addFormat: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if($.isPlainObject(value) &&
             value.id!=null &&
             value.id!='' &&
             value.text!=null &&
             value.text!=''
            )
          {
            options.formatList.push(
              {
                id:value.id,
                text:value.text,
                infos:(value.infos!=null)?value.infos:''
              }
            );
          }
          else if(value=='all')
          {
            options.formatList=[];
          }
          privateMethods.applyListValues(object, 'formatList');
        }, // addFormat

      removeFormat: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if(value!=null && value!='')
          {
            for(var i=0;i<options.formatList.length;i++)
            {
              if(options.formatList[i].id==value)
              {
                options.formatList.splice(i, 1);
                privateMethods.applyListValues(object, 'formatList');
                return(true);
              }
            }
          }
          return(false);
        }, // removeFormat

      applyListValues: function (object, list)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects'),
              target=null,
              source=null,
              values=[];

          switch(list)
          {
            case 'compressionList':
              target=objects.compressionInput;
              source=options.compressionList;
              break;
            case 'formatList':
              target=objects.formatInput;
              source=options.formatList;
              break;
          }

          for(var i=0;i<source.length;i++)
          {
            values.push(
              {
                value:source[i].id,
                cols:[source[i].text, source[i].infos]
              }
            );
          }
          target.inputList('items', values);
        } // applyListValues

    };

    $.fn.inputExportBox = function(method)
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
        $.error( 'Method ' +  method + ' does not exist on jQuery.inputExportBox' );
      }
    } // $.fn.inputExportBox

  }
)(jQuery);


/**
 * open a modal dialog box for export
 */
$.dialogExport = function (opt)
{
  var options=
        {
          width:350,
          height:150,
          title:'Export',
          buttons:
            {
              ok:'Ok',
              cancel:'Cancel'
            },
          chooseFormat:true,
          chooseCompression:true,
          chooseName:true,
          formatList:[],
          compressionList:[],
          name:'',
          format:'',
          compression:'',
          validExport:null,
          cancelExport:null
        },
      objects=
        {
          dialogBox:$('<div/>'),
          iExport:$('<div/>')
        },

  setOptions = function (opt)
    {
      if(opt.width!=null && opt.width>0) options.width=opt.width;
      if(opt.height!=null && opt.height>0) options.height=opt.height;
      if(opt.title) options.title=opt.title;
      if(opt.buttons && opt.buttons.ok) options.buttons.ok=opt.buttons.ok;
      if(opt.buttons && opt.buttons.cancel) options.buttons.cancel=opt.buttons.cancel;
      if(opt.chooseFormat!=null && (opt.chooseFormat==true || opt.chooseFormat==false)) options.chooseFormat=opt.chooseFormat;
      if(opt.chooseCompression!=null && (opt.chooseCompression==true || opt.chooseCompression==false)) options.chooseCompression=opt.chooseCompression;
      if(opt.chooseName!=null && (opt.chooseName==true || opt.chooseName==false)) options.chooseName=opt.chooseName;
      if(opt.formatList && $.isArray(opt.formatList)) options.formatList=opt.formatList;
      if(opt.compressionList && $.isArray(opt.compressionList)) options.compressionList=opt.compressionList;
      if(opt.name) options.name=opt.name;
      if(opt.format) options.format=opt.format;
      if(opt.compression) options.compression=opt.compression;

      if(opt.validExport && $.isFunction(opt.validExport)) options.validExport=opt.validExport;
      if(opt.cancelExport && $.isFunction(opt.cancelExport)) options.cancelExport=opt.cancelExport;
    },

  initDialog = function ()
    {
      var dialogOpt={},
          dialogButtons={};

      dialogButtons[options.buttons.ok] = function (event)
        {
          if(objects.iExport.inputExportBox('isValid'))
          {
            if(options.validExport)
              options.validExport(event,
                {
                  name:objects.iExport.inputExportBox('name'),
                  format:objects.iExport.inputExportBox('format'),
                  compression:objects.iExport.inputExportBox('compression')
                }
              );

            $(this).dialog('close');
          }
        };

      dialogButtons[options.buttons.cancel] = function (event)
        {
          if(options.cancelExport)
            options.cancelExport(event,
              {
                name:objects.iExport.inputExportBox('name'),
                format:objects.iExport.inputExportBox('format'),
                compression:objects.iExport.inputExportBox('compression')
              }
            );

          $(this).dialog('close');
        };

      dialogOpt=
          {
            width:options.width,
            height:options.height,
            closeOnEscape:false,
            closeText:'',
            dialogClass:'ui-dialogExport',
            modal:true,
            resizable:false,
            title:options.title,
            buttons:dialogButtons,
            open: open= function ()
                    {
                      objects.iExport
                        .inputExportBox(
                          {
                            name:options.name,
                            format:options.format,
                            compression:options.compression,
                            chooseCompression:options.chooseCompression,
                            chooseFormat:options.chooseFormat,
                            chooseName:options.chooseName,
                            formatList:options.formatList,
                            compressionList:options.compressionList
                          }
                        );
                    },
            close: function ()
                    {
                      objects.iExport.inputExportBox('destroy').remove();
                      $(this).dialog('destroy').remove();
                    }
          };

      objects.dialogBox
        .append(objects.iExport)
        .dialog(dialogOpt);
    };

  setOptions(opt);
  initDialog();

  return(objects.iExport);
} // $.dialogExport
