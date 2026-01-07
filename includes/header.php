<?php
session_start();
require_once __DIR__ . '/../config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibe Vault</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <nav>
        <div class="nav-container">
            <div class="nav-content">
                <div class="nav-brand">
                    <a href="index.php">Vibe Vault</a>
                </div>
                <div class="nav-links">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="upload.php" class="btn-primary">Upload Vibe</a>
                        <a href="logout.php" class="btn-secondary">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn-secondary">Login</a>
                        <a href="register.php" class="btn-primary">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <main class="container">
