<?php
session_start();

if(isset($_SESSION['username'])) {
echo "Welcome <strong>".$_SESSION['username']."</strong><br/>";
} else {
header('location: log.php');
}

?>