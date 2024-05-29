/**
 * -----------------------------------------------------------------------------
 * file: ui.inputDate.js
 * file version: 1.0.1
 * date: 2012-09-05
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
 * | 1.0.0   | 2012/06/17 | * first release
 * |         |            |
 * | 1.0.1   | 2012/09/05 | * add possibility for time to be optional in datetime mode
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
                      dateType:'date', // date, datetime
                      timeMandatory:false, // used for datetime type only
                      timepicker:{
                        timeFormat:'hh:mm',  // hh:mm, hh:mm:ss
                        minTime:null,
                        maxTime:null
                      },
                      datepicker:{
                        dateFormat:'yy-mm-dd'
                      },
                      disabled:false,
                      value:'',
                      change:null
                    };

              // if options given, merge it
              // if(opt) $.extend(options, opt); ==> options are set by setters
              if(options.value=='' && $.trim($this.html())!='') options.value=$.trim($this.html());

              $this.data('options', options);

              if(!properties)
              {
                $this.data('properties',
                  {
                    initialized:false,
                    dateValue:'',
                    timeValue:'',
                    value:'',
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
                          'class':'ui-inputDate',
                          css:{
                            width:'100%'
                          }
                        }
                    ),
                    inputFDate:$('<input/>', { 'type':'text', class:'ui-inputDate-date', value:''}),
                    inputFTime:$('<input/>', { 'type':'text', class:'ui-inputDate-time', value:''})
                  };

                $this
                  .html('')
                  .append(
                    objects.container
                      .append(
                        objects.inputFDate
                          .bind('keyup.inputDate',
                                  function (event)
                                  {
                                    return(privateMethods.keyUp($this, event));
                                  }
                                )
                          .bind('change.inputDate',
                                  function (event)
                                  {
                                    return(privateMethods.change($this, event));
                                  }
                                )
                      )
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
              objects.inputFDate.unbind().datepicker('destroy').remove();
              objects.inputFTime.unbind().remove();
              objects.container.unbind().remove();
              $this
                .unbind('.inputDate')
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

      disabled: function (value)
        {
          if(value!=null)
          {
            return(
              this.each(
                function()
                {
                  privateMethods.setDisabled($(this), value);
                }
              )
            );
          }
          else
          {
            var options = this.data('options');

            if(options)
            {
              return(options.disabled);
            }
            else
            {
              return('');
            }
          }
        }, // disabled

      value: function (value, language)
        {
          if(value!=null)
          {
            var options=this.data('options');

            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setValue($(this), value, true);
                }
              )
            );
          }
          else
          {
            // return the selected tags
            var properties=this.data('properties');
            return(properties.value);
          }
        }, // value

       dateValue: function (value, language)
        {
          if(value!=null)
          {
            var options=this.data('options');

            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setDateValue($(this), value, true);
                }
              )
            );
          }
          else
          {
            // return the selected tags
            var properties=this.data('properties');
            return(properties.dateValue);
          }
        }, // dateValue

       timeValue: function (value, language)
        {
          if(value!=null)
          {
            var options=this.data('options');

            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setTimeValue($(this), value, true);
                }
              )
            );
          }
          else
          {
            // return the selected tags
            var properties=this.data('properties');
            return(properties.timeValue);
          }
        }, // timeValue

       timeMandatory: function (value)
        {
          if(value!=null)
          {
            var options=this.data('options');

            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setTimeMandatory($(this), value, true);
                }
              )
            );
          }
          else
          {
            // return the selected tags
            var properties=this.data('properties');
            return(properties.timeMandatory);
          }
        }, // timeMandatory

      isValid: function (value)
        {
          if(value!=null)
          {
            // set selected value
            return(
              this.each(
                function()
                {
                  privateMethods.setIsValid($(this), value);
                }
              )
            );
          }
          else
          {
            // return the selected tags
            var properties=this.data('properties');
            return(properties.isValid);
          }
        }, // isValid

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
      isDateValid : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              re=/^\d{4}-\d{2}-\d{2}$/i;

          if(options.datepicker.minDate!=null && options.datepicker.minDate!='' && value<options.datepicker.minDate)
            return(false);

          if(options.datepicker.maxDate!=null && options.datepicker.maxDate!='' && value>options.datepicker.maxDate)
            return(false);

          return(re.test(value));
        },

      isTimeValid : function (object, value)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              re=/^(\d{1,2}):(\d{2})(?::(\d{2})){0,1}$/i,
              hms=[];

          if(value=='' && !options.timeMandatory) return(true);

          if(re.test(value))
          {
            hms=re.exec(value);

            if(hms[1]>'23') return(false);
            if(hms[2]>'59') return(false);
            if(hms[3]!=null && hms[3]>'59' && options.timepicker.timeFormat=='hh:mm:ss' ||
               hms[3]!=null && options.timepicker.timeFormat=='hh:mm') return(false);

            if(hms[3]==null && options.timepicker.timeFormat=='hh:mm:ss')
                hms[3]='00'; //assuming the seconds equals...

            if(hms[1].length==1) hms[1]='0'+hms[1];

            hms[0]=hms[1]+':'+hms[2];
            if(options.timepicker.timeFormat=='hh:mm:ss') hms[0]=hms[0]+':'+hms[3];

            if(options.timepicker.minTime!=null && options.timepicker.minTime!='' && hms[0]<options.datepicker.minTime)
              return(false);

            if(options.datepicker.maxTime!=null && options.datepicker.maxTime!='' && hms[0]>options.datepicker.maxTime)
              return(false);

            return(true);
          }
          return(false);
        },

      setOptions : function (object, value)
        {
          var properties=object.data('properties'),
              options=object.data('options');

          if(!$.isPlainObject(value)) return(false);

          properties.initialized=false;

          privateMethods.setTimeMandatory(object, (value.timeMandatory!=null)?value.timeMandatory:options.timeMandatory);
          privateMethods.setDateType(object, (value.dateType!=null)?value.dateType:options.dateType);
          privateMethods.setTimePicker(object, (value.timepicker!=null)?value.timepicker:options.timepicker);
          privateMethods.setDatePicker(object, (value.datepicker!=null)?value.datepicker:options.datepicker);
          privateMethods.setValue(object, (value.value!=null)?value.value:options.value, true);
          privateMethods.setTimeValue(object, (value.timeValue!=null)?value.timeValue:options.timeValue, true, false);
          privateMethods.setDateValue(object, (value.dateValue!=null)?value.dateValue:options.dateValue, true);
          privateMethods.setDisabled(object, (value.disabled!=null)?value.disabled:options.disabled);
          privateMethods.setEventChange(object, (value.change!=null)?value.change:options.change);

          properties.initialized=true;
        },

      setIsValid : function (object, value)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          if(value=='check')
          {
            value=privateMethods.isDateValid(object, properties.dateValue);
            if(value && options.dateType=='datetime')
              value=privateMethods.isTimeValid(object, properties.timeValue);
          }

          if(properties.isValid!=value)
          {
            properties.isValid=value;
            if(properties.isValid)
            {
              objects.container.removeClass('ui-error');
              objects.inputFDate.removeClass('ui-error');
              objects.inputFTime.removeClass('ui-error');
            }
            else
            {
              objects.container.addClass('ui-error');
              objects.inputFDate.addClass('ui-error');
              objects.inputFTime.addClass('ui-error');
            }
          }
          return(properties.isValid);
        }, // setIsValid

      setDisabled : function (object, value)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          if((!properties.initialized || options.disabled!=value) && (value==true || value==false))
          {
            options.disabled=value;
            objects.inputFDate.attr('disabled', options.disabled);
            objects.inputFTime.attr('disabled', options.disabled);
          }
          return(options.disabled);
        }, //setDisabled

      setDateType : function (object, value)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          if((!properties.initialized || options.dateType!=value) && (value=='date' || value=='datetime'))
          {
            options.dateType=value;
            if(value=='datetime')
            {
              objects.container
                .append(
                  objects.inputFTime
                    .bind('keyup.inputDate',
                            function (event)
                            {
                              return(privateMethods.timeFKeyUp(object, event));
                            }
                          )
                    .bind('keydown.inputDate',
                            function (event)
                            {
                              return(privateMethods.timeFKeyDown(object, event));
                            }
                          )
                    .bind('change.inputDate',
                            function (event)
                            {
                              return(privateMethods.timeFChange(object, event));
                            }
                          )
                );
            }
            else
            {
              objects.container
                .bind('click',
                  function (event)
                  {
                    objects.inputFDate.focus();
                  }
                );
            }

          }
          return(options.disabled);
        }, //setDateType

      setTimeMandatory : function (object, value)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          if((!properties.initialized || options.timeMandatory!=value) && (value==true || value==false))
          {
            options.timeMandatory=value;
          }
          return(options.timeMandatory);
        }, //setTimeMandatory

      setDatePicker : function (object, value)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          if(!properties.initialized && $.isPlainObject(value))
          {
            options.datepicker=value;
            options.datepicker
              .onSelect=function (dateText, inst)
                {
                  privateMethods.setValue(object, dateText, false);
                };
            objects.inputFDate.datepicker(options.datepicker)
          }
          return(options.datepicker);
        }, //setDatePicker

      setTimePicker : function (object, value)
        {
          var options=object.data('options'),
              objects=object.data('objects'),
              properties=object.data('properties');

          if(!properties.initialized && $.isPlainObject(value))
          {
            if(value.timeFormat!=null &&
               (value.timeFormat=='hh:mm' ||
                value.timeFormat=='hh:mm:ss'))
              options.timepicker.timeFormat=value.timeFormat;

            if(value.minTime!=null && privateMethods.isTimeValid(object, value.minTime))
              options.timepicker.minTime=value.minTime;

            if(value.maxTime!=null && privateMethods.isTimeValid(object, value.maxTime))
              options.timepicker.maxTime=value.maxTime;
          }
          return(options.timepicker);
        }, //setTimePicker


      setDateValue : function (object, value, apply)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects'),
              reformatted='';

          if(properties.initialized && properties.dateValue==value || value==null)
          {
            return(properties.dateValue);
          }

          reformatted=privateMethods.reformatDate(value);
          if(reformatted!=value)
          {
            value=reformatted;
            apply=true;
          }

          properties.dateValue=value;
          if(options.dateType=='datetime')
          {
            properties.value=properties.dateValue+' '+properties.timeValue;
            privateMethods.setIsValid(object, privateMethods.isDateValid(object, value) & privateMethods.isTimeValid(object, properties.timeValue));
          }
          else
          {
            properties.value=properties.dateValue;
            privateMethods.setIsValid(object, privateMethods.isDateValid(object, value));
          }


          if(apply)
            objects.inputFDate.datepicker('setDate', properties.dateValue);

          if(options.change) object.trigger('inputDateChange', properties.value);

          return(properties.dateValue);
        }, //setDateValue

       setTimeValue : function (object, value, apply, triggerEvent)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects'),
              reformatted='';

          if(properties.initialized && properties.timeValue==value || value==null)
          {
            return(properties.timeValue);
          }

          reformatted=privateMethods.reformatTime(value, options.timepicker.timeFormat);
          if(reformatted!=value)
          {
            value=reformatted;
            apply=true;
          }

          privateMethods.setIsValid(object, privateMethods.isDateValid(object, properties.dateValue) & privateMethods.isTimeValid(object, value));

          properties.timeValue=value;
          properties.value=properties.dateValue+' '+properties.timeValue;

          if(apply)
            objects.inputFTime.val(properties.timeValue);

          if(options.change && triggerEvent) object.trigger('inputDateChange', properties.value);

          return(properties.timeValue);
        }, //setDateValue

       setValue : function (object, value, apply)
        {
          var options=object.data('options'),
              properties=object.data('properties'),
              objects=object.data('objects'),
              re=/([\d-]+)(?:\s+([\d:]+)){0,1}/,
              values=null;

          if(properties.initialized && properties.value==value || value==null)
          {
            return(properties.value);
          }

          if(re.test(value))
          {
            values=re.exec(value);

            if(options.dateType=='datetime')
              privateMethods.setTimeValue(object, values[2], apply, false);

            privateMethods.setDateValue(object, values[1], apply);
          }

          return(properties.value);
        }, //setDateValue

      setEventChange : function (object, value)
        {
          var options=object.data('options');

          options.change=value;
          object.unbind('inputDateChange');
          if(value) object.bind('inputDateChange', options.change);
          return(options.change);
        }, //setEventChange

      keyUp : function (object, event)
        {
          var objects=object.data('objects');

          if(event.keyCode==9 || //DOM_VK_TAB
             event.keyCode==12 || //DOM_VK_CLEAR
             event.keyCode==16 || //DOM_VK_SHIFT
             event.keyCode==17 || //DOM_VK_CONTROL
             event.keyCode==18 || //DOM_VK_ALT
             event.keyCode==33 || //DOM_VK_PAGE_UP
             event.keyCode==34 || //DOM_VK_PAGE_DOWN
             event.keyCode==35 || //DOM_VK_END
             event.keyCode==36 || //DOM_VK_HOME
             event.keyCode==37 || //DOM_VK_LEFT
             event.keyCode==38 || //DOM_VK_UP
             event.keyCode==39 || //DOM_VK_RIGHT
             event.keyCode==40 || //DOM_VK_DOWN
             event.keyCode==45 || //DOM_VK_INSERT
             event.keyCode==93  //DOM_VK_CONTEXT_MENU
            ) return(false);

          return(privateMethods.setDateValue(object, objects.inputFDate.val(), false));
        }, //keyUp

      change : function (object, event)
        {
          var objects=object.data('objects');

          return(privateMethods.setDateValue(object, objects.inputFDate.val(), false));
        }, //change

      timeFKeyUp : function (object, event)
        {
          var objects=object.data('objects');

          if(event.keyCode==9 || //DOM_VK_TAB
             event.keyCode==12 || //DOM_VK_CLEAR
             event.keyCode==16 || //DOM_VK_SHIFT
             event.keyCode==17 || //DOM_VK_CONTROL
             event.keyCode==18 || //DOM_VK_ALT
             event.keyCode==33 || //DOM_VK_PAGE_UP
             event.keyCode==34 || //DOM_VK_PAGE_DOWN
             event.keyCode==35 || //DOM_VK_END
             event.keyCode==36 || //DOM_VK_HOME
             event.keyCode==37 || //DOM_VK_LEFT
             event.keyCode==38 || //DOM_VK_UP
             event.keyCode==39 || //DOM_VK_RIGHT
             event.keyCode==40 || //DOM_VK_DOWN
             event.keyCode==45 || //DOM_VK_INSERT
             event.keyCode==93  //DOM_VK_CONTEXT_MENU
            ) return(false);

          return(privateMethods.setTimeValue(object, objects.inputFTime.val(), false, true));
        }, //timeFKeyUp

      timeFKeyDown : function (object, event)
        {
          var objects=object.data('objects'),
              options=object.data('options'),
              char='';

          if(objects.inputFTime.val().length>=options.timepicker.timeFormat.length &&
             !(event.keyCode==8 || //DOM_VK_BACK_SPACE
               event.keyCode==9 || //DOM_VK_TAB
               event.keyCode==12 || //DOM_VK_CLEAR
               event.keyCode==16 || //DOM_VK_SHIFT
               event.keyCode==17 || //DOM_VK_CONTROL
               event.keyCode==18 || //DOM_VK_ALT
               event.keyCode==33 || //DOM_VK_PAGE_UP
               event.keyCode==34 || //DOM_VK_PAGE_DOWN
               event.keyCode==35 || //DOM_VK_END
               event.keyCode==36 || //DOM_VK_HOME
               event.keyCode==37 || //DOM_VK_LEFT
               event.keyCode==38 || //DOM_VK_UP
               event.keyCode==39 || //DOM_VK_RIGHT
               event.keyCode==40 || //DOM_VK_DOWN
               event.keyCode==45 || //DOM_VK_INSERT
               event.keyCode==46 || //DOM_VK_DELETE
               event.keyCode==93 || //DOM_VK_CONTEXT_MENU
               objects.inputFTime.get(0).selectionStart!=objects.inputFTime.get(0).selectionEnd
              )
            ) return(false);

            if(event.keyCode==8 || //DOM_VK_BACK_SPACE
               event.keyCode==9 || //DOM_VK_TAB
               event.keyCode==12 || //DOM_VK_CLEAR
               event.keyCode==16 || //DOM_VK_SHIFT
               event.keyCode==17 || //DOM_VK_CONTROL
               event.keyCode==18 || //DOM_VK_ALT
               event.keyCode==33 || //DOM_VK_PAGE_UP
               event.keyCode==34 || //DOM_VK_PAGE_DOWN
               event.keyCode==35 || //DOM_VK_END
               event.keyCode==36 || //DOM_VK_HOME
               event.keyCode==37 || //DOM_VK_LEFT
               event.keyCode==38 || //DOM_VK_UP
               event.keyCode==39 || //DOM_VK_RIGHT
               event.keyCode==40 || //DOM_VK_DOWN
               event.keyCode==45 || //DOM_VK_INSERT
               event.keyCode==46 || //DOM_VK_DELETE
               event.keyCode==93)    //DOM_VK_CONTEXT_MENU
            return(true);

          if(event.keyCode>=96 && event.keyCode<=105 ||  // 0 - 9
             event.keyCode==59)
          {
            var currentValue=objects.inputFTime.val(),
                newValue='';

            if(objects.inputFTime.get(0).selectionStart!=objects.inputFTime.get(0).selectionEnd)
              currentValue=currentValue.substring(0,objects.inputFTime.get(0).selectionStart)+currentValue.substr(objects.inputFTime.get(0).selectionEnd);

            if(event.keyCode==59)
            {
              char=':';
            }
            else char=(event.keyCode-96).toString();

            newValue=currentValue;

            if(currentValue=='' && char>='3')
              newValue='0'+char+':';
            if(currentValue=='' && char<'3')
              newValue=char;

            if(
               (currentValue=='0' ||
                currentValue=='1' ||
                currentValue=='2') &&
                char==':'
              )
              newValue='0'+currentValue+':';

            if((currentValue=='0' ||
                currentValue=='1') &&
               char!=':')
               newValue=currentValue+char+':';

            if(currentValue=='2' && char>='0' && char<='3')
               newValue=currentValue+char+':';

            if(currentValue.length==2 && char==':')
              newValue=currentValue+char;

            if(currentValue.length==2 && char<='5' && char!=':')
              newValue=currentValue+':'+char;

            if(currentValue.length==3 && char<='5' && char!=':')
              newValue=currentValue+char;

            if(currentValue.length==4 && char!=':')
            {
              newValue=currentValue+char;
              if(newValue.length<options.timepicker.timeFormat.length)
                newValue=newValue+':';
            }

            if(currentValue.length==5 && char<='5' && char!=':')
              newValue=currentValue+':'+char;

            if(currentValue.length==5 && char==':')
              newValue=currentValue+char;

            if(currentValue.length==6 && char<='5' && char!=':')
              newValue=currentValue+char;

            if(currentValue.length==7 && char!=':')
              newValue=currentValue+char;

            objects.inputFTime.val(newValue);
            objects.inputFTime.get(0).selectionStart=newValue.length;
            objects.inputFTime.get(0).selectionEnd=newValue.length;
          }
          return(false);
        }, //timeFKeyDown

      timeFChange : function (object, event)
        {
          var objects=object.data('objects');

          return(privateMethods.setTimeValue(object, objects.inputFTime.val(), false, true));
        }, //timeFChange




      /**
       * try to reformat a date...
       *
       * dd-mm-yyyy => yyyy-mm-dd
       * dd/mm/yyyy => yyyy-mm-dd
       *
       * @param String value
       * @return String
       */
      reformatDate: function (value)
        {
          var d=new Date(2012,11,31), //try to see locale date settings...(2012-12-31, december=11)
              dMonth=1,  // in local settings, month is in first position (1=mm/dd/yyyy) or in second position (2=dd/mm/yyyy)
              returned='',
              year='',
              month='',
              day='',
              p1='',
              p2='',
              re=[
                  /^\d{2}[-\/]\d{2}[-\/]\d{4}$/i,
                  /^\d{4}[-\/]\d{2}[-\/]\d{2}$/i
                ];

          if(d.toLocaleDateString().substr(3,2)=='12') dMonth=2;

          for(var i=0;i<re.length;i++)
          {
            if(re[i].test(value))
            {
              switch(i)
              {
                case 0:
                  year=value.substr(6,4);
                  p1=value.substr(0,2);
                  p2=value.substr(3,2);
                  break;
                case 1:
                  year=value.substr(0,4);
                  p1=value.substr(5,2);
                  p2=value.substr(8,2);
                  break;
              }

              if(p2>'12' && p1<='12')
              {
                month=p1;
                day=p2;
              }
              else if(p1>'12' && p2<='12')
              {
                month=p2;
                day=p1;
              }
              else if(i==0)
              {
                switch(dMonth)
                {
                  case 1:
                    month=p1;
                    day=p2;
                    break;
                  case 2:
                    month=p2;
                    day=p1;
                    break;
                }
              }
              else
              {
                month=p1;
                day=p2;
              }

              return(year+'-'+month+'-'+day);
            }
          }

          return(value);
        }, //reformatDate

      reformatTime : function (value, timeFormat)
        {
          var re=/^(\d{1,2}):(\d{2})(?::(\d{2})){0,1}$/i,
              hms=[];

          if(re.test(value))
          {
            hms=re.exec(value);

            if(hms[1].length==1) hms[1]='0'+hms[1];
            if(hms[3]==null && timeFormat=='hh:mm:ss')
                hms[3]='00'; //assuming the seconds equals...

            hms[0]=hms[1]+':'+hms[2];
            if(timeFormat=='hh:mm:ss') hms[0]=hms[0]+':'+hms[3];

            return(hms[0]);
          }
          return(value);
        } //reformatTime

    };


    $.fn.inputDate = function(method)
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
        $.error( 'Method ' +  method + ' does not exist on jQuery.inputDate' );
      }
    } // $.fn.inputDate

  }
)(jQuery);


