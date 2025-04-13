<?php
session_start();
session_destroy();
header("Location: sacco_login.php");
exit();
