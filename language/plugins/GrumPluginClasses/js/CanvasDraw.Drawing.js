/** ----------------------------------------------------------------------------
 * file         : CanvasDraw.Drawing.js
 * file version : 1.0
 * date         : 2010-09-25
 * -----------------------------------------------------------------------------
 * author: grum at grum.fr
 * << May the Little SpaceFrog be with you >>
 *
 * This program is free software and is published under the terms of the GNU GPL
 * Please read CanvasDraw.ReadMe.txt file for more information
 *
 * -----------------------------------------------------------------------------
 *
 * dependencies : jquery.js
 *                CanvasDraw.CommonClasses.js
 *
 * -----------------------------------------------------------------------------
 *
 * The Drawing classes are designed to provide function allowing to draw on a
 * canvas context
 *
 * provided classes :
 *  - CDDrawing
 *    . properties
 *    . constructor(canvas)
 *    . setContextFromCanvasId(canvasId)
 *    . setContextFromCanvas(canvas)
 *    . getContext()
 *    . getContextWidth()
 *    . getContextHeight()
 *    . drawingManageCrisp(manage)
 *    . drawingStatePush()
 *    . drawingStatePop()
 *    . transformTranslate(param)
 *    . transformScale(param)
 *    . transformRotate(param)
 *    . transformMatrix(reset, m11, m12, m21, m22, dx, dy)
 *    . imageCount()
 *    . imageLoad(url)
 *    . imageLoaded(url)
 *    . imageLoadSetOnProgressEvent(eventFunction))
 *    . imageLoadSetOnEndEvent(eventFunction))
 *    . imageDraw(url, x, y)
 *    . imageDrawScaled(url, x, y, width, height)
 *    . imageDrawSliced(url, sX, sY, sWidth, sHeight, dX, dY, dWidth, dHeight)
 *    . shapeClearRect(x, y, width, height)
 *    . shapePathBegin()
 *    . shapePathEnd(close, fill)
 *    . shapePathMoveTo(x, y)
 *    . shapePathLineTo(x, y)
 *    . shapePathArc(x, y, radius, startAngle, endAngle, antiClockwise, mode)
 *    . shapePathCurveBezier(cp1x, cp1y, cp2x, cp2y, x, y)
 *    . shapePathCurveQuadratic(cp1x, cp1y, x, y)
 *    . shapeLine(xs, ys, xe, ye)
 *    . shapeRect(x, y, width, height, fill)
 *    . shapeRoundRect(x, y, width, height, radiusWidth, radiusHeight, fill)
 *    . shapeEllipse(x, y, width, height, fill)
 *    . shapeCircle(x,y,radius, fill)
 *    . shapeStar(x,y,outerRadius,innerRadius,numVertices, fill)
 *    . shapePolygon(x,y,radius,numEdges, fill)
 *    . shapeArrow(xs, ys, xe, ye, width, numHead, lengthHead, angleHead, styleHead, fill)
 *    . shapeSimpleShape(mode, points, fill)
 *    . shapeComplexShape(mode, points, fill)
 *    . styleStrokeColor(color)
 *    . styleStrokeGradient(mode, start, end, gradients)
 *    . styleStrokePattern(url, mode)
 *    . styleStrokeDraw(param)
 *    . styleFillColor(color)
 *    . styleFillGradient(mode, start, end, gradients)
 *    . styleFillPattern(url, mode)
 *    . styleGlobalAlpha(opacity)
 *    . styleShadow(offsetX, offsetY, blur, color)
 *    . styleShadowReset()
 *    . textPrint(text, x, y, mode)
 *    . textStyle(param)
 *    . textWidth(text)
 *
 * -----------------------------------------------------------------------------
 */




function CDDrawing(canvasContext) {

  var properties = {
    isCanvasContext:false,
    canvasContext:null,
    canvas:null,
    imagesUrl:new Array(),
    imagesObj:new Array(),
    imagesLoaded:0,
    imagesLoadOnProgress:null,
    imagesLoadOnEnd:null,
    manageCrisp:false,
  }

  /**
   * constructor for the object need one parameter : a canvas Id or a canvas
   * object
   *
   * if the given canvas don't allow to return a canvas context, the object
   * don't allow to draw
   *
   * @param String canvas : a canvas Id
   *
   * or
   *
   * @param Object canvas : a canvas object
   */
  this.constructor = function (canvas)
  {
    if(canvas!=null)
    {
      if(typeof(canvas)=='string')
      {
        this.setContextFromCanvasId(canvas);
      }
      else if(typeof(canvas)=='object')
      {
        this.setContextFromCanvas(canvas);
      }
    }
  }


  /**
   * this function allows to change the canvas context from a canvas Id
   *
   * if the the given canvas Id don't allow the get a canvas context, the
   * previous canvas context is kept
   *
   * @param String canvasId : Id of the canvas
   * @return Bool : true if canvas is Ok, otherwise false
   */
  this.setContextFromCanvasId = function (canvasId)
  {
    var canvas = $('#'+canvasId).get(0);
    return(this.setContextFromCanvas(canvas));
  }


  /**
   * this function allows to change the canvas context from a canvas object
   *
   * if the the given canvas object don't allow the get a canvas context, the
   * previous canvas context is kept
   *
   * @param Object canvas : the canvas
   * @return Bool : true if canvas is Ok, otherwise false
   */
  this.setContextFromCanvas = function (canvas)
  {
    if(canvas!=null)
    {
      if(canvas.getContext)
      {
        properties.canvas=canvas;
        properties.isCanvasContext=true;
        properties.canvasContext=canvas.getContext('2d');
        return(true);
      }
    }
    return(false);
  }

  /**
   * returns the canvas context
   *
   * @return
   */
  this.getContext = function ()
  {
    return(properties.canvasContext);
  }

  /**
   * returns the canvas context width
   *
   * @return Integer
   */
  this.getContextWidth = function ()
  {
    return(properties.canvas.width);
  }

  /**
   * returns the canvas context height
   *
   * @return Integer
   */
  this.getContextHeight = function ()
  {
    return(properties.canvas.height);
  }

  /**
   * allows to define if crisp have to be managed
   *
   * @param Bool manage
   * @return Bool : the value actually set
   */
  this.drawingManageCrisp = function(manage)
  {
    if(!properties.isCanvasContext) return(false);

    if(manage==true || manage==false)
    {
      if(!properties.manageCrisp && manage)
      {
        properties.canvasContext.translate(0.5,0.5);
        properties.manageCrisp=manage;
        return(true);
      }
      else if(properties.manageCrisp && !manage)
      {
        properties.canvasContext.translate(-0.5,-0.5);
        properties.manageCrisp=manage;
        return(true);
      }
    }

    return(false);
  }




  /**
   *
   * @return Bool : true if can draw, otherwise false
   */
  this.drawingStatePush = function ()
  {
    if(properties.canvasContext==null) return (false);
    properties.canvasContext.save();
    return(true);
  }

  /**
   *
   * @return Bool : true if can draw, otherwise false
   */
  this.drawingStatePop = function ()
  {
    if(properties.canvasContext==null) return (false);
    properties.canvasContext.restore();
    return(true);
  }

  /**
   * this function apply a translation on the canvas.
   * one object is given as parameter, and can have two properties
   *  x : the absissa translation
   *  y : the ordinate translation
   *
   * if a parameter is not given, assuming the defaut translation values
   *  x : 0
   *  y : 0
   *
   * @param Object param : an object with properties x and y
   * @return Bool : true if can draw, otherwise false
   */
  this.transformTranslate = function (param)
  {
    if(properties.canvasContext==null) return (false);

    if(param==null || param.constructor!=Object) param = { x:0, y:0 }
    if(param.x==null) param.x=0;
    if(param.y==null) param.y=0;
    properties.canvasContext.translate(param.x,param.y);
    return(true);
  }

  /**
   * this function apply a scaling on the canvas.
   * one object is given as parameter, and can have two properties
   *  x : the absissa scaling
   *  y : the ordinate scaling
   *
   * if a parameter is not given, assuming the defaut scaling values
   *  x : 1
   *  y : 1
   *
   * @param Object param : an object with properties x and y
   * @return Bool : true if can draw, otherwise false
   */

  this.transformScale = function (param)
  {
    if(properties.canvasContext==null) return (false);

    if(param==null || param.constructor!=Object) param = { x:1, y:1 }
    if(param.x==null) param.x=1;
    if(param.y==null) param.y=1;
    properties.canvasContext.scale(param.x,param.y);
    return(true);
  }


  /**
   * this function apply a rotation on the canvas.
   * one object is given as parameter, and can have two properties
   *  angle : the rotation angle
   *  mode : the expression of angle 'degree' or 'radian'
   *
   * if a parameter is not given, assuming the defaut rotating values
   *  angle : 0
   *  mode  : 'degree'
   *
   * @param Object param : an object with properties x and y
   * @return Bool : true if can draw, otherwise false
   */
  this.transformRotate = function (param)
  {
    if(properties.canvasContext==null) return (false);

    if(param==null || param.constructor!=Object) param = { angle:0, mode:'degree' }
    if(param.angle==null) param.angle=0;
    if(!(param.mode=='degree' || param.mode=='radian')) param.mode='degree';

    param.angle=-param.angle;

    if(param.mode=='degree') param.angle=param.angle*Math.PI/180;
    properties.canvasContext.rotate(param.angle);
    return(true);
  }

  /**
   * this function apply a transformation matrix on the canvas.
   * one object is given as parameter, and can have 7 properties
   *  reset : reset the transformation matrix or no
   *  m11, m12, m21, m22, dx, dy : the matrix values
   *            [ m11  m21  dx ]
   *            [ m12  m22  dy ]
   *            [ 0    0    1  ]
   *
   * @param Bool reset : if true, the matrix values are reseted before applying
   *                     new values
   * @param Float m11, m12, m21, m22, dx, dy : matrix values
   * @return Bool : true if can draw, otherwise false
   */
  this.transformMatrix = function (reset, m11, m12, m21, m22, dx, dy)
  {
    if(properties.canvasContext==null) return (false);

    if(reset)
    {
      properties.canvasContext.setTransform(m11, m12, m21, m22, dx, dy);
    }
    else
    {
      properties.canvasContext.transform(m11, m12, m21, m22, dx, dy);
    }

    return(true);
  }

  /**
   * this function returns the number of pictures
   *
   * @return Integer :
   */
  this.imageCount = function ()
  {
    return(properties.imagesUrl.length);
  }

  /**
   * this function loads images in an array, allowing to manage image by their
   * url
   *
   * @param Object param : an object with properties x and y
   * @return Bool : true if can draw, otherwise false
   */
  this.imageLoad = function (url)
  {
    if($.inArray(url, properties.imagesUrl)==-1)
    {
      img=new Image();
      $(img).bind('load', {url:url}, imageLoadProgressEvent);
      img.src=url;

      properties.imagesUrl.push(url);
      properties.imagesObj.push(img);

      delete img;
    }
  }

  /**
   * this function returns true if the image is loaded
   *
   * if no url is given (url is an empty string or null), the function checks
   * if all images are loaded
   *
   * @param String url : the image to check
   * @return Object|Bool :
   */
  this.imageLoaded = function (url)
  {
    if(url=='' || url==null)
    {
      if(properties.imagesObj.length!=properties.imagesLoaded)
      {
        return(false);
      }
      return(true);
    }
    else
    {
      index=$.inArray(url, properties.imagesUrl);
      if(index!=-1)
      {
        if(properties.imagesObj[index].complete)
        {
          return(
            {
              index:index,
              width:properties.imagesObj[index].width,
              height:properties.imagesObj[index].height
            }
          );
        }
      }
      return(
        {
          index:-1,
          width:0,
          height:0
        }
      );
    }
  }

  /**
   * this method allows to define a callback function wich will be called each
   * time a picture is loaded
   *
   * the given function must have 2 parameters :
   *  - percent : percent of loading
   *  - url     : url of the loaded picture
   *
   * @param Function eventFunction : the function to set
   * @return Bool : true is set is Ok, otherwise false
   */
  this.imageLoadSetOnProgressEvent = function (eventFunction)
  {
    if($.isFunction(eventFunction))
    {
      properties.imagesLoadOnProgress = eventFunction;
      return(true);
    }
    return(false);
  }

  /**
   * this method allows to define a callback function wich will be called when
   * all given pictures are loaded
   *
   * the given function don't need parameters
   *
   * @param Function eventFunction : the function to set
   * @return Bool : true is set is Ok, otherwise false
   */
  this.imageLoadSetOnEndEvent = function (eventFunction)
  {
    if($.isFunction(eventFunction))
    {
      properties.imagesLoadOnEnd = eventFunction;
      return(true);
    }
    return(false);
  }


  /**
   * called each time a picture is loaded, and trigger the imageLoadOnProgress()
   * and imageLoadOnEnd() function if defined
   */
  var imageLoadProgressEvent = function (event) {
    properties.imagesLoaded++;

    if($.isFunction(properties.imagesLoadOnProgress))
    {
      properties.imagesLoadOnProgress(100*properties.imagesLoaded/properties.imagesUrl.length,
        {
         url: event.data.url,
         fullUrl:event.target.src,
         handler:event.target
        });
    }

    if(properties.imagesLoaded==properties.imagesUrl.length && $.isFunction(properties.imagesLoadOnEnd))
    {
      properties.imagesLoadOnEnd();
    }
  }


  /**
   * draw an image on the canvas from its url
   *
   * @param String url : the url of image
   * @param Integer x : the x position on the canvas
   * @param Integer y : the y position on the canvas
   * @return Bool : true if drawed, otherwise false
   */
  this.imageDraw = function (url, x, y)
  {
    if(properties.canvasContext==null) return (false);

    imageIndex=this.imageLoaded(url);
    if(imageIndex.index==-1) return(false);


    if(properties.manageCrisp)
    {
      properties.canvasContext.save();
      properties.canvasContext.translate(-0.5,-0.5);
      properties.canvasContext.drawImage(properties.imagesObj[imageIndex.index], x, y);
      properties.canvasContext.restore();
    }
    else
    {
      properties.canvasContext.drawImage(properties.imagesObj[imageIndex.index], x, y);
    }

    return(true);
  }

  /**
   * draw an image on the canvas from its url, with given dimensions
   *
   * @param String url : the url of image
   * @param Integer x : the x position on the canvas
   * @param Integer y : the y position on the canvas
   * @param Integer width  : the width of the image on the canvas
   * @param Integer height : the height of the image on the canvas
   * @return Bool : true if drawed, otherwise false
   */
  this.imageDrawScaled = function (url, x, y, width, height)
  {
    if(properties.canvasContext==null) return (false);

    imageIndex=this.imageLoaded(url);
    if(imageIndex.index==-1) return(false);


    if(properties.manageCrisp)
    {
      properties.canvasContext.save();
      properties.canvasContext.translate(-0.5,-0.5);
      properties.canvasContext.drawImage(properties.imagesObj[imageIndex.index], x, y, width, height);
      properties.canvasContext.restore();
    }
    else
    {
      properties.canvasContext.drawImage(properties.imagesObj[imageIndex.index], x, y, width, height);
    }

    return(true);
  }

  /**
   * draw a portion of an image on the canvas from its url, with given dimensions
   *
   * @param String url : the url of image
   * @param Integer sX : the x position on the source image
   * @param Integer sY : the y position on the source image
   * @param Integer sWidth  : the width of the source image
   * @param Integer sHeight : the height of the source image
   * @param Integer dX : the x position on the canvas
   * @param Integer dY : the y position on the canvas
   * @param Integer dWidth  : the width of the image on the canvas
   * @param Integer dHeight : the height of the image on the canvas
   * @return Bool : true if drawed, otherwise false
   */
  this.imageDrawSliced = function (url, sX, sY, sWidth, sHeight, dX, dY, dWidth, dHeight)
  {
    if(properties.canvasContext==null) return (false);

    imageIndex=this.imageLoaded(url);
    if(imageIndex.index==-1) return(false);

    if(properties.manageCrisp)
    {
      properties.canvasContext.save();
      properties.canvasContext.translate(-0.5,-0.5);
      properties.canvasContext.drawImage(properties.imagesObj[imageIndex.index], sX, sY, sWidth, sHeight, dX, dY, dWidth, dHeight);
      properties.canvasContext.restore();
    }
    else
    {
      properties.canvasContext.drawImage(properties.imagesObj[imageIndex.index], sX, sY, sWidth, sHeight, dX, dY, dWidth, dHeight);
    }

    return(true);
  }


  /**
   * clear (set transparency) a rectangular area
   *
   * @param Integer x : the left coordinate
   * @param Integer y : the top coordinate
   * @param Integer width  : the rectangle width
   * @param Integer height : the rectangle height
   * @return Bool : true if drawed, otherwise false
   */
  this.shapeClearRect = function (x, y, width, height)
  {
    if(properties.canvasContext==null) return (false);

    properties.canvasContext.clearRect(x,y,width,height);
    return(true);
  }

  /**
   * begins a new path
   *
   * @return Bool : true if drawed, otherwise false
   */
  this.shapePathBegin = function ()
  {
    if(properties.canvasContext==null) return (false);

    properties.canvasContext.beginPath();
    return(true);
  }

  /**
   * ends a path
   *
   * @param Bool close : if set to true, close the path by drawing a line
   *                     otherwise the path stays open
   * @param Bool fill  : if set to true, fill the path with current fill
   *                      properties, otherwise the path stays empty
   * @return Bool : true if drawed, otherwise false
   */
  this.shapePathEnd = function(close, fill)
  {
    if(properties.canvasContext==null) return (false);

    if(close) properties.canvasContext.closePath();
    if(fill)
    {
      properties.canvasContext.fill();
    }
    else
    {
      properties.canvasContext.stroke();
    }
    return(true);
  }

  /**
   * move pen to the given coordinates
   *
   * @param Integer x :
   * @param Integer y :
   * @return Bool : true if drawed, otherwise false
   */
  this.shapePathMoveTo = function (x, y)
  {
    if(properties.canvasContext==null) return (false);

    properties.canvasContext.moveTo(x,y);
    return(true);
  }

  /**
   * draws a line from current point to the given coordinates
   *
   * @param Integer x :
   * @param Integer y :
   * @return Bool : true if drawed, otherwise false
   */
  this.shapePathLineTo = function (x, y)
  {
    if(properties.canvasContext==null) return (false);

    properties.canvasContext.lineTo(x,y);
    return(true);
  }

  /**
   * draws an arc
   *
   * @param Integer x : x coordinate
   * @param Integer y : y coordinate
   * @param Integer radius : arc radius
   * @param Float startAngle :
   * @param Float endAngle :
   * @param Bool antiClockwise : if true, arc is drawn in anticlockwise direction
   * @param String mode : define the expression of given angles 'degree' or 'radian'
   * @return Bool : true if drawed, otherwise false
   */
  this.shapePathArc = function(x, y, radius, startAngle, endAngle, antiClockwise, mode)
  {
    if(properties.canvasContext==null) return (false);

    if(!(mode=='degree' || mode=='radian')) mode='degree';
    if(mode=='degree')
    {
      startAngle=startAngle*Math.PI/180;
      endAngle=endAngle*Math.PI/180;
    }
    startAngle=-startAngle;
    endAngle=-endAngle;

    properties.canvasContext.arc(x, y, radius, startAngle, endAngle, antiClockwise);
    return(true);
  }


  /**
   * draws a bezier curve from the current point to the given coordinate
   * you can have more information about how this function works on this page :
   *    https://developer.mozilla.org/en/Canvas_tutorial/Drawing_shapes
   *
   * @param Integer cp1x : control point 1 x coordinate
   * @param Integer cp1y : control point 1 y coordinate
   * @param Integer cp1x : control point 2 x coordinate
   * @param Integer cp1y : control point 2 y coordinate
   * @param Integer x : destination x coordinate
   * @param Integer y : destination y coordinate
   * @return Bool : true if drawed, otherwise false
   */
  this.shapePathCurveBezier = function(cp1x, cp1y, cp2x, cp2y, x, y)
  {
    if(properties.canvasContext==null) return (false);

    properties.canvasContext.bezierCurveTo(cp1x, cp1y, cp2x, cp2y, x, y);
    return(true);
  }

  /**
   * draws a quadratic curve from the current point to the given coordinate
   * you can have more information about how this function works on this page :
   *    https://developer.mozilla.org/en/Canvas_tutorial/Drawing_shapes
   *
   * @param Integer cp1x : control point 1 x coordinate
   * @param Integer cp1y : control point 1 y coordinate
   * @param Integer x : destination x coordinate
   * @param Integer y : destination y coordinate
   * @return Bool : true if drawed, otherwise false
   */
  this.shapePathCurveQuadratic = function(cp1x, cp1y, x, y)
  {
    if(properties.canvasContext==null) return (false);

    properties.canvasContext.quadraticCurveTo(cp1x, cp1y, x, y);
    return(true);
  }

  /**
   * draws a line between two points
   *
   * @param Integer xs : start x coordinate
   * @param Integer ys : start y coordinate
   * @param Integer xe : end x coordinate
   * @param Integer ye : end y coordinate
   * @return Bool : true if drawed, otherwise false
   */
  this.shapeLine = function(xs, ys, xe, ye)
  {
    if(properties.canvasContext==null) return (false);

    properties.canvasContext.beginPath();
    properties.canvasContext.moveTo(xs, ys);
    properties.canvasContext.lineTo(xe, ye);
    properties.canvasContext.stroke();
    return(true);
  }

  /**
   * draws a rectangle
   *
   * @param Integer x : the left coordinate
   * @param Integer y : the top coordinate
   * @param Integer width  : the rectangle width
   * @param Integer height : the rectangle height
   * @param Object mode : 2 properties
   *                        fill: true or false (default:true)
   *                        stroke: true or false (default:true)
   * @return Bool : true if drawed, otherwise false
   */
  this.shapeRect = function(x, y, width, height, mode)
  {
    if(properties.canvasContext==null) return (false);

    if(mode==null) mode={fill:true, stroke:true};
    if(mode.fill==null) mode.fill=true;
    if(mode.stroke==null) mode.stroke=true;
    modeLoop=new Array();
    if(mode.fill) modeLoop.push('fill');
    if(mode.stroke) modeLoop.push('stroke');

    for(this.loop=0;this.loop<modeLoop.length;this.loop++)
    {
      if(modeLoop[this.loop]=='fill')
      {
        properties.canvasContext.fillRect(x, y, width, height);
      }
      else
      {
        properties.canvasContext.save();
        if(mode.fill) properties.canvasContext.shadowColor='rgba(0,0,0,0)';
        properties.canvasContext.strokeRect(x, y, width, height);
        properties.canvasContext.restore();
      }
    }
    return(true);
  }

  /**
   * draws a rectangle with rounded corner
   *
   * @param Integer x : the left coordinate
   * @param Integer y : the top coordinate
   * @param Integer width  : the rectangle width
   * @param Integer height : the rectangle height
   * @param Integer radiusWidth :
   * @param Integer radiusHeight :
   * @param Object mode : 2 properties
   *                        fill: true or false (default:true)
   *                        stroke: true or false (default:true)
   * @return Bool : true if drawed, otherwise false
   */
  this.shapeRoundRect = function(x, y, width, height, radiusWidth, radiusHeight, mode)
  {
    if(properties.canvasContext==null) return (false);

    if(mode.fill==null) mode.fill=true;
    if(mode.stroke==null) mode.stroke=true;
    modeLoop=new Array();
    if(mode.fill) modeLoop.push('fill');
    if(mode.stroke) modeLoop.push('stroke');

    for(this.loop=0;this.loop<modeLoop.length;this.loop++)
    {
      properties.canvasContext.beginPath();
      properties.canvasContext.moveTo(x+radiusWidth,y);
      properties.canvasContext.lineTo(x+width-radiusWidth,y);
      properties.canvasContext.quadraticCurveTo(x+width,y,x+width,y+radiusHeight);
      properties.canvasContext.lineTo(x+width,y+height-radiusHeight);
      properties.canvasContext.quadraticCurveTo(x+width,y+height,x+width-radiusWidth,y+height);
      properties.canvasContext.lineTo(x+radiusWidth,y+height);
      properties.canvasContext.quadraticCurveTo(x,y+height,x,y+height-radiusHeight);
      properties.canvasContext.lineTo(x,y+radiusHeight);
      properties.canvasContext.quadraticCurveTo(x,y,x+radiusWidth,y);

      if(modeLoop[this.loop]=='fill')
      {
        properties.canvasContext.fill();
      }
      else
      {
        properties.canvasContext.save();
        if(mode.fill) properties.canvasContext.shadowColor='rgba(0,0,0,0)';
        properties.canvasContext.stroke();
        properties.canvasContext.restore();
      }
    }
    return(true);
  }


  /**
   * draws an ellipse (defined by a rectangle limits)
   *
   * @param Integer x : the left coordinate
   * @param Integer y : the top coordinate
   * @param Integer width  : the rectangle width
   * @param Integer height : the rectangle height
   * @param Object mode : 2 properties
   *                        fill: true or false (default:true)
   *                        stroke: true or false (default:true)
   * @return Bool : true if drawed, otherwise false
   */
  this.shapeEllipse = function(x, y, width, height, mode)
  {
    if(properties.canvasContext==null || width==0 || height==0) return (false);

    if(mode.fill==null) mode.fill=true;
    if(mode.stroke==null) mode.stroke=true;
    modeLoop=new Array();
    if(mode.fill) modeLoop.push('fill');
    if(mode.stroke) modeLoop.push('stroke');

    ratio=width/height;

    for(this.loop=0;this.loop<modeLoop.length;this.loop++)
    {
      properties.canvasContext.save();
      properties.canvasContext.translate(x,y);
      properties.canvasContext.scale(ratio,1);
      properties.canvasContext.beginPath();
      properties.canvasContext.arc(height/2,height/2, height/2, 0, Math.PI*2, true);

      if(modeLoop[this.loop]=='fill')
      {
        properties.canvasContext.fill();
      }
      else
      {
        properties.canvasContext.save();
        if(mode.fill) properties.canvasContext.shadowColor='rgba(0,0,0,0)';
        properties.canvasContext.stroke();
        properties.canvasContext.restore();
      }
      properties.canvasContext.restore();
    }
    return(true);
  }

  /**
   * draws a circle (defined by a center point + radius)
   *
   * @param Integer x : the x center coordinate
   * @param Integer y : the y center coordinate
   * @param Integer radius : the circle radius
   * @param Object mode : 2 properties
   *                        fill: true or false (default:true)
   *                        stroke: true or false (default:true)
   * @return Bool : true if drawed, otherwise false
   */
  this.shapeCircle = function(x,y,radius, mode)
  {
    if(properties.canvasContext==null) return (false);

    if(mode.fill==null) mode.fill=true;
    if(mode.stroke==null) mode.stroke=true;
    modeLoop=new Array();
    if(mode.fill) modeLoop.push('fill');
    if(mode.stroke) modeLoop.push('stroke');

    for(this.loop=0;this.loop<modeLoop.length;this.loop++)
    {
      properties.canvasContext.beginPath();
      properties.canvasContext.arc(x,y,radius, 0, Math.PI*2, true);

      if(modeLoop[this.loop]=='fill')
      {
        properties.canvasContext.fill();
      }
      else
      {
        properties.canvasContext.save();
        if(mode.fill) properties.canvasContext.shadowColor='rgba(0,0,0,0)';
        properties.canvasContext.stroke();
        properties.canvasContext.restore();
      }

    }
    return(true);
  }


  /**
   * draws a star (defined by a center point)
   *
   * @param Integer x : the x center coordinate
   * @param Integer y : the y center coordinate
   * @param Integer outerRadius : the outer radius of vertices star
   * @param Integer innerRadius : the inner radius of vertices star
   *                                if innerRadius = 0, the inner radius is
   *                                computed automatically
   * @param Integer numVertices : the number of vertices
   * @param Object mode : 2 properties
   *                        fill: true or false (default:true)
   *                        stroke: true or false (default:true)
   * @return Bool : true if drawed, otherwise false
   */
  this.shapeStar = function(x,y,outerRadius,innerRadius,numVertices, mode)
  {
    if(properties.canvasContext==null) return (false);

    if(mode.fill==null) mode.fill=true;
    if(mode.stroke==null) mode.stroke=true;
    modeLoop=new Array();
    if(mode.fill) modeLoop.push('fill');
    if(mode.stroke) modeLoop.push('stroke');


    if(numVertices<5) numVertices=5;

    for(this.loop=0;this.loop<modeLoop.length;this.loop++)
    {
      properties.canvasContext.beginPath();

      angle=2*Math.PI/numVertices;
      if(innerRadius<=0) innerRadius=Math.abs(outerRadius*Math.sin(Math.PI/2-angle)/Math.cos(angle/2));


      properties.canvasContext.moveTo(x, y-outerRadius);

      for(this.i=0;this.i<numVertices;this.i++)
      {
        xc=x+innerRadius*Math.cos(Math.PI/2-angle*(this.i+1)+angle/2);
        yc=y-innerRadius*Math.sin(Math.PI/2-angle*(this.i+1)+angle/2);
        properties.canvasContext.lineTo(xc, yc);

        xc=x+outerRadius*Math.cos(Math.PI/2-angle*(this.i+1));
        yc=y-outerRadius*Math.sin(Math.PI/2-angle*(this.i+1));
        properties.canvasContext.lineTo(xc, yc);
      }

      if(modeLoop[this.loop]=='fill')
      {
        properties.canvasContext.fill();
      }
      else
      {
        properties.canvasContext.stroke();
      }
    }
    return(true);
  }


  /**
   * draws a star (defined by a center point)
   *
   * @param Integer x : the x center coordinate
   * @param Integer y : the y center coordinate
   * @param Integer outerRadius : the outer radius of vertices star
   * @param Integer innerRadius : the inner radius of vertices star
   *                                if innerRadius = 0xFFFF, the inner radius is
   *                                computed automatically
   * @param Integer numVertices : the number of vertices
   * @param Object mode : 2 properties
   *                        fill: true or false (default:true)
   *                        stroke: true or false (default:true)
   * @return Bool : true if drawed, otherwise false
   */
  this.shapePolygon = function(x,y,radius,numEdges, mode)
  {
    if(properties.canvasContext==null) return (false);

    if(mode.fill==null) mode.fill=true;
    if(mode.stroke==null) mode.stroke=true;
    modeLoop=new Array();
    if(mode.fill) modeLoop.push('fill');
    if(mode.stroke) modeLoop.push('stroke');

    if(numEdges<3) numEdges=3;

    for(this.loop=0;this.loop<modeLoop.length;this.loop++)
    {
      properties.canvasContext.beginPath();

      angle=2*Math.PI/numEdges;

      properties.canvasContext.moveTo(x, y-radius);

      for(this.i=0;this.i<numEdges;this.i++)
      {
        xc=x+radius*Math.cos(Math.PI/2-angle*(this.i+1));
        yc=y-radius*Math.sin(Math.PI/2-angle*(this.i+1));
        properties.canvasContext.lineTo(xc, yc);
      }

      if(modeLoop[this.loop]=='fill')
      {
        properties.canvasContext.fill();
      }
      else
      {
        properties.canvasContext.stroke();
      }
    }
    return(true);
  }

  /**
   * draws an arrow
   *
   * @param Integer xs : start x coordinate
   * @param Integer ys : start y coordinate
   * @param Integer xe : end x coordinate
   * @param Integer ye : end y coordinate
   * @param Integer width : width of the arrow, used if styleHead is set to 0x0012
   *                        if width is set to 0xFFFF, width is computed automatically
   * @param Integer numHead : number of head (1 or 2)
   * @param Integer lengthHead : length (size) of head in pixel
   * @param Integer angleHead : angle (in degree) of head, , allowing to choose
   *                            an acute or obtuse look
   * @param Integer styleHead : 0x0010 : body is a line, head is line
   *                            0x0011 : body is a line, head is a closed triangle
   *                            0x0012 : body is an area, head is an area
   * @param Object mode : 2 properties
   *                        fill: true or false (default:true)
   *                        stroke: true or false (default:true)
   * @return Bool : true if drawed, otherwise false
   */
  this.shapeArrow = function(xs, ys, xe, ye, width, numHead, lengthHead, angleHead, styleHead, mode)
  {
    if(properties.canvasContext==null) return (false);

    if(mode.fill==null) mode.fill=true;
    if(mode.stroke==null) mode.stroke=true;
    modeLoop=new Array();
    if(mode.fill) modeLoop.push('fill');
    if(mode.stroke) modeLoop.push('stroke');


    if(numHead<1)
    {
      numHead=1;
    }
    else if(numHead>2)
    {
      numHead=2;
    }

    angleHead=angleHead*Math.PI/180;

    points=[
      new CDPoint(),
      new CDPoint(),
      new CDPoint(),
      new CDPoint(),
      new CDPoint(),
      new CDPoint(),
      new CDPoint(),
      new CDPoint()];


    //first head (end point)
    points[0].x=lengthHead*Math.cos(Math.PI-angleHead);
    points[0].y=lengthHead*Math.sin(Math.PI-angleHead);
    points[1].x=points[0].x;
    points[1].y=-points[0].y;

    //second head (start point)
    if(numHead==2)
    {
      points[2].x=lengthHead*Math.cos(angleHead);
      points[2].y=lengthHead*Math.sin(angleHead);
      points[3].x=points[2].x;
      points[3].y=-points[2].y;
    }

    if(styleHead==0x0010 || styleHead==0x0011)
    {
      properties.canvasContext.beginPath();
      properties.canvasContext.moveTo(xs, ys);
      properties.canvasContext.lineTo(xe, ye);
      properties.canvasContext.stroke();

      if(numHead==2)
      {
        for(this.i=0;this.i<modeLoop.length;this.i++)
        {
          properties.canvasContext.save();
          properties.canvasContext.translate(xs, ys);
          properties.canvasContext.rotate(Math.atan2(ye-ys, xe-xs));

          properties.canvasContext.beginPath();
          properties.canvasContext.moveTo(points[2].x, points[2].y);
          properties.canvasContext.lineTo(0, 0);
          properties.canvasContext.lineTo(points[3].x, points[3].y);

          if(styleHead==0x0010)
          {
            properties.canvasContext.stroke();
          }
          else
          {
            properties.canvasContext.closePath();
            if(modeLoop[this.i]=='fill')
            {
              properties.canvasContext.fill();
            }
            else
            {
              properties.canvasContext.save();
              if(mode.fill) properties.canvasContext.shadowColor='rgba(0,0,0,0)';
              properties.canvasContext.stroke();
              properties.canvasContext.restore();
            }
          }
          properties.canvasContext.restore();
        }
      }

      for(this.i=0;this.i<modeLoop.length;this.i++)
      {
        properties.canvasContext.save();
        properties.canvasContext.translate(xe, ye);
        properties.canvasContext.rotate(Math.atan2(ye-ys, xe-xs));

        properties.canvasContext.beginPath();
        properties.canvasContext.moveTo(points[0].x, points[0].y);
        properties.canvasContext.lineTo(0, 0);
        properties.canvasContext.lineTo(points[1].x, points[1].y);
        if(styleHead==0x0010)
        {
          properties.canvasContext.stroke();
        }
        else
        {
          properties.canvasContext.closePath();
          if(modeLoop[this.i]=='fill')
          {
            properties.canvasContext.fill();
          }
          else
          {
            properties.canvasContext.save();
            if(mode.fill) properties.canvasContext.shadowColor='rgba(0,0,0,0)';
            properties.canvasContext.stroke();
            properties.canvasContext.restore();

          }
        }
        properties.canvasContext.restore();
      }
    }
    else
    {
      if(width==0xFFFF) width=2*lengthHead;

      arrowLength=distance(xs,ys,xe,ye);

      points[4].x=points[0].x;
      points[4].y=width/2;
      points[5].x=points[4].x;
      points[5].y=-points[4].y;

      points[6].x=points[2].x;
      points[6].y=points[4].y;
      points[7].x=points[6].x;
      points[7].y=-points[6].y;

      for(this.i=0;this.i<modeLoop.length;this.i++)
      {
        properties.canvasContext.save();
        properties.canvasContext.translate(xs, ys);
        properties.canvasContext.rotate(Math.atan2(ye-ys, xe-xs));

        properties.canvasContext.beginPath();
        properties.canvasContext.moveTo(0, 0);
        properties.canvasContext.lineTo(points[2].x, points[2].y);
        properties.canvasContext.lineTo(points[6].x, points[6].y);
        properties.canvasContext.lineTo(arrowLength+points[4].x, points[4].y);
        properties.canvasContext.lineTo(arrowLength+points[0].x, points[0].y);
        properties.canvasContext.lineTo(arrowLength,0);
        properties.canvasContext.lineTo(arrowLength+points[1].x, points[1].y);
        properties.canvasContext.lineTo(arrowLength+points[5].x, points[5].y);
        properties.canvasContext.lineTo(points[7].x, points[7].y);
        properties.canvasContext.lineTo(points[3].x, points[3].y);

        properties.canvasContext.closePath();
        if(modeLoop[this.i]=='fill')
        {
          properties.canvasContext.fill();
        }
        else
        {
          properties.canvasContext.stroke();
        }
        properties.canvasContext.restore();
      }
    }

    return(true);
  }



  /**
   * draw a path from a point list ; each point are joined with a line
   *
   * @param String mode : can take values
   *                      "open"  = the shape is not closed, close it manually
   *                      "close" = the shape is automatically closed
   * @param Array points : array of float <num1,num2,num3,num4,...,numN-1,numN>
   *                        each number have to be taken by couples (each couple
   *                        is one point coordinates)
   *                          num1,num2
   *                          num3,num4
   *                          ...
   *                          numN-1,numN
   *                        first value  : x coordinate
   *                        second value : y coordinate
   * @param Object mode : 2 properties
   *                        fill: true or false (default:true)
   *                        stroke: true or false (default:true)
   * @return Bool : true if drawed, otherwise false
   */
  this.shapeSimpleShape = function (pathMode, points, mode)
  {
    var ptnum=0;

    if(properties.canvasContext==null) return (false);

    if(mode.fill==null) mode.fill=true;
    if(mode.stroke==null) mode.stroke=true;
    modeLoop=new Array();
    if(mode.fill) modeLoop.push('fill');
    if(mode.stroke) modeLoop.push('stroke');


    for(this.loop=0;this.loop<modeLoop.length;this.loop++)
    {
      ptnum=0;
      properties.canvasContext.beginPath();

      for(this.i=0;this.i<Math.floor(points.length/2);this.i++)
      {
        if(ptnum==0)
        {
          properties.canvasContext.moveTo(points[ptnum], points[ptnum+1]);
        }
        else
        {
          properties.canvasContext.lineTo(points[ptnum], points[ptnum+1]);
        }
        ptnum+=2;
      }

      if(pathMode=="close") properties.canvasContext.closePath();

      if(modeLoop[this.loop]=='fill')
      {
        properties.canvasContext.fill();
      }
      else
      {
        properties.canvasContext.save();
        if(mode.fill) properties.canvasContext.shadowColor='rgba(0,0,0,0)';
        properties.canvasContext.stroke();
        properties.canvasContext.restore();
      }

    }
    return(true);
  }

  /**
   * draw a path from a point list ; each point are joined with a line
   *
   * @param String mode : can take values
   *                      "open"  = the shape is not closed, close it manually
   *                      "close" = the shape is automatically closed
   * points : array of float <num1,num2,num3,...,numN-2,numN-1,numN>
   *              num1,num2,num3
   *              ...
   *              numN-2,numN-1,numN
   *                1st value  : method ; 0:move to, 1:line to, 2:quadratic curve to, 3:bezier curve to
   *                2nd & 3rd values : x & y coordinate
   *                4th & 5th values : x & y coordinate (quadratic curve : control point, bezier curve : 1st control point)
   *                6th & 7th values : x & y coordinate (bezier curve : 2nd control point)
   * @param Object mode : 2 properties
   *                        fill: true or false (default:true)
   *                        stroke: true or false (default:true)
   * @return Bool : true if drawed, otherwise false
   */
  this.shapeComplexShape = function(pathMode, points, mode)
  {
    var ptnum=0;

    if(properties.canvasContext==null) return (false);

    if(mode.fill==null) mode.fill=true;
    if(mode.stroke==null) mode.stroke=true;
    modeLoop=new Array();
    if(mode.fill) modeLoop.push('fill');
    if(mode.stroke) modeLoop.push('stroke');

    for(this.loop=0;this.loop<modeLoop.length;this.loop++)
    {
      ptnum=0;
      properties.canvasContext.beginPath();
      while(ptnum<points.length)
      {
        if(points[ptnum]==0) //moveTo
        {
          properties.canvasContext.moveTo(points[ptnum+1], points[ptnum+2]);
          ptnum+=3;
        }
        else if(points[ptnum]==1) //lineTo
        {
          properties.canvasContext.lineTo(points[ptnum+1], points[ptnum+2]);
          ptnum+=3;
        }
        else if(points[ptnum]==2)  //quadraticCurveTo
        {
          properties.canvasContext.quadraticCurveTo(points[ptnum+1], points[ptnum+2], points[ptnum+3],points[ptnum+4]);
          ptnum+=5;
        }
        else if(points[ptnum]==3)  //bezierCurveTo
        {
          properties.canvasContext.bezierCurveTo(points[ptnum+1], points[ptnum+2],points[ptnum+3],points[ptnum+4],points[ptnum+5],points[ptnum+6]);
          ptnum+=7;
        }
        else break; // if pt!=0|1|2|3 there is a problem, so stop drawing the shape
      }

      if(pathMode=="close") properties.canvasContext.closePath();

      if(modeLoop[this.loop]=='fill')
      {
        properties.canvasContext.fill();
      }
      else
      {
        properties.canvasContext.save();
        if(mode.fill) properties.canvasContext.shadowColor='rgba(0,0,0,0)';
        properties.canvasContext.stroke();
        properties.canvasContext.restore();
      }
    }
    return(true);
  }


  /**
   * define a color for lines
   *
   * @param String color : a color
   *                        '#rrggbb' with rr,gg,bb [0x00..0xFF]
   *                        'rgb(r,g,b)' with r,g,b [0..255]
   *                        'rgba(r,g,b,a)' with r,g,b [0..255] and a [0..1]
   * @return Bool : true if drawed, otherwise false
   */
  this.styleStrokeColor = function (color)
  {
    if(properties.canvasContext==null) return (false);

    properties.canvasContext.strokeStyle=color;
    return(true);
  }

  /**
   * define a gradient for lines
   * you can have more information about how this function works on this page :
   *    https://developer.mozilla.org/en/Canvas_tutorial%3aApplying_styles_and_colors
   *
   * @param String mode : kind of gradient 'linear' or 'radial'
   * @param CDPoint|CDRpoint start : start coordinate for the gradient
   *                                    a CDPoint for 'linear' mode
   *                                    a CDRPoint for 'radial' mode
   * @param CDPoint|CDRpoint end   : end coordinate for the gradient
   *                                    a CDPoint for 'linear' mode
   *                                    a CDRPoint for 'radial' mode
   * @param Array<CDGradientStep> gradients : an array of CDGradientStep
   * @return Bool : true if drawed, otherwise false
   */
  this.styleStrokeGradient = function (mode, start, end, gradients)
  {
    if(properties.canvasContext==null) return (false);

    gradient=null;
    if(mode=='linear')
    {
      gradient=properties.canvasContext.createLinearGradient(start.x, start.y, end.x, end.y);
    }
    else if(mode=='radial')
    {
      gradient=properties.canvasContext.createRadialGradient(start.x, start.y, start.r, end.x, end.y, end.r);
    }

    if(gradient!=null)
    {
      for(this.i=0;this.i<gradients.length;this.i++)
      {
        gradient.addColorStop(gradients[this.i].step, gradients[this.i].color);
      }

      properties.canvasContext.strokeStyle=gradient;
      return(true);
    }

    return(false);
  }

  /**
   * define a pattern for lines
   * you can have more information about how this function works on this page :
   *    https://developer.mozilla.org/en/Canvas_tutorial%3aApplying_styles_and_colors
   *
   * @param String url  : the url of image pattern
   * @param String mode : the repeat mode 'repeat' 'repeat-x' 'repeat-y' 'no-repeat'
   * @return Bool : true if drawed, otherwise false
   */
  this.styleStrokePattern = function (url, mode)
  {
    if(properties.canvasContext==null) return (false);

    imageIndex=this.imageLoaded(url);
    if(imageIndex.index==-1) return(false);

    if(!(mode=='repeat' || mode=='repeat-x' || mode=='repeat-y' || mode=='no-repeat')) mode='repeat';

    properties.canvasContext.strokeStyle=properties.canvasContext.createPattern(properties.imagesObj[imageIndex.index], mode);
    return(true);
  }

  /**
   * define stroke line properties for drawing
   *
   * if a properties is not given, current style is kept.
   *
   * @param Object param : object with properties
   *                        width  : width of lines
   *                        cap    : 'butt', 'round', 'square'
   *                        joints : 'round', 'bevel', 'miter'
   * @return Bool : true if drawed, otherwise false
   */
  this.styleStrokeDraw = function (param)
  {
    if(properties.canvasContext==null) return (false);

    if(param.width!= null) properties.canvasContext.lineWidth=param.width;
    if(param.cap!=null && (param.cap=='butt' || param.cap=='round' || param.cap=='square')) properties.canvasContext.lineCap=param.cap;
    if(param.joints!=null && (param.joints=='round' || param.joints=='bevel' || param.joints=='miter')) properties.canvasContext.lineJoin=param.joints;

    return(true);
  }



  /**
   * define a color for fill
   *
   * @param String color : a color
   *                        '#rrggbb' with rr,gg,bb [0x00..0xFF]
   *                        'rgb(r,g,b)' with r,g,b [0..255]
   *                        'rgba(r,g,b,a)' with r,g,b [0..255] and a [0..1]
   * @return Bool : true if drawed, otherwise false
   */
  this.styleFillColor = function (color)
  {
    if(properties.canvasContext==null) return (false);

    properties.canvasContext.fillStyle=color;
    return(true);
  }

  /**
   * define a gradient for fill
   * you can have more information about how this function works on this page :
   *    https://developer.mozilla.org/en/Canvas_tutorial%3aApplying_styles_and_colors
   *
   * @param String mode : kind of gradient 'linear' or 'radial'
   * @param CDPoint|CDRpoint start : start coordinate for the gradient
   *                                    a CDPoint for 'linear' mode
   *                                    a CDRPoint for 'radial' mode
   * @param CDPoint|CDRpoint end   : end coordinate for the gradient
   *                                    a CDPoint for 'linear' mode
   *                                    a CDRPoint for 'radial' mode
   * @param Array<CDGradientStep> gradients : an array of CDGradientStep
   * @return Bool : true if drawed, otherwise false
   */
  this.styleFillGradient = function (mode, start, end, gradients)
  {
    if(properties.canvasContext==null) return (false);

    gradient=null;
    if(mode=='linear')
    {
      gradient=properties.canvasContext.createLinearGradient(start.x, start.y, end.x, end.y);
    }
    else if(mode=='radial')
    {
      gradient=properties.canvasContext.createRadialGradient(start.x, start.y, start.r, end.x, end.y, end.r);
    }

    if(gradient!=null)
    {
      for(this.i=0;this.i<gradients.length;this.i++)
      {
        gradient.addColorStop(gradients[this.i].step, gradients[this.i].color);
      }

      properties.canvasContext.fillStyle=gradient;
      return(true);
    }

    return(false);
  }

  /**
   * define a pattern for fill
   * you can have more information about how this function works on this page :
   *    https://developer.mozilla.org/en/Canvas_tutorial%3aApplying_styles_and_colors
   *
   * @param String url  : the url of image pattern
   * @param String mode : the repeat mode 'repeat' 'repeat-x' 'repeat-y' 'no-repeat'
   * @return Bool : true if drawed, otherwise false
   */
  this.styleFillPattern = function (url, mode)
  {
    if(properties.canvasContext==null) return (false);

    imageIndex=this.imageLoaded(url);
    if(imageIndex.index==-1) return(false);

    if(!(mode=='repeat' || mode=='repeat-x' || mode=='repeat-y' || mode=='no-repeat')) mode='repeat';

    properties.canvasContext.fillStyle=properties.canvasContext.createPattern(properties.imagesObj[imageIndex.index], mode);
    return(true);
  }


  /**
   * define the global opacity
   *
   * @param Float opacity : 0:transparent, 1:opaque
   * @return Bool : true if drawed, otherwise false
   */
  this.styleGlobalAlpha = function (opacity)
  {
    if(properties.canvasContext==null) return (false);

    if(opacity<0)
    {
      opacity=0;
    }
    else if(opacity > 1)
    {
      opacity=1;
    }

    properties.canvasContext.globalAlpha=opacity;
    return(true);
  }


  /**
   * define a shadow
   *
   * @return Bool : true if drawed, otherwise false
   */
  this.styleShadow = function (offsetX, offsetY, blur, color)
  {
    if(properties.canvasContext==null) return (false);
    if(properties.canvasContext.shadowOffsetX==null) return(false);

    properties.canvasContext.shadowOffsetX=offsetX;
    properties.canvasContext.shadowOffsetY=offsetY;
    properties.canvasContext.shadowBlur=blur;
    properties.canvasContext.shadowColor=color;

    return(true);
  }

  /**
   * reset the shadow (remove it)
   *
   * @return Bool : true if drawed, otherwise false
   */
  this.styleShadowReset = function ()
  {
    return(this.styleShadow(0,0,0,'rgba(0,0,0,0)'));
  }


  /**
   * print a text
   *
   * @param String text : text to print
   * @param Integer x : x coordinate
   * @param Integer y : y coordinate
   * @param String mode : 'fill' 'stroke' 'both'
   * @return Bool : true if drawed, otherwise false
   */
  this.textPrint = function (text, x, y, mode)
  {
    if(properties.canvasContext==null) return (false);

    /* a bad trick for a strange bug...
     *
     * when using the strokeText() function, it seems that the last drawn path
     * is drawn again...
     *
     * so, making a dummy path to avoid this problem
     *
     * >>
     */
    properties.canvasContext.beginPath();
    properties.canvasContext.moveTo(x,y);
    properties.canvasContext.fill();
    /*
     * <<
     */

    if(mode=='fill' || mode=='both') properties.canvasContext.fillText(text,x,y);
    if(mode=='stroke' || mode=='both') properties.canvasContext.strokeText(text,x,y);

    return(true);
  }

  /**
   * print a text
   *
   * @param Object param : object with properties
   *                        font : a string like '20px sans' (css format)
   *                        alignH : 'left', 'right', 'center', 'start', 'end'
   *                        alignV : 'top', 'bottom', 'middle', 'alphabetic'
   * @return Bool : true if drawed, otherwise false
   */
  this.textStyle = function (param)
  {
    if(properties.canvasContext==null) return (false);

    if(param.font!=null) properties.canvasContext.font=param.font;
    if(param.alignH=='left' ||
       param.alignH=='right' ||
       param.alignH=='center' ||
       param.alignH=='start' ||
       param.alignH=='end') properties.canvasContext.textAlign=param.alignH;
    if(param.alignV=='top' ||
       param.alignV=='bottom' ||
       param.alignV=='middle' ||
       param.alignV=='alphabetic') properties.canvasContext.textBaseline=param.alignV;

    return(true);
  }

  /**
   * mesure the width for a given text
   *
   * @param String text : text to print
   * @return Integer :
   */
  this.textWidth = function (text)
  {
    if(properties.canvasContext==null) return (-1);

    return(properties.canvasContext.measureText(text));
  }





  /**
   * calculate the distance between 2 points
   */
  var distance = function(x1, y1, x2, y2)
  {
    return(Math.sqrt( Math.pow(x1-x2,2) + Math.pow(y1-y2,2)));
  }


  this.constructor(canvasContext);

} //CDDrawing class

/*
 * transformMatrix()
 * shapeDot(x,y)
 *
 */
