/**
 * -----------------------------------------------------------------------------
 * file: ui.inputFilterBox.js
 * file version: 1.0.0
 * date: 2012-06-14
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
 * | 1.0.0   | 2012/06/14 | first release
 * |         |            |
 * |         |            |
 * |         |            |
 * |         |            |
 * |         |            |
 * |         |            |
 *
 */


var inputFilterBoxLang={
    'Operator':'Operator',
    'Value':'Value',
    'MinValue':'Minimum value',
    'MaxValue':'Maximum value',
    '>':'Greater than',
    '<':'Less than',
    '>=':'Greater or equal to',
    '<=':'Less or equal to',
    '=':'Equal to',
    '!=':'Different than',
    'between':'Between',
    'not between':'Not between',
    'and':'and',
    'like':'Like',
    'not like':'Not like',
    'invalidParam':'Filter is not valid'
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
                  data = $this.data('options'),
                  objects = $this.data('objects'),
                  properties = $this.data('properties'),
                  options =
                    {
                      dataType:'', // numeric, string, dataset-url, dataset-values, date, time, datetime
                      filterOperators:[], //allowed filter types
                      defaultOperator:'=', //default filter applied
                      defaultValue:{   //default value
                        value:null,
                        minValue:null,
                        maxValue:null
                      },
                      numericData:{
                        numDec:0,
                        minValue:'none',
                        maxValue:'none'
                      },
                      stringData:{
                        regExp:'',
                        maxChar:0
                      },
                      datasetData:{
                        serverUrl:'',
                        values:[],
                        listMaxHeight:200
                      },
                      datetimeData:{
                        value:'',
                        minValue:'',
                        maxValue:'',
                        timeFormat:'hh:mm'
                      }
                    };

              // if options given, merge it
              // if(opt) $.extend(options, opt); ==> options are set by setters

              $this.data('options', options);


              if(!properties)
              {
                $this.data('properties',
                  {
                    datasetValues:[], //available values for a dataset
                    filter:{
                      operator:'',
                      value:null,
                      minValue:null,
                      maxValue:null
                    }
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
                          'class':'ui-inputFilterBox'
                        }
                    ),
                    operatorBox:$('<div/>',
                        {
                          'class':'ui-inputFilterBox-operatorBox'
                        }
                    ),
                    valueBox1:$('<div/>',
                        {
                          'class':'ui-inputFilterBox-valueBox'
                        }
                    ),
                    valueBox2:$('<div/>',
                        {
                          'class':'ui-inputFilterBox-valueBox'
                        }
                    ),
                    operator:$('<div/>', {'class':'ui-inputFilterBox-operator'}),
                    value0:$('<div/>', {'class':'ui-inputFilterBox-value'}),
                    value1:$('<div/>', {'class':'ui-inputFilterBox-value'}),
                    value2:$('<div/>', {'class':'ui-inputFilterBox-value'})
                  };

                $this
                  .html('')
                  .append(
                      objects.container
                        .append(objects.operatorBox)
                        .append(objects.valueBox1)
                        .append(objects.valueBox2)
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
                  options = $this.data('options'),
                  objects = $this.data('objects');
              switch(options.dataType)
              {
                case 'numeric':
                  objects.operator.inputList('destroy').remove();
                  objects.value0.inputNum('destroy').remove();
                  objects.value1.inputNum('destroy').remove();
                  objects.value2.inputNum('destroy').remove();
                  break;
                case 'string':
                  objects.operator.inputList('destroy').remove();
                  objects.value0.inputText('destroy').remove();
                  objects.value1.inputText('destroy').remove();
                  objects.value2.inputText('destroy').remove();
                  break;
                case 'date':
                case 'datetime':
                  objects.operator.inputList('destroy').remove();
                  objects.value0.inputDate('destroy').remove();
                  objects.value1.inputDate('destroy').remove();
                  objects.value2.inputDate('destroy').remove();
                  break;
                case 'dataset-url':
                case 'dataset-values':
                  objects.value0.inputList('destroy').remove();
                  break;
              }

              objects.valueBox2.remove();
              objects.valueBox1.remove();
              objects.operatorBox.remove();
              objects.container.remove();

              $this
                .removeData()
                .unbind()
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

      filter: function ()
        {
          var properties=this.data('properties');
          return(properties.filter);
        }, //filter

      isValid: function ()
        {
          return(privateMethods.isValid($(this)));
        } //isValid

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

          privateMethods.setFilter(object, (value!=null)?value:options);
          privateMethods.initialiseFilter(object);
          privateMethods.buildInterface(object);

          properties.initialized=true;
        },

      setFilter : function (object, value)
        {
          var options=object.data('options');

          options.dataType=value.dataType;

          switch(value.dataType)
          {
            case 'numeric':
            case 'date':
            case 'time':
            case 'datetime':
              for(var i=0;i<value.filterOperators.length;i++)
              {
                if(value.filterOperators[i]=='>' ||
                   value.filterOperators[i]=='<' ||
                   value.filterOperators[i]=='>=' ||
                   value.filterOperators[i]=='<=' ||
                   value.filterOperators[i]=='=' ||
                   value.filterOperators[i]=='!=' ||
                   value.filterOperators[i]=='between' ||
                   value.filterOperators[i]=='not between') options.filterOperators.push(value.filterOperators[i]);
              }
              break;
            case 'string':
              for(var i=0;i<value.filterOperators.length;i++)
              {
                if(value.filterOperators[i]=='>' ||
                  value.filterOperators[i]=='<' ||
                  value.filterOperators[i]=='>=' ||
                  value.filterOperators[i]=='<=' ||
                  value.filterOperators[i]=='=' ||
                  value.filterOperators[i]=='!=' ||
                  value.filterOperators[i]=='like' ||
                  value.filterOperators[i]=='not like' ||
                  value.filterOperators[i]=='between' ||
                  value.filterOperators[i]=='not between') options.filterOperators.push(value.filterOperators[i]);
              }
              break;
            case 'dataset-url':
            case 'dataset-values':
              for(var i=0;i<value.filterOperators.length;i++)
              {
                if(value.filterOperators[i]=='=' ||
                  value.filterOperators[i]=='in') options.filterOperators.push(value.filterOperators[i]);
              }
              break;
          }

          options.defaultValue=value.defaultValue;
          options.defaultOperator=value.defaultOperator;

          switch(value.dataType)
          {
            case 'numeric':
              if(value.data.numDec)
                options.numericData.numDec=value.data.numDec;
              if(value.data.minValue)
                options.numericData.minValue=value.data.minValue;
              if(value.data.maxValue)
                options.numericData.maxValue=value.data.maxValue;
              break;
            case 'string':
              if(value.data.regExp)
                options.stringData.regExp=value.data.regExp;
              if(value.data.maxChar)
                options.stringData.maxChar=value.data.maxChar;
              break;
            case 'date':
            case 'time':
            case 'datetime':
              if(value.data.value)
                options.datetimeData.value=value.data.value;
              if(value.data.minValue)
                options.datetimeData.minValue=value.data.minValue;
              if(value.data.maxValue)
                options.datetimeData.maxValue=value.data.maxValue;
              if(value.data.timeFormat)
                options.datetimeData.timeFormat=value.data.timeFormat;
              break;
            case 'dataset-url':
                options.datasetData.serverUrl=value.data.serverUrl;
                if(value.data.listMaxHeight)
                  options.datasetData.listMaxHeight=value.data.listMaxHeight;
              break;
            case 'dataset-values':
                options.datasetData.values=value.data.values;
                if(value.data.listMaxHeight)
                  options.datasetData.listMaxHeight=value.data.listMaxHeight;
              break;
          }

          return(options.filter);
        }, //setFilter

      /*
       * initialise the returned filter
       */
      initialiseFilter : function (object)
        {
          var options=object.data('options'),
              properties=object.data('properties');

          properties.filter.value=options.defaultValue.value;
          properties.filter.minValue=options.defaultValue.minValue;
          properties.filter.maxValue=options.defaultValue.maxValue;

          if(options.dataType=='dataset-values')
            properties.datasetValues=options.datasetData.values;

          if(options.dataType=='dataset-values' ||
             options.dataType=='dataset-values')
          {
            properties.filter.operator='';
          }
          else
          {
            properties.filter.operator=options.defaultOperator;
          }
        }, //buildFilter

      buildInterface : function (object)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          if(options.dataType=='numeric' ||
             options.dataType=='string' ||
             options.dataType=='date' ||
             options.dataType=='time' ||
             options.dataType=='datetime')
          {
            var operatorList=[];

            for(var i=0;i<options.filterOperators.length;i++)
            {
              operatorList.push(
                {
                  value:options.filterOperators[i],
                  cols:[inputFilterBoxLang[options.filterOperators[i]]]
                }
              );
            }

            objects.operator
              .inputList(
                {
                  value:options.defaultOperator,
                  colsWidth:[],
                  colsDisplayed:[0],
                  items:operatorList,
                  change:function (event, value)
                    {
                      privateMethods.changeOperator(object, value);
                    }
                }
              );

            objects.operatorBox
              .append($('<span/>').html(inputFilterBoxLang['Operator']))
              .append(objects.operator);
          } // operator: numeric, string, date, time, datetime

          if(options.dataType=='numeric')
          {
            objects.value0
              .inputNum(
                {
                  numDec:options.numericData.numDec,
                  minValue:options.numericData.minValue,
                  maxValue:options.numericData.maxValue,
                  value:options.defaultValue.value,
                  change:function (event, value)
                  {
                    privateMethods.checkNumericValue(object);
                  }
                }
              ).addClass('ui-inputFilterBox-numValue');
            objects.value1
              .inputNum(
                {
                  numDec:options.numericData.numDec,
                  minValue:options.numericData.minValue,
                  maxValue:options.numericData.maxValue,
                  value:options.defaultValue.minValue,
                  change:function (event, value)
                  {
                    privateMethods.checkNumericBetweenValue(object);
                  }
                }
              ).addClass('ui-inputFilterBox-numValue');
            objects.value2
              .inputNum(
                {
                  numDec:options.numericData.numDec,
                  minValue:options.numericData.minValue,
                  maxValue:options.numericData.maxValue,
                  value:options.defaultValue.maxValue,
                  change:function (event, value)
                    {
                      privateMethods.checkNumericBetweenValue(object)
                    }
                }
              ).addClass('ui-inputFilterBox-numValue');
            privateMethods.checkNumericValue(object);
            privateMethods.checkNumericBetweenValue(object);
          } //numeric

          if(options.dataType=='string')
          {
            objects.value0
              .inputText(
                {
                  regExp:options.stringData.regExp,
                  maxChar:options.stringData.maxChar,
                  value:options.defaultValue.value,
                  change:function (event, value)
                  {
                    privateMethods.checkStringValue(object);
                  }
                }
              ).addClass('ui-inputFilterBox-stringValue');
            objects.value1
              .inputText(
                {
                  regExp:options.stringData.regExp,
                  maxChar:options.stringData.maxChar,
                  value:options.defaultValue.minValue,
                  change:function (event, value)
                  {
                    privateMethods.checkStringBetweenValue(object);
                  }
                }
              ).addClass('ui-inputFilterBox-stringValue');
            objects.value2
              .inputText(
                {
                  regExp:options.stringData.regExp,
                  maxChar:options.stringData.maxChar,
                  value:options.defaultValue.maxValue,
                  change:function (event, value)
                  {
                    privateMethods.checkStringBetweenValue(object)
                  }
                }
              ).addClass('ui-inputFilterBox-stringValue');
            privateMethods.checkStringValue(object);
            privateMethods.checkStringBetweenValue(object);
          } //string

          if(options.dataType=='date' ||
             options.dataType=='datetime')
          {
            objects.value0
              .inputDate(
                {
                  dateType:options.dataType,
                  value:options.defaultValue.value,
                  timepicker:{
                    timeFormat:options.datetimeData.timeFormat
                  },
                  datepicker:{
                    minDate:options.datetimeData.minValue,
                    maxDate:options.datetimeData.maxValue,
                    defaultDate:options.defaultValue.value,
                    dateFormat:'yy-mm-dd'
                  },
                  change:function (event, value)
                    {
                      privateMethods.checkDateValue(object);
                    }
                }
              ).addClass('ui-inputFilterBox-dateValue');

            objects.value1
              .inputDate(
                {
                  dateType:options.dataType,
                  value:options.defaultValue.minValue,
                  timepicker:{
                    timeFormat:options.datetimeData.timeFormat
                  },
                  datepicker:{
                    minDate:options.datetimeData.minValue,
                    maxDate:options.datetimeData.maxValue,
                    defaultDate:options.defaultValue.minValue,
                    dateFormat:'yy-mm-dd'
                  },
                  change:function (event, value)
                    {
                      privateMethods.checkDateBetweenValue(object);
                    }
                }
              ).addClass('ui-inputFilterBox-dateValue');

            objects.value2
              .inputDate(
                {
                  dateType:options.dataType,
                  value:options.defaultValue.maxValue,
                  timepicker:{
                    timeFormat:options.datetimeData.timeFormat
                  },
                  datepicker:{
                    minDate:options.datetimeData.minValue,
                    maxDate:options.datetimeData.maxValue,
                    defaultDate:options.defaultValue.maxValue,
                    dateFormat:'yy-mm-dd'
                  },
                  change:function (event, value)
                    {
                      privateMethods.checkDateBetweenValue(object);
                    }
                }
              ).addClass('ui-inputFilterBox-dateValue');

            privateMethods.checkDateValue(object);
            privateMethods.checkDateBetweenValue(object);
          } //date, datetime


          if(options.dataType=='numeric' ||
             options.dataType=='string' ||
             options.dataType=='date' ||
             options.dataType=='datetime')
          {
            objects.valueBox1
            .append($('<span/>').html(inputFilterBoxLang['Value']))
            .append(objects.value0);

            objects.valueBox2
            .append($('<span/>').html(inputFilterBoxLang['MinValue']))
            .append(objects.value1)
            .append($('<span/>').html(inputFilterBoxLang['MaxValue']))
            .append(objects.value2);
          } // numeric+string+date+datetime


          if((options.dataType=='numeric' ||
              options.dataType=='string' ||
              options.dataType=='date' ||
              options.dataType=='time' ||
              options.dataType=='datetime') &&
             options.defaultOperator!=null && options.defaultOperator!='')
                privateMethods.changeOperator(object, options.defaultOperator);

          if(options.dataType=='dataset-values' ||
             options.dataType=='dataset-url')
          {
            var itemsList=null,
                serverUrl=null;

            if(options.dataType=='dataset-values')
            {
              itemsList=[];

              for(var i=0;i<options.datasetData.values.length;i++)
              {
                itemsList.push(
                  {
                    value:options.datasetData.values[i],
                    cols:options.datasetData.values[i]
                  }
                );
              }
            }
            else
            {
              serverUrl=options.datasetData.serverUrl;
            }

            objects.value0
              .inputList(
                {
                  value:options.defaultValue.value,
                  multiple:($.inArray('in', options.filterOperators)>-1),
                  colsWidth:[],
                  colsCss:['col1', 'col2', 'col3'],
                  items:itemsList,
                  serverUrl:serverUrl,
                  listMaxHeight:options.datasetData.listMaxHeight,
                  change:function (event, value)
                    {
                      privateMethods.checkDatasetValue(object);
                    }
                }
              );

            objects.valueBox1
              .append($('<span/>').html(inputFilterBoxLang['Value']))
              .append(objects.value0)
              .css('display', 'block');

            objects.operatorBox.css('display', 'none');
          } //dataset-url + dataset-values
        }, //buildInterface

      changeOperator : function (object, value)
        {
          var objects=object.data('objects')
              properties=object.data('properties');

          properties.filter.operator=value;

          if(value=='between' || value=='not between')
          {
            objects.valueBox1.css('display', 'none');
            objects.valueBox2.css('display', 'block');
          }
          else
          {
            objects.valueBox2.css('display', 'none');
            objects.valueBox1.css('display', 'block');
          }
        }, //changeOperator

      checkNumericValue : function (object)
        {
          var objects=object.data('objects'),
              properties=object.data('properties');

          properties.filter.value=objects.value0.inputNum('value');
        }, //checkNumericValue

      checkNumericBetweenValue : function (object)
        {
          var objects=object.data('objects'),
              properties=object.data('properties'),
              minValue=null,
              maxValue=null;

          minValue=objects.value1.inputNum('value');
          maxValue=objects.value2.inputNum('value');

          properties.filter.minValue=minValue;
          properties.filter.maxValue=maxValue;

          if(minValue>maxValue)
          {
            objects.value1.inputNum('isValid', false);
            objects.value2.inputNum('isValid', false);
          }
          else
          {
            objects.value1.inputNum('isValid', 'check');
            objects.value2.inputNum('isValid', 'check');
          }
        }, //checkNumericMinMaxValue

      checkStringValue : function (object)
        {
          var objects=object.data('objects'),
              properties=object.data('properties'),
              value='';

          value=objects.value0.inputText('value');

          properties.filter.value=value;

          if(value=='')
          {
            objects.value0.inputText('isValid', false);
          }
          else
          {
            objects.value0.inputText('isValid', 'check');
          }
        }, //checkStringValue

      checkStringBetweenValue : function (object)
        {
          var objects=object.data('objects'),
              properties=object.data('properties'),
              minValue=null,
              maxValue=null;

          minValue=objects.value1.inputText('value');
          maxValue=objects.value2.inputText('value');

          properties.filter.minValue=minValue;
          properties.filter.maxValue=maxValue;

          if(minValue=='')
            objects.value1.inputText('isValid', false);

          if(maxValue=='')
            objects.value2.inputText('isValid', false);

          if(minValue>maxValue)
          {
            objects.value1.inputText('isValid', false);
            objects.value2.inputText('isValid', false);
          }
          else if(minValue!='' && maxValue!='')
          {
            objects.value1.inputText('isValid', 'check');
            objects.value2.inputText('isValid', 'check');
          }
        }, //checkStringBetweenValue


      checkDatasetValue : function (object)
        {
          var objects=object.data('objects'),
              properties=object.data('properties'),
              value='';

          value=objects.value0.inputList('value');

          properties.filter.value=value;

          if(objects.value0.inputList('properties', 'multiple'))
          {
            if(value.length==0)
            {
              objects.value0.inputList('isValid', false);
            }
            else
            {
              objects.value0.inputList('isValid', true);
            }
          }
          else
          {
            if(value=='')
            {
              objects.value0.inputList('isValid', false);
            }
            else
            {
              objects.value0.inputList('isValid', true);
            }
          }
        }, //checkDatasetValue

      checkDateValue : function (object)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          properties.filter.value=objects.value0.inputDate('value');
        }, //checkDateValue

      checkDateBetweenValue : function (object)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties'),
              minValue=null,
              maxValue=null;

          minValue=objects.value1.inputDate('value');
          maxValue=objects.value2.inputDate('value');

          properties.filter.minValue=minValue;
          properties.filter.maxValue=maxValue;

          if(minValue>maxValue)
          {
            objects.value1.inputDate('isValid', false);
            objects.value2.inputDate('isValid', false);
          }
          else
          {
            objects.value1.inputDate('isValid', 'check');
            objects.value2.inputDate('isValid', 'check');
          }

        }, //checkDateBetweenValue

      setValid: function (object, inputObject, isValid)
        {
          if(isValid)
          {
            inputObject.removeClass('ui-error');
          }
          else
          {
            inputObject.addClass('ui-error');
          }
        }, //setValid


      isValid:function(object)
        {
          var objects=object.data('objects'),
              properties=object.data('properties'),
              options=object.data('options');

          switch(options.dataType)
          {
            case 'numeric':
              if(properties.filter.operator=='between' || properties.filter.operator=='not between')
              {
                return(objects.value1.inputNum('isValid') && objects.value2.inputNum('isValid'));
              }
              else
              {
                return(objects.value0.inputNum('isValid'));
              }
              break;
            case 'string':
              if(properties.filter.operator=='between' || properties.filter.operator=='not between')
              {
                return(objects.value1.inputText('isValid') && objects.value2.inputText('isValid'));
              }
              else
              {
                return(objects.value0.inputText('isValid'));
              }
              break;
            case 'date':
            case 'time':
            case 'datetime':
              if(properties.filter.operator=='between' || properties.filter.operator=='not between')
              {
                return(objects.value1.inputDate('isValid') && objects.value2.inputDate('isValid'));
              }
              else
              {
                return(objects.value0.inputDate('isValid'));
              }
              break;
            case 'dataset-url':
            case 'dataset-values':
              return(objects.value0.inputText('isValid'));
              break;
          }
        } //isValid


    };


    $.fn.inputFilterBox = function(method)
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
        $.error( 'Method ' +  method + ' does not exist on jQuery.inputFilterBox' );
      }
    } // $.fn.inputFilterBox

  }
)(jQuery);

/**
 * check if the given object can be considered as a valid filter
 *
 * @param Object filter: object to check
 * @return Boolean: return true if object is a valid filter, otherwise return false
 */
$.isValidFilter = function (filter)
{
  var validFilterTypes=[];

  if(!$.isPlainObject(filter)) return(false);
  if(filter.dataType==null ||
     !$.isArray(filter.filterOperators) ||
     filter.filterOperators.length==0) return(false);

  if(filter.data!==null)
  {
    switch(filter.dataType)
    {
      case 'numeric':
        if((filter.data.numDec!=null && !$.isNumeric(filter.data.numDec)) ||
           (filter.data.minValue!=null && !$.isNumeric(filter.data.minValue)) ||
           (filter.data.maxValue!=null && !$.isNumeric(filter.data.maxValue))) return(false);
        if(filter.data.numDec<0 ||
           filter.data.minValue > filter.data.maxValue) return(false);
        break;
      case 'datetime':
        if(filter.data.timeFormat!=null &&
           !(filter.data.timeFormat=='hh:mm' || filter.data.timeFormat=='hh:mm:ss')) return(false);
      case 'date':
        /*
         * faire un check de la validité des valeur min&max
        if((filter.data.minValue!=null && filter.data.minValue!='') ||
           (filter.data.maxValue!=null && filter.data.minValue!='')) return(false);
        */
        if(filter.data.minValue > filter.data.maxValue) return(false);
        break;
      case 'string':
        if(filter.data.maxChar!=null && !$.isNumeric(filter.data.maxChar)) return(false);
        if(filter.data.maxChar<0) return(false);
        break;
      case 'dataset-url':
        if(filter.data.serverUrl==null ||
           filter.data.serverUrl=='') return(false);
        if(filter.listMaxHeight!=null &&
           !$.isNumeric(filter.listMaxHeight) &&
           filter.listMaxHeight<0) return(false);
        break;
      case 'dataset-values':
        if(!$.isArray(filter.data.values) ||
           filter.data.values.length==0) return(false);
        if(filter.listMaxHeight!=null &&
           !$.isNumeric(filter.listMaxHeight) &&
           filter.listMaxHeight<0) return(false);
        break;
    }
  }

  switch(filter.dataType)
  {
    case 'numeric':
    case 'date':
    case 'time':
    case 'datetime':
      for(var i=0;i<filter.filterOperators.length;i++)
      {
        if(filter.filterOperators[i]=='>' ||
           filter.filterOperators[i]=='<' ||
           filter.filterOperators[i]=='>=' ||
           filter.filterOperators[i]=='<=' ||
           filter.filterOperators[i]=='=' ||
           filter.filterOperators[i]=='!=' ||
           filter.filterOperators[i]=='between' ||
           filter.filterOperators[i]=='not between') validFilterTypes.push(filter.filterOperators[i]);
      }
      break;
    case 'string':
      for(var i=0;i<filter.filterOperators.length;i++)
      {
        if(filter.filterOperators[i]=='>' ||
          filter.filterOperators[i]=='<' ||
          filter.filterOperators[i]=='>=' ||
          filter.filterOperators[i]=='<=' ||
          filter.filterOperators[i]=='=' ||
          filter.filterOperators[i]=='!=' ||
          filter.filterOperators[i]=='like' ||
          filter.filterOperators[i]=='not like' ||
          filter.filterOperators[i]=='between' ||
          filter.filterOperators[i]=='not between') validFilterTypes.push(filter.filterOperators[i]);
      }
      break;
    case 'dataset-values':
    case 'dataset-url':
      for(var i=0;i<filter.filterOperators.length;i++)
      {
        if(filter.filterOperators[i]=='=' ||
           filter.filterOperators[i]=='in') validFilterTypes.push(filter.filterOperators[i]);
      }
      if(validFilterTypes.length>1) return(false); // only one filter type at once for dataset filters
      break;
    default:
      return(false);
  }
  if(validFilterTypes.length==0) return(false);

  return(true);
}

/**
 * open a modal dialog box to set filter properties
 */
$.inputDialogFilterBox = function(opt)
{
  var options=
        {
          width:350,
          height:170,
          title:'Filter box',
          buttons:
            {
              ok:'Ok',
              cancel:'Cancel',
              erase:null
            },
          filter:
            {
              dataType:''
            },
          errorMessage:inputFilterBoxLang['invalidParam'],
          change:null
        },
      objects=
        {
          dialogBox:$('<div/>'),
          filterBox:$('<div/>', {'class':'filterBox'} )
        },

  setOptions = function (opt)
    {
      if(opt.width!=null && opt.width>0) options.width=opt.width;
      if(opt.height!=null && opt.height>0) options.height=opt.height;
      if(opt.errorMessage!=null && opt.errorMessage!='') options.errorMessage=opt.errorMessage;
      if(opt.title) options.title=opt.title;
      if($.isValidFilter(opt.filter)) options.filter=opt.filter;
      if(opt.buttons && opt.buttons.ok) options.buttons.ok=opt.buttons.ok;
      if(opt.buttons && opt.buttons.cancel) options.buttons.cancel=opt.buttons.cancel;
      if(opt.buttons && opt.buttons.erase) options.buttons.erase=opt.buttons.erase;
      if(opt.change && $.isFunction(opt.change)) options.change=opt.change;
    },

  initDialog = function ()
    {
      var dialogOpt={},
          dialogButtons={};

      dialogButtons[options.buttons.ok] = function (event)
        {
          if(objects.filterBox.inputFilterBox('isValid'))
          {
            if(options.change)
            {
              options.change(event, objects.filterBox.inputFilterBox('filter') );
            }
            $(this).dialog('close');
          }
          else
          {
            alert(options.errorMessage);
          }
        };

      dialogButtons[options.buttons.cancel] = function (event)
        {
          $(this).dialog('close');
        };

      if(options.buttons.erase!=null)
        dialogButtons[options.buttons.erase]=function (event)
          {
            if(options.change)
            {
              options.change(event, null);
            }
            $(this).dialog('close');
          };

      dialogOpt=
          {
            width:options.width,
            height:options.height,
            closeText:'x',
            dialogClass:'ui-inputDialogFilterBox',
            modal:true,
            resizable:true,
            title:options.title,
            buttons:dialogButtons,
            open: open= function ()
                    {
                      objects.filterBox
                        .inputFilterBox(options.filter);
                    },
            close: function ()
                    {
                      objects.filterBox.inputFilterBox('destroy').remove();
                      $(this).dialog('destroy').remove();
                    }
          };

      objects.dialogBox
        .append(objects.filterBox)
        .dialog(dialogOpt);
    };

  setOptions(opt);
  if(!$.isValidFilter(options.filter))
  {
    alert('[Technical error] '+inputFilterBoxLang['invalidParam']);
  }
  else
  {
    initDialog();
  }

} // $.fn.inputFilterBox
