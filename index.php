<?php
require_once 'utils/SessionUtils.php';
SessionUtils::startSessionIfNotStarted();

if (isset($_SESSION["email"])) {
        header("Location: app/views/private/index.php");

} else {
    header("Location: app/views/public/index.php");
}
?>
