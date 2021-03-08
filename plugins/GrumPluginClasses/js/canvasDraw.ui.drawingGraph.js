/**
 * -----------------------------------------------------------------------------
 * file: CanvasDraw.ui.drawingGraph.js
 * file version: 1.0.0
 * date: 2011-10-17
 *
 * A jQuery plugin provided by the piwigo's plugin "GrumPluginClasses"
 *
 * -----------------------------------------------------------------------------
 * Author     : Grum
 *   email    : grum@piwigo.com
 *   website  : http://photos.grum.fr
 *   PWG user : http://forum.phpwebgallery.net/profile.php?id=3706
 *
 *   << May the Little SpaceFrog be with you ! >>
 * -----------------------------------------------------------------------------
 *
 * The drawing graph provide all methods and properties to draw charts
 *
 * It use:
 *  - 1 layer for graphs
 *  - 1 layer for the grid & axis
 *  - 1 layer for the cursor
 *
 * :: HISTORY ::
 *
 * | release | date       |
 * | 1.0.0   | 2011-10-17 | first release
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
      /**
       * initialize the object
       *
       * @param Object opt : options
       */
      init : function (opt)
        {
          return this.each(function()
            {
              // default values for the plugin
              var $this=$(this),
                  data = $this.data('options'),
                  objects = $this.data('objects'),
                  properties = $this.data('properties'),
                  canvasObjects = $this.data('canvasObjects'),
                  options =
                    {
                      margins:new CDMargins(),
                      legend:new CDLegend(),
                      axis:{
                          front:new CDAxis(),
                          back:null
                        },
                      cursor:
                        {
                          visible:true,
                          color:'rgba(128,128,128,0.2)',
                          verticalType:'bar'  // 'bar' or 'line'
                        },
                      display:
                        {
                          width:320,
                          height:200,
                          legend:false,
                        },
                      events:
                        {
                          mousePositionChange:null,
                          mouseEnter:null,
                          mouseLeave:null,
                          mouseClick:null
                        },
                    };

              // if options given, merge it
              // if(opt) $.extend(options, opt); ==> options are set by setters

              $this.data('options', options);

              if(!properties)
              {
                $this.data('properties',
                  {
                    initialized:false,
                    mouseIsOver:false,
                    cursor:{
                        x:0,
                        y:0,
                        axis:{
                          XY:{
                            front:{H:-1, V:-1},
                            back:{H:-1, V:-1}
                          }
                        },
                      },
                    typeGraph:'xy',  // 'xy', 'pie'
                  }
                );
                properties=$this.data('properties');
              }

              if(!objects)
              {
                objects =
                  {
                    viewport:$('<div/>', { 'class':'ui-drawingGraph-viewport' } ),
                    sheet:$('<div/>', { 'class':'ui-drawingGraph-sheet' } )
                      .bind('mousemove',
                            function (event)
                              {
                                privateMethods.mousePositionUpdate($this, event.originalEvent.layerX, event.originalEvent.layerY);
                              }
                          )
                      .bind('mouseleave',
                            function (event)
                              {
                                privateMethods.mouseLeave($this);
                              }
                          )
                      .bind('mouseenter',
                            function (event)
                              {
                                privateMethods.mouseEnter($this, event.originalEvent.layerX, event.originalEvent.layerY);
                              }
                          )
                      .bind('click',
                            function (event)
                              {
                                privateMethods.mouseClick($this, event.originalEvent.layerX, event.originalEvent.layerY);
                              }
                          ),
                    canvasCursor:$('<canvas/>',  { 'class':'ui-drawingGraph-cursor' } ),
                    canvasAxis:$('<canvas/>', { 'class':'ui-drawingGraph-axis' } ),
                    canvasGraph:$('<canvas/>', { 'class':'ui-drawingGraph-graph' } )
                  };

                canvasObjects = {
                    cursor:new CDDrawing(objects.canvasCursor.get(0)),
                    axis:new CDDrawing(objects.canvasAxis.get(0)),
                    graph:new CDDrawing(objects.canvasGraph.get(0)),
                  };

                $this
                  .html('')
                  .addClass('ui-drawingGraph')
                  .bind('click.drawingGraph',
                      function ()
                      {
                        //
                      }
                    )
                  .bind('mouseenter.drawingGraph',
                      function ()
                      {
                        properties.mouseIsOver=true;
                      }
                    )
                  .bind('mouseleave.drawingGraph',
                      function ()
                      {
                        properties.mouseIsOver=false;
                      }
                    )
                  .append(objects.viewport.append(objects.sheet.append(objects.canvasAxis).append(objects.canvasCursor).append(objects.canvasGraph)));

                $this.data('objects', objects);
                $this.data('canvasObjects', canvasObjects);
              }

              privateMethods.setOptions($this, opt);
            }
          );
        }, // init

      /**
       * object destroy methods to clean memory
       */
      destroy : function ()
        {
          return this.each(
            function()
            {
              // default values for the plugin
              var $this=$(this);
              $this
                .unbind('.drawingGraph')
                .css(
                  {
                    width:'',
                    height:''
                  }
                );
            }
          );
        }, // destroy

      /**
       * initialize the options
       *
       * @param Object value : options properties as an object
       */
      options: function (value)
        {
          return this.each(function()
            {
              privateMethods.setOptions($(this), value);
            }
          );
        }, // options

      /**
       * define the size (witdh & height) of the current drawing area
       *
       * @param Object value : an object with width&height properties
       * @return Object : if no parameter are given, returns an object with the
       *                  width & height properties
       */
      display : function (value)
        {
          if(value!=null)
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setDisplay($(this), value);
              }
            );
          }
          else
          {
            // return the selected value
            var options=this.data('options');

            if(options)
            {
              return(options.display);
            }
            else
            {
              return(null);
            }
          }
        },

      /**
       * define the cursor state
       *
       * @param Object value : an object with the cursor properties (visible,
       *                       color)
       * @return Object : if no parameter are given, returns an object with the
       *                  cursor properties
       */
      cursor : function (value)
        {
          if(value!=null)
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setCursor($(this), value);
              }
            );
          }
          else
          {
            // return the selected value
            var options=this.data('options');

            if(options)
            {
              return(options.cursor);
            }
            else
            {
              return(null);
            }
          }
        },

      /**
       * define the margins
       *
       * @param Object value : a CDMargins object or an object with left, top, right, bottom properties
       * @return Object : if no parameter are given, returns a CDMargins object
       */
      margins : function (value)
        {
          if(value!=null && value instanceof CDMargins)
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setMargins($(this), value);
              }
            );
          }
          else
          {
            // return the selected value
            var options=this.data('options');

            if(options)
            {
              return(options.margins);
            }
            else
            {
              return(null);
            }
          }
        },

      /**
       * define the legend
       *
       * @param Object value : a CDLegend object or an object with left, top, right, bottom properties
       * @return Object : if no parameter are given, returns a CDLegend object
       */
      legend : function (value)
        {
          if(value!=null && value instanceof CDLegend)
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setLegend($(this), value);
              }
            );
          }
          else
          {
            // return the selected value
            var options=this.data('options');

            if(options)
            {
              return(options.legend);
            }
            else
            {
              return(null);
            }
          }
        },

      /**
       * define the front axis
       *
       * @param Object value : a CDAxis object
       * @return Object : if no parameter are given, returns a CDAxis object
       */
      axisFront : function (value)
        {
          if(value!=null && value instanceof CDAxis)
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setAxis($(this), value, true);
              }
            );
          }
          else
          {
            // return the selected value
            var options=this.data('options');

            if(options)
            {
              return(options.axis.front);
            }
            else
            {
              return(null);
            }
          }
        },

      /**
       * define the back axis
       *
       * @param Object value : a CDAxis object
       * @return Object : if no parameter are given, returns a CDAxis object
       */
      axisBack : function (value)
        {
          if(value!=null && value instanceof CDAxis)
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setAxis($(this), value, false);
              }
            );
          }
          else
          {
            // return the selected value
            var options=this.data('options');

            if(options)
            {
              return(options.axis.back);
            }
            else
            {
              return(null);
            }
          }
        },

      /**
       * return the canvas objects
       *
       * @return Object : an object with axis, graph and cursor canvas
       */
      canvasObjects : function ()
        {
          var canvasObjects=this.data('canvasObjects');

          if(canvasObjects)
          {
            return(canvasObjects);
          }
          else
          {
            return(
              {
                cursor:null,
                axis:null,
                graph:null
              }
            );
          }
        },

      /**
       * define the function to be triggered when the mouse moves on the drawing
       * area
       *
       * @param Function value : a function to be triggered
       * @return Function : if no paramater is given, return the function
       */
      mousePositionChange: function (value)
        {
          if(value!=null && $.isFunction(value))
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setEventMousePositionChange($(this), value);
              }
            );
          }
          else
          {
            // return the selected value
            var options=this.data('options');

            if(options)
            {
              return(options.events.mousePositionChange);
            }
            else
            {
              return(null);
            }
          }
        }, // mousePositionChange

      /**
       * define the function to be triggered when the mouse enter on the drawing
       * area
       *
       * @param Function value : a function to be triggered
       * @return Function : if no paramater is given, return the function
       */
      mouseEnter: function (value)
        {
          if(value!=null && $.isFunction(value))
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setEventMouseEnter($(this), value);
              }
            );
          }
          else
          {
            // return the selected value
            var options=this.data('options');

            if(options)
            {
              return(options.events.mouseEnter);
            }
            else
            {
              return(null);
            }
          }
        }, // mouseEnter

      /**
       * define the function to be triggered when the mouse leaves the drawing
       * area
       *
       * @param Function value : a function to be triggered
       * @return Function : if no paramater is given, return the function
       */
      mouseLeave: function (value)
        {
          if(value!=null && $.isFunction(value))
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setEventMouseLeave($(this), value);
              }
            );
          }
          else
          {
            // return the selected value
            var options=this.data('options');

            if(options)
            {
              return(options.events.mouseLeave);
            }
            else
            {
              return(null);
            }
          }
        }, // mouseLeave

      /**
       * define the function to be triggered when the mouse is clicked on the
       * drawing area
       *
       * @param Function value : a function to be triggered
       * @return Function : if no paramater is given, return the function
       */
      mouseClick: function (value)
        {
          if(value!=null && $.isFunction(value))
          {
            // set selected value
            return this.each(function()
              {
                privateMethods.setEventMouseClick($(this), value);
              }
            );
          }
          else
          {
            // return the selected value
            var options=this.data('options');

            if(options)
            {
              return(options.events.mouseClick);
            }
            else
            {
              return(null);
            }
          }
        }, // mouseClick

      /**
       * force the drawing area to refresh display
       */
      refresh: function ()
        {
          return this.each(function()
            {
              privateMethods.draw($(this));
            }
          );
        }
    }, // methods


    /*
     * plugin 'private' methods
     */
    privateMethods =
    {
      /**
       * initialise the object with given options
       *
       * @param object value: options to be set
       */
      setOptions : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          if(!$.isPlainObject(value)) return(false);

          properties.initialized=false;

          if(value.axis==null) value.axis={};
          if(value.events==null) value.events={};

          privateMethods.setMargins(object, (value.margins!=null)?value.margins:options.margins);
          privateMethods.setLegend(object, (value.legend!=null)?value.legend:options.legend);
          privateMethods.setCursor(object, (value.cursor!=null)?value.cursor:options.cursor);
          privateMethods.setAxis(object, (value.axis.front!=null)?value.axis.front:options.axis.front, true);
          privateMethods.setAxis(object, (value.axis.back!=null)?value.axis.back:options.axis.back, false);
          privateMethods.setDisplay(object, (value.display!=null)?value.display:options.display);

          privateMethods.setEventMousePositionChange(object, (value.events.mousePositionChange!=null)?value.events.mousePositionChange:options.events.mousePositionChange);
          privateMethods.setEventMouseLeave(object, (value.events.mouseLeave!=null)?value.events.mouseLeave:options.events.mouseLeave);
          privateMethods.setEventMouseEnter(object, (value.events.mouseEnter!=null)?value.events.mouseEnter:options.events.mouseEnter);
          privateMethods.setEventMouseClick(object, (value.events.mouseClick!=null)?value.events.mouseClick:options.events.mouseClick);

          properties.initialized=true;

          privateMethods.draw(object);
        },


      /**
       * setDisplay allows to resize the sheetSizeport
       *
       * @param object value: an object with width&height properties
       * @return object: display options properties
       */
      setDisplay : function (object, value)
        {
          var properties=object.data('properties'),
              objects=object.data('objects'),
              options=object.data('options'),
              canvasObjects=object.data('canvasObjects'),
              triggerSize=false,
              axisBox={
                width:0,
                height:0
              };



          if(value.width==null) value.width=options.display.width;
          if(value.height==null) value.height=options.display.height;

          if(value.width>0 &&
             value.height>0 &&
             (value.width!=options.display.width ||
              value.height!=options.display.height ||
              !properties.initialized)
            )
          {
            delete canvasObjects.cursor;
            delete canvasObjects.axis;
            delete canvasObjects.graph;

            options.display.width=value.width;
            options.display.height=value.height;

            objects.sheet.css(
              {
                width:options.display.width+'px',
                height:options.display.height+'px'
              }
            );

            objects.viewport.attr("height", options.display.height).attr("width", options.display.width);
            objects.canvasCursor.attr("height", options.display.height).attr("width", options.display.width);
            objects.canvasAxis.attr("height", options.display.height).attr("width", options.display.width);
            objects.canvasGraph.attr("height", options.display.height).attr("width", options.display.width);
            object.attr("height", options.display.height).attr("width", options.display.width);
            object.css(
              {
                width:options.display.width+'px',
                height:options.display.height+'px'
              }
            );//attr("height", options.display.height).attr("width", options.display.width);

            canvasObjects.cursor=new CDDrawing(objects.canvasCursor.get(0));
            canvasObjects.axis=new CDDrawing(objects.canvasAxis.get(0));
            canvasObjects.graph=new CDDrawing(objects.canvasGraph.get(0));

            axisBox=privateMethods.axisBox(object);

            if(options.axis.front!=null)
              options.axis.front.set(
                {
                  size:{
                      width:axisBox.width, //options.display.width-options.margins.get().left-options.margins.get().right,
                      height:axisBox.height //options.display.height-options.margins.get().top-options.margins.get().bottom
                    }
                }
              );

            if(options.axis.back!=null)
              options.axis.back.set(
                {
                  size:{
                      width:axisBox.width, //options.display.width-options.margins.get().left-options.margins.get().right,
                      height:axisBox.height //options.display.height-options.margins.get().top-options.margins.get().bottom
                    }
                }
              );

            if(properties.initialized)
            {
              /*
               * redraw graph
               */
            }
          }

          return(options.display);
        }, // setDisplay


      /**
       * define the cursor properties
       *
       * @param object value: the cursor properties (color, visible, verticalType)
       * @return object: cursor options values
       */
      setCursor : function (object, value)
        {
          var properties=object.data('properties'),
              objects=object.data('objects'),
              options=object.data('options'),
              redraw=false;

          if(value.color==null) value.color=options.cursor.color;
          if(value.visible==null) value.visible=options.cursor.visible;
          if(value.verticalType==null) value.verticalType=options.cursor.verticalType;

          if((value.visible===true || value.visible===false) &&
             (value.verticalType=='bar' || value.verticalType=='line') &&
             (value.visible!=options.cursor.visible ||
              value.color!=options.cursor.color ||
              value.verticalType!=options.cursor.verticalType ||
              !properties.initialized)
            )
          {
            if(options.cursor.color!=value.color ||
               options.cursor.verticalType!=value.verticalType ||
               options.cursor.visible!=value.visible) redraw=true;

            options.cursor.visible=value.visible;
            options.cursor.color=value.color;
            options.cursor.verticalType=value.verticalType;

            objects.canvasCursor.css('display', options.cursor.visible?'block':'none');

            if(options.cursor.visible && redraw) privateMethods.drawCursor(object);
          }
          return(options.cursor);
        }, // setCursor

      /**
       * define the margins
       *
       * @param CDMargins value: a CDMargins object
       * @return CDMargins: the CDMargins applied
       */
      setMargins : function (object, value)
        {
          var properties=object.data('properties'),
              objects=object.data('objects'),
              options=object.data('options');

          if(value instanceof CDMargins &&
             (!options.margins.equals(value) ||
              !properties.initialized)
            )
          {
            options.margins.set(value);
            privateMethods.draw(object);
          }
          return(options.margins);
        }, // setMargins

      /**
       * define the legend
       *
       * @param CDLegend value: a CDLegend object
       * @return CDLegend: current CDLegend applied
       */
      setLegend : function (object, value)
        {
          var properties=object.data('properties'),
              objects=object.data('objects'),
              options=object.data('options');

          if(value instanceof CDLegend &&
             (!options.legend.equals(value) ||
              !properties.initialized)
            )
          {
            options.legend.set(value);
            privateMethods.draw(object);
          }
          return(options.legend);
        }, // setLegend

      /**
       * define the axis
       *
       * @param CDAxis value: a CDAxis object
       * @param boolean front: true if function is called to define the front axis,
       *                       false if function is called to define the baxk axis
       * @return CDAxis: the CDAxis object applied
       */
      setAxis : function (object, value, front)
        {
          var properties=object.data('properties'),
              objects=object.data('objects'),
              options=object.data('options');

          if(value instanceof CDAxis)
          {
            if(front)
            {
              delete options.axis.front;
              options.axis.front=value;
            }
            else
            {
              delete options.axis.back;
              options.axis.back=value;
            }

            privateMethods.draw(object);
          }
          return(front?options.axis.front:options.axis.back);
        }, // setAxis


      /**
       * this function is used to set a callback when mouse position changed over
       * the viewport
       */
      setEventMousePositionChange : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          options.events.mousePositionChange=value;
          object.unbind('drawingGraphMousePositionChange');
          if(value) object.bind('drawingGraphMousePositionChange', options.events.mousePositionChange);
          return(options.events.mousePositionChange);
        }, //setEventMousePositionChange

      /**
       * this function is used to set a callback when mouse leave the viewport
       */
      setEventMouseLeave : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          options.events.mouseLeave=value;
          object.unbind('drawingGraphMouseLeave');
          if(value) object.bind('drawingGraphMouseLeave', options.events.mouseLeave);
          return(options.events.mouseLeave);
        }, //setEventMouseLeave


      /**
       * this function is used to set a callback when mouse enter the viewport
       */
      setEventMouseEnter : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          options.events.mouseEnter=value;
          object.unbind('drawingGraphMouseEnter');
          if(value) object.bind('drawingGraphMouseEnter', options.events.mouseEnter);
          return(options.events.mouseEnter);
        }, //setEventMouseEnter


      /**
       * this function is used to set a callback when mouse is clicked on the
       * viewport
       */
      setEventMouseClick : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          options.events.mouseClick=value;
          object.unbind('drawingGraphMouseClick');
          if(value) object.bind('drawingGraphMouseClick', options.events.mouseClick);
          return(options.events.mouseClick);
        }, // setEventMouseClick


      /**
       * this function is called when the mouse moves on the drawing area
       *  - calculate the axis position
       *  - draw cursor
       *  - trigger function event if any
       *
       * Note: works only if the axis mode is 'XY'.
       *
       * @param integer valueX: x position on the canvas
       * @param integer valueY: y position on the canvas
       */
      mousePositionUpdate : function (object, valueX, valueY)
        {
          var properties=object.data('properties'),
              options=object.data('options'),
              work={
                margins:options.margins.get(),
                legend:options.legend.get(),
                axis:{
                  front:(options.axis.front!=null)?options.axis.front.get():null,
                  back:(options.axis.back!=null)?options.axis.back.get():null
                },
                values:[],
                axisValues:{},
                axisPos:{
                  x:0,
                  y:0
                },
                updated:false
              },
              /**
               * returns for each series, the value associated with the cursor's position
               *
               * @param Array series: series
               * @param integer position: horinzontal cursor position
               * @return Array: array of series values
               */
              calculateSeriesValues = function (series, position)
                {
                  var tmpSerie=null,
                      returned=[];

                  for(var i=0;i<series.length;i++)
                  {
                    tmpSerie=series[i].get();

                    if(position>=0 && position<tmpSerie.values.length)
                      returned.push(
                        {
                          name:tmpSerie.name,
                          value:tmpSerie.values[position]
                        }
                      );
                  }
                  return(returned);
                };

          properties.cursor.x=valueX;
          properties.cursor.y=valueY;


          if(work.axis.back!=null && work.axis.back.properties.mode=='XY')
          {
            // get relative position to the axis
            work.axisPos=privateMethods.axisXYRelativePosition(object, properties.cursor.x+((options.cursor.verticalType=='bar' || work.axis.back.properties.XY.ticks.H.offset0)?0:work.axis.back.data.XY.H.space/2), properties.cursor.y);

            work.axisValues=options.axis.back.getXYAxisValues(work.axisPos.x, work.axisPos.y);
            if(work.axisValues.H!=properties.cursor.axis.XY.back.H || work.axisValues.V!=properties.cursor.axis.XY.back.V)
            {
              if(work.axisValues.H!=properties.cursor.axis.XY.back.H) work.updated=true;
              properties.cursor.axis.XY.back.H=work.axisValues.H;
              properties.cursor.axis.XY.back.V=work.axisValues.V;
            }
            work.values=work.values.concat(calculateSeriesValues(options.axis.back.get().properties.series, work.axisValues.H));
          }

          if(work.axis.front!=null && work.axis.front.properties.mode=='XY')
          {
            // get relative position to the axis
            work.axisPos=privateMethods.axisXYRelativePosition(object, properties.cursor.x+((options.cursor.verticalType=='bar' || work.axis.front.properties.XY.ticks.H.offset0)?0:work.axis.front.data.XY.H.space/2), properties.cursor.y);

            work.axisValues=options.axis.front.getXYAxisValues(work.axisPos.x, work.axisPos.y);
            if(work.axisValues.H!=properties.cursor.axis.XY.front.H || work.axisValues.V!=properties.cursor.axis.XY.front.V)
            {
              if(work.axisValues.H!=properties.cursor.axis.XY.front.H) work.updated=true;
              properties.cursor.axis.XY.front.H=work.axisValues.H;
              properties.cursor.axis.XY.front.V=work.axisValues.V;
            }
            work.values=work.values.concat(calculateSeriesValues(options.axis.front.get().properties.series, work.axisValues.H));
          }

          if(options.cursor.visible)
            privateMethods.drawCursor(object);

          if(options.events.mousePositionChange && work.updated && work.values.length>0)
            object.trigger('drawingGraphMousePositionChange',
              {
                position:{
                  x:properties.cursor.x,
                  y:properties.cursor.y
                },
                values:work.values
              }
            );
        }, // mousePositionUpdate


      /**
       * this function is called when the mouse moves on the drawing area
       *  - hide cursor
       *  - trigger function event if any
       */
      mouseLeave : function (object)
        {
          var objects=object.data('objects'),
              options=object.data('options'),
              properties=object.data('properties');

          objects.canvasCursor.css('display', 'none');

          properties.cursor.axis.XY.front.H=-1;
          properties.cursor.axis.XY.front.V=-1;
          properties.cursor.axis.XY.back.H=-1;
          properties.cursor.axis.XY.back.V=-1;

          if(options.events.mouseLeave)
            object.trigger('drawingGraphMouseLeave');
        },

      /**
       * this function is called when the mouse moves on the drawing area
       *  - show cursor
       *  - trigger function event if any
       */
      mouseEnter : function (object)
        {
          var objects=object.data('objects'),
              options=object.data('options');

          objects.canvasCursor.css('display', options.cursor.visible?'block':'none');

          if(options.events.mouseEnter)
            object.trigger('drawingGraphMouseEnter');
        },


      /**
       * this function is called when the mouse click on the drawing area
       */
      mouseClick : function (object)
        {
          var options=object.data('options');

          if(options.events.mouseClick)
            object.trigger('drawingGraphMouseClick');
        },

      /**
       * return position relative to the axis
       *
       * @param integer x: x position
       * @param integer y: y position
       * @return object: a {x,y} object; coordinates relative to the axis
       */
      axisXYRelativePosition : function (object, x, y)
        {
          var properties=object.data('properties'),
              options=object.data('options'),
              work={
                margins:options.margins.get(),
                legend:options.legend.get(),
                returned:{
                  x:0,
                  y:0
                }
              };
          work.returned.y=options.display.height-y-work.margins.bottom;
          work.returned.x=x-work.margins.left;
          if(work.legend.visible && work.legend.position=='left') work.returned.x-=options.legend.getRealWidth()+work.margins.right;
          return(work.returned);
        }, //axisXYRelativePosition

      /**
       * calculate the axis box
       *
       * @return object: axis dimensions
       */
      axisBox : function (object)
        {
          var properties=object.data('properties'),
              objects=object.data('objects'),
              options=object.data('options'),
              work={
                margins:options.margins.get(),
                legend:options.legend.get(),
                returned:{
                  width:0,
                  height:0
                }
              };

          work.returned.height=options.display.height-options.margins.get().top-options.margins.get().bottom;
          work.returned.width=options.display.width-options.margins.get().left-options.margins.get().right;
          if(work.legend.visible) work.returned.width-=options.legend.getRealWidth()+options.margins.get().right;

          return(work.returned);
        },

      /**
       * this function draws the cursor
       */
      drawCursor : function (object)
        {
          var properties=object.data('properties'),
              objects=object.data('objects'),
              options=object.data('options'),
              canvasObjects=object.data('canvasObjects'),
              work={
                  margins:options.margins.get(),
                  axis:{
                    front:(options.axis.front!=null)?options.axis.front.get():null,
                    back:(options.axis.back!=null)?options.axis.back.get():null
                  },
                  width:options.display.width,
                  height:options.display.height,
                  nearest:0,
                  step:0,
                  axisValues:
                    {
                      front:{H:0, V:0},
                      back:{H:0, V:0}
                    }
                };
          // draw the cursor only if at least, one of the axis mode equals XY
          if(!(work.axis.front!=null && work.axis.front.properties.mode=='XY' ||
               work.axis.back!=null && work.axis.back.properties.mode=='XY')) return(false);

          // prepare canvas area
          canvasObjects.cursor.drawingManageCrisp(true);

          canvasObjects.cursor.shapeClearRect(0,0,work.width, work.height);
          canvasObjects.cursor.styleStrokeColor(options.cursor.color);
          canvasObjects.cursor.styleFillColor(options.cursor.color);
          canvasObjects.cursor.styleStrokeDraw({width:1, cap:'butt', joints:'miter'});

          //save canvas state
          canvasObjects.cursor.drawingStatePush();

          // get relative position to the axis
          work.axisPos=privateMethods.axisXYRelativePosition(object, 0, 0);

          // flip canvas vertically & translate (zero in vertical position is localized at the bottom)
          canvasObjects.cursor.transformScale({y:-1});
          canvasObjects.cursor.transformTranslate(
            {
              x:-work.axisPos.x,
              y:-work.axisPos.y
            }
          );


          // front axis managment
          if(work.axis.front!=null &&
             work.axis.front.properties.mode=='XY' &&
             (work.axis.front.properties.display.visible.XY.cursorH ||
              work.axis.front.properties.display.visible.XY.cursorV)
            )
          {
            if(work.axis.front.properties.display.visible.XY.cursorH &&
               properties.cursor.axis.XY.front.H>=0 &&
               properties.cursor.axis.XY.front.H<work.axis.front.properties.XY.values.H.length
              )
            {
              // draw the period rectangle
              pH=options.axis.front.getXYHPos(properties.cursor.axis.XY.front.H, false);
              if(options.cursor.verticalType=='bar')
              {
                canvasObjects.cursor.shapeRect(pH, 0, work.axis.front.data.XY.H.space, work.axis.front.properties.size.height);
              }
              else
              {
                if(work.axis.front.properties.XY.ticks.H.offset0) pH+=work.axis.front.data.XY.H.space/2;
                canvasObjects.cursor.shapeLine(pH, 0, pH, work.axis.front.properties.size.height);
              }
            }

            // calculate the nearest y value (tick's frequency adjusted)
            if(work.axis.front.properties.XY.ticks.V.frequency.small==0)
            {
              work.step=work.axis.front.properties.XY.ticks.V.frequency.big;
            }
            else
            {
              work.step=work.axis.front.properties.XY.ticks.V.frequency.small;
            }
            work.nearest=(work.step==0)?0:options.axis.front.getXYVStepPos(work.step*Math.round(properties.cursor.axis.XY.front.V/work.step));

            if(work.axis.front.properties.display.visible.XY.cursorV &&
               work.nearest>=0 && work.nearest<=work.axis.front.properties.size.height
              )
            {
              // draw the value line
              canvasObjects.cursor.shapeLine(0, work.nearest, work.axis.front.properties.size.width, work.nearest);
            }
          } // front axis managment

          // back axis managment
          if(work.axis.back!=null &&
             work.axis.back.properties.mode=='XY' &&
             (work.axis.back.properties.display.visible.XY.cursorH ||
              work.axis.back.properties.display.visible.XY.cursorV)
            )
          {
            if(work.axis.back.properties.display.visible.XY.cursorH &&
               properties.cursor.axis.XY.back.H>=0 &&
               properties.cursor.axis.XY.back.H<work.axis.back.properties.XY.values.H.length
              )
            {
              // draw the period rectangle
              pH=options.axis.back.getXYHPos(properties.cursor.axis.XY.back.H, false);

              if(options.cursor.verticalType=='bar')
              {
                canvasObjects.cursor.shapeRect(pH, 0, work.axis.back.data.XY.H.space, work.axis.back.properties.size.height);
              }
              else
              {
                if(work.axis.back.properties.XY.ticks.H.offset0) pH+=work.axis.back.data.XY.H.space/2;
                canvasObjects.cursor.shapeLine(pH, 0, pH, work.axis.back.properties.size.height);
              }
            }

            // calculate the nearest y value (tick's frequency adjusted)
            if(work.axis.back.properties.XY.ticks.V.frequency.small==0)
            {
              work.step=work.axis.back.properties.XY.ticks.V.frequency.big;
            }
            else
            {
              work.step=work.axis.back.properties.XY.ticks.V.frequency.small;
            }
            work.nearest=(work.step==0)?0:options.axis.back.getXYVStepPos(work.step*Math.round(properties.cursor.axis.XY.back.V/work.step));
            if(work.axis.back.properties.display.visible.XY.cursorV &&
               work.nearest>=0 && work.nearest<=work.axis.back.properties.size.height)
            {
              canvasObjects.cursor.shapeLine(0, work.nearest, work.axis.back.properties.size.width, work.nearest);
            }
          } // back axis managment


          //restore the canvas state
          canvasObjects.cursor.drawingStatePop();
        }, //drawCursor

      /**
       * this function draws the graphs
       */
      draw : function (object)
        {
          var properties=object.data('properties'),
              canvasObjects=object.data('canvasObjects'),
              options=object.data('options'),
              work={
                  margins:options.margins.get(),
                  axis:{
                    front:(options.axis.front!=null)?options.axis.front.get():null,
                    back:(options.axis.back!=null)?options.axis.back.get():null
                  },
                  width:canvasObjects.axis.getContextWidth(),
                  height:canvasObjects.axis.getContextHeight(),
                  legendBox:null
                };

          if(!properties.initialized) return(false);

          canvasObjects.axis.shapeClearRect(0,0,work.width, work.height);
          canvasObjects.graph.shapeClearRect(0,0,work.width, work.height);

          canvasObjects.axis.drawingManageCrisp(true);
          canvasObjects.graph.drawingManageCrisp(true);

          canvasObjects.axis.drawingStatePush();
          canvasObjects.graph.drawingStatePush();

          canvasObjects.axis.transformScale({y:-1});
          canvasObjects.graph.transformScale({y:-1});

          canvasObjects.axis.transformTranslate({x:work.margins.left, y:work.margins.bottom-work.height});
          canvasObjects.graph.transformTranslate({x:work.margins.left, y:work.margins.bottom-work.height});

          privateMethods.drawLegend(object);
          if(work.axis.back!=null) privateMethods.drawGraph(object, options.axis.back);
          if(work.axis.front!=null) privateMethods.drawGraph(object, options.axis.front);

          canvasObjects.axis.drawingStatePop();
          canvasObjects.graph.drawingStatePop();

          return(true);
        },

      drawGraph : function (object, axis)
        {
          var properties=object.data('properties'),
              canvasObjects=object.data('canvasObjects'),
              options=object.data('options'),
              work={
                  axis:axis.get(),
                  margins:options.margins.get(),
                  width:canvasObjects.axis.getContextWidth(),
                  height:canvasObjects.axis.getContextHeight()
                };

          privateMethods.drawAxis(object, axis);
          for(var i=work.axis.properties.series.length-1;i>=0;i--)
          {
            switch(work.axis.properties.series[i].get().options.get().type)
            {
              case 'bar':
                privateMethods.drawSerieBar(object, axis, work.axis.properties.series[i]);
                break;
              case 'area':
                privateMethods.drawSerieArea(object, axis, work.axis.properties.series[i]);
                break;
              case 'line':
                privateMethods.drawSerieLine(object, axis, work.axis.properties.series[i]);
                break;
              case 'pie':
                privateMethods.drawSeriePie(object, axis, work.axis.properties.series[i]);
                break;
            }
          }

        },

      /**
       * draw the axis; canvas must be ready before calling this function
       */
      drawAxis : function (object, axis)
        {
          var properties=object.data('properties'),
              canvasObjects=object.data('canvasObjects'),
              options=object.data('options'),
              work={
                  margins:options.margins.get(),
                  axis:axis.get(),
                  width:canvasObjects.axis.getContextWidth(),
                  height:canvasObjects.axis.getContextHeight()
                };

          if(
              work.axis.properties.mode=='pie' && !work.axis.properties.display.visible.pie
                ||
              work.axis.properties.mode=='XY' &&
             !work.axis.properties.display.visible.XY.H && !work.axis.properties.display.visible.XY.V
            ) return(false);

          // prepare canvas
          canvasObjects.axis.styleFillColor(work.axis.properties.display.color);
          canvasObjects.axis.styleStrokeColor(work.axis.properties.display.color);
          canvasObjects.axis.styleStrokeDraw({width:1, cap:'butt', joints:'miter'});

          /*
           * -------------------------------------------------------------------
           * drawing horizontal ticks&values
           * -------------------------------------------------------------------
           */
          if(work.axis.properties.mode=='XY' && work.axis.properties.display.visible.XY.H)
          {
            canvasObjects.axis.shapeLine(0,0,work.axis.properties.size.width,0);

            // prepare values
            switch(work.axis.properties.XY.ticks.H.value.rotate)
            {
              case 0:
                canvasObjects.axis.textStyle(
                  {
                    font:work.axis.properties.XY.ticks.H.value.fontName+' '+work.axis.properties.XY.ticks.H.value.fontSize+'px',
                    alignH:'center',
                    alignV:'top'
                  }
                );
                break;
              case 90:
                canvasObjects.axis.textStyle(
                  {
                    font:work.axis.properties.XY.ticks.H.value.fontName+' '+work.axis.properties.XY.ticks.H.value.fontSize+'px',
                    alignH:'right',
                    alignV:'center'
                  }
                );
                break;
              default:
                canvasObjects.axis.textStyle(
                  {
                    font:work.axis.properties.XY.ticks.H.value.fontName+' '+work.axis.properties.XY.ticks.H.value.fontSize+'px',
                    alignH:'right',
                    alignV:'top'
                  }
                );
                break;
            }
            // draw
            for(var i=0;i<work.axis.properties.XY.values.H.length;i++)
            {
              p=axis.getXYHPos(i);
              if(work.axis.properties.XY.ticks.H.frequency.big>0 &&
                 work.axis.properties.XY.ticks.H.visible.big &&
                 i%work.axis.properties.XY.ticks.H.frequency.big==0)
              {
                canvasObjects.axis.shapeLine(p,0,p,-work.axis.properties.XY.ticks.H.size.big);

                if(work.axis.properties.XY.ticks.H.value.visible)
                {
                  canvasObjects.axis.drawingStatePush();
                  canvasObjects.axis.transformScale({y:-1});
                  canvasObjects.axis.transformTranslate(
                    {
                      x:p,
                      y:work.axis.properties.XY.ticks.H.size.big+2
                    }
                  );
                  canvasObjects.axis.transformRotate({angle:work.axis.properties.XY.ticks.H.value.rotate, mode:'degree'})
                  canvasObjects.axis.textPrint(work.axis.properties.XY.values.H[i],0,0,'fill');
                  canvasObjects.axis.drawingStatePop();
                }
              }
              else if(work.axis.properties.XY.ticks.H.frequency.small>0 &&
                 work.axis.properties.XY.ticks.H.visible.small &&
                 i%work.axis.properties.XY.ticks.H.frequency.small==0)
              {
                canvasObjects.axis.shapeLine(p,0,p,-work.axis.properties.XY.ticks.H.size.small);
              }
            }
          }

          /*
           * -------------------------------------------------------------------
           * drawing vertical ticks&values
           * -------------------------------------------------------------------
           */
          if(work.axis.properties.mode=='XY' && work.axis.properties.display.visible.XY.V)
          {
            canvasObjects.axis.shapeLine(0,0,0,work.axis.properties.size.height);

            // prepare values
            switch(work.axis.properties.XY.ticks.V.value.rotate)
            {
              case 0:
                canvasObjects.axis.textStyle(
                  {
                    font:work.axis.properties.XY.ticks.V.value.fontName+' '+work.axis.properties.XY.ticks.V.value.fontSize+'px',
                    alignH:'right',
                    alignV:'center'
                  }
                );
                break;
              case 90:
                canvasObjects.axis.textStyle(
                  {
                    font:work.axis.properties.XY.ticks.V.value.fontName+' '+work.axis.properties.XY.ticks.V.value.fontSize+'px',
                    alignH:'center',
                    alignV:'bottom'
                  }
                );
                break;
              default:
                canvasObjects.axis.textStyle(
                  {
                    font:work.axis.properties.XY.ticks.V.value.fontName+' '+work.axis.properties.XY.ticks.V.value.fontSize+'px',
                    alignH:'right',
                    alignV:'bottom'
                  }
                );
                break;
            }
            //draw small ticks
            if(work.axis.properties.XY.ticks.V.value.visible &&
               work.axis.properties.XY.ticks.V.frequency.small>0 &&
               work.axis.properties.XY.ticks.V.visible.small)
            {
              i=0;
              while(i<=work.axis.properties.XY.ticks.V.steps)
              {
                p=axis.getXYVStepPos(i);
                canvasObjects.axis.shapeLine(0,p,-work.axis.properties.XY.ticks.V.size.small,p);
                i+=work.axis.properties.XY.ticks.V.frequency.small;
              }
            }

            //draw big ticks
            if(work.axis.properties.XY.ticks.V.value.visible &&
               work.axis.properties.XY.ticks.V.frequency.big >0 &&
               work.axis.properties.XY.ticks.V.visible.big)
            {
              i=0;
              while(i<=work.axis.properties.XY.ticks.V.steps)
              {
                p=axis.getXYVStepPos(i);

                canvasObjects.axis.shapeLine(0,p,-work.axis.properties.XY.ticks.V.size.big,p);

                if(work.axis.properties.XY.ticks.V.value.visible)
                {
                  canvasObjects.axis.drawingStatePush();
                  canvasObjects.axis.transformScale({y:-1});
                  canvasObjects.axis.transformTranslate(
                    {
                      x:-(work.axis.properties.XY.ticks.V.size.big+2),
                      y:-(p+work.axis.properties.XY.ticks.V.value.fontSize/2)
                    }
                  );
                  canvasObjects.axis.transformRotate({angle:work.axis.properties.XY.ticks.V.value.rotate, mode:'degree'})
                  canvasObjects.axis.textPrint(i,0,0,'fill');
                  canvasObjects.axis.drawingStatePop();
                }
                i+=work.axis.properties.XY.ticks.V.frequency.big;
              }
            }
          }

          /*
           * -------------------------------------------------------------------
           * drawing values for pies
           * -------------------------------------------------------------------
           */
          if(work.axis.properties.mode=='pie' && work.axis.properties.display.visible.pie)
          {
            var drawSerieValues = function (serie)
                  {
                    var pieWork={
                            serieProp:serie.get(),
                            tmp:0,
                            angle:0,
                            angle2:0,
                            angCnv:Math.PI/180,
                            pV:0,
                            pH:0,
                            textWidth:0,
                            radiusList:[],
                            distance:0,
                            distance2:0,
                            sumDistance:0,
                            minDistance:10,
                            endRadius:0,
                            startRadius:0,
                            lastZero:0
                          };

                    for(var i=0;i<pieWork.serieProp.values.length;i++)
                    {
                      pieWork.tmp+=pieWork.serieProp.values[i];
                    }
                    pieWork.tmp=360/pieWork.tmp;

                    pieWork.endRadius=work.axis.properties.pie.outerRadius*pieWork.serieProp.options.get().outerRadius;
                    pieWork.startRadius=pieWork.serieProp.options.get().innerRadius+work.axis.properties.pie.innerRadius*(pieWork.serieProp.options.get().outerRadius-pieWork.serieProp.options.get().innerRadius);

                    // calculate radius list
                    for(var i=0;i<pieWork.serieProp.values.length;i++)
                    {
                      if(i==0)
                      {
                        pieWork.radiusList.push({radius:0, distance:0});
                      }
                      else
                      {
                        pieWork.distance2=Math.pow(pieWork.endRadius*Math.sin(pieWork.angle*pieWork.angCnv) ,2) + Math.pow(pieWork.endRadius*(1-Math.cos(pieWork.angle*pieWork.angCnv)) ,2);
                        pieWork.distance=Math.sqrt(pieWork.distance2);
                        pieWork.sumDistance+=pieWork.distance;

                        if(pieWork.sumDistance<2*pieWork.minDistance)
                        {
                          pieWork.radiusList.push({radius:Math.sqrt(pieWork.distance2 + 4*pieWork.minDistance*pieWork.minDistance) , distance:pieWork.distance});
                        }
                        else
                        {
                          pieWork.radiusList.push({radius:0, distance:pieWork.distance});
                          pieWork.sumDistance=0;
                          pieWork.lastZero=i;
                        }
                      }

                      pieWork.angle=pieWork.serieProp.values[i]*pieWork.tmp;
                      pieWork.angle2+=pieWork.angle
                    }

                    canvasObjects.axis.drawingStatePush();
                    canvasObjects.axis.styleFillColor(work.axis.properties.display.color);
                    // draw lines
                    for(var i=0;i<pieWork.serieProp.values.length;i++)
                    {
                      if(i==0)
                      {
                        canvasObjects.axis.transformRotate({angle:pieWork.serieProp.values[i]*pieWork.tmp/2, mode:'degree'});
                      }
                      else
                      {
                        canvasObjects.axis.transformRotate({angle:(pieWork.serieProp.values[i]*pieWork.tmp+pieWork.serieProp.values[i-1]*pieWork.tmp)/2, mode:'degree'});
                      }
                      canvasObjects.axis.shapeLine(pieWork.startRadius, 0, pieWork.endRadius+pieWork.radiusList[i].radius, 0);
                      canvasObjects.axis.shapeCircle(pieWork.startRadius, 0, 2, {fill:true, stroke:false});
                    }
                    canvasObjects.axis.drawingStatePop();

                    // draw values
                    canvasObjects.axis.textStyle(
                      {
                        font:work.axis.properties.pie.fontName+' '+work.axis.properties.pie.fontSize+'px',
                        alignH:'center',
                        alignV:'center'
                      }
                    );

                    canvasObjects.axis.drawingStatePush();
                    canvasObjects.axis.transformRotate({angle:90, mode:'degree'});
                    canvasObjects.axis.transformScale({y:-1});
                    pieWork.angle=-90;
                    for(var i=0;i<pieWork.serieProp.values.length;i++)
                    {
                      if(i==0)
                      {
                        pieWork.angle+=pieWork.serieProp.values[i]*pieWork.tmp/2;
                      }
                      else
                      {
                        pieWork.angle+=(pieWork.serieProp.values[i]*pieWork.tmp+pieWork.serieProp.values[i-1]*pieWork.tmp)/2;
                      }

                      pieWork.pH=(pieWork.endRadius+pieWork.radiusList[i].radius)*Math.cos(pieWork.angle*pieWork.angCnv);
                      pieWork.pV=(pieWork.endRadius+pieWork.radiusList[i].radius)*Math.sin(pieWork.angle*pieWork.angCnv)+work.axis.properties.pie.fontSize/2;

                      pieWork.textWidth=canvasObjects.axis.textWidth(pieWork.serieProp.values[i]);
                      canvasObjects.axis.shapeClearRect(pieWork.pH-pieWork.textWidth.width/2-1, pieWork.pV-work.axis.properties.pie.fontSize-1, pieWork.textWidth.width+2, work.axis.properties.pie.fontSize+2);

                      canvasObjects.axis.textPrint(pieWork.serieProp.values[i],pieWork.pH,pieWork.pV,'fill');
                    }
                    canvasObjects.axis.drawingStatePop();

                  };

            // save canvas state
            canvasObjects.axis.drawingStatePush();

            canvasObjects.axis.transformTranslate({x:work.axis.data.pie.H.center, y:work.axis.data.pie.V.center});
            canvasObjects.axis.transformRotate({angle:-90, mode:'degree'});

            // prepare canvas
            canvasObjects.axis.styleStrokeColor(work.axis.properties.display.color);
            canvasObjects.axis.styleStrokeDraw({width:1, cap:'butt', joints:'round'});

            // draw values
            for(var i=work.axis.properties.series.length-1;i>=0;i--)
            {
              drawSerieValues(work.axis.properties.series[i]);
            }
            //restore canvas state
            canvasObjects.axis.drawingStatePop();
          }


          return(true);
        }, // drawAxis

        /**
         * calculate the legend width, draw the legend
         */
        drawLegend : function (object)
          {
            var properties=object.data('properties'),
                canvasObjects=object.data('canvasObjects'),
                options=object.data('options'),
                work={
                    axis:{
                      front:(options.axis.front!=null)?options.axis.front.get():null,
                      back:(options.axis.back!=null)?options.axis.back.get():null
                    },
                    margins:options.margins.get(),
                    legend:options.legend.get(),
                    legendBox:{width:0, height:0, margin:0},
                    width:canvasObjects.axis.getContextWidth(),
                    height:canvasObjects.axis.getContextHeight(),
                    tmpTop:0
                  },

                calculateLegendBox = function (axis, canvas, legend, currentHeight, currentWidth)
                  {
                    var returned={width:currentWidth, height:currentHeight, margin:0},
                        itemHeight=12,
                        tmp=0;

                    if(axis!=null)
                    {
                      if(legend.fontSize>itemHeight) itemHeight=legend.fontSize+4;
                      canvasObjects.axis.textStyle({font:legend.fontSize+'px '+legend.fontName});

                      for(var i=0; i<axis.properties.series.length;i++)
                      {
                        returned.height+=itemHeight;
                        tmp=canvas.textWidth(axis.properties.series[i].get().name);
                        if(tmp.width>returned.width) returned.width=tmp.width;

                        // if serie type is 'pie', use valuesLabels in the legend
                        if(axis.properties.series[i].get().options.get().type=='pie')
                        {
                          for(var j=0;j<axis.properties.series[i].get().valuesLabels.length;j++)
                          {
                            returned.height+=itemHeight;
                            tmp=canvas.textWidth(axis.properties.series[i].get().valuesLabels[j]);
                            if(tmp.width>returned.width) returned.width=tmp.width;
                          }
                          if(i<axis.properties.series.length-1) returned.height+=itemHeight/2;
                        }
                      }
                    }

                    return(returned);
                  },

                drawLegendNames = function (axis, canvas, legend, currentTop)
                  {
                    var top=currentTop,
                        itemHeight=12,
                        tmp=0;

                    if(axis!=null)
                    {
                      canvas.drawingStatePush();
                      canvas.transformScale({y:-1});
                      canvas.transformTranslate({y:4-work.legendBox.height});

                      canvasObjects.axis.textStyle(
                        {
                          font:legend.fontSize+'px '+legend.fontName,
                          alignH:'left',
                          alignV:'top'
                        }
                      );

                      canvas.styleFillColor(work.legend.borderColor);

                      if(legend.fontSize>itemHeight) itemHeight=legend.fontSize+4;

                      for(var i=0; i<axis.properties.series.length;i++)
                      {
                        if(axis.properties.series[i].get().options.get().type=='pie')
                        {
                          canvas.textPrint(axis.properties.series[i].get().name,4,top,'fill');
                          top+=itemHeight;

                          for(var j=0;j<axis.properties.series[i].get().valuesLabels.length;j++)
                          {
                            canvas.textPrint(axis.properties.series[i].get().valuesLabels[j],26,top,'fill');
                            drawLegendStyle(canvas, new CDSerie({options: new CDSerieOptionsBar({backgroundColor:axis.properties.series[i].get().options.get().backgroundColors[j]}) }).get(), top+itemHeight/2);
                            top+=itemHeight;
                          }
                          if(i<axis.properties.series.length-1) top+=itemHeight/2;
                        }
                        else
                        {
                          canvas.textPrint(axis.properties.series[i].get().name,26,top,'fill');
                          drawLegendStyle(canvas, axis.properties.series[i].get(), top+itemHeight/2);
                          top+=itemHeight;
                        }
                      }
                      canvas.drawingStatePop();
                    }

                    return(top);
                  },

                drawLegendStyle = function (canvas, serie, top)
                  {
                    canvas.drawingStatePush();
                    switch(serie.options.get().type)
                    {
                      case 'bar':
                      case 'area':
                        canvas.styleFillColor(serie.options.get().backgroundColor);
                        canvas.shapeRect(11,top-6,6,6, {fill:true, stroke:false});
                        break;
                      case 'line':
                        canvas.styleFillColor(serie.options.get().color);
                        canvas.styleStrokeColor(serie.options.get().color);
                        canvas.styleStrokeDraw({width:serie.options.width, cap:'butt', joints:'miter'});
                        canvas.shapeLine(6,top,22,top);
                        tmpSize=serie.options.get().dotSize/2.0;
                        switch(serie.options.get().dot)
                        {
                          case 'circle':
                            canvas.shapeCircle(14,top,tmpSize,{fill:true, stroke:false});
                            break;
                          case 'square':
                            canvas.shapeRect(14-tmpSize,top-tmpSize,serie.options.get().dotSize,serie.options.get().dotSize,{fill:true, stroke:false});
                            break;
                          case 'diamond':
                            canvas.shapeSimpleShape("close",[14,top-tmpSize,14+tmpSize,top,14,top+tmpSize,14-tmpSize,top],{fill:true, stroke:false});
                            break;
                          default:
                            // 'none'
                            break;
                        }
                        break;
                      case 'pie':
                        break;
                    }
                    canvas.drawingStatePop();
                  },

                setAxisSize = function ()
                  {
                    var w=0;

                    if(work.legend.visible) w=work.legendBox.width+work.legendBox.margin;

                    if(options.axis.front!=null)
                      options.axis.front.set(
                        {
                          size:{
                              width:options.display.width-options.margins.get().left-options.margins.get().right-w
                            }
                        }
                      );

                    if(options.axis.back!=null)
                      options.axis.back.set(
                        {
                          size:{
                              width:options.display.width-options.margins.get().left-options.margins.get().right-w
                            }
                        }
                      );
                  };

            if(!work.legend.visible) return(false);

            canvasObjects.axis.drawingStatePush();

            work.legendBox=calculateLegendBox(work.axis.front, canvasObjects.axis, work.legend, 0, 0);
            work.legendBox=calculateLegendBox(work.axis.back, canvasObjects.axis, work.legend, work.legendBox.height, work.legendBox.width);
            work.legendBox.width+=32; //6+16+4+6
            work.legendBox.height+=8;

            if(work.legend.width!=0) work.legendBox.width=work.legend.width;

            options.legend.setRealWidth(work.legendBox.width);

            canvasObjects.axis.styleFillColor(work.legend.backgroundColor);
            canvasObjects.axis.styleStrokeColor(work.legend.borderColor);
            canvasObjects.axis.styleStrokeDraw({width:work.legend.borderWidth, cap:'butt', joints:'miter'});

            work.legendBox.margin=work.margins.right;
            if(work.legend.position=='right')
            {
              canvasObjects.axis.transformTranslate(
                {
                  x:work.width-(work.margins.left+work.margins.right+work.legendBox.width),
                  y:work.height-(work.margins.top+work.margins.bottom+work.legendBox.height)
                }
              );
            }
            else
              canvasObjects.axis.transformTranslate(
                {
                  x:work.legendBox.margin-work.margins.left,
                  y:work.height-(work.margins.top+work.margins.bottom+work.legendBox.height)
                }
              );


            canvasObjects.axis.shapeRect(0,0,work.legendBox.width, work.legendBox.height, {fill:true, stroke:(work.legend.borderWidth>0)});

            tmpTop=drawLegendNames(work.axis.front, canvasObjects.axis, work.legend, 0);
            tmpTop=drawLegendNames(work.axis.back, canvasObjects.axis, work.legend, tmpTop);

            // restore canvas state
            canvasObjects.axis.drawingStatePop();

            if(work.legend.position=='left')
            {
              canvasObjects.axis.transformTranslate({x:work.legendBox.width+work.legendBox.margin});
              canvasObjects.graph.transformTranslate({x:work.legendBox.width+work.legendBox.margin});
              //canvasObjects.cursor.transformTranslate({x:work.legendBox.width+work.legendBox.margin});
            }

            setAxisSize();

            return(true);
          }, // drawLegend

        drawSerieBar : function (object, axis, serie)
          {
            var properties=object.data('properties'),
                canvasObjects=object.data('canvasObjects'),
                options=object.data('options'),
                work={
                    margins:options.margins.get(),
                    axis:axis.get(),
                    width:canvasObjects.axis.getContextWidth(),
                    height:canvasObjects.axis.getContextHeight(),
                    serieProp:serie.get(),
                    opt:serie.get().options.get()
                  };

            // save canvas state
            canvasObjects.graph.drawingStatePush();

            // prepare canvas
            canvasObjects.graph.styleFillColor(work.opt.backgroundColor);
            canvasObjects.graph.styleStrokeColor(work.opt.borderColor);
            canvasObjects.graph.styleStrokeDraw({width:work.opt.borderWidth, cap:'butt', joints:'miter'});

            for(var i=0;i<work.serieProp.values.length;i++)
            {
              // calculate horizontal & vertical values
              var pH=axis.getXYHPos(i),
                  pV=axis.getXYVStepPos((work.opt.mode=='normal')?work.serieProp.values[i]:work.opt.cumulativesValues[i]);

              bWidth=work.axis.data.XY.H.space*work.opt.width;

              // adjust horizontal value (using H axis offset0 or not)
              if(work.axis.properties.XY.ticks.H.offset0)
              {
                pH-=Math.floor(bWidth/2);
              }
              else
              {
                pH+=Math.floor((work.axis.data.XY.H.space-bWidth)/2);
              }
              // adjust horizontal value (using offset bar or not)
              if(work.opt.mode=='normal') pH+=Math.floor(work.opt.offset*bWidth);

              //draw bar !
              canvasObjects.graph.shapeRect(pH,0,Math.ceil(bWidth),pV, {fill:true, stroke:work.opt.borderWidth>0});
            }

            // restore canvas state
            canvasObjects.graph.drawingStatePop();
          },
        drawSerieArea : function (object, axis, serie)
          {
            var properties=object.data('properties'),
                canvasObjects=object.data('canvasObjects'),
                options=object.data('options'),
                work={
                    margins:options.margins.get(),
                    axis:axis.get(),
                    width:canvasObjects.axis.getContextWidth(),
                    height:canvasObjects.axis.getContextHeight(),
                    serieProp:serie.get(),
                    opt:serie.get().options.get(),
                    points:[]
                  };

            // save canvas state
            canvasObjects.graph.drawingStatePush();

            // prepare canvas
            canvasObjects.graph.styleFillColor(work.opt.backgroundColor);
            canvasObjects.graph.styleStrokeColor(work.opt.borderColor);
            canvasObjects.graph.styleStrokeDraw({width:work.opt.borderWidth, cap:'butt', joints:'miter'});

            //start point
            work.points=[axis.getXYHPos(0),axis.getXYVStepPos(0)];

            for(var i=0;i<work.serieProp.values.length;i++)
            {
              // calculate horizontal & vertical values
              work.points.push(axis.getXYHPos(i));
              work.points.push(axis.getXYVStepPos((work.opt.mode=='normal')?work.serieProp.values[i]:work.opt.cumulativesValues[i]));
            }
            work.points.push(axis.getXYHPos(i-1));
            work.points.push(axis.getXYVStepPos(0));

            //draw area !
            canvasObjects.graph.shapeSimpleShape('close', work.points, {fill:true, stroke:false});

            if(work.opt.borderWidth>0)
            {
              work.points.splice(0,2);
              work.points.splice(-1,2);
              canvasObjects.graph.shapeSimpleShape('open', work.points, {fill:false, stroke:true});
            }

            // restore canvas state
            canvasObjects.graph.drawingStatePop();
          },
        drawSerieLine : function (object, axis, serie)
          {
            var properties=object.data('properties'),
                canvasObjects=object.data('canvasObjects'),
                options=object.data('options'),
                work={
                    margins:options.margins.get(),
                    axis:axis.get(),
                    width:canvasObjects.axis.getContextWidth(),
                    height:canvasObjects.axis.getContextHeight(),
                    serieProp:serie.get(),
                    opt:serie.get().options.get(),
                    points:[]
                  },
                tmpSize=work.opt.dotSize/2.0;

            // save canvas state
            canvasObjects.graph.drawingStatePush();

            // prepare canvas
            canvasObjects.graph.styleFillColor(work.opt.color);
            canvasObjects.graph.styleStrokeColor(work.opt.color);
            canvasObjects.graph.styleStrokeDraw({width:work.opt.width, cap:'butt', joints:'miter'});


            for(var i=0;i<work.serieProp.values.length;i++)
            {
              var pH=axis.getXYHPos(i),
                  pV=axis.getXYVStepPos(work.serieProp.values[i]);

              switch(work.opt.dot)
              {
                case 'circle':
                  canvasObjects.graph.shapeCircle(pH,pV,tmpSize,{fill:true, stroke:false});
                  break;
                case 'square':
                  canvasObjects.graph.shapeRect(pH-tmpSize,pV-tmpSize,work.opt.dotSize,work.opt.dotSize,{fill:true, stroke:false});
                  break;
                case 'diamond':
                  canvasObjects.graph.shapeSimpleShape("close",[pH,pV-tmpSize,pH+tmpSize,pV,pH,pV+tmpSize,pH-tmpSize,pV],{fill:true, stroke:false});
                  break;
                default:
                  // 'none'
                  break;
              }

              // calculate horizontal & vertical values
              work.points.push(pH);
              work.points.push(pV);
            }

            canvasObjects.graph.shapeSimpleShape('open', work.points, {fill:false, stroke:true});

            // restore canvas state
            canvasObjects.graph.drawingStatePop();
          },
        drawSeriePie : function (object, axis, serie)
          {
            var properties=object.data('properties'),
                canvasObjects=object.data('canvasObjects'),
                options=object.data('options'),
                work={
                    margins:options.margins.get(),
                    axis:axis.get(),
                    width:canvasObjects.axis.getContextWidth(),
                    height:canvasObjects.axis.getContextHeight(),
                    serieProp:serie.get(),
                    opt:serie.get().options.get(),
                    points:[],
                    tmp:0,
                    angle:0,
                    angle2:0,
                    pH:0,
                    pV:0,
                    angCnv:Math.PI/180
                  };


            for(var i=0;i<work.serieProp.values.length;i++)
            {
              work.tmp+=work.serieProp.values[i];
            }
            work.tmp=360/work.tmp;
            work.pH=work.axis.data.pie.H.center;
            work.pV=work.axis.data.pie.V.center;

            // save canvas state
            canvasObjects.graph.drawingStatePush();

            canvasObjects.graph.transformTranslate({x:work.pH, y:work.pV});
            canvasObjects.graph.transformRotate({angle:-90, mode:'degree'});

            // prepare canvas
            canvasObjects.graph.styleStrokeColor(work.opt.borderColor);
            canvasObjects.graph.styleStrokeDraw({width:work.opt.borderWidth, cap:'butt', joints:'round'});


            for(var i=0;i<work.serieProp.values.length;i++)
            {
              work.angle2+=work.serieProp.values[i]*work.tmp;

              canvasObjects.graph.styleFillColor(work.opt.backgroundColors[i]);
              canvasObjects.graph.shapePathBegin();

              if(work.opt.innerRadius>0)
              {
                canvasObjects.graph.shapePathArc(0,0,work.opt.innerRadius,work.angle, work.angle2, true,'degree');
                canvasObjects.graph.shapePathArc(0,0,work.opt.outerRadius,work.angle2, work.angle, false,'degree');
              }
              else
              {
                canvasObjects.graph.shapePathMoveTo(0,0);
                canvasObjects.graph.shapePathArc(0,0,work.opt.outerRadius,work.angle, work.angle2, true,'degree');
              }
              canvasObjects.graph.shapePathEnd(false, true);

              work.angle=work.angle2;
            }

            if(work.opt.borderWidth>0)
            {
              work.angle=0;
              work.angle2=0;
              for(var i=0;i<work.serieProp.values.length;i++)
              {
                work.angle2+=work.serieProp.values[i]*work.tmp;

                canvasObjects.graph.shapePathBegin();
                if(work.opt.innerRadius>0)
                {
                  canvasObjects.graph.shapePathArc(0,0,work.opt.innerRadius,work.angle, work.angle2, true,'degree');
                  canvasObjects.graph.shapePathArc(0,0,work.opt.outerRadius,work.angle2, work.angle, false,'degree');
                }
                else
                {
                  canvasObjects.graph.shapePathMoveTo(0,0);
                  canvasObjects.graph.shapePathArc(0,0,work.opt.outerRadius,work.angle, work.angle2, true,'degree');
                }
                canvasObjects.graph.shapePathEnd(false, false);

                work.angle=work.angle2;
              }
            }

            // restore canvas state
            canvasObjects.graph.drawingStatePop();
          }
    };

    $.fn.drawingGraph = function(method)
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
        $.error( 'Method ' +  method + ' does not exist on jQuery.drawingGraph' );
      }
    } // $.fn.inputNum

  }
)(jQuery);
