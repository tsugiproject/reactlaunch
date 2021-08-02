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
$auto = Settings::linkGet('auto', false);
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
    SettingsForm::checkbox('auto',"Auto launch after 2 seconds.");
    SettingsForm::end();
    
    $OUTPUT->flashMessages();
}

if ( ! $url ) {
    echo("<p>React application url has not yet been configured</p>\n");
} else {
?>
<script>
    function forward() {
        window.localStorage.setItem("_TSUGI", _TSUGI);
        window.location.href = '<?= $url ?>?_TSUGI='+encodeURIComponent(JSON.stringify(_TSUGI));
    }
</script>
<?php if ( $auto ) { ?>
<script>
    var timer = setTimeout(function(){ forward(); }, 2000);
</script>
    <p id="continue" style="display:none;">
    <a href="#" onclick="forward();return false;">Continue to <?= htmlentities($url) ?></a> ...
    </p>
    <div id="pause">
    <a href="#" onclick="forward();return false;">Auto forwarding to <?= htmlentities($url) ?></a> ...
    <button onclick="clearTimeout(timer); $('#pause').hide(); $('#continue').show(); return false;">Pause</button>
</div>
<?php    } else { ?>
    <a href="#" onclick="forward();return false;">Continue to <?= htmlentities($url) ?></a>
<?php    } ?>

<?php
}
$OUTPUT->footerStart();
$OUTPUT->footerEnd();
