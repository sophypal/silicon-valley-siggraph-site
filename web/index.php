<?php

require_once('../lib/svSiggraphApp.php');

$app = svSiggraphApp::loadApplicationSettings('webconfig.ini');
$app->execute();

?>
