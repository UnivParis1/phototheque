/**
 * -----------------------------------------------------------------------------
 * file: ui.timer.js
 * file version: 1.0.0
 * date: 2012-07-14
 *
 * A jQuery plugin provided by the piwigo's plugin "GrumPluginClasses"
 *
 * -----------------------------------------------------------------------------
 * Author     : Grum
 *   email    : grum@piwigo.com
 *   website  : http://www.grum.fr
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
 * | 1.0.0   | 2012/07/14 | first release
 * |         |            |
 * |         |            |
 * |         |            |
 * |         |            |
 * |         |            |
 * |         |            |
 *
 */



/**
 * set a timer
 *
 * $.timer('id', {properties})
 *  => set properties for a timer 'id'
 *
 * $.timer('id', 'function' [, param])
 *  => available functions are:
 *    - start: start the timer
 *    - stop: stop the timer
 *    - reset: reset the timer
 *    - remove: remove the timer
 *    - count: if no param, returns the current count value otherwise set the count value to param value
 *    - frequency: if no param, returns the current frequency value otherwise set the frequency value to param value
 *
 */
$.timer = function (id, value1, value2)
{
  var returned=null,
      properties=
        {
          timers:{}
        },


    // set timer properties
    setTimer = function (id, value)
      {
        if(properties.timers[id]==null)
        {
          properties.timers[id]={
            autoStart:false,      // if set to true, timer start automaticaly when created
            frequency:1000,       // frequency of timer, in milliseconds
            limit:0,              // limit of timer, 0=no limit; timer stop when limit is reached
            timer:null,           // function callback

            count:0,              // number of times the timer was triggered
            started:false,        // true if timer is started, otherwise false
            timerId:null          // timer uid
          }
        }

        if($.isPlainObject(value))
        {
          if(value.autoStart &&
            (value.autoStart==true || value.autoStart==false))
            properties.timers[id].autoStart=value.autoStart;

          if(value.frequency &&
            Math.round(value.frequency)>0)
            properties.timers[id].frequency=Math.round(value.frequency);

          if(value.limit &&
            Math.round(value.limit)>=0)
            properties.timers[id].limit=Math.round(value.limit);

          if(value.timer &&
            $.isFunction(value.timer))
            properties.timers[id].timer=value.timer;
        }

        if(properties.timers[id].autoStart && !properties.timers[id].started)
          startTimer(id);
      },

    /**
     * start the timer if not started
     *
     * @param String Id: timer Id
     * @return Boolean: true if started, otherwise false
     */
    startTimer = function (id)
      {
        if(properties.timers[id]==null || properties.timers[id].started) return(false);

        properties.timers[id].timerId=window.setInterval(
          callFunction,
          properties.timers[id].frequency,
          id
        );
        properties.timers[id].started=true;
        return(true);
      },

    /**
     * stop the timer if started
     *
     * @param String Id: timer Id
     * @return Boolean: true if stopped, otherwise false
     */
    stopTimer = function (id)
      {
        if(properties.timers[id]==null && !properties.timers[id].started) return(false);

        properties.timers[id].started=false;
        window.clearInterval(properties.timers[id].timerId);
        return(true);
      },

    /**
     * reset the timer:
     *  - count is set to 0
     *  - timer is reseted for a new cycle
     *
     * @param String Id: timer Id
     * @return Boolean: true if reseted, otherwise false
     */
    resetTimer = function (id)
      {
        if(properties.timers[id]==null) return(false);

        stopTimer(id);
        properties.timers[id].count=0;
        startTimer(id);
        return(true);
      },

    /**
     * remove a timer
     * timer if stopped is necessary
     *
     * @param String Id: timer Id
     * @return Boolean: true if removed, otherwise false
     */
    removeTimer = function (id)
      {
        if(properties.timers[id]==null) return(false);

        stopTimer(id);
        delete properties.timers[id];
        return(true);
      },

    /**
     * set the limit of execution
     *
     * @param String Id: timer Id
     * @param Integer value: limit to apply
     * @return Boolean: true if limit is set, otherwise false
     */
    setLimit = function (id, value)
      {
        if(properties.timers[id]==null || Math.round(value)<0) return(false);
        properties.timers[id].limit=Math.round(value);
      },

    /**
     * set the frequency of execution
     *
     * @param String Id: timer Id
     * @param Integer value: frequency (in milliseconds) to apply
     * @return Boolean: true if frequency is set, otherwise false
     */
    setFrequency = function (id, value)
      {
        if(properties.timers[id]==null || Math.round(value)<=0) return(false);
        properties.timers[id].frequency=Math.round(value);
        stopTimer(id);
        startTimer(id);
        return(true);
      },

    /**
     * internal callback
     * called when a timer is triggered; if a callback function is set for the
     * timer, execute it
     *
     *
     * @param String Id: timer Id
     * @return Boolean: true if callback is called, otherwise false
     */
    callFunction = function (id)
      {
        var noLimit=true,
            last=false;

        if(properties.timers[id]==null) return(false);
        properties.timers[id].count++;

        noLimit=(properties.timers[id].limit==0);
        last=(!noLimit && (properties.timers[id].count==properties.timers[id].limit));

        if(last)
          stopTimer(id);

        if(properties.timers[id].timer)
          properties.timers[id].timer(
            properties.timers[id].count,
            last
          );

        return(true);
      },

    // save current data in global stack
    setData = function ()
      {
        $(window).data('timerProperties', properties.timers);
      },

    // load current data from global stack
    getData = function ()
      {
        var tmp=$(window).data('timerProperties');
        if(tmp!=null) properties.timers=tmp;
      }

  getData();

  switch(value1)
  {
    case 'start':
      returned=startTimer(id);
      break;
    case 'stop':
      returned=stopTimer(id);
      break;
    case 'reset':
      returned=resetTimer(id);
      break;
    case 'count':
      getData();
      if(!properties.timers[id]) return(-1);
      returned=properties.timers[id].count;
      break;
    case 'limit':
      getData();
      if(!properties.timers[id]) return(-1);

      if(value2!=null)
        setLimit(id, value2);
      returned=properties.timers[id].limit;
      break;
    case 'frequency':
      getData();
      if(!properties.timers[id]) return(-1);

      if(value2!=null)
        setFrequency(id, value2);
      returned=properties.timers[id].frequency;
      break;
    case 'remove':
      returned=removeTimer(id);
      break;
    default:
      setTimer(id, value1);
      break;
  }

  setData();
  return(returned);
} // $.timer
