<?php
/* -----------------------------------------------------------------------------
  class name: GPCUserAgent
  class version  : 1.0.1
  plugin version : 3.5.4
  date           : 2012-09-04
  ------------------------------------------------------------------------------
  author: grum at piwog.org
  << May the Little SpaceFrog be with you >>
  ------------------------------------------------------------------------------


| release | date       |
| 1.0.1   | 2012/09/04 | * Fix some bot definition
|         |            |
|         |            |

   ---------------------------------------------------------------------- */

require_once('GPCUserAgent.const.inc.php');

class GPCUserAgent
{
  /**
   * parse a user agent string and return an array of normalized informations
   *
   * returned:
   *  array(
   *    'os'               => (integer)
   *    'os_version'       => (string)
   *    'browser'          => (integer)
   *    'browser_name'     => (string)
   *    'browser_type'     => (integer)
   *    'browser_version'  => (string)
   *    'engine'           => (integer)
   *    'engine_version'   => (string)
   *  )
   *
   * @param String $userAgent
   * @return Array
   */
  static public function parse($userAgent)
  {
    $returned=array(
      UA_DATA_OS              => UA_OS_UNKNOWN,
      UA_DATA_OS_VERSION      => '',

      UA_DATA_BROWSER         => UA_BOT_UNKNOWN,
      UA_DATA_BROWSER_NAME    => '',
      UA_DATA_BROWSER_TYPE    => UA_BROWSER_TYPE_UNKNOWN,
      UA_DATA_BROWSER_VERSION => '',

      UA_DATA_ENGINE          => UA_ENGINE_UNKNOWN,
      UA_DATA_ENGINE_VERSION  => ''
    );

    $bot=self::getBot($userAgent);
    if($bot[UA_DATA_BROWSER]!=='')
    {
      $returned[UA_DATA_BROWSER]=$bot[UA_DATA_BROWSER];
      $returned[UA_DATA_BROWSER_TYPE]=UA_BROWSER_TYPE_CRAWLER;
      $returned[UA_DATA_BROWSER_VERSION]=str_replace(array(';', '(', ')'), array('', '', ''), $bot[UA_DATA_BROWSER_VERSION]);
      return($returned);
    }

    $tmp=self::getBrowser($userAgent);
    $returned[UA_DATA_BROWSER]=$tmp[UA_DATA_BROWSER];
    $returned[UA_DATA_BROWSER_TYPE]=GPCUserAgentValues::$UA_BrowserInfo[UA_DATA_BROWSER][$tmp[UA_DATA_BROWSER]][UA_PROP_TYPE];
    $returned[UA_DATA_BROWSER_VERSION]=str_replace(array(';', '(', ')'), array('', '', ''), $tmp[UA_DATA_BROWSER_VERSION]);

    $tmp=self::getOs($userAgent);
    $returned[UA_DATA_OS]=$tmp[UA_DATA_OS];
    $returned[UA_DATA_OS_VERSION]=str_replace(array(';', '(', ')'), array('', '', ''), $tmp[UA_DATA_OS_VERSION]);

    $tmp=self::getEngine($userAgent);
    $returned[UA_DATA_ENGINE]=$tmp[UA_DATA_ENGINE];
    $returned[UA_DATA_ENGINE_VERSION]=str_replace(array(';', '(', ')'), array('', '', ''), $tmp[UA_DATA_ENGINE_VERSION]);

    // explicit OS for mobile device override the browser type
    if($returned[UA_DATA_OS]==UA_OS_BLACKBERRY or
        $returned[UA_DATA_OS]==UA_OS_SYMBIAN_OS or
        $returned[UA_DATA_OS]==UA_OS_SYMBOS or
        $returned[UA_DATA_OS]==UA_OS_ANDROID or
        $returned[UA_DATA_OS]==UA_OS_IOS) $returned[UA_DATA_BROWSER_TYPE]=UA_BROWSER_TYPE_MOBILE;

    // explicit OS for console device override the browser type
    if($returned[UA_DATA_OS]==UA_OS_NINTENDO_DS or
        $returned[UA_DATA_OS]==UA_OS_NINTENDO_WII or
        $returned[UA_DATA_OS]==UA_OS_SONY_PS3 or
        $returned[UA_DATA_OS]==UA_OS_SONY_PSP) $returned[UA_DATA_BROWSER_TYPE]=UA_BROWSER_TYPE_CONSOLE;

    return($returned);
  }


  /**
   * from a user agent array properties, return an array completed with associated
   * properties
   *
   * @param Array $userAgent
   * @return Array
   */
  static public function getProperties($userAgent)
  {
    $returned=array();
    if(isset($userAgent[UA_DATA_BROWSER]) and isset(GPCUserAgentValues::$UA_BrowserInfo[UA_DATA_BROWSER][$userAgent[UA_DATA_BROWSER]]))
    {
      $returned[UA_DATA_BROWSER]=$userAgent[UA_DATA_BROWSER];
      $returned[UA_DATA_BROWSER_NAME]=GPCUserAgentValues::$UA_BrowserInfo[UA_DATA_BROWSER][$userAgent[UA_DATA_BROWSER]][UA_PROP_NAME];
      $returned[UA_DATA_BROWSER_URL]=GPCUserAgentValues::$UA_BrowserInfo[UA_DATA_BROWSER][$userAgent[UA_DATA_BROWSER]][UA_PROP_URL];
    }

    if(!isset($userAgent[UA_DATA_BROWSER_TYPE]) and isset($userAgent[UA_DATA_BROWSER]))
      $userAgent[UA_DATA_BROWSER_TYPE]=GPCUserAgentValues::$UA_BrowserInfo[UA_DATA_BROWSER][$userAgent[UA_DATA_BROWSER]][UA_PROP_TYPE];

    if(isset($userAgent[UA_DATA_BROWSER_TYPE]) and isset(GPCUserAgentValues::$UA_BrowserInfo[UA_DATA_BROWSER_TYPE][$userAgent[UA_DATA_BROWSER_TYPE]]))
    {
      $returned[UA_DATA_BROWSER_TYPE]=$userAgent[UA_DATA_BROWSER_TYPE];
      $returned[UA_DATA_BROWSER_TYPE_NAME]=GPCUserAgentValues::$UA_BrowserInfo[UA_DATA_BROWSER_TYPE][$userAgent[UA_DATA_BROWSER_TYPE]];
    }


    if(isset($userAgent[UA_DATA_OS]) and isset(GPCUserAgentValues::$UA_BrowserInfo[UA_DATA_OS][$userAgent[UA_DATA_OS]]))
    {
      $returned[UA_DATA_OS]=$userAgent[UA_DATA_OS];
      $returned[UA_DATA_OS_NAME]=GPCUserAgentValues::$UA_BrowserInfo[UA_DATA_OS][$userAgent[UA_DATA_OS]][UA_PROP_NAME];
      $returned[UA_DATA_OS_URL]=GPCUserAgentValues::$UA_BrowserInfo[UA_DATA_OS][$userAgent[UA_DATA_OS]][UA_PROP_URL];
    }

    if(isset($userAgent[UA_DATA_ENGINE]) and isset(GPCUserAgentValues::$UA_BrowserInfo[UA_DATA_ENGINE][$userAgent[UA_DATA_ENGINE]]))
    {
      $returned[UA_DATA_ENGINE]=$userAgent[UA_DATA_ENGINE];
      $returned[UA_DATA_ENGINE_NAME]=GPCUserAgentValues::$UA_BrowserInfo[UA_DATA_ENGINE][$userAgent[UA_DATA_ENGINE]][UA_PROP_NAME];
      $returned[UA_DATA_ENGINE_URL]=GPCUserAgentValues::$UA_BrowserInfo[UA_DATA_ENGINE][$userAgent[UA_DATA_ENGINE]][UA_PROP_URL];
    }

    return($returned);
  }


  /**
   * return bot properties
   * if user agent is not a bot, properties are filled with string
   *
   * @param String $userAgent : user agent string to parse
   * @return Array
   */
  static private function getBot($userAgent)
  {
    $botList=array(
      '(008)\/(\S*)[\;]'                                => UA_BOT_008,
      '(abachobot)'                                     => UA_BOT_ABACHOBOT,
      '(accoona-ai-agent)(?:\/(\S*))*'                  => UA_BOT_ACCOONA_AI_AGENT,
      '(arachmo)'                                       => UA_BOT_ARACHMO,
      '(b-l-i-t-z-b-o-t)'                               => UA_BOT_BLITZBOT,
      '(blitzbot)'                                      => UA_BOT_BLITZBOT,
      '(bingbot)\/(\S*)[\;]'                            => UA_BOT_MICROSOFT_BING,
      '(bingbot)(?:\/(\S*))*'                           => UA_BOT_MICROSOFT_BING,
      '(charlotte)\/(\S*)[\;]'                          => UA_BOT_CHARLOTTE,
      '(charlotte)(?:\/(\S*))*'                         => UA_BOT_CHARLOTTE,
      '(cerberian drtrs)\sversion-(\S*)[\)]'            => UA_BOT_CERBERIAN_DRTRS,
      '(cosmos)\/(\S*)[\_]'                             => UA_BOT_COSMOS,
      '(covario-ids)(?:\/(\S*))*'                       => UA_BOT_COVARIO_IDS,
      '(dataparksearch)\/(\S*)[\-]'                     => UA_BOT_DATAPARKSEARCH,
      '(dataparksearch)(?:\/(\S*))*'                    => UA_BOT_DATAPARKSEARCH,
      '(gaisbot)\/(\S*)[\(\s]'                          => UA_BOT_GAISBOT,
      '(google)(?:\/(\S*))*'                            => UA_BOT_GOOGLE,
      '(googlebot)\/(\S*);'                             => UA_BOT_GOOGLE,
      '(googlebot)(?:\/(\S*))*'                         => UA_BOT_GOOGLE,
      '(googlebot-image)(?:\/(\S*))*'                   => UA_BOT_GOOGLE,
      '(gurujibot)\/(\S*);'                             => UA_BOT_GURUJIBOT,
      '(gurujibot)(?:\/(\S*))*'                         => UA_BOT_GURUJIBOT,
      '(holmes)(?:\/(\S*))*'                            => UA_BOT_HOLMES,
      '(htdig)(?:\/(\S*))*'                             => UA_BOT_HTDIG,
      '(ia_archiver)\/(\S*)'                            => UA_BOT_IA_ARCHIVER,
      '(ia_archiver)'                                   => UA_BOT_IA_ARCHIVER,
      '(iccrawler)'                                     => UA_BOT_ICCRAWLER,
      '(ichiro)\/(\S*)\('                               => UA_BOT_ICHIRO,
      '(ichiro)(?:\/(\S*))*'                            => UA_BOT_ICHIRO,
      '(l.webis)(?:\/(\S*))*'                           => UA_BOT_LWEBIS,
      '(larbin)'                                        => UA_BOT_LARBIN,
      '(linkwalker)(?:\/(\S*))*'                        => UA_BOT_LINKWALKER,
      '(lwp-trivial)(?:\/(\S*))*'                       => UA_BOT_LWPTRIVIAL,
      '(mabontland)'                                    => UA_BOT_MABONLAND,
      '(mnogosearch)'                                   => UA_BOT_MNOGOSEARCH,
      '(mogimogi)(?:\/(\S*))*'                          => UA_BOT_MOGIMOGI,
      '(morning\spaper)'                                => UA_BOT_MORNINGPAPER,
      '(netresearchserver)\/(\S*)\('                    => UA_BOT_NETRESEARCHSERVER,
      '(netresearchserver)(?:\/(\S*))*'                 => UA_BOT_NETRESEARCHSERVER,
      '(newsgator)(?:\/(\S*))*'                         => UA_BOT_NEWSGATOR,
      '(ng-search)(?:\/(\S*))*'                         => UA_BOT_NGSEARCH,
      '(nymesis)(?:\/(\S*))*'                           => UA_BOT_NYMESIS,
      '(oegp)'                                          => UA_BOT_OEGP,
      '(pompos)(?:\/(\S*))*'                            => UA_BOT_POMPOS,
      '(pycurl)(?:\/(\S*))*'                            => UA_BOT_PYCURL,
      '(qseero)'                                        => UA_BOT_QSEERO,
      '(sbider)(?:\/(\S*))*'                            => UA_BOT_SBIDER,
      '(scoutjet)'                                      => UA_BOT_SCOUTJET,
      '(scrubby)(?:\/(\S*))*'                           => UA_BOT_SCRUBBY,
      '(searchsight)(?:\/(\S*))*'                       => UA_BOT_SEARCHSIGHT,
      '(semanticdiscovery)(?:\/(\S*))*'                 => UA_BOT_SEMANTICDISCOVERY,

      '(shoula)'                                        => UA_BOT_SHOULA,
      '(snappy)(?:\/(\S*))*'                            => UA_BOT_SNAPPY,
      '(stackrambler)(?:\/(\S*))*'                      => UA_BOT_STACKRAMBLER,
      '(silk)(?:\/(\S*))*'                              => UA_BOT_SILK,
      '(teoma)'                                         => UA_BOT_TEOMA,
      '(tineye)(?:\/(\S*))*'                            => UA_BOT_TINEYE,
      '(truwogps)(?:\/(\S*))*'                          => UA_BOT_TRUWOGPS,
      '(updated)(?:\/(\S*))*'                           => UA_BOT_UPDATED,
      '(voyager)(?:\/(\S*))*'                           => UA_BOT_VOYAGER,
      '(vyu2)'                                          => UA_BOT_VYU2,
      '(webcollage)(?:\/(\S*))*'                        => UA_BOT_WEBCOLLAGE,
      '(yooglifetchagent)(?:\/(\S*))*'                  => UA_BOT_YOOGLIFETCHAGENT,
      '(zao)(?:\/(\S*))*'                               => UA_BOT_ZAO,
      '(zealbot)'                                       => UA_BOT_ZEALBOT,
      '(baiduspider)'                                   => UA_BOT_BAIDU,
      '(msnbot)\/(\d+(?:\.\d+)*)'                       => UA_BOT_MSN_SEARCH,
      '(msnbot)\s(\d+(?:\.\d+)*)'                       => UA_BOT_MSN_SEARCH,
      '(exabot)\/(\d+(?:\.\d+)*)'                       => UA_BOT_EXALEAD,
      '(gamespyhttp)\/(\d+(?:\.\d+)*)'                  => UA_BOT_GAMESPY,
      '(gigabot)\/(\d+(?:\.\d+)*)'                      => UA_BOT_GIGABLAST,
      '(inktomi)'                                       => UA_BOT_INKTOMI,
      '(Yahoo! Slurp)'                                  => UA_BOT_YAHOO_SEARCH,
      '(yahooseeker)'                                   => UA_BOT_YAHOO_SEARCH,
      '\s*([a-z]*(?:bot|spyder|crawl|crawler|spider)[a-z]*)'  => UA_BOT_UNKNOWN
    );

    $returned=array(
      UA_DATA_BROWSER => '',
      //'name' => '',
      UA_DATA_BROWSER_VERSION => ''
    );

    $result=array();
    foreach($botList as $regExp => $crawler)
    {
      if(preg_match('/'.$regExp.'/i',$userAgent,$result))
      {
        // exclude some case
        if($crawler==UA_BOT_UNKNOWN and preg_match('/(?:msiecrawler)/i', $userAgent))
          return($returned);

        $returned=array(
          UA_DATA_BROWSER => $crawler,
          //'name' => $result[1], #retrieved from the code
          UA_DATA_BROWSER_VERSION => isset($result[2])?$result[2]:''
        );
        return($returned);
      }
    }

    return($returned);
  }


  /**
   * return browser properties
   *
   * @param String $userAgent : user agent string to parse
   * @return Array
   */
  static private function getBrowser($userAgent)
  {
    $browserList=array(
      '(android).*applewebkit.*(?:version\/(\S*))(?:safari)?' => UA_BROWSER_ANDROID_WEBKIT,
      '(opera mini)\/(\S*)\/'                                 => UA_BROWSER_OPERA_MINI,
      '(opera mini)\/(\S*)'                                   => UA_BROWSER_OPERA_MINI,
      '(opera mobi).*(?:version\/(\S*))'                      => UA_BROWSER_OPERA_MOBILE,
      '(opera mobi)'                                          => UA_BROWSER_OPERA_MOBILE,
      '(blackberry).*version\/(\S*)'                          => UA_BROWSER_BLACKBERRY,
      '(blackberry\d*)\/(\S*)'                                => UA_BROWSER_BLACKBERRY,
      '(blackberry)'                                          => UA_BROWSER_BLACKBERRY,
      '(bunjalloo)\/(\S*)[\;\(]'                              => UA_BROWSER_BUNJALLOO,
      '(Fennec)\/(\S*)'                                       => UA_BROWSER_FENNEC,
      '(gobrowser)\/(\S*)'                                    => UA_BROWSER_GOBROWSER,
      '(gobrowser)'                                           => UA_BROWSER_GOBROWSER,
      '(iemobile)\/(\S*)[\;\)]'                               => UA_BROWSER_IEMOBILE,
      '(iemobile)\s(\S*)[\;\)]'                               => UA_BROWSER_IEMOBILE,
      '(iris)\/(\S*)'                                         => UA_BROWSER_IRIS,
      '(maemo browser)\s(\S*)'                                => UA_BROWSER_MAEMO_BROWSER,
      '(mib)\/(\S*)'                                          => UA_BROWSER_MIB,
      '(minimo)\/(\S*)'                                       => UA_BROWSER_MINIMO,
      '(netfront)\/(\S*)'                                     => UA_BROWSER_NETFRONT,
      '(SEMC-Browser)\/(\S*)'                                 => UA_BROWSER_SEMC,
      '(teashark)\/(\S*)'                                     => UA_BROWSER_TEASHARK,

      '(playstation 3);\s*(\S*)[\;\)]'                        => UA_BROWSER_PS3,
      '(playstation 3)'                                       => UA_BROWSER_PS3,
      '(PSP \(PlayStation Portable\));\s*(\S*)[\;\)]'         => UA_BROWSER_PSP,
      '(PSP \(PlayStation Portable\));\s*(\S*)'               => UA_BROWSER_PSP,

      '(opera)\/(\S*)\s.*(?:nintendo)'                        => UA_BROWSER_OPERA_WII,
      '(opera).*(?:version\/(\S*))'                           => UA_BROWSER_OPERA,
      '(opera)\/(\S*)'                                        => UA_BROWSER_OPERA,
      '(opera)\s(\S*)'                                        => UA_BROWSER_OPERA,
      '(shiira)\/(\S*)'                                       => UA_BROWSER_SHIIRA,
      '(shiira)'                                              => UA_BROWSER_SHIIRA,
      '(skyfire)\/(\S*)'                                      => UA_BROWSER_SKYFIRE,
      '(thunderbird)\/(\S*)'                                  => UA_BROWSER_THUNDERBIRD,
      '(namoroka)\/(\S*)'                                     => UA_BROWSER_NAMOROKA,
      '(minefield)\/(\S*)'                                    => UA_BROWSER_MINEFIELD,
      '(lunascape)\/(\S*)'                                    => UA_BROWSER_LUNASCAPE,
      '(lunascape)\s(\S*)[\;\)]'                              => UA_BROWSER_LUNASCAPE,
      '(lunascape)\s(.*)[\;\)]'                               => UA_BROWSER_LUNASCAPE,
      '(lunascape)'                                           => UA_BROWSER_LUNASCAPE,
      '(arora)\/(\S*)'                                        => UA_BROWSER_ARORA,
      '(camino)\/(\S*)'                                       => UA_BROWSER_CAMINO,
      '(kapiko)\/(\S*)'                                       => UA_BROWSER_KAPIKO,
      '(kazehakase)\/(\S*)'                                   => UA_BROWSER_KAZEHAKAZE,
      '(chromeplus)\/(\S*)'                                   => UA_BROWSER_CHROMEPLUS,
      '(chrome)\/(\S*)'                                       => UA_BROWSER_CHROME,
      '(epiphany)\/(\S*)'                                     => UA_BROWSER_EPIPHANY,
      '(epiphany)'                                            => UA_BROWSER_EPIPHANY,
      '(galeon)\/(\S*)'                                       => UA_BROWSER_GALEON,
      '(orca)\/(\S*)'                                         => UA_BROWSER_ORCA,
      '(lobo)\/(\S*)'                                         => UA_BROWSER_LOBO,
      '(seamonkey)\/(\S*)'                                    => UA_BROWSER_SEAMONKEY,
      '(midori)\/(\S*)'                                       => UA_BROWSER_MIDORI,
      '(midori)'                                              => UA_BROWSER_MIDORI,
      '(maxthon)\/(\S*)'                                      => UA_BROWSER_MAXTHON,
      '(maxthon)\s?(\S*)[\);]'                                => UA_BROWSER_MAXTHON,
      '(iceape)\/(\S*)'                                       => UA_BROWSER_ICEAPE,
      '(iceweasel)\/(\S*)'                                    => UA_BROWSER_ICEWEASEL,
      '(netscape\d?)\/(\S*)'                                  => UA_BROWSER_NETSCAPE,
      '(navigator)\/(\S*)'                                    => UA_BROWSER_NETSCAPE,
      '(firebird)\/(\S*)'                                     => UA_BROWSER_FIREBIRD,
      '(firefox)\/(\S*)'                                      => UA_BROWSER_FIREFOX,
      '(msie)\s?(\S*)[\);]'                                   => UA_BROWSER_INTERNET_EXPLORER,
      '(konqueror)\/(\S*)[\);]'                               => UA_BROWSER_KONQUEROR,
      '(links)\s?\((\S*)[\);]'                                => UA_BROWSER_LINKS,
      '(lynx)\/(\S*)'                                         => UA_BROWSER_LYNX,
      '(safari)|version\/(\S*)'                               => UA_BROWSER_SAFARI,
      '(mozilla)\/(\S*)'                                      => UA_BROWSER_NETSCAPE
    );

    $returned=array(
      UA_DATA_BROWSER => UA_BROWSER_UNKNOWN,
      //'name' => '',
      UA_DATA_BROWSER_VERSION => ''
    );

    $result=array();
    foreach($browserList as $regExp => $browser)
    {
      if(preg_match('/'.$regExp.'/i',$userAgent,$result))
      {
        //echo print_r($userAgent, true).print_r($result, true);
        if(is_array($result) and count($result)>=2)
        {
          if($browser==UA_BROWSER_SAFARI and preg_match('/iphone|ipad|ipod/i', $userAgent))
            $browser=UA_BROWSER_SAFARI_MOBILE;

          $returned=array(
            UA_DATA_BROWSER => $browser,
            //'name' => $result[1],
            UA_DATA_BROWSER_VERSION => isset($result[2])?$result[2]:''
          );
        }
        else
        {
          $returned=array(
            UA_DATA_BROWSER => UA_BROWSER_UNKNOWN,
            //'name' => '',
            UA_DATA_BROWSER_VERSION => ''
          );
        }
        return($returned);
      }
    }
    return($returned);
  }


  /**
   * return OS properties
   *
   * @param String $userAgent : user agent string to parse
   * @return Array
   */
  static private function getOs($userAgent)
  {
    $osList=array(
      '(android)\s?(\S*)[\;\)]'                               => UA_OS_ANDROID,
      '(android)\s?(\S*)'                                     => UA_OS_ANDROID,
      '(linux)'                                               => UA_OS_LINUX,
      '(freebsd)'                                             => UA_OS_FREEBSD,
      '(openbsd)'                                             => UA_OS_OPENBSD,
      '(netbsd)'                                              => UA_OS_NETBSD,
      '(sunos)'                                               => UA_OS_SUNOS,
      '(blackberry)\s?([^;.]*);'                              => UA_OS_BLACKBERRY,
      '(blackberry)'                                          => UA_OS_BLACKBERRY,
      '(symbianos)'                                           => UA_OS_SYMBIAN_OS,
      '(symbos)'                                              => UA_OS_SYMBOS,
      '(windows)\s?(phone\sos\s\S*)[\;\)]'                    => UA_OS_WINDOWS,
      '(windows)\s?(phone\sos\s\S*)'                          => UA_OS_WINDOWS,
      '(windows)\s?(ce\s?\S*)[\;\)]'                          => UA_OS_WINDOWS,
      '(windows)\s?(ce\s?\S*)'                                => UA_OS_WINDOWS,
      '(windows)\s?(NT\s?\S*)[\;\)]'                          => UA_OS_WINDOWS,
      '(windows)\s?(NT\s?\S*)'                                => UA_OS_WINDOWS,
      '(windows)\s?(\S*)[\;\)]'                               => UA_OS_WINDOWS,
      '(windows)\s?(\S*)'                                     => UA_OS_WINDOWS,
      '(winnt)'                                               => UA_OS_WINDOWS,
      '(win98)'                                               => UA_OS_WINDOWS,
      '(win95)'                                               => UA_OS_WINDOWS,
      '(mac_powerpc)'                                         => UA_OS_MACINTOSH,
      '(cpu\siphone\sos)\s?(\S*)'                             => UA_OS_IOS,
      '(iphone|ipad|ipod);.*(?:cpu\sos\s(\S*))'               => UA_OS_IOS,
      '(mac\sos\sx)\s(\S*)[\;\)]'                             => UA_OS_MAC_OS_X,
      '(mac\sos\sx)\s(\S*)'                                   => UA_OS_MAC_OS_X,
      '(mac\sos\sx)'                                          => UA_OS_MAC_OS_X,
      '(nintendo\swii).*;\s([0-9\-]*);'                       => UA_OS_NINTENDO_WII,
      '(playstation\s3)'                                      => UA_OS_SONY_PS3,
      '(playstation\sportable)'                               => UA_OS_SONY_PSP,
      '(nintendo\sds)'                                        => UA_OS_NINTENDO_DS,
      '(cros)(?:\s*i\d*)(?:\s(\S*))'                          => UA_OS_CHROME_OS,
      '(cros)'                                                => UA_OS_CHROME_OS,
      '(beos)'                                                => UA_OS_BE_OS,
      '(dragonfly)'                                           => UA_OS_DRAGONFLY,
      '(unix)'                                                => UA_OS_UNIX,
      '(darwin)'                                              => UA_OS_DARWIN,
      '(macintosh)'                                           => UA_OS_MACINTOSH,
      '(fedora)'                                              => UA_OS_LINUX,
      '(os\/2).*(warp(?:\s\S*));'                             => UA_OS_OS2,
      '(os\/2)'                                               => UA_OS_OS2,
      '(amigaos)(?:\s(\S*))'                                  => UA_OS_AMIGAOS,
      '(amigaos)'                                             => UA_OS_AMIGAOS
    );

    $returned=array(
      UA_DATA_OS => UA_OS_UNKNOWN,
      //'name' => '',
      UA_DATA_OS_VERSION => ''
    );

    $result=array();
    foreach($osList as $regExp => $os)
    {
      if(preg_match('/'.$regExp.'/i',$userAgent,$result))
      {
        $returned=array(
          UA_DATA_OS => $os,
          //'name' => $result[1],
          UA_DATA_OS_VERSION => isset($result[2])?$result[2]:''
        );
        switch($os)
        {
          case UA_OS_WINDOWS:
            switch($returned[UA_DATA_OS_VERSION])
            {
              case 'NT 5.0':
                  $returned['version']='2000';
                break;
              case 'NT 5.1':
                  $returned['version']='XP';
                break;
              case 'NT 5.2':
                  $returned['version']='Server 2003';
                break;
              case 'NT 6.0':
                  $returned['version']='Vista';
                break;
              case 'NT 6.1':
                  $returned['version']='Seven';
                break;
              default;
                break;
            }
            break;
        }

        return($returned);
      }
    }

    return($returned);
  }

  /**
   * return engine properties
   *
   * @param String $userAgent : user agent string to parse
   * @return Array
   */
  static private function getEngine($userAgent)
  {
    $engineList=array(
      '(presto)(?:\/(\S*))*'           => UA_ENGINE_PRESTO,
      '(applewebkit)(?:\/(\S*))*'      => UA_ENGINE_APPLEWEBKIT,
      '(webkit)(?:\/(\S*))*'           => UA_ENGINE_WEBKIT,
      '(khtml)(?:\/(\S*))*'            => UA_ENGINE_KHTML,
      '(gecko)(?:\/(\S*))*'            => UA_ENGINE_GECKO,
      '(trident)(?:\/(\S*))*'          => UA_ENGINE_TRIDENT
    );

    $returned=array(
      UA_DATA_ENGINE => UA_ENGINE_UNKNOWN,
      //'name' => '',
      UA_DATA_ENGINE_VERSION => ''
    );

    $result=array();
    foreach($engineList as $regExp => $engine)
    {
      if(preg_match('/'.$regExp.'/i',$userAgent,$result))
      {
        $returned=array(
          UA_DATA_ENGINE => $engine,
          //'name' => $result[1],
          UA_DATA_ENGINE_VERSION => isset($result[2])?$result[2]:''
        );
        return($returned);
      }
    }

    return($returned);
  }
} // GPCUserAgent class


?>
