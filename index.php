<?php
require_once "../config.php";

use \Tsugi\Util\U;
use \Tsugi\Core\LTIX;
use \Tsugi\Core\Settings;
use \Tsugi\UI\SettingsForm;

$LTI = LTIX::requireData();

// Handle the incoming post first
if ( $LTI->link && $LTI->link->id && SettingsForm::handleSettingsPost() ) {
    header('Location: '.addSession('index.php') ) ;
    return;
}

// $url = $LTI->link->settingsGet('url', false);
$url = Settings::linkGet('url', false);

$menu = false;
if ( $LTI->link && $LTI->user && $LTI->user->instructor ) {
    $menu = new \Tsugi\UI\MenuSet();
    $menu->addRight(__('Settings'), '#', /* push */ false, SettingsForm::attr());
}

// Render view
$OUTPUT->header();
$OUTPUT->bodyStart();
$OUTPUT->topNav($menu);
?>
<?php

if ( $LTI->link && $LTI->user && $LTI->user->instructor ) {
    SettingsForm::start();
    SettingsForm::text('url','Please enter the URL.');
    SettingsForm::end();
    
    $OUTPUT->flashMessages();
}

if ( ! $url ) {
    echo("<p>iFrame url has not yet been configured</p>\n");
} else {
?>
<script>
    window.localStorage.setItem("_TSUGI", _TSUGI);
    console.log("Sending",_TSUGI);
    alert('Forwarding request to Node');
    window.location.href = '<?= $url ?>?_TSUGI='+encodeURIComponent(JSON.stringify(_TSUGI));
</script>
    <p>This should have forwarded to Node at <?= htmlentities($url) ?> - check console for errors.</p>
<?php
}
$OUTPUT->footerStart();
$OUTPUT->footerEnd();
