/**
 * -----------------------------------------------------------------------------
 * file: ui.dynamicTable.js
 * file version: 1.0.1
 * date: 2012-09-01
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
 * | 1.0.0   | 2012/06/09 | * first release
 * |         |            |
 * | 1.0.1   | 2012/09/01 |  * fix bugs
 * |         |            |
 * |         |            |  * add 'group' icon
 * |         |            |
 * |         |            |  * add 'save' button
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
                      autoLoad:true,
                      columns:[],
                      postUrl:'',
                      postData:{},
                      minHeight:100,
                      maxHeight:300,
                      contentLoading:null,
                      contentLoaded:null,
                      contentDisplayed:null,
                      pageChanged:null,
                      click:null,
                      saveButtonClick:null,
                      nbItemsPage:50,
                      currentPage:1,
                      sortBoxTitle:'Sort by',
                      showTotalRow:'auto',     // visible, hidden, auto
                      showSaveButton:false,
                      footerString:
                        {
                          singular:'% item',
                          plural:'% items',
                          waitForDownload:'Please wait, download will start...'
                        },
                      pagesNavigator:{},
                      dialogsButtons:{
                        ok:'Ok',
                        cancel:'Cancel',
                        erase:'Erase filter'
                      }
                    };

              // if options given, merge it
              // if(opt) $.extend(options, opt); ==> options are set by setters

              $this.data('options', options);


              if(!properties)
              {
                $this.data('properties',
                  {
                    objectId:'dt'+Math.ceil(timeStamp.getTime()*Math.random()),
                    hasSortableButton:false,
                    nbItems:0,
                    sortedColumns:[],
                    filteredColumns:[],
                    groupedColumns:[],
                    loadedData:[],
                    totalRowHasData:false,
                    downloadWaitState:false
                  }
                );
                properties=$this.data('properties');
              }

              if(!objects)
              {
                objects =
                  {
                    headerContainer:$('<table/>',
                        {
                          'class':'ui-dynamicTableHeader'
                        }
                      ),
                    header:$('<thead/>',
                        {
                          'class':'ui-dynamicTableHeader'
                        }
                      ),
                    headerTr:$('<tr/>'),


                    contentContainer:$('<div/>',
                        {
                          'class':'ui-dynamicTableContent'
                        }
                      ),
                    content:$('<table/>',
                        {
                          'class':'ui-dynamicTableContent'
                        }
                      ),
                    loadingContent:$('<div/>',
                        {
                          class:'ui-dynamicTableLoading'
                        }
                      ),
                    loadingContentWorkInProgress:$('<div/>',
                        {
                          class:'ui-dynamicTableLoadingWorkInProgress'
                        }
                      ),

                    totalRowContent:$('<table/>',
                        {
                          'class':'ui-dynamicTableTotalRow'
                        }
                      ),
                    totalRowTr:$('<tr/>'),


                    footer:$('<div/>',
                        {
                          'class':'ui-dynamicTableFooter'
                        }
                      ),
                    footerSaveButton:$('<div/>',
                        {
                          'class':'ui-dynamicTableFooter-saveButton'
                        }
                      ),
                    footerNbItems:$('<div/>',
                        {
                          'class':'ui-dynamicTableFooter-nbItems'
                        }
                      ),
                    footerPagesNavigator:$('<div/>',
                        {
                          'class':'ui-dynamicTableFooter-pagesNavigator'
                        }
                      )
                  };

                $this
                  .html('')
                  .addClass('ui-dynamicTable')
                  .append(objects.headerContainer.append(objects.header.append(objects.headerTr)))
                  .append(objects.loadingContent)
                  .append(objects.loadingContentWorkInProgress)
                  .append(objects.contentContainer.append(objects.content))
                  .append(objects.totalRowContent.append(objects.totalRowTr))
                  .append(objects.footer
                            .append(objects.footerSaveButton)
                            .append(objects.footerNbItems)
                            .append(objects.footerPagesNavigator)
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
              objects.content.remove();
              objects.header.remove();
              $(window).unbind('resize.'+properties.objectId);
              $this.removeClass('ui-dynamicTable');
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


      columns: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setColumns($(this), value, true);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.columns);
          }
        }, // columns

      column: function (value)
        {
          if(value!=null && $.isPlainObject(value))
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setColumn($(this), value, true);
                }
              )
            );
          }
          else if(value!=null)
          {
            var options=this.data('options');
            for(var i=0;i<options.columns.length;i++)
            {
              if(options.columns[i].id==value) return(options.columns[i]);
            }
            return({});
          }
          else return({});
        }, // columns

      sortBoxTitle: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setSortBoxTitle($(this), value, true);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.sortBoxTitle);
          }
        }, // sortBoxTitle

      footerString: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setFooterString($(this), value, true);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.footerString);
          }
        }, // footerString

      waitForDownload: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setDownloadWaitState($(this), value);
                }
              )
            );
          }
          else
          {
            var properties=this.data('properties');
            return(properties.downloadWaitState);
          }
        }, // waitForDownload

      autoLoad: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setAutoLoad($(this), value, true);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.autoLoad);
          }
        }, // autoLoad


      showTotalRow : function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setShowTotalRow($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.showTotalRow);
          }
        }, // showTotalRow



      showSaveButton : function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setShowSaveButton($(this), value);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.showSaveButton);
          }
        }, // showSaveButton


       currentPage: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setCurrentPage($(this), value, true);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.currentPage);
          }
        }, // currentPage

      nbItemsPage: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setNbItemsPage($(this), value, true);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.currentPage);
          }
        }, // nbItemsPage

      postUrl: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setPostUrl($(this), value, true);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.postUrl);
          }
        }, // postUrl

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

      minHeight: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setMinHeight($(this), value, true);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.minHeight);
          }
        }, // minHeight

      maxHeight: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setMaxHeight($(this), value, true);
                }
              )
            );
          }
          else
          {
            var options=this.data('options');
            return(options.maxHeight);
          }
        }, // maxHeight

      click: function (value)
        {
          if(value!=null && ($.isFunction(value) || value=='clear'))
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
        }, // click


      saveButtonClick: function (value)
        {
          if(value!=null && ($.isFunction(value) || value=='clear'))
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setEventSaveButtonClick($(this), value);
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
              return(options.saveButtonClick);
            }
            else
            {
              return(null);
            }
          }
        }, // saveButtonClick

      contentLoading: function (value)
        {
          if(value!=null && ($.isFunction(value) || value=='clear'))
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setEventContentLoading($(this), value);
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
              return(options.contentLoading);
            }
            else
            {
              return(null);
            }
          }
        }, // contentLoading

      contentLoaded: function (value)
        {
          if(value!=null && ($.isFunction(value) || value=='clear'))
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setEventContentLoaded($(this), value);
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
              return(options.contentLoaded);
            }
            else
            {
              return(null);
            }
          }
        }, // contentLoaded

      contentDisplayed: function (value)
        {
          if(value!=null && ($.isFunction(value) || value=='clear'))
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setEventContentDisplayed($(this), value);
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
              return(options.contentDisplayed);
            }
            else
            {
              return(null);
            }
          }
        }, // contentDisplayed

      pageChanged: function (value)
        {
          if(value!=null && ($.isFunction(value) || value=='clear'))
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setEventPageChanged($(this), value);
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
              return(options.pageChanged);
            }
            else
            {
              return(null);
            }
          }
        }, // pageChanged

      loadedData: function (value)
        {
          var properties=$(this).data('properties');

          if(value && $.isNumeric(value) && value>=0 && value<properties.loadedData.length)
            return(properties.loadedData[value]);

          return(properties.loadedData);
        }, // loadedData

      /**
       * refresh table content
       * @param Integer value: page; if not specified, refresh current page
       */
      refreshContent: function (value)
        {
          privateMethods.loadContent($(this), value);
        },

      /**
       * force table to resize columns
       */
      resizeContent: function (value)
        {
          privateMethods.setColumnsSize($(this));
        },


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

          privateMethods.setAutoLoad(object, (value.autoLoad!=null)?value.autoLoad:options.autoLoad);
          privateMethods.setShowTotalRow(object, (value.showTotalRow!=null)?value.showTotalRow:options.showTotalRow);
          privateMethods.setShowSaveButton(object, (value.showSaveButton!=null)?value.showSaveButton:options.showSaveButton);
          privateMethods.setPostData(object, (value.postData!=null)?value.postData:options.postData);
          privateMethods.setPostUrl(object, (value.postUrl!=null)?value.postUrl:options.postUrl);
          privateMethods.setMaxHeight(object, (value.maxHeight!=null)?value.maxHeight:options.maxHeight);
          privateMethods.setMinHeight(object, (value.minHeight!=null)?value.minHeight:options.minHeight);
          privateMethods.setColumns(object, (value.columns!=null)?value.columns:options.columns);
          privateMethods.setSortBoxTitle(object, (value.sortBoxTitle!=null)?value.sortBoxTitle:options.sortBoxTitle);
          privateMethods.setFooterString(object, (value.footerString!=null)?value.footerString:options.footerString);
          privateMethods.setDialogsButtons(object, (value.dialogsButtons!=null)?value.dialogsButtons:options.dialogsButtons);
          privateMethods.setPagesNavigator(object, (value.pagesNavigator!=null)?value.pagesNavigator:options.pagesNavigator);
          //privateMethods.setCurrentPage(object, (value.currentPage!=null)?value.currentPage:options.currentPage);
          privateMethods.setNbItemsPage(object, (value.nbItemsPage!=null)?value.nbItemsPage:options.nbItemsPage);

          privateMethods.setEventContentLoading(object, (value.contentLoading!=null)?value.contentLoading:options.contentLoading);
          privateMethods.setEventContentLoaded(object, (value.contentLoaded!=null)?value.contentLoaded:options.contentLoaded);
          privateMethods.setEventContentDisplayed(object, (value.contentDisplayed!=null)?value.contentDisplayed:options.contentDisplayed);
          privateMethods.setEventPageChanged(object, (value.pageChanged!=null)?value.pageChanged:options.pageChanged);
          privateMethods.setEventSaveButtonClick(object, (value.saveButtonClick!=null)?value.saveButtonClick:options.saveButtonClick);
          privateMethods.setEventClick(object, (value.click!=null)?value.click:options.click);

          $(window).bind('resize.'+properties.objectId, function (event) { privateMethods.setColumnsSize(object); });
          properties.initialized=true;


          if(options.autoLoad)
            privateMethods.loadContent(object);

        },

      setAutoLoad : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          if((!properties.initialized || value!=options.autoLoad) && (value==true || value==false))
          {
            options.autoLoad=value;
          }

          return(options.autoLoad);
        }, // setAutoLoad

      setShowTotalRow : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          if((!properties.initialized || value!=options.showTotalRow) && (value=='visible' || value=='hidden' || value=='auto'))
          {
            options.showTotalRow=value;
            if(properties.initialized)
              privateMethods.showTotalRow(object);
          }

          return(options.showTotalRow);
        }, // setShowTotalRow


      setShowSaveButton : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          if((!properties.initialized || value!=options.showSaveButton) && (value==true || value==false))
          {
            options.showSaveButton=value;
            if(properties.initialized)
              privateMethods.showSaveButton(object);
          }

          return(options.showSaveButton);
        }, // setShowSaveButton


      setColumns : function (object, value)
        {
          var options=object.data('options'),
              objects=object.data('objects');

          if(value!=null && $.isArray(value))
          {
            options.columns=[];

            for(var i=0;i<value.length;i++)
            {
              privateMethods.setColumn(object, value[i], false);
            }

            privateMethods.updateTable(object);
          }
          return(options.columns);
        }, //setColumns

      setColumn : function (object, value, updateTable)
        {
          var newCol={},
              options=object.data('options'),
              objects=object.data('objects');

          if(value!=null && $.isPlainObject(value) && value.id!=null)
          {
            newCol.id=value.id;
            newCol.title=(value.title!=null)?value.title:'';
            newCol.width=(value.width!=null)?value.width:'';
            newCol.sortable=(value.sortable=='asc' || value.sortable=='desc')?value.sortable:'no';
            newCol.group=(value.group==true||value.group==false)?value.group:false;
            newCol.filter=null;

            if($.isValidFilter(value.filter))
              newCol.filter=value.filter;

            options.columns.push(newCol);

            if(updateTable) privateMethods.updateTable(object);
          }

          return(newCol);
        }, //setColumn

      setMinHeight: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if((!properties.initialized || value!=options.minHeight) && value>0 && value<=options.maxHeight)
          {
            options.minHeight=value;
            objects.contentContainer.attr('style', 'min-height:'+options.minHeight+'px;max-height:'+options.maxHeight+'px;');
          }

          return(options.minHeight);
        }, // setMinHeight

      setMaxHeight: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if((!properties.initialized || value!=options.maxHeight) && value>0 && value>=options.minHeight)
          {
            options.maxHeight=value;
            objects.contentContainer.attr('style', 'min-height:'+options.minHeight+'px;max-height:'+options.maxHeight+'px;');
          }

          return(options.maxHeight);
        }, // setMaxHeight


      setSortBoxTitle : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if(!properties.initialized || value!=options.sortBoxTitle)
          {
            options.sortBoxTitle=value;
          }

          return(options.sortBoxTitle);
        }, // setSortBoxTitle

      setFooterString: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');


          if($.isPlainObject(value))
          {
            if((!properties.initialized || value.singular!=null) && value.singular!='' && value.singular!=options.footerString.singular)
              options.footerString.singular=value.singular;

            if((!properties.initialized || value.plural!=null) && value.plural!='' && value.plural!=options.footerString.plural)
              options.footerString.plural=value.plural;

            if((!properties.initialized || value.waitForDownload!=null) && value.waitForDownload!='' && value.waitForDownload!=options.footerString.waitForDownload)
              options.footerString.waitForDownload=value.waitForDownload;

            privateMethods.updateNbItems(object);
          }
          else if(!properties.initialized || value!=options.footerString)
          {
            options.footerString.singular=value;
            options.footerString.plural=value;
            privateMethods.updateNbItems(object);
          }

          return(options.footerString);
        }, // setFooterString

      setDownloadWaitState: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if((!properties.initialized || value!=null) && (value==true || value==false) && (value!=properties.downloadWaitState))
          {
            properties.downloadWaitState=value;
            privateMethods.applyDownloadWaitState(object);
          }
          return(properties.downloadWaitState);
        }, // setDownloadWaitState

      setDialogsButtons: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');


          if($.isPlainObject(value))
          {
            if((!properties.initialized || value.ok!=null) && value.ok!='')
              options.dialogsButtons.ok=value.ok;

            if((!properties.initialized || value.cancel!=null) && value.cancel!='')
              options.dialogsButtons.cancel=value.cancel;

            if((!properties.initialized || value.erase!=null) && value.erase!='')
              options.dialogsButtons.erase=value.erase;

            privateMethods.updateNbItems(object);
          }

          return(options.dialogsButtons);
        }, // setDialogsButtons

      setPostUrl : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          if(!properties.initialized || value!=options.postUrl)
          {
            options.postUrl=value;
          }

          return(options.postUrl);
        }, // setPostUrl

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

      setEventContentLoading : function (object, value)
        {
          var options=object.data('options');

          if(value=='clear') value=null;
          options.contentLoading=value;
          object.unbind('dynamicTableContentLoading');
          if(value) object.bind('dynamicTableContentLoading', options.contentLoading);
          return(options.contentLoading);
        }, //setEventContentLoading

      setEventContentLoaded : function (object, value)
        {
          var options=object.data('options');

          if(value=='clear') value=null;
          options.contentLoaded=value;
          object.unbind('dynamicTableContentLoaded');
          if(value) object.bind('dynamicTableContentLoaded', options.contentLoaded);
          return(options.contentLoaded);
        }, //setEventContentLoaded

      setEventContentDisplayed : function (object, value)
        {
          var options=object.data('options');

          if(value=='clear') value=null;
          options.contentDisplayed=value;
          object.unbind('dynamicTableContentDisplayed');
          if(value) object.bind('dynamicTableContentDisplayed', options.contentDisplayed);
          return(options.contentDisplayed);
        }, //setEventContentDisplayed

      setEventPageChanged : function (object, value)
        {
          var options=object.data('options');

          if(value=='clear') value=null;
          options.pageChanged=value;
          object.unbind('dynamicTablePageChanged');
          if(value) object.bind('dynamicTablePageChanged', options.pageChanged);
          return(options.pageChanged);
        }, //setEventPageChanged

      setEventClick : function (object, value)
        {
          var options=object.data('options'),
              objects=object.data('objects');

          if(value=='clear') value=null;
          options.click=value;
          objects.content.find('tr').unbind('click.dynamicTable');
          if(value)
          {
            objects.content.css('cursor', 'pointer');
            objects.content.find('tr').bind('click.dynamicTable', options.click);
          }
          else
          {
            objects.content.css('cursor', 'default');
          }
          return(options.click);
        }, //setEventClick


      setEventSaveButtonClick : function (object, value)
        {
          var options=object.data('options'),
              objects=object.data('objects');

          if(value=='clear') value=null;
          options.saveButtonClick=value;
          objects.footerSaveButton.unbind('click.dynamicTable');
          if(value)
            objects.footerSaveButton.bind('click.dynamicTable', function (event)
              {
                options.saveButtonClick(event, privateMethods.getPostProperties(object));
              }
            );

          return(options.saveButtonClick);
        }, //setEventSaveButtonClick


      setNbItems: function (object, value)
        {
          var properties=object.data('properties');

          if(value!=null && value>=0 && properties.nbItems!=value)
          {
            properties.nbItems=value;
            privateMethods.updateNbItems(object);
          }
          return(properties.nbItems);
        }, //setNbItems

      setCurrentPage: function (object, value)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          if(options.currentPage!=value && value>0 && value <= objects.footerPagesNavigator.inputPages('nbPages') || value==1)
          {
            // if value == 1, force reload
            options.currentPage=value;
            privateMethods.loadContent(object);
            if(options.pageChanged) object.trigger('dynamicTablePageChanged', options.currentPage);
          }

          return(options.currentPage);
        }, //setCurrentPage

      setNbItemsPage: function (object, value)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          if(options.nbItemsPage!=value && value>1)
          {
            options.nbItemsPage=value;
            objects.footerPagesNavigator.inputPages('nbItemsPage', options.nbItemsPage);
            privateMethods.setCurrentPage(object, 1);
          }
          return(options.nbItemsPage);
        }, //setNbItemsPage

      setPagesNavigator: function (object, value)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          options.pagesNavigator=value;
          options.pagesNavigator.change=function (event, value)
            {
              privateMethods.setCurrentPage(object, value);
            };
          objects.footerPagesNavigator.inputPages(options.pagesNavigator);

          return(options.pagesNavigator);
        }, //setPagesNavigator

      /*
       * update DOM for headers & footer & total row
       */
      updateTable : function (object)
        {
          var style='',
              td=null,
              button=null,
              eraseButton=null,
              options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          objects.headerTr.children().remove();
          objects.totalRowTr.children().remove();

          properties.hasSortableButton=false;
          properties.sortedColumns=[];
          properties.filteredColumns=[];

          for(var i=0;i<options.columns.length;i++)
          {
            td=$('<td/>',
                  {
                    'oId':options.columns[i].id,
                  }
                ).html(options.columns[i].title);

            if(options.columns[i].width!='') td.attr('style', 'width:'+options.columns[i].width+';');

            if(options.columns[i].sortable!='no')
            {
              properties.hasSortableButton=true;
              properties.sortedColumns.push(
                  {
                    id:options.columns[i].id,
                    content:options.columns[i].title,
                    direction:options.columns[i].sortable
                  }
                );
            }

            if(options.columns[i].filter!=null)
            {
              // filter button
              button=$('<div/>',
                        {
                          class:'ui-dynamicTableFilterButton-inactive'
                        }
                      )
                      .bind('click', i,
                         function (event)
                         {
                           var columnIndex=event.data,
                               defaultValue={},
                               defaultOperator=options.columns[columnIndex].filter.filterOperators[0],
                               $button=$(this);

                           if(properties.filteredColumns[columnIndex])
                           {
                             defaultValue=properties.filteredColumns[columnIndex];
                             defaultOperator=properties.filteredColumns[columnIndex].operator;
                             eraseButton=options.dialogsButtons.erase;
                           }

                           $.inputDialogFilterBox(
                              {
                                buttons:{
                                  erase:eraseButton,
                                  ok:options.dialogsButtons.ok,
                                  cancel:options.dialogsButtons.cancel
                                },
                                title:options.columns[columnIndex].filter.title,
                                filter:{
                                  dataType:options.columns[columnIndex].filter.dataType,
                                  filterOperators:options.columns[columnIndex].filter.filterOperators,
                                  defaultOperator:defaultOperator,
                                  defaultValue:defaultValue,
                                  data:options.columns[columnIndex].filter.data
                                },
                                change: function (event, value)
                                  {
                                    if(value==null)
                                    {
                                      $button
                                        .addClass('ui-dynamicTableFilterButton-inactive')
                                        .removeClass('ui-dynamicTableFilterButton-active');
                                    }
                                    else
                                    {
                                      $button
                                        .removeClass('ui-dynamicTableFilterButton-inactive')
                                        .addClass('ui-dynamicTableFilterButton-active');
                                      value.id=options.columns[columnIndex].id;
                                    }
                                    properties.filteredColumns[columnIndex]=value;
                                    privateMethods.setCurrentPage(object, 1);
                                  }
                              }
                           );
                         }
                       );
              td.append(button);
            } // filter button


            if(options.columns[i].group==true)
            {
              // groupable button
              button=$('<div/>',
                        {
                          class:'ui-dynamicTableGroupButton-inactive'
                        }
                      )
                      .bind('click', i,
                         function (event)
                         {
                           var columnIndex=event.data,
                               $button=$(this);

                          $button.toggleClass('ui-dynamicTableGroupButton-inactive ui-dynamicTableGroupButton-active');

                          if($button.hasClass('ui-dynamicTableGroupButton-active'))
                          {
                            properties.groupedColumns[columnIndex]=options.columns[columnIndex].id;
                          }
                          else
                          {
                            delete properties.groupedColumns[columnIndex];
                          }

                          privateMethods.setCurrentPage(object, 1);
                         }
                       );
              td.append(button);
            } // groupable button


            objects.headerTr.append(td);

            td=$('<td/>');
            if(options.columns[i].width!='') td.attr('style', 'width:'+options.columns[i].width+';');
            objects.totalRowTr.append(td);
          }

          if(properties.hasSortableButton)
          {
            button=$('<div/>',
                      {
                        class:'ui-dynamicTableSortButton',
                      }
                    );
            button.bind('click',
                    function (event)
                      {
                        var cWidth=0,
                            tWidth=0;

                        for(var i=0;i<options.columns.length;i++)
                        {
                          tWidth=objects.header.find('[oId="'+options.columns[i].id+'"]').width();
                          if(tWidth>cWidth) cWidth=tWidth;
                        }

                        $.inputDialogSortBox(
                          {
                            buttons:{
                              ok:options.dialogsButtons.ok,
                              cancel:options.dialogsButtons.cancel
                            },
                            modal:true,
                            width:cWidth,
                            height:250,
                            autoHeight:false,
                            title:options.sortBoxTitle,
                            mode:'direction',
                            items:properties.sortedColumns,
                            change: function (event, value)
                              {
                                properties.sortedColumns=value;
                                privateMethods.setCurrentPage(object, 1);
                              }
                          }
                        );

                      }
                    );

            td=$('<td/>',
                  {
                    'oId':'sort',
                    class:'ui-dynamicTableSortColumn'
                  }
                ).append(button);
            objects.headerTr.append(td);

            td=$('<td/>');
            objects.totalRowTr.append(td);
          }
        }, //updateTable

      /**
       * load table content
       *
       * @param Integer page: page to load; if not specified, use the current page
       */
      loadContent : function (object, page)
        {
          var tmpData=null,
              data=null,
              tr=null,
              td=null,
              options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          if(options.postUrl=='') return(false);

          if(page>0 && page <= objects.footerPagesNavigator.inputPages('nbPages'))
            options.currentPage=page;
          privateMethods.displayLoading(object, true);

          data=options.postData;
          data.currentPage=options.currentPage;
          data.nbItemsPage=options.nbItemsPage;

          tmpData=privateMethods.getPostProperties(object);
          data.sort=tmpData.sort;
          data.filter=tmpData.filter;
          data.group=tmpData.group;

          if(options.contentLoading) object.trigger('dynamicTableContentLoading', data);

          $.ajax(
            {
              type: "POST",
              url: options.postUrl,
              async: true,
              data:data,
              success: function(msg)
                {
                  msg=$.parseJSON(msg);

                  if(msg==null || msg.rows==null)
                  {
                    privateMethods.displayLoading(object, false);
                    return(false);
                  }

                  if(options.contentLoaded) object.trigger('dynamicTableContentLoaded', msg);

                  objects.content.find('tr').unbind('click.dynamicTable');
                  objects.content.children().remove();
                  objects.contentContainer.scrollTop('0px');

                  delete properties.loadedData;
                  properties.loadedData=[];

                  for(var row=0;row<msg.rows.length;row++)
                  {
                    tr=$('<tr/>', {'oId':row});

                    properties.loadedData[row]=msg.rows[row];

                    for(var col=0;col<msg.rows[row].length;col++)
                    {
                      if(col<options.columns.length)
                      {
                        td=$('<td/>').html(msg.rows[row][col]);

                        if((col==msg.rows[row].length-1) && properties.hasSortableButton) td.attr('colspan', '2');
                        tr.append(td);
                      }
                    }
                    objects.content.append(tr);
                  }

                  if(msg.nbItems!=null)
                  {
                    objects.footerPagesNavigator
                      .inputPages('nbItems', msg.nbItems);

                    privateMethods.setNbItems(object, msg.nbItems);
                    objects.footer.css('display', 'block');

                    if(msg.nbItems==0)
                    {
                      objects.footerPagesNavigator.css('display', 'none');
                    }
                    else
                    {
                      objects.footerPagesNavigator.css('display', 'block');
                    }
                  }
                  else
                  {
                    objects.footer.css('display', 'none');
                  }

                  if(msg.total!=null && $.isArray(msg.total))
                  {
                    properties.totalRowHasData=true;
                    objects.totalRowTr.children().each(
                      function (index)
                      {
                        $(this).html(msg.total[index]);
                      }
                    );
                  }
                  else
                  {
                    properties.totalRowHasData=false;
                  }

                  if(options.click)
                    objects.content.find('tr').bind('click.dynamicTable', options.click);

                  privateMethods.showTotalRow(object);
                  privateMethods.setColumnsSize(object);

                  if(options.contentDisplayed) object.trigger('dynamicTableContentDisplayed', msg);
                  privateMethods.displayLoading(object, false);
                },
              error: function(msg)
                {
                  //
                  objects.loadingContent.attr('style', 'display:none;');
                  objects.loadingContentWorkInProgress.attr('style', 'display:none;');
                },
            }
         );
        }, //loadContent

      // return a ready-to-use filter/group/sort object
      getPostProperties: function (object)
        {
          var data={},
              properties=object.data('properties');

          data.sort=[];
          for(var i=0;i<properties.sortedColumns.length;i++)
          {
            data.sort.push(
              {
                id:properties.sortedColumns[i].id,
                direction:(properties.sortedColumns[i].direction=='asc')?'A':'D'
              }
            );
          }
          data.filter=[];
          for(var i in properties.filteredColumns)
          {
            data.filter.push(properties.filteredColumns[i]);
          }

          data.group=[];
          for(var i in properties.groupedColumns)
          {
            data.group.push(properties.groupedColumns[i]);
          }
          return(data);
        }, //getPostProperties

      setColumnsSize : function (object)
        {
          var cols=[],
              options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects');

          if(!(objects.header || objects.content)) return(false);
          // set columns width
          objects.header.find('tr:first td').each(
            function (index)
            {
              cols[index]=$(this).width();
            }
          );

          // resize first row of table content
          objects.content.find('tr:first td').each(
            function (index)
            {
              var style='';

              if(index==(cols.length-1))
              {
                style='max-width:';
              }
              else
              {
                style='width:';
              }
              $(this).attr('style', style+cols[index]+'px;');
            }
          );

          // resize total row if displayed
          if(options.showTotalRow=='visible' ||
             options.showTotalRow=='auto' && properties.totalRowHasData)
          {
            objects.totalRowTr.find('td').each(
              function (index)
              {
                var style='';

                if(index==(cols.length-1))
                {
                  style='max-width:';
                }
                else
                {
                  style='width:';
                }
                $(this).attr('style', style+cols[index]+'px;');
              }
            );
          }

          return(true);
        }, //setColumnsSize

      displayLoading : function (object, display)
        {
          var objects=object.data('objects');

          if(display)
          {
            objects.loadingContent.attr('style', 'display:block;width:'+objects.contentContainer.width()+'px;height:'+objects.contentContainer.height()+'px;');
            objects.loadingContentWorkInProgress.css(
              {
                'display':'block',
                'width':objects.contentContainer.width()+'px',
                'height':objects.contentContainer.height()+'px',
                'background-position':Math.round((objects.contentContainer.width()-16)/2)+'px '+Math.round((objects.contentContainer.height()-16)/2)+'px'
              }
            );
          }
          else
          {
            objects.loadingContent.attr('style', 'display:none;');
            objects.loadingContentWorkInProgress.attr('style', 'display:none;');
          }
        }, //displayLoading

      showTotalRow : function (object)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          switch(options.showTotalRow)
          {
            case 'visible':
              objects.totalRowContent.css('display',  'block');
              break;
            case 'hidden':
              objects.totalRowContent.css('display', 'none');
              break;
            case 'auto':
              if(properties.totalRowHasData)
              {
                objects.totalRowContent.css('display', 'block');
              }
              else
              {
                objects.totalRowContent.css('display', 'none');
              }
              break;
          }
        }, // showTotalRow

      updateNbItems: function (object)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          if(properties.nbItems>1)
          {
            objects.footerNbItems.html(options.footerString.plural.replace('%', properties.nbItems));
          }
          else
          {
            objects.footerNbItems.html(options.footerString.singular.replace('%', properties.nbItems));
          }

          if(properties.nbItems>0)
          {
            privateMethods.showSaveButton(object);
          }
          else
          {
            privateMethods.showSaveButton(object, true); // force button hide
          }

        }, // updateNbItems

      showSaveButton : function (object, hide)
        {
          var options=object.data('options'),
              objects=object.data('objects');

          if(hide==null) hide=false;

          if(options.showSaveButton && hide!=true)
          {
            objects.footerSaveButton.css('display',  'block');
          }
          else
          {
            objects.footerSaveButton.css('display',  'none');
          }
        }, // showSaveButton

      applyDownloadWaitState: function (object)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          if(properties.downloadWaitState)
          {
            objects.footerSaveButton
              .removeClass('ui-dynamicTableFooter-saveButton')
              .addClass('ui-dynamicTableFooter-saveButtonWait');
            objects.footerNbItems.html(options.footerString.waitForDownload);
          }
          else
          {
            objects.footerSaveButton
              .removeClass('ui-dynamicTableFooter-saveButtonWait')
              .addClass('ui-dynamicTableFooter-saveButton');
            privateMethods.updateNbItems(object);
          }
        } // applyDownloadWaitState
    };


    $.fn.dynamicTable = function(method)
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
        $.error( 'Method ' +  method + ' does not exist on jQuery.dynamicTable' );
      }
    } // $.fn.dynamicTable

  }
)(jQuery);
