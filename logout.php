<?php
session_start();

$id = $_POST["session-id"];
if (isset($_SESSION[$id]['password'])) {
    unset($_SESSION[$id]['password']);
}

header('Location: index.html');
exit;
?>