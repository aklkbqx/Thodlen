<?php
session_start();
require_once __DIR__ . "/../lib/util.php";
$admin_id = isset($_SESSION["user_login"]) ? header("location: ../") : (isset($_SESSION["admin_login"]) ? header("location: ../") : null);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN ADMIN</title>
    <?php require_once __DIR__ . "/../lib/link.php"; ?>
</head>

<body>
    <div class="d-flex justify-content-center vh-100 align-items-center">
        <div class="bg-white p-5 rounded-4 border shadow-lg">
            <h1 class="mb-3 text-center">ADMIN LOGIN</h1>
            <form action="../api/manage_user-admin.php?login" method="post" class="mb-0">
                <input type="email" name="email" class="form-control mb-3" placeholder="Email">
                <input type="password" name="password" class="form-control mb-3" placeholder="Password">
                <button name="login_submit" type="submit" class="btn btn-cyan w-100">LOGIN</button>
            </form>
        </div>
    </div>
</body>

</html>