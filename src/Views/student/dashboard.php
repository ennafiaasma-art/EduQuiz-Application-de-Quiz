<?php
session_start();

if (isset($_SESSION['user'])) {
    echo $_SESSION['user']['name'];
} else {
    echo "User not logged in";
}
?>