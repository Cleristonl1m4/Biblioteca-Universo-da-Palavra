<?php
session_start();
session_unset();
session_destroy();
header("Location: /Biblioteca-Universo-da-Palavra/Pages/loginpage/login.php");
exit;
