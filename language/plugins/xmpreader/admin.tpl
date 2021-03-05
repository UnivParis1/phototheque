<!-- Show the title of the plugin -->
<div class="titlePage">
    <h2>{'XMP Simple Reader'|@translate}</h2>
</div>

<!-- Show content in a nice box -->
<fieldset>
    <legend>{'Configuration du plugin XMP Simple Reader'|@translate}</legend>
    <div id="helpContent">
        <p> {'Toute la configuration du plugin XMP Simple Reader va dans le fichier "local/config/config.inc.php", à éditer avec votre LocalFiles Editor.'|@translate}<br />
            {'Ajouter simplement un tableau $conf[\'xmpreader\'] associant les noms d\'attributs que vous voulez récupérer aux expressions régulières qui permettent de les retrouver dans le XMP'|@translate}</p>
        <p>    {'Par exemple :'|@translate}</p>
        <code><pre>
$conf['xmpreader'] = array(
        'xmp_keywords' => '/&ltdc:subject>\s*&ltrdf:(?:Bag|Seq)>\s*(.*?)\s*&lt\/rdf:(?:Bag|Seq)>\s*&lt\/dc:subject>/is',
        'xmp_rating' => '/xmp:Rating="(\d)"/',
        'xmp_headline' => '/photoshop:Headline="(.*?)"/',
        'xmp_credit' => '/photoshop:Credit="(.*?)"/',
        'xmp_usageterms' => '/&ltxmpRights:UsageTerms>\s*&ltrdf:Alt>\s*&ltrdf:li xml:lang="x-default">(.*?)&lt\/rdf:li>\s*&lt\/rdf:Alt>\s*&lt\/xmpRights:UsageTerms>/'
    );
            </pre></code>
        <p>{'Les clés du tableaux $conf[\'xmpreader\'] sont disponibles pour être utilisées comme des attributs EXIF standards par le système de métadonnés de Piwigo avec "show_exif" ou "user_exif", par exemple :'|@translate}</p>
        <code><pre>
$conf['show_exif_fields'] = array(
  'xmp_keywords',
  'xmp_credit',
  'xmp_usageterms',
  'xmp_rating',
  'xmp_headline'
  
  );
            </pre></code>
    </div>


</fieldset>
