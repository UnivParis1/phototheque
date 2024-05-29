/** ----------------------------------------------------------------------------
 * file         : CanvasDraw.GraphClasses.js
 * file version : 1.0
 * date         : 2011-10-22
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
 *  - CDMargins()
 *      . top
 *      . bottom
 *      . left
 *      . right
 *
 *  - CDAxis()
 *      . set()
 *      . setValues()
 *      . get()
 *      . getXYHPos()
 *      . getVPos()
 *      . getXYVStepPos()
 *      . getXYAxisValues()
 *      . getXYAxisValues()
 *
 *  - CDSerie()
 *      .
 *
 * -----------------------------------------------------------------------------
 */


/**
 * margins
 */
function CDMargins(values)
{
  var _this=this,
      margins={
        left:0,
        right:0,
        bottom:0,
        top:0
  },

  init = function (values)
    {
      _this.set(values);
    };

  this.setLeft = function(value)
    {
      if(value>=0) margins.left=value;
      return(margins.left);
    };

  this.setRight = function(value)
    {
      if(value>=0) margins.right=value;
      return(margins.right);
    };

  this.setTop = function(value)
    {
      if(value>=0) margins.top=value;
      return(margins.top);
    };

  this.setBottom = function(value)
    {
      if(value>=0) margins.bottom=value;
      return(margins.bottom);
    };

  this.get = function ()
    {
      return(margins);
    };

  this.set = function (value)
    {
      if(value instanceof CDMargins)
      {
        tmp=value.get();
        margins.left=tmp.left;
        margins.top=tmp.top;
        margins.bottom=tmp.bottom;
        margins.right=tmp.right;
        return(margins);
      }
      if($.isPlainObject(value))
      {
        if(value.left && value.left>0) margins.left=value.left;
        if(value.right && value.right>0) margins.right=value.right;
        if(value.top && value.top>0) margins.top=value.top;
        if(value.bottom && value.bottom>0) margins.bottom=value.bottom;
      }
      return(margins);
    };

  this.equals = function (value)
    {
      if(value instanceof CDMargins)
      {
        tmp=value.get();
        if(margins.left==tmp.left &&
           margins.top==tmp.top &&
           margins.bottom==tmp.bottom &&
           margins.right==tmp.right) return(true);
        return(false);
      }
      if(value.left && value.right && value.top && value.bottom)
      {
        if(value.left!=margins.left ||
           value.right!=margins.right ||
           value.top!=margins.top ||
           value.bottom!=margins.bottom) return(false);
        return(true);
      }
      return(false);
    };

  init(values);
}

/**
 * axis properties
 */
function CDAxis(options, values)
{
  var _this=this,
      properties={
        mode:'XY',  // 'XY', 'pie'
        series:[],
        size:{
          width:0,
          height:0
        },
        display:{
          color:'rgba(128,128,128,1)',
          visible:
            {
              XY:{
                H:true,
                V:true,
                cursorH:true,
                cursorV:true
              },
              pie:true
            }
        },
        XY:{
          ticks:{
            H:{
              size:{
                small:0,
                big:3
              },
              visible:{
                small:false,
                big:true
              },
              minSpaceLast:5,
              frequency:{
                small:0,
                big:1
              },
              value:{
                rotate:90,
                visible:true,
                fontName:'arial',
                fontSize:8
              },
              offset0:false
            },
            V:{
              unit:'',
              size:{
                small:1,
                big:3
              },
              visible:{
                small:true,
                big:true
              },
              minSpaceLast:5,
              steps:100,
              frequency:{
                small:5,
                big:10
              },
              value:{
                rotate:0,
                visible:true,
                fontName:'arial',
                fontSize:8
              }
            }
          },
          values:{
            H:[],
            minV:0,
            maxV:100
          }
        },
        pie:{
          unit:'',
          innerRadius:0.6,  // between 0 and 1
          outerRadius:1.5,  // greater than 1
          fontName:'arial',
          fontSize:8
        }

      },
      data={
        XY:{
            H:{
              space:0,
              size:0,
              center:0
            },
            V:{
              space:0,
              factor:1,
              size:0,
              center:0
            }
          },
        pie:{
            H:{center:0},
            V:{center:0}
          }
      },

    // functions
      init = function (options)
        {
          if($.isPlainObject(options)) _this.set(options);
        },

      computeData = function ()
        {
          data.XY.H.size=properties.size.width-properties.XY.ticks.H.minSpaceLast;
          data.XY.H.center=Math.round(properties.size.width/2);
          data.XY.V.size=properties.size.height-properties.XY.ticks.V.minSpaceLast;
          data.XY.V.center=Math.round(properties.size.height/2);

          if(properties.XY.values.H.length>0)
          {
            data.XY.H.space=Math.round((data.XY.H.size-properties.XY.values.H.length)/properties.XY.values.H.length)+1;
          }
          else
          {
            data.XY.H.space=0;
          }


          data.XY.V.space=Math.floor(10000*data.XY.V.size/properties.XY.ticks.V.steps)/10000;
          data.XY.V.factor=Math.abs(data.XY.V.size)/properties.XY.ticks.V.steps;

          data.pie.H.center=Math.round(properties.size.width/2);
          data.pie.V.center=Math.round(properties.size.height/2);
        },

      serieFind = function (name)
        {
          for(var i=0;i<properties.series.length;i++)
          {
            if(properties.series[i].get().name==name) return(i);
          }
          return(-1);
        },

      serieSort = function ()
        {
          properties.series.sort(serieCompareOrder);

          // calculate cumulative values
          for(var i=properties.series.length-1;i>=0;i--)
          {
            var current=properties.series[i].get().options.get();
            if(current.mode!=null && current.mode=='cumulative')
            {
              properties.series[i].get().options.cumulativeInit(properties.series[i].get().values);
              for(var j=i-1;j>=0;j--)
              {
                var next=properties.series[j].get().options.get();
                if(next.mode!=null && next.mode=='cumulative')
                {
                  properties.series[i].get().options.cumulativeAdd(properties.series[j].get().values);
                }
              }
            }
          }
        },

      serieCompareOrder = function (a, b)
        {
          aO=a.get().order;
          bO=b.get().order;
          if(aO==bO) return(0);
          return((aO<bO)?-1:1);
        };

  this.set = function (value)
    {
      if(value.mode!=null &&
         (value.mode=='XY' || value.mode=='pie')
        ) properties.mode=value.mode;

      if(value.size!=null)
      {
        if(value.size.width!=null) properties.size.width=value.size.width;
        if(value.size.height!=null) properties.size.height=value.size.height;
      }

      if(value.display!=null)
      {
        if(value.display.color!=null) properties.display.color=value.display.color;
        if(value.display.visible!=null)
        {
          if(value.display.visible.XY!=null)
          {
            if(value.display.visible.XY.H==true || value.display.visible.XY.H==false) properties.display.visible.XY.H=value.display.visible.XY.H;
            if(value.display.visible.XY.V==true || value.display.visible.XY.V==false) properties.display.visible.XY.V=value.display.visible.XY.V;
            if(value.display.visible.XY.cursorH==true || value.display.visible.XY.cursorH==false) properties.display.visible.XY.cursorH=value.display.visible.XY.cursorH;
            if(value.display.visible.XY.cursorV==true || value.display.visible.XY.cursorV==false) properties.display.visible.XY.cursorV=value.display.visible.XY.cursorV;
          }
          if(value.display.visible.pie!=null)
          {
            if(value.display.visible.pie==true || value.display.visible.pie==false) properties.display.visible.pie=value.display.visible.pie;
          }

        }
      }

      if(value.XY!=null)
      {
        if(value.XY.ticks!=null)
        {
          if(value.XY.ticks.H!=null)
          {
            if(value.XY.ticks.H.size!=null && !$.isPlainObject(value.XY.ticks.H.size))
            {
              properties.XY.ticks.H.size.small=value.XY.ticks.H.size;
              properties.XY.ticks.H.size.big=value.XY.ticks.H.size;
            }
            else if(value.XY.ticks.H.size!=null && $.isPlainObject(value.XY.ticks.H.size))
            {
              if(value.XY.ticks.H.size.small) properties.XY.ticks.H.size.small=value.XY.ticks.H.size.small;
              if(value.XY.ticks.H.size.big) properties.XY.ticks.H.size.big=value.XY.ticks.H.size.big;
            }

            if(value.XY.ticks.H.visible==true || value.XY.ticks.H.visible==false)
            {
              properties.XY.ticks.H.visible.small=value.XY.ticks.H.visible;
              properties.XY.ticks.H.visible.big=value.XY.ticks.H.visible;
            }
            else if(value.XY.ticks.H.visible && $.isPlainObject(value.XY.ticks.H.visible))
            {
              if(value.XY.ticks.H.visible.small==true || value.XY.ticks.H.visible.small==false) properties.XY.ticks.H.visible.small=value.XY.ticks.H.visible.small;
              if(value.XY.ticks.H.visible.big==true || value.XY.ticks.H.visible.big==false) properties.XY.ticks.H.visible.big=value.XY.ticks.H.visible.big;
            }

            if(value.XY.ticks.H.frequency!=null)
            {
              if(value.XY.ticks.H.frequency.small!=null) properties.XY.ticks.H.frequency.small=value.XY.ticks.H.frequency.small;
              if(value.XY.ticks.H.frequency.big!=null) properties.XY.ticks.H.frequency.big=value.XY.ticks.H.frequency.big;
            }

            if(value.XY.ticks.H.value!=null)
            {
              if(value.XY.ticks.H.value.rotate!=null) properties.XY.ticks.H.value.rotate=value.XY.ticks.H.value.rotate%180;
              if(value.XY.ticks.H.value.visible==true || value.XY.ticks.H.value.visible==false) properties.XY.ticks.H.value.visible=value.XY.ticks.H.value.visible;
              if(value.XY.ticks.H.value.fontName!=null) properties.XY.ticks.H.value.fontName=value.XY.ticks.H.value.fontName;
              if(value.XY.ticks.H.value.fontSize!=null) properties.XY.ticks.H.value.fontSize=value.XY.ticks.H.value.fontSize;
            }

            if(value.XY.ticks.H.minSpaceLast!=null && value.XY.ticks.minSpaceLast>=0) properties.XY.ticks.H.minSpaceLast=value.XY.ticks.H.minSpaceLast;
            if(value.XY.ticks.H.offset0==true || value.XY.ticks.H.offset0==false) properties.XY.ticks.H.offset0=value.XY.ticks.H.offset0;
          }

          if(value.XY.ticks.V!=null)
          {
            if(value.XY.ticks.V.size!=null && !$.isPlainObject(value.XY.ticks.V.size))
            {
              properties.XY.ticks.V.size.small=value.XY.ticks.V.size;
              properties.XY.ticks.V.size.big=value.XY.ticks.V.size;
            }
            else if(value.XY.ticks.V.size!=null)
            {
              if(value.XY.ticks.V.size.small!=null) properties.XY.ticks.V.size.small=value.XY.ticks.V.size.small;
              if(value.XY.ticks.V.size.big!=null) properties.XY.ticks.V.size.big=value.XY.ticks.V.size.big;
            }

            if(value.XY.ticks.V.visible==true || value.XY.ticks.V.visible==false)
            {
              properties.XY.ticks.V.visible.small=value.XY.ticks.V.visible;
              properties.XY.ticks.V.visible.big=value.XY.ticks.V.visible;
            }
            else if(value.XY.ticks.V.visible!=null && $.isPlainObject(value.XY.ticks.V.visible))
            {
              if(value.XY.ticks.V.visible.small==true || value.XY.ticks.V.visible.small==false) properties.XY.ticks.V.visible.small=value.XY.ticks.V.visible.small;
              if(value.XY.ticks.V.visible.big==true || value.XY.ticks.V.visible.big==false) properties.XY.ticks.V.visible.big=value.XY.ticks.V.visible.big;
            }

            if(value.XY.ticks.V.frequency!=null)
            {
              if(value.XY.ticks.V.frequency.small!=null) properties.XY.ticks.V.frequency.small=value.XY.ticks.V.frequency.small;
              if(value.XY.ticks.V.frequency.big!=null) properties.XY.ticks.V.frequency.big=value.XY.ticks.V.frequency.big;
            }

            if(value.XY.ticks.V.value!=null)
            {
              if(value.XY.ticks.V.value.rotate!=null) properties.XY.ticks.V.value.rotate=value.XY.ticks.V.value.rotate%180;
              if(value.XY.ticks.V.value.visible==true || value.XY.ticks.V.value.visible==false) properties.XY.ticks.V.value.visible=value.XY.ticks.V.value.visible;
              if(value.XY.ticks.V.value.fontName!=null) properties.XY.ticks.V.value.fontName=value.XY.ticks.V.value.fontName;
              if(value.XY.ticks.V.value.fontSize!=null) properties.XY.ticks.V.value.fontSize=value.XY.ticks.V.value.fontSize;
            }

            if(value.XY.ticks.V.minSpaceLast!=null && value.XY.ticks.V.minSpaceLast>=0) properties.XY.ticks.V.minSpaceLast=value.XY.ticks.V.minSpaceLast;
            if(value.XY.ticks.V.steps!=null && value.XY.ticks.V.steps>=0) properties.XY.ticks.V.steps=value.XY.ticks.V.steps;
            if(value.XY.ticks.V.unit!=null) properties.XY.ticks.V.unit=value.XY.ticks.V.unit;
          }
        }

        if(value.XY.values) this.setValues(value.XY.values);
      }

      if(value.pie!=null)
      {
        if(value.pie.unit!=null) properties.pie.unit=value.pie.unit;

        if(value.pie.innerRadius!=null && value.pie.innerRadius>=0 && value.pie.innerRadius<=1) properties.pie.innerRadius=value.pie.innerRadius;
        if(value.pie.outerRadius!=null && value.pie.outerRadius>=1) properties.pie.outerRadius=value.pie.outerRadius;

        if(value.pie.fontName!=null) properties.pie.fontName=value.pie.fontName;
        if(value.pie.fontSize!=null) properties.pie.fontSize=value.pie.fontSize;
      }

      if(value.series!=null && $.isArray(value.series))
        for(var i=0;i<value.series.length;i++)
        {
          this.serieAdd(value.series[i]);
        }

      computeData();
    };

  this.setValues = function (value)
    {
      if(value.H && $.isArray(value.H)) properties.XY.values.H=value.H;
      value.minV?tmpMin=value.minV:tmpMin=properties.XY.values.minV;
      value.maxV?tmpMax=value.maxV:tmpMax=properties.XY.values.maxV;

      if(tmpMin>0 && tmpMin<tmpMax) properties.XY.values.minV=tmpMin;
      if(tmpMax>0 && tmpMin<tmpMax) properties.XY.values.maxV=tmpMax;

      computeData();
    };

  this.get = function ()
    {
      return({properties:properties, data:data});
    };

  this.getXYHPos = function (index, applyOffset)
    {
      var offset=0;

      if(applyOffset==null) applyOffset=true;

      if(applyOffset==true && properties.XY.ticks.H.offset0) offset=0.5;
      return(Math.round(data.XY.H.space*(index+offset)));
    };

  this.getXYVPos = function (value)
    {
      return(data.XY.V.factor*value);
    };

  this.getXYVStepPos = function (value)
    {
      return(Math.round(data.XY.V.space*value));
    };

  this.getXYAxisValues = function (x, y)
    {
      var H=0,
          V=0;

      //if(properties.XY.ticks.H.offset0) x+=data.XY.H.space/2;
      H=(data.XY.H.space==0)?0:Math.floor(x/data.XY.H.space);
      V=(data.XY.V.space==0)?0:y/data.XY.V.space;

      return({H:H, V:V});
    };

  /**
   * Add a serie to the axis; the serie type must be compatible with the axis mode
   * Note: the serie name is unique for an axis; if the serie name already exist,
   * she won't be added
   *
   * @param CDSerie serie: the serie to Add
   * @return boolean: true if serie was added otherwise false
   */
  this.serieAdd = function (serie)
    {
      var index=-1,
          serieType='';

      if(serie instanceof CDSerie)
      {
        serieType=serie.get().options.get().type;

        if(
           (properties.mode=='XY' &&
             (serieType=='bar' ||
              serieType=='area' ||
              serieType=='line')
           ) ||
           (properties.mode=='pie' && serieType=='pie')
          )
        {
          index=serieFind(serie.get().name);
          if(index==-1)
          {
            properties.series.push(serie);
            serieSort();
            return(true);
          }
        }
      }
      return(false);
    };

  this.serieGet = function (serieName)
    {
      var index=-1;

      if(serieName instanceof CDSerie)
      {
        serieName=serieName.get().name;
      }
      if(serieName!=null)
      {
        index=serieFind(serieName);
        if(index>=0) return(properties.series[index]);
      }
      return(properties.series);
    };

  this.serieDelete = function (serie)
    {
      var index=-1;

      if(serieName instanceof CDSerie)
      {
        serieName=serieName.get().name;
      }
      if(serieName!=null)
      {
        index=serieFind(serieName);
        if(index>=0)
        {
          properties.series.splice(index, 1);
          serieSort();
          return(true);
        }
      }
      return(false);
    };

  init(options, values);
}


function CDSerie(initProperties)
{
  var _this=this,
      properties={
        name:'',
        order:0,
        values:[],
        valuesLabels:[],
        options:{ }
      },

    init = function (values)
      {
        _this.set(values);
      };


  this.set = function (values)
    {
      if(!$.isPlainObject(values)) return(false);

      if(values.name!=null) properties.name=values.name;
      if(values.order!=null && values.order>=0) properties.order=values.order;

      if(values.values!=null && $.isArray(values.values)) properties.values=values.values;

      if(values.valuesLabels!=null && $.isArray(values.valuesLabels))
      {
        properties.valuesLabels=values.valuesLabels;
      }

      if(properties.valuesLabels.length>properties.values.length)
      {
        properties.valuesLabels.splice(properties.values.length);
      }
      else if(properties.valuesLabels.length<properties.values.length)
      {
        var nb=properties.values.length-properties.valuesLabels.length;

        for(var i=0;i<nb;i++)
        {
          properties.valuesLabels.push('');
        }
      }

      if(values.options!=null &&
         (values.options instanceof CDSerieOptionsBar ||
          values.options instanceof CDSerieOptionsArea ||
          values.options instanceof CDSerieOptionsLine ||
          values.options instanceof CDSerieOptionsPie)
        )
      {
        delete properties.options;
        properties.options=values.options;
      }

      return(true);
    };

  this.get = function ()
    {
      return(properties);
    }

  init(initProperties);
}

function CDSerieOptionsBar(initProperties)
{
  var _this=this,
      properties={
        type:'bar',
        mode:'normal',        // normal, cumulative
        backgroundColor:'#ccccff',
        borderColor:'#ffffff',
        borderWidth:1,
        width:1,          // bar width in percentage; 1=100%
        offset:0,         // x offset applied to display the bar
        cumulativesValues:[]
      },

    init = function (values)
      {
        _this.set(values);
      };

  this.set = function (values)
    {
      if(!$.isPlainObject(values)) return(false);

      if(values.mode=='normal' || values.mode=='cumulative') properties.mode=values.mode;
      if(values.backgroundColor!=null) properties.backgroundColor=values.backgroundColor;
      if(values.borderColor!=null) properties.borderColor=values.borderColor;
      if(values.borderWidth!=null && values.borderWidth>=0) properties.borderWidth=values.borderWidth;

      if(values.width) properties.width=values.width;
      if(values.offset) properties.offset=values.offset;

      return(true);
    };

  this.cumulativeInit = function (values)
    {
      if(!$.isArray(values)) return(properties.cumulativesValues);
      properties.cumulativesValues=[];
      for(var i=0;i<values.length;i++)
      {
        properties.cumulativesValues.push(values[i]);
      }
      return(properties.cumulativesValues);
    };
  this.cumulativeAdd = function (values)
    {
      if(values.length!=properties.cumulativesValues.length) return(properties.cumulativesValues);
      for(var i=0;i<properties.cumulativesValues.length;i++)
      {
        properties.cumulativesValues[i]+=values[i];
      }
      return(properties.cumulativesValues);
    };
  this.cumulativeGet = function ()
    {
      return(properties.cumulativesValues);
    };

  this.get = function ()
    {
      return(properties);
    };

  init(initProperties);
}

function CDSerieOptionsArea(initProperties)
{
  var _this=this,
      properties={
        type:'area',
        mode:'normal',        // normal, cumulative
        backgroundColor:'#ccccff',
        borderColor:'#ffffff',
        borderWidth:1,
        cumulativesValues:[]
      },

    init = function (values)
      {
        _this.set(values);
      };

  this.set = function (values)
    {
      if(!$.isPlainObject(values)) return(false);

      if(values.mode=='normal' || values.mode=='cumulative') properties.mode=values.mode;
      if(values.backgroundColor!=null) properties.backgroundColor=values.backgroundColor;
      if(values.borderColor!=null) properties.borderColor=values.borderColor;
      if(values.borderWidth!=null && values.borderWidth>=0) properties.borderWidth=values.borderWidth;

      return(true);
    };

  this.cumulativeInit = function (values)
    {
      if(!$.isArray(values)) return(properties.cumulativesValues);
      properties.cumulativesValues=values;
      return(properties.cumulativesValues);
    };
  this.cumulativeAdd = function (values)
    {
      if(values.length!=properties.cumulativesValues.length) return(properties.cumulativesValues);
      for(var i=0;i<properties.cumulativesValues.length;i++)
      {
        properties.cumulativesValues[i]+=values[i];
      }
      return(properties.cumulativesValues);
    };
  this.cumulativeGet = function ()
    {
      return(properties.cumulativesValues);
    };

  this.get = function ()
    {
      return(properties);
    };

  init(initProperties);
}

function CDSerieOptionsLine(initProperties)
{
  var _this=this,
      properties={
        type:'line',
        color:'#ffff00',
        width:1,
        dot:'none',   // none, circle, square, diamong
        dotSize:3
      },

    init = function (values)
      {
        _this.set(values);
      };

  this.set = function (values)
    {
      if(!$.isPlainObject(values)) return(false);

      if(values.mode=='normal' || values.mode=='cumulative') properties.mode=values.mode;
      if(values.color!=null) properties.color=values.color;
      if(values.width!=null) properties.width=values.width;
      if(values.dot=='none' ||
         values.dot=='square' ||
         values.dot=='circle' ||
         values.dot=='diamond'
        ) properties.dot=values.dot;

      if(values.dotSize!=null && values.dotSize>1) properties.dotSize=values.dotSize;

      return(true);
    }

  this.get = function ()
    {
      return(properties);
    }

  init(initProperties);
}

function CDSerieOptionsPie(initProperties)
{
  var _this=this,
      properties={
        type:'pie',
        backgroundColors:
          ['#FF96A1',
           '#A796FF',
           '#96FF97',
           '#FFFE96',
           '#FF96DA',
           '#96C8FF',
           '#AEFF96',
           '#FF9896',
           '#C096FF',
           '#96FFFD',
           '#D4FF96'],
        borderColor:'#ffffff',
        borderWidth:2,
        outerRadius:50,
        innerRadius:0,
        offset:0        // exploded pie or not..
      },

    init = function (values)
      {
        _this.set(values);
      };

  this.set = function (values)
    {
      var tmpIRadius=0,
          tmpORadius=0;

      if(!$.isPlainObject(values)) return(false);

      if(values.backgroundColors!=null && $.isArray(values.backgroundColors)) properties.backgroundColors=values.backgroundColors;
      if(values.borderColor!=null) properties.borderColor=values.borderColor;
      if(values.borderWidth!=null && values.borderWidth>=0) properties.borderWidth=values.borderWidth;

      tmpORadius=(values.outerRadius!=null)?values.outerRadius:properties.outerRadius;
      tmpIRadius=(values.innerRadius!=null)?values.innerRadius:properties.innerRadius;

      if(tmpORadius>0 && tmpORadius>tmpIRadius) properties.outerRadius=tmpORadius;
      if(tmpIRadius>=0 && tmpIRadius<tmpORadius) properties.innerRadius=tmpIRadius;
      if(values.offset!=null && values.offset>0) properties.offset=values.offset;

      return(true);
    }

  this.get = function ()
    {
      return(properties);
    }

  init(initProperties);
}




/**
 * legend
 */
function CDLegend(values)
{
  var _this=this,
      properties={
        width:0,
        visible:true,
        position:'right',  // left or right
        backgroundColor:'#101010',
        borderColor:'#ffffff',
        borderWidth:1,
        fontName:'arial',
        fontSize:8
      },
      data={
        realWidth:0
      };

  init = function (values)
    {
      _this.set(values);
    };

  this.get = function ()
    {
      return(properties);
    };

  this.set = function (value)
    {
      if(value instanceof CDLegend)
      {
        tmp=value.get();
        properties.fontName=tmp.fontName;
        properties.fontSize=tmp.fontSize;
        properties.width=tmp.width;
        properties.visible=tmp.visible;
        properties.position=tmp.position;
        properties.backgroundColor=tmp.backgroundColor;
        properties.borderColor=tmp.borderColor;
        properties.borderWidth=tmp.borderWidth;

        data.realWidth=value.width;
        return(properties);
      }
      if($.isPlainObject(value))
      {
        if(value.fontName!=null && value.fontName!='') properties.fontName=value.fontName;
        if(value.fontSize!=null && value.fontSize>0) properties.fontSize=value.fontSize;
        if(value.width!=null && value.width>0)
        {
          properties.width=value.width;
          data.realWidth=value.width;
        }
        if(value.visible!=null) properties.visible=value.visible;
        if(value.position!=null && (value.position=='left' || value.position=='right')) properties.position=value.position;
        if(value.backgroundColor!=null) properties.backgroundColor=value.backgroundColor;
        if(value.borderColor!=null) properties.borderColor=value.borderColor;
        if(value.borderWidth!=null && value.borderWidth>=0) properties.borderWidth=value.borderWidth;
      }
      return(properties);
    };

  this.equals = function (value)
    {
      if(value instanceof CDLegend)
      {
        tmp=value.get();
        if(properties.fontName==tmp.fontName &&
           properties.fontSize==tmp.fontSize &&
           properties.width==tmp.width &&
           properties.visible==tmp.visible &&
           properties.position==tmp.position &&
           properties.backgroundColor==tmp.backgroundColor &&
           properties.borderColor==tmp.borderColor &&
           properties.borderWidth==tmp.borderWidth) return(true);
        return(false);
      }
      if(value.fontName!=null &&
         value.fontSize!=null &&
         value.width!=null &&
         value.visible!=null &&
         value.position!=null &&
         value.backgroundColor!=null &&
         value.borderColor!=null &&
         value.borderWidth!=null &&

         value.fontName==properties.fontName &&
         value.fontSize==properties.fontSize &&
         value.width==properties.width &&
         value.visible==properties.visible &&
         value.position==properties.position &&
         value.backgroundColor==properties.backgroundColor &&
         value.borderColor==properties.borderColor &&
         value.borderWidth==properties.borderWidth
        )
        return(true);
      return(false);
    };

  this.getRealWidth = function ()
    {
      return(data.realWidth);
    };

  this.setRealWidth = function (value)
    {
      if(properties.width==0 && value>=0) data.realWidth=value;
      return(data.realWidth);
    };


  init(values);
}

