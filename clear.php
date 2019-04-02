<?php
#20111229 #1581:sougata change session name to keep fd session
session_name("crsclienttest");
session_start();
session_destroy();
header('location:index.php');
?>
