/**
 * -----------------------------------------------------------------------------
 * file: ui.inputPages.js
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
 *
 *
 *
 * :: HISTORY ::
 *
 * | release | date       |
 * | 1.0.0   | 2010/11/04 | * first release
 * |         |            |
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
                  data = $this.data('options'),
                  objects = $this.data('objects'),
                  properties = $this.data('properties'),
                  options =
                    {
                      nbItems:0,
                      nbItemsPage:50,
                      currentPage:1,
                      displayedPages:7,
                      showButtons:{
                        first:'auto',
                        last:'auto',
                        previous:'auto',
                        next:'auto',
                        more:'auto'
                      },
                      chars:{
                        first:'&nbsp;', // <<
                        previous:'&nbsp;', // <
                        next:'&nbsp;', // >
                        last:'&nbsp;', // >>
                        more:'...'
                      },
                      change:null
                    };

              // if options given, merge it
              // if(opt) $.extend(options, opt); ==> options are set by setters

              $this.data('options', options);

              if(!properties)
              {
                $this.data('properties',
                  {
                    initialized:false,
                    nbPages:0
                  }
                );
                properties=$this.data('properties');
              }

              if(!objects)
              {
                objects =
                  {
                    container:$('<ul/>', { 'class':'ui-inputPages' } ),
                    buttonFirst:$('<li/>', { 'class':'ui-inputPagesButton-first-inactive', oValue:':first' } ),
                    buttonLast:$('<li/>', { 'class':'ui-inputPagesButton-last-inactive', oValue:':last' } ),
                    buttonPrevious:$('<li/>', { 'class':'ui-inputPagesButton-previous-inactive', oValue:':previous' } ),
                    buttonNext:$('<li/>', { 'class':'ui-inputPagesButton-next-inactive', oValue:':next' } )
                  };

                $this
                  .html('')
                  .append(
                    objects.container
                      .append(objects.buttonFirst)
                      .append(objects.buttonPrevious)
                      .append(objects.buttonNext)
                      .append(objects.buttonLast)
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
              objects.container.unbind().remove();
              $this
                .unbind('.inputPages')
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

      nbItems: function (value)
        {
          if(value!=null)
          {
            return(
              this.each(
                function()
                {
                  privateMethods.setNbItems($(this), value);
                }
              )
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.nbItems);
            }
            else
            {
              return('');
            }
          }
        }, // nbItems

      nbItemsPage: function (value)
        {
          if(value!=null)
          {
            return(
              this.each(
                function()
                {
                  privateMethods.setNbItemsPage($(this), value);
                }
              )
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.nbItemsPage);
            }
            else
            {
              return('');
            }
          }
        }, // nbItemsPage

      currentPage: function (value)
        {
          if(value!=null)
          {
            return(
              this.each(
                function()
                {
                  privateMethods.setCurrentPage($(this), value);
                }
              )
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.currentPage);
            }
            else
            {
              return('');
            }
          }
        }, // currentPage

      displayedPages: function (value)
        {
          if(value!=null)
          {
            return(
              this.each(
                function()
                {
                  privateMethods.setDisplayedPages($(this), value);
                }
              )
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.displayedPages);
            }
            else
            {
              return('');
            }
          }
        }, // displayedPages

      nbPages: function (value)
        {
          var properties = this.data('properties');

          if(properties)
          {
            return(properties.nbPages);
          }
          return(0);
        }, // nbPages

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
      /**
       * return true is given value is a valid numeric value, according to the
       * rules defined by the object
       * @param Object object
       * @param value
       * @return Bool
       */
      isValid : function (object, value)
        {
          var properties=object.data('properties');

          return(properties.re.test(value));
        },

      setOptions : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          if(!$.isPlainObject(value)) return(false);

          properties.initialized=false;

          privateMethods.setChars(object, (value.chars!=null)?value.chars:options.chars);
          privateMethods.setShowButtons(object, (value.showButtons!=null)?value.showButtons:options.showButtons);
          privateMethods.setNbItems(object, (value.nbItems!=null)?value.nbItems:options.nbItems);
          privateMethods.setNbItemsPage(object, (value.nbItemsPage!=null)?value.nbItemsPage:options.nbItemsPage);
          privateMethods.setCurrentPage(object, (value.currentPage!=null)?value.currentPage:options.currentPage);
          privateMethods.setDisplayedPages(object, (value.displayedPages!=null)?value.displayedPages:options.displayedPages);

          privateMethods.setEventChange(object, (value.change!=null)?value.change:options.change);

          properties.initialized=true;

          privateMethods.refreshPages(object);
        },


      setChars : function (object, value)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          if(!properties.initialized && value!=null)
          {
            if(value.first)
            {
              options.chars.first=value.first;
              objects.buttonFirst.html(options.chars.first);
            }

            if(value.previous)
            {
              options.chars.previous=value.previous;
              objects.buttonPrevious.html(options.chars.previous);
            }

            if(value.next)
            {
              options.chars.next=value.next;
              objects.buttonNext.html(options.chars.next);
            }

            if(value.last)
            {
              options.chars.last=value.last;
              objects.buttonLast.html(options.chars.last);
            }

            if(value.more)
            {
              options.chars.more=value.more;
            }
          }
          return(options.chars);
        }, //setChars


      setShowButtons : function (object, value)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          if(!properties.initialized && value!=null)
          {
            if(value.first && (value.first=='always' || value.first=='never' || value.first=='auto'))
              options.showButtons.first=value.first;

            if(value.previous && (value.previous=='always' || value.previous=='never' || value.previous=='auto'))
              options.showButtons.previous=value.previous;

            if(value.next && (value.next=='always' || value.next=='never' || value.next=='auto'))
              options.showButtons.next=value.next;

            if(value.last && (value.last=='always' || value.last=='never' || value.last=='auto'))
              options.showButtons.last=value.last;

            if(value.more && (value.more=='always' || value.more=='never' || value.more=='auto'))
              options.showButtons.more=value.more;

            if(options.showButtons.first=='never')
              objects.buttonFirst.css('display', 'none');
            if(options.showButtons.previous=='never')
              objects.buttonPrevious.css('display', 'none');
            if(options.showButtons.next=='never')
              objects.buttonNext.css('display', 'none');
            if(options.showButtons.last=='never')
              objects.buttonLast.css('display', 'none');

            if(options.showButtons.first=='always')
              objects.buttonFirst.css('display', 'inline-block');
            if(options.showButtons.previous=='always')
              objects.buttonPrevious.css('display', 'inline-block');
            if(options.showButtons.next=='always')
              objects.buttonNext.css('display', 'inline-block');
            if(options.showButtons.last=='always')
              objects.buttonLast.css('display', 'inline-block');
          }
          return(options.showButtons);
        }, //setShowButtons


      setNbItems: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if((!properties.initialized || options.nbItems!=value) && value>0)
          {
            options.nbItems=value;
            options.currentPage=1;
            privateMethods.calculateNbPages(object);
            privateMethods.refreshPages(object);
          }
          return(options.nbItems);
        }, //setNbItems

      setNbItemsPage: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if((!properties.initialized || options.nbItemsPage!=value) && value>0)
          {
            options.nbItemsPage=value;
            options.currentPage=1;
            privateMethods.calculateNbPages(object);
            privateMethods.refreshPages(object);
          }
          return(options.nbItemsPage);
        }, //setNbItemsPage

      setDisplayedPages: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          if((!properties.initialized || options.displayedPages!=value) && value>0)
          {
            options.displayedPages=value;
            privateMethods.refreshPages(object);
          }
          return(options.displayedPages);
        }, //setDisplayedPages

      setCurrentPage: function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              askedPage=0;

          if((!properties.initialized || options.currentPage!=value) &&
              (value==':first' ||
              value==':previous' ||
              value==':next' ||
              value==':last' ||
              value==':pp' ||
              value==':ps' ||
              $.isNumeric(value) && value>0))
          {
            switch(value)
            {
              case ':first':
                askedPage=1;
                break;
              case ':previous':
                askedPage=options.currentPage-1;
                break;
              case ':next':
                askedPage=options.currentPage+1;
                break;
              case ':last':
                askedPage=properties.nbPages
                break;
              case ':pp':
                askedPage=options.currentPage-options.displayedPages;
                if(askedPage<1) askedPage=1;
                break;
              case ':ps':
                askedPage=options.currentPage+options.displayedPages;
                if(askedPage>properties.nbPages) askedPage=properties.nbPages;
                break;
              default:
                askedPage=value;
            }

            if(askedPage>=1 && askedPage<=properties.nbPages)
            {
              options.currentPage=askedPage*1;
              privateMethods.refreshPages(object);

              if(options.change) object.trigger('inputPageChange', options.currentPage);
            }

          }
          return(options.currentPage);
        }, //setCurrentPage

      setEventChange : function (object, value)
        {
          var options=object.data('options');

          options.change=value;
          object.unbind('inputPageChange');
          if(value) object.bind('inputPageChange', options.change);
          return(options.change);
        }, //setEventChange

      calculateNbPages : function (object)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          properties.nbPages=Math.ceil(options.nbItems/options.nbItemsPage);
        }, // calculateNbPages

      refreshPages : function (object)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties'),
              itemClass='';

          if(options.currentPage==1)
          {
            objects.buttonFirst
              .removeClass('ui-inputPagesButton-first-active ui-inputPagesButton-active')
              .addClass('ui-inputPagesButton-first-inactive');
            objects.buttonPrevious
              .removeClass('ui-inputPagesButton-previous-active ui-inputPagesButton-active')
              .addClass('ui-inputPagesButton-previous-inactive');
          }
          else if(options.currentPage==properties.nbPages)
          {
            objects.buttonLast
              .removeClass('ui-inputPagesButton-last-active ui-inputPagesButton-active')
              .addClass('ui-inputPagesButton-last-inactive');
            objects.buttonNext
              .removeClass('ui-inputPagesButton-next-active ui-inputPagesButton-active')
              .addClass('ui-inputPagesButton-next-inactive');
          }

          if(options.currentPage<properties.nbPages)
          {
            objects.buttonLast
              .removeClass('ui-inputPagesButton-last-inactive')
              .addClass('ui-inputPagesButton-last-active ui-inputPagesButton-active');
            objects.buttonNext
              .removeClass('ui-inputPagesButton-next-inactive')
              .addClass('ui-inputPagesButton-next-active ui-inputPagesButton-active');
          }
          if(options.currentPage>1)
          {
            objects.buttonFirst
              .removeClass('ui-inputPagesButton-first-inactive')
              .addClass('ui-inputPagesButton-first-active ui-inputPagesButton-active');
            objects.buttonPrevious
              .removeClass('ui-inputPagesButton-previous-inactive')
              .addClass('ui-inputPagesButton-previous-active ui-inputPagesButton-active');
          }

          if(properties.nbPages<=1 || properties.nbPages<=options.displayedPages)
          {
            if(options.showButtons.first=='auto')
              objects.buttonFirst.css('display', 'none');
            if(options.showButtons.previous=='auto')
              objects.buttonPrevious.css('display', 'none');
            if(options.showButtons.next=='auto')
              objects.buttonNext.css('display', 'none');
            if(options.showButtons.last=='auto')
              objects.buttonLast.css('display', 'none');
          }
          else
          {
            if(options.showButtons.first=='auto')
              objects.buttonFirst.css('display', 'inline-block');
            if(options.showButtons.previous=='auto')
              objects.buttonPrevious.css('display', 'inline-block');
            if(options.showButtons.next=='auto')
              objects.buttonNext.css('display', 'inline-block');
            if(options.showButtons.last=='auto')
              objects.buttonLast.css('display', 'inline-block');
          }

          objects.container.children().unbind('click.inputPages');
          objects.container.children('.ui-inputPages-pageNum').remove();

          if(properties.nbPages>1)
          {
            if(options.displayedPages==0 || options.nbPages<=options.displayedPages)
            {
              for(var i=1;i<=properties.nbPages;i++)
              {
                if(i==options.currentPage)
                {
                  itemClass='ui-inputPagesButton-selected ui-inputPages-pageNum';
                }
                else
                {
                  itemClass='ui-inputPagesButton-active ui-inputPages-pageNum';
                }
                objects.buttonNext.before(
                  $('<li/>',
                    {
                      'class':itemClass,
                      oValue:i
                    }
                  ).html(i)
                );
              }
            }
            else
            {
              var firstPage=0,
                  lastPage=0;

              firstPage=options.currentPage-Math.floor(options.displayedPages/2);

              if((firstPage+options.displayedPages)>properties.nbPages)
              {
                firstPage=properties.nbPages-options.displayedPages+1;
              }

              if(firstPage<1)
              {
                firstPage=1;
              }

              lastPage=Math.min(firstPage+options.displayedPages-1, properties.nbPages);

              if(firstPage>1 && options.showButtons.more=='auto')
                objects.buttonNext.before(
                  $('<li/>',
                    {
                      'class':'ui-inputPagesButton-active ui-inputPages-pageNum',
                      oValue:':pp'
                    }
                  ).html(options.chars.more)
                );

              for(var i=firstPage;i<=lastPage;i++)
              {
                if(i==options.currentPage)
                {
                  itemClass='ui-inputPagesButton-selected ui-inputPages-pageNum';
                }
                else
                {
                  itemClass='ui-inputPagesButton-active ui-inputPages-pageNum';
                }
                objects.buttonNext.before(
                  $('<li/>',
                    {
                      'class':itemClass,
                      oValue:i
                    }
                  ).html(i)
                );
              }

              if(lastPage<properties.nbPages && options.showButtons.more=='auto')
                objects.buttonNext.before(
                  $('<li/>',
                    {
                      'class':itemClass,
                      oValue:':ps'
                    }
                  ).html(options.chars.more)
                );
            }
          }

          objects.container
            .children('.ui-inputPagesButton-active')
              .bind('click.inputPages',
                function (event)
                {
                  privateMethods.setCurrentPage(object, $(this).attr('oValue'));
                }
              );

        } // refreshPages


    };


    $.fn.inputPages = function(method)
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
        $.error( 'Method ' +  method + ' does not exist on jQuery.inputPages' );
      }
    } // $.fn.inputPages

  }
)(jQuery);


