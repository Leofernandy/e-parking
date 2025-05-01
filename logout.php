<?php
session_start();
session_unset();  // menghapus semua data session
session_destroy(); // mengakhiri session
header("Location: login.php"); // arahkan user ke halaman login
exit();
?>
