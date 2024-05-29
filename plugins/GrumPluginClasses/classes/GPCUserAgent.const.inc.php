<?php

/**
 * -- UA_DATA --
 * Data types : bot, browser, engine, os
 */
define('UA_DATA',                     0x0000);

define('UA_DATA_BROWSER',             0x0001);
define('UA_DATA_ENGINE',              0x0002);
define('UA_DATA_OS',                  0x0003);

define('UA_DATA_BROWSER_NAME',        0x0011);
define('UA_DATA_OS_NAME',             0x0012);
define('UA_DATA_ENGINE_NAME',         0x0013);

define('UA_DATA_BROWSER_VERSION',     0x0021);
define('UA_DATA_ENGINE_VERSION',      0x0022);
define('UA_DATA_OS_VERSION',          0x0023);

define('UA_DATA_BROWSER_TYPE',        0x0031);
define('UA_DATA_BROWSER_TYPE_NAME',   0x0131);
define('UA_DATA_OS_TYPE',             0x0033);
define('UA_DATA_OS_TYPE_NAME',        0x0133);

define('UA_DATA_BROWSER_URL',         0x0041);
define('UA_DATA_ENGINE_URL',          0x0042);
define('UA_DATA_OS_URL',              0x0043);



/**
 * -- UA_PROP --
 * Index properties for bot, browser, engine, ...
 */
define('UA_PROP_NAME',                0x01);
define('UA_PROP_URL',                 0x02);
define('UA_PROP_TYPE',                0x03);

/**
 * -- UA_DATA_BROWSER_TYPE --
 * Indexes for UA_DATA_BROWSER_TYPE information (computer, mobile, console, ...)
 */
define('UA_BROWSER_TYPE_UNKNOWN',   0x00);
define('UA_BROWSER_TYPE_COMPUTER',  0x01);
define('UA_BROWSER_TYPE_MOBILE',    0x02);
define('UA_BROWSER_TYPE_CONSOLE',   0x03);
define('UA_BROWSER_TYPE_CRAWLER',   0x04);

/**
 * -- UA_BOT --
 * Known bots
 */
define('UA_BOT_UNKNOWN',              0x0000);
define('UA_BOT_008',                  0x0001);
define('UA_BOT_ABACHOBOT',            0x0002);
define('UA_BOT_ARACHMO',              0x0003);
define('UA_BOT_BLITZBOT',             0x0004);
define('UA_BOT_MICROSOFT_BING',       0x0005);
define('UA_BOT_CHARLOTTE',            0x0006);
define('UA_BOT_CERBERIAN_DRTRS',      0x0007);
define('UA_BOT_COSMOS',               0x0008);
define('UA_BOT_COVARIO_IDS',          0x0009);
define('UA_BOT_DATAPARKSEARCH',       0x000A);
define('UA_BOT_GAISBOT',              0x000B);
define('UA_BOT_GOOGLE',               0x000C);
define('UA_BOT_GURUJIBOT',            0x000D);
define('UA_BOT_HOLMES',               0x000E);
define('UA_BOT_HTDIG',                0x000F);
define('UA_BOT_IA_ARCHIVER',          0x0010);
define('UA_BOT_ICCRAWLER',            0x0011);
define('UA_BOT_ICHIRO',               0x0012);
define('UA_BOT_BAIDU',                0x0013);
define('UA_BOT_MSN_SEARCH',           0x0014);
define('UA_BOT_EXALEAD',              0x0015);
define('UA_BOT_GAMESPY',              0x0016);
define('UA_BOT_GIGABLAST',            0x0017);
define('UA_BOT_INKTOMI',              0x0018);
define('UA_BOT_YAHOO_SEARCH',         0x0019);
define('UA_BOT_ACCOONA_AI_AGENT',     0x001A);
define('UA_BOT_LWEBIS',               0x001B);
define('UA_BOT_LARBIN',               0x001C);
define('UA_BOT_LINKWALKER',           0x001D);
define('UA_BOT_LWPTRIVIAL',           0x001E);
define('UA_BOT_MABONLAND',            0x001F);
define('UA_BOT_MNOGOSEARCH',          0x0020);
define('UA_BOT_MOGIMOGI',             0x0021);
define('UA_BOT_MORNINGPAPER',         0x0022);
define('UA_BOT_NETRESEARCHSERVER',    0x0023);
define('UA_BOT_NEWSGATOR',            0x0024);
define('UA_BOT_NGSEARCH',             0x0025);
define('UA_BOT_NYMESIS',              0x0026);
define('UA_BOT_OEGP',                 0x0027);
define('UA_BOT_POMPOS',               0x0028);
define('UA_BOT_PYCURL',               0x0029);
define('UA_BOT_QSEERO',               0x002A);
define('UA_BOT_SBIDER',               0x002B);
define('UA_BOT_SCOUTJET',             0x002C);
define('UA_BOT_SCRUBBY',              0x002D);
define('UA_BOT_SEARCHSIGHT',          0x002E);
define('UA_BOT_SEMANTICDISCOVERY',    0x002F);
define('UA_BOT_SHOULA',               0x0030);
define('UA_BOT_SNAPPY',               0x0031);
define('UA_BOT_STACKRAMBLER',         0x0032);
define('UA_BOT_SILK',                 0x0033);
define('UA_BOT_TEOMA',                0x0034);
define('UA_BOT_TINEYE',               0x0035);
define('UA_BOT_TRUWOGPS',             0x0036);
define('UA_BOT_UPDATED',              0x0037);
define('UA_BOT_VOYAGER',              0x0038);
define('UA_BOT_VYU2',                 0x0039);
define('UA_BOT_WEBCOLLAGE',           0x003A);
define('UA_BOT_YOOGLIFETCHAGENT',     0x003B);
define('UA_BOT_ZAO',                  0x003C);
define('UA_BOT_ZEALBOT',              0x003D);


/**
 * -- UA_BROWSER --
 * Known browsers
 */
define('UA_BROWSER_UNKNOWN',          0x1000);
define('UA_BROWSER_ANDROID_WEBKIT',   0x1001);
define('UA_BROWSER_OPERA_MINI',       0x1002);
define('UA_BROWSER_OPERA_MOBILE',     0x1003);
define('UA_BROWSER_BLACKBERRY',       0x1004);
define('UA_BROWSER_BUNJALLOO',        0x1005);
define('UA_BROWSER_FENNEC',           0x1006);
define('UA_BROWSER_GOBROWSER',        0x1007);
define('UA_BROWSER_IEMOBILE',         0x1008);
define('UA_BROWSER_IRIS',             0x1009);
define('UA_BROWSER_MAEMO_BROWSER',    0x100A);
define('UA_BROWSER_MIB',              0x1010);
define('UA_BROWSER_MINIMO',           0x1011);
define('UA_BROWSER_NETFRONT',         0x1012);
define('UA_BROWSER_SEMC',             0x1013);
define('UA_BROWSER_TEASHARK',         0x1014);
define('UA_BROWSER_PS3',              0x1015);
define('UA_BROWSER_PSP',              0x1016);
define('UA_BROWSER_OPERA',            0x1017);
define('UA_BROWSER_SHIIRA',           0x1018);
define('UA_BROWSER_SKYFIRE',          0x1019);
define('UA_BROWSER_THUNDERBIRD',      0x101A);
define('UA_BROWSER_NAMOROKA',         0x101B);
define('UA_BROWSER_MINEFIELD',        0x101C);
define('UA_BROWSER_LUNASCAPE',        0x101D);
define('UA_BROWSER_ARORA',            0x101E);
define('UA_BROWSER_CAMINO',           0x101F);
define('UA_BROWSER_KAPIKO',           0x1020);
define('UA_BROWSER_KAZEHAKAZE',       0x1021);
define('UA_BROWSER_CHROMEPLUS',       0x1022);
define('UA_BROWSER_CHROME',           0x1023);
define('UA_BROWSER_EPIPHANY',         0x1024);
define('UA_BROWSER_GALEON',           0x1025);
define('UA_BROWSER_ORCA',             0x1026);
define('UA_BROWSER_LOBO',             0x1027);
define('UA_BROWSER_SEAMONKEY',        0x1028);
define('UA_BROWSER_MIDORI',           0x1029);
define('UA_BROWSER_MAXTHON',          0x102A);
define('UA_BROWSER_ICEAPE',           0x102B);
define('UA_BROWSER_ICEWEASEL',        0x102C);
define('UA_BROWSER_NETSCAPE',         0x102D);
define('UA_BROWSER_FIREBIRD',         0x102E);
define('UA_BROWSER_INTERNET_EXPLORER',0x102F);
define('UA_BROWSER_KONQUEROR',        0x1030);
define('UA_BROWSER_LINKS',            0x1031);
define('UA_BROWSER_LYNX',             0x1032);
define('UA_BROWSER_SAFARI',           0x1033);
define('UA_BROWSER_FIREFOX',          0x1034);
define('UA_BROWSER_OPERA_WII',        0x1035);
define('UA_BROWSER_SAFARI_MOBILE',    0x1036);


/**
 * -- UA_OS --
 * Known OS
 */
define('UA_OS_UNKNOWN',               0x00);
define('UA_OS_LINUX',                 0x01);
define('UA_OS_FREEBSD',               0x02);
define('UA_OS_OPENBSD',               0x03);
define('UA_OS_NETBSD',                0x04);
define('UA_OS_WINDOWS',               0x05);
define('UA_OS_SUNOS',                 0x06);
define('UA_OS_BLACKBERRY',            0x07);
define('UA_OS_SYMBIAN_OS',            0x08);
define('UA_OS_SYMBOS',                0x09);
define('UA_OS_MACINTOSH',             0x0A);
define('UA_OS_MAC_OS_X',              0x0B);
define('UA_OS_ANDROID',               0x0C);
define('UA_OS_IOS',                   0x0D);
define('UA_OS_NINTENDO_DS',           0x0E);
define('UA_OS_NINTENDO_WII',          0x0F);
define('UA_OS_SONY_PS3',              0x10);
define('UA_OS_SONY_PSP',              0x11);
define('UA_OS_CHROME_OS',             0x12);
define('UA_OS_BE_OS',                 0x13);
define('UA_OS_DRAGONFLY',             0x14);
define('UA_OS_UNIX',                  0x15);
define('UA_OS_DARWIN',                0x16);
define('UA_OS_OS2',                   0x17);
define('UA_OS_AMIGAOS',               0x18);


/**
 * -- UA_OS_TYPE --
 * Known OS type
 */
define('UA_OS_TYPE_UNKNOWN',          0x00);
define('UA_OS_TYPE_LINUX',            0x01);
define('UA_OS_TYPE_BSD',              0x02);
define('UA_OS_TYPE_UNIX',             0x03);
define('UA_OS_TYPE_WINDOWS',          0x04);
define('UA_OS_TYPE_OS2',              0x05);



/**
 * -- UA_ENGINE --
 * Known engine
 */
define('UA_ENGINE_UNKNOWN',           0x00);
define('UA_ENGINE_PRESTO',            0x01);
define('UA_ENGINE_GECKO',             0x02);
define('UA_ENGINE_APPLEWEBKIT',       0x03);
define('UA_ENGINE_KHTML',             0x04);
define('UA_ENGINE_TRIDENT',           0x05);
define('UA_ENGINE_WEBKIT',            0x06);


class GPCUserAgentValues
{
  static public $UA_BrowserInfo=array(
    UA_DATA => array(
              UA_DATA_BROWSER => array(UA_PROP_NAME => 'Browser'),
              UA_DATA_ENGINE  => array(UA_PROP_NAME => 'Engine'),
              UA_DATA_OS      => array(UA_PROP_NAME => 'Operating System')
            ),
    UA_DATA_BROWSER=> array(
              UA_BOT_UNKNOWN           => array(UA_PROP_NAME => 'Unknown',              UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),

              UA_BOT_008               => array(UA_PROP_NAME => '008',                  UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.80legs.com'),
              UA_BOT_ABACHOBOT         => array(UA_PROP_NAME => 'ABACHOBot',            UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.abacho.com'),
              UA_BOT_ACCOONA_AI_AGENT  => array(UA_PROP_NAME => 'Accoona-AI-Agent',     UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.accoona.com'),
              UA_BOT_ARACHMO           => array(UA_PROP_NAME => 'Arachmo',              UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_BLITZBOT          => array(UA_PROP_NAME => 'BlitzBOT',             UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_MICROSOFT_BING    => array(UA_PROP_NAME => 'Microsoft Bing',       UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.bing.com/bingbot.htm'),
              UA_BOT_CHARLOTTE         => array(UA_PROP_NAME => 'Charlotte',            UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.searchme.com'),
              UA_BOT_CERBERIAN_DRTRS   => array(UA_PROP_NAME => 'Cerberian Drtrs',      UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_COSMOS            => array(UA_PROP_NAME => 'Cosmos',               UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.xyleme.com/'),
              UA_BOT_COVARIO_IDS       => array(UA_PROP_NAME => 'Covario IDS',          UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.covario.com/ids'),
              UA_BOT_DATAPARKSEARCH    => array(UA_PROP_NAME => 'DataparkSearch',       UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.dataparksearch.org'),
              UA_BOT_GAISBOT           => array(UA_PROP_NAME => 'Gaisbot',              UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://gais.cs.ccu.edu.tw/'),
              UA_BOT_GOOGLE            => array(UA_PROP_NAME => 'Google',               UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.google.com/bot.html'),
              UA_BOT_GURUJIBOT         => array(UA_PROP_NAME => 'GurujiBot',            UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.guruji.com/en/WebmasterFAQ.html'),
              UA_BOT_HOLMES            => array(UA_PROP_NAME => 'Holmes',               UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.ucw.cz/holmes'),
              UA_BOT_HTDIG             => array(UA_PROP_NAME => 'htdig',                UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://htdig.sourceforge.net'),
              UA_BOT_IA_ARCHIVER       => array(UA_PROP_NAME => 'ia_archiver',          UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.alexa.com/'),
              UA_BOT_ICCRAWLER         => array(UA_PROP_NAME => 'iCCrawler',            UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.iccenter.net/bot.htm'),
              UA_BOT_ICHIRO            => array(UA_PROP_NAME => 'Ichiro',               UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://help.goo.ne.jp/door/crawler.html'),
              UA_BOT_BAIDU             => array(UA_PROP_NAME => 'Baidu',                UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.baidu.com'),
              UA_BOT_MSN_SEARCH        => array(UA_PROP_NAME => 'Microsoft MSN Search', UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://search.msn.com/msnbot.htm'),
              UA_BOT_EXALEAD           => array(UA_PROP_NAME => 'Exalead',              UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_GAMESPY           => array(UA_PROP_NAME => 'GameSpy',              UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_GIGABLAST         => array(UA_PROP_NAME => 'Gigabot',              UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.gigablast.com/spider.html'),
              UA_BOT_INKTOMI           => array(UA_PROP_NAME => 'Inktomi',              UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_YAHOO_SEARCH      => array(UA_PROP_NAME => 'Yahoo! Search',        UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.yahoo.com/'),
              UA_BOT_LWEBIS            => array(UA_PROP_NAME => 'L.webis',              UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://webalgo.iit.cnr.it/index.php?pg=lwebis'),
              UA_BOT_LARBIN            => array(UA_PROP_NAME => 'Larbin',               UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_LINKWALKER        => array(UA_PROP_NAME => 'LinkWalker',           UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.seventwentyfour.com/'),
              UA_BOT_LWPTRIVIAL        => array(UA_PROP_NAME => 'lwp-trivial',          UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_MABONLAND         => array(UA_PROP_NAME => 'Mabontland',           UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.mabontland.com'),
              UA_BOT_MNOGOSEARCH       => array(UA_PROP_NAME => 'Mnogosearch',          UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://mnogosearch.org'),
              UA_BOT_MOGIMOGI          => array(UA_PROP_NAME => 'mogimogi',             UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_MORNINGPAPER      => array(UA_PROP_NAME => 'Morning Paper',        UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.boutell.com'),
              UA_BOT_NETRESEARCHSERVER => array(UA_PROP_NAME => 'NetResearchServer',    UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.loopimprovements.com'),
              UA_BOT_NEWSGATOR         => array(UA_PROP_NAME => 'NewsGator',            UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.newsgator.com'),
              UA_BOT_NGSEARCH          => array(UA_PROP_NAME => 'NG-Search',            UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.ng-search.com'),
              UA_BOT_NYMESIS           => array(UA_PROP_NAME => 'Nymesis',              UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.nymesis.com'),
              UA_BOT_OEGP              => array(UA_PROP_NAME => 'oegp',                 UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_POMPOS            => array(UA_PROP_NAME => 'Pompos',               UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://dir.com/pompos.html'),
              UA_BOT_PYCURL            => array(UA_PROP_NAME => 'PycURL',               UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://pycurl.sourceforge.net'),
              UA_BOT_QSEERO            => array(UA_PROP_NAME => 'Qseero',               UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_SBIDER            => array(UA_PROP_NAME => 'SBIder',               UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.sitesell.com'),
              UA_BOT_SCOUTJET          => array(UA_PROP_NAME => 'ScoutJet',             UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.scoutjet.com'),
              UA_BOT_SCRUBBY           => array(UA_PROP_NAME => 'Scrubby',              UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.scrubtheweb.com'),
              UA_BOT_SEARCHSIGHT       => array(UA_PROP_NAME => 'SearchSight',          UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://searchsight.com'),
              UA_BOT_SEMANTICDISCOVERY => array(UA_PROP_NAME => 'semanticdiscovery',    UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_SHOULA            => array(UA_PROP_NAME => 'Shoula',               UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_SNAPPY            => array(UA_PROP_NAME => 'Snappy',               UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.urltrends.com'),
              UA_BOT_STACKRAMBLER      => array(UA_PROP_NAME => 'StackRambler',         UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_SILK              => array(UA_PROP_NAME => 'Silk',                 UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.slider.com/silk.htm'),
              UA_BOT_TEOMA             => array(UA_PROP_NAME => 'Teoma',                UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://sp.ask.com/docs/about/tech_crawling.html'),
              UA_BOT_TINEYE            => array(UA_PROP_NAME => 'TinEye',               UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://tineye.com/crawler.html'),
              UA_BOT_TRUWOGPS          => array(UA_PROP_NAME => 'truwoGPS',             UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.lan4lano.net/browser.html'),
              UA_BOT_UPDATED           => array(UA_PROP_NAME => 'updated',              UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.updated.com'),
              UA_BOT_VOYAGER           => array(UA_PROP_NAME => 'voyager',              UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.kosmix.com/crawler.html'),
              UA_BOT_VYU2              => array(UA_PROP_NAME => 'vyu2',                 UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_WEBCOLLAGE        => array(UA_PROP_NAME => 'WebCollage',           UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_YOOGLIFETCHAGENT  => array(UA_PROP_NAME => 'yoogliFetchAgent',     UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),
              UA_BOT_ZAO               => array(UA_PROP_NAME => 'Zao',                  UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => 'http://www.kototoi.org/zao'),
              UA_BOT_ZEALBOT           => array(UA_PROP_NAME => 'Zealbot',              UA_PROP_TYPE=>UA_BROWSER_TYPE_CRAWLER, UA_PROP_URL => ''),


              UA_BROWSER_UNKNOWN       => array(UA_PROP_NAME => 'Unknown',              UA_PROP_TYPE=>UA_BROWSER_TYPE_UNKNOWN, UA_PROP_URL => ''),

              UA_BROWSER_ANDROID_WEBKIT=> array(UA_PROP_NAME => 'Android WebKit Browser',  UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => ''),
              UA_BROWSER_OPERA_MINI    => array(UA_PROP_NAME => 'Opera Mini',              UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => 'http://www.opera.com/'),
              UA_BROWSER_OPERA_MOBILE  => array(UA_PROP_NAME => 'Opera Mobile',            UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => 'http://www.opera.com/'),
              UA_BROWSER_BLACKBERRY    => array(UA_PROP_NAME => 'BlackBerry',              UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => 'http://worldwide.blackberry.com'),
              UA_BROWSER_FENNEC        => array(UA_PROP_NAME => 'Fennec',                  UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => 'http://www.mozilla.org/en-US/mobile'),
              UA_BROWSER_GOBROWSER     => array(UA_PROP_NAME => 'Go Browser',              UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => 'http://www.3g.cn/'),
              UA_BROWSER_IEMOBILE      => array(UA_PROP_NAME => 'IE Mobile',               UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => ''),
              UA_BROWSER_IRIS          => array(UA_PROP_NAME => 'Iris',                    UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => 'http://www.torchmobile.com'),
              UA_BROWSER_MAEMO_BROWSER => array(UA_PROP_NAME => 'Maemo Browser',           UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => 'http://browser.garage.maemo.org'),
              UA_BROWSER_MIB           => array(UA_PROP_NAME => 'MIB',                     UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => 'http://www.useragentstring.com/pages/MIB/www.motorola.com'),
              UA_BROWSER_MINIMO        => array(UA_PROP_NAME => 'Minimo',                  UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => 'http://www-archive.mozilla.org/projects/minimo/'),
              UA_BROWSER_NETFRONT      => array(UA_PROP_NAME => 'NetFront',                UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => 'http://www.access-company.com'),
              UA_BROWSER_SEMC          => array(UA_PROP_NAME => 'SEMC-Browser',            UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => ''),
              UA_BROWSER_TEASHARK      => array(UA_PROP_NAME => 'TeaShark',                UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => 'http://www.navire.fi/teashark/index.html'),
              UA_BROWSER_SKYFIRE       => array(UA_PROP_NAME => 'Skyfire',                 UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => 'http://www.skyfire.com'),
              UA_BROWSER_SAFARI_MOBILE => array(UA_PROP_NAME => 'Safari',                  UA_PROP_TYPE=>UA_BROWSER_TYPE_MOBILE, UA_PROP_URL => 'http://www.apple.com/safari'),

              UA_BROWSER_PS3           => array(UA_PROP_NAME => 'Playstation 3',           UA_PROP_TYPE=>UA_BROWSER_TYPE_CONSOLE, UA_PROP_URL => 'http://us.playstation.com/ps3'),
              UA_BROWSER_PSP           => array(UA_PROP_NAME => 'Playstation Portable',    UA_PROP_TYPE=>UA_BROWSER_TYPE_CONSOLE, UA_PROP_URL => 'http://us.playstation.com/psp'),
              UA_BROWSER_BUNJALLOO     => array(UA_PROP_NAME => 'Bunjalloo',               UA_PROP_TYPE=>UA_BROWSER_TYPE_CONSOLE, UA_PROP_URL => 'http://code.google.com/p/quirkysoft/'),
              UA_BROWSER_OPERA_WII     => array(UA_PROP_NAME => 'Opera',                   UA_PROP_TYPE=>UA_BROWSER_TYPE_CONSOLE, UA_PROP_URL => 'http://www.opera.com'),

              UA_BROWSER_OPERA         => array(UA_PROP_NAME => 'Opera',                  UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://www.opera.com'),
              UA_BROWSER_SHIIRA        => array(UA_PROP_NAME => 'Shiira',                 UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://shiira.jp/en'),
              UA_BROWSER_THUNDERBIRD   => array(UA_PROP_NAME => 'Thunderbird',            UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://www.mozilla.org/thunderbird'),
              UA_BROWSER_NAMOROKA      => array(UA_PROP_NAME => 'Namoroka',               UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'https://wiki.mozilla.org/Firefox/Namoroka'),
              UA_BROWSER_MINEFIELD     => array(UA_PROP_NAME => 'Minefield',              UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://www.mozilla.org/projects/minefield'),
              UA_BROWSER_LUNASCAPE     => array(UA_PROP_NAME => 'Lunascape',              UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://www.lunascape.tv'),
              UA_BROWSER_ARORA         => array(UA_PROP_NAME => 'Arora',                  UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://code.google.com/p/arora'),
              UA_BROWSER_CAMINO        => array(UA_PROP_NAME => 'Camino',                 UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://caminobrowser.org'),
              UA_BROWSER_KAPIKO        => array(UA_PROP_NAME => 'Kapiko',                 UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://ufoxlab.googlepages.com/cooperation'),
              UA_BROWSER_KAZEHAKAZE    => array(UA_PROP_NAME => 'Kazehakase',             UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://kazehakase.sourceforge.jp'),
              UA_BROWSER_CHROMEPLUS    => array(UA_PROP_NAME => 'ChromePlus',             UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://coolnovo.com'),
              UA_BROWSER_CHROME        => array(UA_PROP_NAME => 'Chrome',                 UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://www.google.com/chrome'),
              UA_BROWSER_EPIPHANY      => array(UA_PROP_NAME => 'Epiphany',               UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://projects.gnome.org/epiphany'),
              UA_BROWSER_GALEON        => array(UA_PROP_NAME => 'Galeon',                 UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://galeon.sourceforge.net'),
              UA_BROWSER_ORCA          => array(UA_PROP_NAME => 'Orca',                   UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://www.orcabrowser.com'),
              UA_BROWSER_LOBO          => array(UA_PROP_NAME => 'Lobo',                   UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://lobobrowser.org'),
              UA_BROWSER_SEAMONKEY     => array(UA_PROP_NAME => 'SeaMonkey',              UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://www.seamonkey-project.org'),
              UA_BROWSER_MIDORI        => array(UA_PROP_NAME => 'Midori',                 UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://twotoasts.de/?/pages/midori_summary.html'),
              UA_BROWSER_MAXTHON       => array(UA_PROP_NAME => 'Maxthon',                UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://www.maxthon.com'),
              UA_BROWSER_ICEAPE        => array(UA_PROP_NAME => 'Iceape',                 UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://packages.debian.org/fr/squeeze/iceape-browser'),
              UA_BROWSER_ICEWEASEL     => array(UA_PROP_NAME => 'Iceweasel',              UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://www.geticeweasel.org'),
              UA_BROWSER_NETSCAPE      => array(UA_PROP_NAME => 'Netscape',               UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://isp.netscape.com'),
              UA_BROWSER_FIREBIRD      => array(UA_PROP_NAME => 'Firebird',               UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://www.firefox.com'),
              UA_BROWSER_FIREFOX       => array(UA_PROP_NAME => 'Firefox',                UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://www.firefox.com'),
              UA_BROWSER_INTERNET_EXPLORER=> array(UA_PROP_NAME => 'Internet Explorer',   UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://windows.microsoft.com/en-us/internet-explorer/products/ie/home'),
              UA_BROWSER_KONQUEROR     => array(UA_PROP_NAME => 'Konqueror',              UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://www.konqueror.org'),
              UA_BROWSER_LINKS         => array(UA_PROP_NAME => 'Links',                  UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://www.jikos.cz/~mikulas/links'),
              UA_BROWSER_LYNX          => array(UA_PROP_NAME => 'Lynx',                   UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://lynx.browser.org'),
              UA_BROWSER_SAFARI        => array(UA_PROP_NAME => 'Safari',                 UA_PROP_TYPE=>UA_BROWSER_TYPE_COMPUTER, UA_PROP_URL => 'http://www.apple.com/safari')
            ),

    UA_DATA_OS => array(
              UA_OS_UNKNOWN            => array(UA_PROP_NAME => 'Unknown',                UA_PROP_TYPE=>UA_OS_TYPE_UNKNOWN,   UA_PROP_URL=>''),
              UA_OS_LINUX              => array(UA_PROP_NAME => 'Linux',                  UA_PROP_TYPE=>UA_OS_TYPE_LINUX,     UA_PROP_URL=>'http://www.linux.com'),
              UA_OS_FREEBSD            => array(UA_PROP_NAME => 'FreeBSD',                UA_PROP_TYPE=>UA_OS_TYPE_BSD,       UA_PROP_URL=>'http://www.freebsd.org'),
              UA_OS_OPENBSD            => array(UA_PROP_NAME => 'OpenBSD',                UA_PROP_TYPE=>UA_OS_TYPE_BSD,       UA_PROP_URL=>'http://www.openbsd.org'),
              UA_OS_NETBSD             => array(UA_PROP_NAME => 'NetBSD',                 UA_PROP_TYPE=>UA_OS_TYPE_BSD,       UA_PROP_URL=>'http://www.netbsd.org'),
              UA_OS_WINDOWS            => array(UA_PROP_NAME => 'Windows',                UA_PROP_TYPE=>UA_OS_TYPE_WINDOWS,   UA_PROP_URL=>'http://windows.microsoft.com'),
              UA_OS_SUNOS              => array(UA_PROP_NAME => 'SunOS',                  UA_PROP_TYPE=>UA_OS_TYPE_UNIX,      UA_PROP_URL=>''),
              UA_OS_BLACKBERRY         => array(UA_PROP_NAME => 'Blackberry OS',          UA_PROP_TYPE=>UA_OS_TYPE_UNKNOWN,   UA_PROP_URL=>'http://us.blackberry.com/apps-software/devices'),
              UA_OS_SYMBIAN_OS         => array(UA_PROP_NAME => 'Symbian OS',             UA_PROP_TYPE=>UA_OS_TYPE_UNKNOWN,   UA_PROP_URL=>'http://symbian.nokia.com'),
              UA_OS_SYMBOS             => array(UA_PROP_NAME => 'SymbOS',                 UA_PROP_TYPE=>UA_OS_TYPE_UNKNOWN,   UA_PROP_URL=>'http://www.symbos.de'),
              UA_OS_MACINTOSH          => array(UA_PROP_NAME => 'Macintosh',              UA_PROP_TYPE=>UA_OS_TYPE_UNKNOWN,   UA_PROP_URL=>'http://www.apple.com'),
              UA_OS_MAC_OS_X           => array(UA_PROP_NAME => 'Mac OS X',               UA_PROP_TYPE=>UA_OS_TYPE_BSD,       UA_PROP_URL=>'http://www.apple.com'),
              UA_OS_ANDROID            => array(UA_PROP_NAME => 'Android',                UA_PROP_TYPE=>UA_OS_TYPE_LINUX,     UA_PROP_URL=>'http://www.android.com'),
              UA_OS_IOS                => array(UA_PROP_NAME => 'iOS',                    UA_PROP_TYPE=>UA_OS_TYPE_UNKNOWN,   UA_PROP_URL=>'http://www.apple.com'),
              UA_OS_NINTENDO_DS        => array(UA_PROP_NAME => 'Nintendo DS',            UA_PROP_TYPE=>UA_OS_TYPE_UNKNOWN,   UA_PROP_URL=>'http://www.nintendo.com/ds'),
              UA_OS_NINTENDO_WII       => array(UA_PROP_NAME => 'Nintendo Wii',           UA_PROP_TYPE=>UA_OS_TYPE_UNKNOWN,   UA_PROP_URL=>'http://www.nintendo.com/wii'),
              UA_OS_SONY_PS3           => array(UA_PROP_NAME => 'Sony PS3',               UA_PROP_TYPE=>UA_OS_TYPE_UNKNOWN,   UA_PROP_URL=>'http://us.playstation.com/ps3'),
              UA_OS_SONY_PSP           => array(UA_PROP_NAME => 'Sony PSP',               UA_PROP_TYPE=>UA_OS_TYPE_UNKNOWN,   UA_PROP_URL=>'http://us.playstation.com/psp'),
              UA_OS_CHROME_OS          => array(UA_PROP_NAME => 'Chrome OS',              UA_PROP_TYPE=>UA_OS_TYPE_LINUX,     UA_PROP_URL=>''),
              UA_OS_BE_OS              => array(UA_PROP_NAME => 'BeOS',                   UA_PROP_TYPE=>UA_OS_TYPE_BSD,       UA_PROP_URL=>''),
              UA_OS_DRAGONFLY          => array(UA_PROP_NAME => 'DragonFly BSD',          UA_PROP_TYPE=>UA_OS_TYPE_BSD,       UA_PROP_URL=>'http://www.dragonflybsd.org'),
              UA_OS_UNIX               => array(UA_PROP_NAME => 'UNIX',                   UA_PROP_TYPE=>UA_OS_TYPE_UNIX,      UA_PROP_URL=>''),
              UA_OS_DARWIN             => array(UA_PROP_NAME => 'Darwin',                 UA_PROP_TYPE=>UA_OS_TYPE_BSD,       UA_PROP_URL=>'developer.apple.com/darwin'),
              UA_OS_OS2                => array(UA_PROP_NAME => 'IBM OS/2',               UA_PROP_TYPE=>UA_OS_TYPE_OS2,       UA_PROP_URL=>''),
              UA_OS_AMIGAOS            => array(UA_PROP_NAME => 'AmigaOS',                UA_PROP_TYPE=>UA_OS_TYPE_UNKNOWN,   UA_PROP_URL=>'http://amiga.com')
            ),
    UA_DATA_ENGINE => array(
              UA_ENGINE_UNKNOWN        => array(UA_PROP_NAME => 'Unknown',                UA_PROP_URL=>''),
              UA_ENGINE_GECKO          => array(UA_PROP_NAME => 'Gecko',                  UA_PROP_URL=>'https://developer.mozilla.org/en/Gecko'),
              UA_ENGINE_KHTML          => array(UA_PROP_NAME => 'KHTML',                  UA_PROP_URL=>'http://api.kde.org/3.5-api/kdelibs-apidocs/khtml/html/index.html'),
              UA_ENGINE_PRESTO         => array(UA_PROP_NAME => 'Presto',                 UA_PROP_URL=>'http://dev.opera.com/articles/view/presto-2-1-web-standards-supported-by'),
              UA_ENGINE_APPLEWEBKIT    => array(UA_PROP_NAME => 'AppleWebKit',            UA_PROP_URL=>''),
              UA_ENGINE_WEBKIT         => array(UA_PROP_NAME => 'WebKit',                 UA_PROP_URL=>'http://www.webkit.org'),
              UA_ENGINE_TRIDENT        => array(UA_PROP_NAME => 'Trident',                UA_PROP_URL=>'http://msdn.microsoft.com/en-us/library/aa741317.aspx')
            ),

    UA_DATA_BROWSER_TYPE => array(
              UA_BROWSER_TYPE_UNKNOWN  => 'Unknown',
              UA_BROWSER_TYPE_COMPUTER => 'Computer',
              UA_BROWSER_TYPE_CONSOLE  => 'Console',
              UA_BROWSER_TYPE_MOBILE   => 'Mobile',
              UA_BROWSER_TYPE_CRAWLER  => 'Crawler'
            ),

    UA_DATA_OS_TYPE => array(
              UA_OS_TYPE_UNKNOWN  => 'Unknown',
              UA_OS_TYPE_LINUX    => 'Linux',
              UA_OS_TYPE_BSD      => 'BSD',
              UA_OS_TYPE_UNIX     => 'Unix',
              UA_OS_TYPE_WINDOWS  => 'Windows',
              UA_OS_TYPE_OS2      => 'OS/2'
            )

  );

}

?>
