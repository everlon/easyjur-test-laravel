<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    include __DIR__ . "/../templates/login.html";
    exit();
}
header("Location: /home");
