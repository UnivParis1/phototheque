/** ----------------------------------------------------------------------------
 * file         : CanvasDraw.CommonClasses.js
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
 * dependencies : none
 *
 * -----------------------------------------------------------------------------
 *
 * provided classes :
 *  - CDOrigin
 *      . setX(value)
 *      . setY(value)
 *      . getX()
 *      . getY()
 *
 *  - CDPoint(x,y)
 *      . x
 *      . y
 *
 *  - CDBoundBox()
 *      . xMin
 *      . yMin
 *      . xMax
 *      . yMax
 *      . width
 *      . height
 *
 *  - CDRPoint(x,y,r)
 *      . x
 *      . y
 *      . r
 *
 *  - CDGradientStep(step, color)
 *      . step
 *      . color
 *
 *  - CDTransformMatrix()
 *      . get
 *      . rotation(angle)
 *      . scale(scaleX,scaleY)
 *      . translation(x,y)
 *      . identity
 *      . apply
 *
 * -----------------------------------------------------------------------------
 */



/**
 * The CDOrigin class give methods to manage origin values on abscissa an ordinate
 * It's used to determinate objects origin when positionning them

 *
 *
 * Object public properties
 *  - x : String "left" | "middle" | "right"
 *        origin on the abscissa
 *          default "left"
 *
 *  - y : String "top" | "middle" | "bottom"
 *        origin on the ordinate
 *          default "top"
 *
 *
 * Object public functions & methods
 * This object don't have any public functions & methods
 */
function CDOrigin () {

  this.properties = {
    x:"left",
    y:"top"
  }

  this.setX = function(value)
  {
    if((value=="left")||(value=="right")||(value=="middle")) this.properties.x = value;
    return(this.properties.x);
  }


  this.setY = function (value)
  {
    if((value=="top")||(value=="bottom")||(value=="middle")) this.properties.y = value;
    return(this.properties.y);
  }
}

/**
 * this CDPoint is used to define a coordinate
 */
function CDPoint (x,y) {
  this.x=x;
  this.y=y;
}

/**
 * this CDBoundBox is used to define a bound box
 */
function CDBoundBox () {
  this.properties = {
    min:new CDPoint(NaN,NaN),
    max:new CDPoint(NaN,NaN),
    size:new CDPoint(NaN,NaN)
  };

  this.destroy = function ()
  {
    delete this.properties.min;
    delete this.properties.max;
    delete this.properties.size;
    delete this.properties;
  }

  this.reset = function (value)
  {
    this.properties.min.x=NaN;
    this.properties.min.y=NaN;
    this.properties.max.x=NaN;
    this.properties.max.y=NaN;
    this.properties.size.x=NaN;
    this.properties.size.y=NaN;
  }

  this.copy = function (value)
  {
    if(value instanceof CDBoundBox)
    {
      this.properties.min.x=value.properties.min.x;
      this.properties.min.y=value.properties.min.y;
      this.properties.max.x=value.properties.max.x;
      this.properties.max.y=value.properties.max.y;
      this.properties.size.x=value.properties.size.x;
      this.properties.size.y=value.properties.size.y;
    }
  }

  this.applyTransformMatrix = function (value)
  {
    var tmpPt=[new CDPoint(), new CDPoint(), new CDPoint(), new CDPoint()],
        tmpPos=new CDPoint();
    if(value instanceof CDTransformMatrix)
    {

      tmpPt[0].x=this.properties.min.x;
      tmpPt[0].y=this.properties.min.y;
      tmpPt[1].x=this.properties.max.x;
      tmpPt[1].y=this.properties.max.y;
      tmpPt[2].x=this.properties.min.x;
      tmpPt[2].y=this.properties.max.y;
      tmpPt[3].x=this.properties.max.x;
      tmpPt[3].y=this.properties.min.y;
      /*
      value.translation(this.properties.min.x, this.properties.min.y);
      tmpPos.x=this.properties.min.x;
      tmpPos.y=this.properties.min.y;
      tmpPt[0].x=0;
      tmpPt[0].y=0;
      tmpPt[1].x=this.properties.size.x;
      tmpPt[1].y=this.properties.size.y;
      tmpPt[2].x=0;
      tmpPt[2].y=this.properties.size.y;
      tmpPt[3].x=this.properties.size.x;
      tmpPt[3].y=0;
      */

      this.reset();
      for(var i=0;i<4;i++)
      {
        tmpPt[i]=value.apply(tmpPt[i]);
        this.setX(tmpPt[i].x);
        this.setY(tmpPt[i].y);
      }

    }
  }

  this.isNull = function ()
  {
    return(
      (isNaN(this.properties.size.x)) ||
      (isNaN(this.properties.size.y)) ||
      ((this.properties.size.x+this.properties.size.y)==0)
    );
  }

  this.setX = function (value)
  {
    if(isNaN(this.properties.min.x) && isNaN(this.properties.max.x))
    {
      this.setXMin(value);
      this.setXMax(value);
    }
    else if(value<this.properties.min.x)
      this.setXMin(value)
    else if(value>this.properties.max.x)
      this.setXMax(value);
  }

  this.setXMin = function (value)
  {
    if(value<this.properties.min.x || this.properties.min.x==this.properties.max.x || isNaN(this.properties.min.x))
    {
      this.properties.min.x=value;
      if(this.properties.max.x<this.properties.min.x || isNaN(this.properties.max.x)) this.properties.max.x=this.properties.min.x;
      this.properties.size.x=this.properties.max.x-this.properties.min.x;
    }
  }

  this.setXMax = function (value)
  {
    if(value>this.properties.max.x || this.properties.min.x==this.properties.max.x || isNaN(this.properties.max.x))
    {
      this.properties.max.x=value;
      if(this.properties.min.x>this.properties.max.x || isNaN(this.properties.min.x)) this.properties.min.x=this.properties.max.x;
      this.properties.size.x=this.properties.max.x-this.properties.min.x;
    }
  }

  this.setWidth = function (value)
  {
    if(value>0 && value>this.properties.size.x)
    {
      this.properties.size.x=value;
      this.properties.max.x=this.properties.min.x+value;
    }
  }

  this.setY = function (value)
  {
    if(isNaN(this.properties.min.y) && isNaN(this.properties.max.y))
    {
      this.setYMin(value);
      this.setYMax(value);
    }
    else if(value<this.properties.min.y)
      this.setYMin(value)
    else if(value>this.properties.max.y)
      this.setYMax(value);
  }

  this.setYMin = function (value)
  {
    if(value<this.properties.min.y || this.properties.min.y==this.properties.max.y || isNaN(this.properties.min.y))
    {
      this.properties.min.y=value;
      if(this.properties.max.y<this.properties.min.y || isNaN(this.properties.max.y)) this.properties.max.y=this.properties.min.y;
      this.properties.size.y=this.properties.max.y-this.properties.min.y;
    }
  }

  this.setYMax = function (value)
  {
    if(value>this.properties.max.y || this.properties.min.y==this.properties.max.y || isNaN(this.properties.max.y))
    {
      this.properties.max.y=value;
      if(this.properties.min.y>this.properties.max.y || isNaN(this.properties.min.y)) this.properties.min.y=this.properties.max.y;
      this.properties.size.y=this.properties.max.y-this.properties.min.y;
    }
  }

  this.setHeight = function (value)
  {
    if(value>0 && value>this.properties.size.y)
    {
      this.properties.size.y=value;
      this.properties.max.y=this.properties.min.y+value;
    }
  }
}


/**
 * this CDRPoint is used to define a radial coordinate (for radial gradient)
 */
function CDRPoint (x,y,r) {
  this.x=x;
  this.y=y;
  this.r=r;
}

/**
 * this CDGradientStep is used to defined a gradient step
 */
function CDGradientStep (step,color) {
  this.step=step;
  this.color=color;
}




/**
 * returns an object {r:RR, g:GG, b:BB} from a color string #RRGGBB
 *
 * if the given color is not a color, return r:0, g:0, b:0
 *
 * @param String value : color value
 */
function colorHexToRGBInt(value) {
  returned={r:0, g:0, b:0}

  re=/#([0-9A-F][0-9A-F])([0-9A-F][0-9A-F])([0-9A-F][0-9A-F])/i;
  rgb=re.exec(value);
  if(rgb!=null)
  {
    returned.r=parseInt('0x'+rgb[1]);
    returned.g=parseInt('0x'+rgb[2]);
    returned.b=parseInt('0x'+rgb[3]);
  }
  return(returned);
}


/**
 * returns a rgba() color
 *
 * @param String color : a #rrggbb color value
 * @param Float opacity : the opacity
 * @return String :
 */
function toRGBA(color, opacity) {
  rgb=colorHexToRGBInt(color);
  return('rgba('+rgb.r+', '+rgb.g+', '+rgb.b+', '+opacity+')');
}



/**
 * returns true if given color is a valid color string #rrggbb
 *
 * @param String value : color value
 */
function isValidColor(value) {
  re=/#([0-9A-F][0-9A-F])([0-9A-F][0-9A-F])([0-9A-F][0-9A-F])/i;
  if(re.exec(value)!=null) return(true);
  return(false);
}

/**
 * returns true if given opacity is valid
 *
 * @param Float value : color value
 */
function isValidOpacity(value) {
  if((value>=0)&&(value<=1)) return(true);
  return(false);
}


/**
 * matrix usage
 */
function CDTransformMatrix()
{
  this.matrix=[];

  this.identity = function ()
    {
      // matrix[y][x]
      this.matrix= [
                    [1,0,0],
                    [0,1,0]
                   ];
    };

  this.get = function ()
    {
      return(this.matrix);
    }

  this.rotation = function (angle)
    {
      var angleRad=angle*Math.PI/180,
          sinus=Math.sin(angleRad),
          cosinus=Math.cos(angleRad),
          returned=[[0,0],[0,0]];

      returned[0][0]=this.matrix[0][0]*cosinus+this.matrix[1][0]*sinus;
      returned[1][0]=-this.matrix[0][0]*sinus+this.matrix[1][0]*cosinus;
      returned[0][1]=this.matrix[0][1]*cosinus+this.matrix[1][1]*sinus;
      returned[1][1]=-this.matrix[0][1]*sinus+this.matrix[1][1]*cosinus;

      this.matrix[0][0]=returned[0][0];
      this.matrix[0][1]=returned[0][1];
      this.matrix[1][0]=returned[1][0];
      this.matrix[1][1]=returned[1][1];
    }

  this.scale = function (scaleX, scaleY)
    {
      this.matrix[0][0]*=scaleX;
      this.matrix[1][1]*=scaleY;

      this.matrix[0][2]*=scaleX;
      this.matrix[1][2]*=scaleY;
    }

  this.translation = function (x, y)
    {
      this.matrix[0][2]+=x;
      this.matrix[1][2]+=y;
    }

  this.apply = function (point)
    {
      var returned=new CDPoint();

      if(point instanceof CDPoint)
      {
        returned.x=(point.x * this.matrix[0][0] + point.y * this.matrix[0][1])+this.matrix[0][2];
        returned.y=(point.x * this.matrix[1][0] + point.y * this.matrix[1][1])+this.matrix[1][2];
      }

      return(returned);
    }

  this.identity();
}
