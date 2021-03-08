<?php

//defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

$phpcas_path = 'include/phpCAS/source/';

$cas_host = 'cas.univ-paris1.fr';
$cas_context = '/cas';
$cas_port = 443;

$cas_url = 'https://' . $cas_host;
if ($cas_port != '443') {
    $cas_url = $cas_url . ':' . $cas_port;
}
$cas_url = $cas_url . $cas_context;

require_once $phpcas_path . '/CAS.php';
phpCAS::setDebug();
phpCAS::setVerbose(true);
phpCAS::client(SAML_VERSION_1_1, $cas_host, $cas_port, $cas_context);
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();

// Some small code triggered by the logout button
if (isset($_REQUEST['logout'])) {
    phpCAS::logout();
}
?>
<html>
  <head>
    <title>Advanced SAML 1.1 example</title>
  </head>
  <body>
<h2>Advanced SAML 1.1 example</h2>
<?//php require 'script_info.php' ?>

Authentication succeeded for user
<strong><?php echo phpCAS::getUser(); ?></strong>.

<h3>User Attributes</h3>
<ul>
<?php
foreach (phpCAS::getAttributes() as $key => $value) {
    if (is_array($value)) {
        echo '<li>', $key, ':<ol>';
        foreach ($value as $item) {
            echo '<li><strong>', $item, '</strong></li>';
        }
        echo '</ol></li>';
    } else {
        echo '<li>', $key, ': <strong>', $value, '</strong></li>' . PHP_EOL;
    }
}
    ?>
</ul>
<p><a href="?logout=">Logout</a></p>
</body>
</html>
