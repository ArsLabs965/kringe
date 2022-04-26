<?php
session_start();
session_destroy();
include "settings/root_way.php";
$rootway = root_way();
header("Location: http://" . $_SERVER['SERVER_NAME'] . "/" . $rootway . "index.php");
exit();
?>