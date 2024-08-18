<?php
session_start();
require_once __DIR__ . "/../lib/util.php";

if (isset($_REQUEST["login_submit"]) && isset($_GET["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $check = sql("SELECT * FROM `users` WHERE `email` = ?", [$email]);
    if ($check->rowCount() > 0) {
        $row = $check->fetch(PDO::FETCH_ASSOC);
        if ($email == $row['email'] && password_verify($password, $row['password'])) {
            $_SESSION[$row['role'] . '_login'] = $row['user_id'];
            $_SESSION['success'] = 'เข้าสู่ระบบสำเร็จ!';
            if ($row['role'] == "admin") {
                header('location: ../admin/');
            } else {
                header('location: ../');
            }
            exit;
        } else {
            msg('รหัสผ่านไม่ถูกต้อง!', 'danger', $_SERVER['HTTP_REFERER']);
        }
    } else {
        msg('ไม่มีข้อมูลในระบบ!', 'warning', $_SERVER['HTTP_REFERER']);
    }
}

if (isset($_REQUEST["register_submit"]) && isset($_GET["register"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $tel = $_POST["tel"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $c_password = $_POST["c_password"];
    $address = $_POST["address"];

    $profile = $_FILES['profile']['name'];
    $tmp_name = $_FILES['profile']['tmp_name'];
    $path = '../assets/images/user_images/';

    if ($password != $c_password) {
        msg('รหัสผ่านไม่ตรงกัน!', 'danger', $_SERVER['HTTP_REFERER']);
    } else {
        if (!empty($profile)) {
            $extension = pathinfo($profile, PATHINFO_EXTENSION);
            $profileImage = uniqid() . '.' . $extension;
            if (empty($tmp_name)) {
                msg('ไฟล์รูปภาพมีปัญหา กรุณาลองใหม่อีกครั้ง!', 'danger', $_SERVER['HTTP_REFERER']);
            } else {
                move_uploaded_file($tmp_name, $path . $profileImage);
            }
        } else {
            $profileImage = 'default-profile.jpg';
        }
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $insert = sql("INSERT INTO `users`(`firstname`,`lastname`,tel,`email`,`password`,`profile_image`,`address`) VALUES(?,?,?,?,?,?,?)", [
            $firstname,
            $lastname,
            $tel,
            $email,
            $passwordHash,
            $profileImage,
            $address
        ]);
        if ($insert) {
            $lastId = $pdo->lastInsertId();
            $stmt = sql("SELECT * FROM `users` WHERE `user_id` = ?", [$lastId]);
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION[$row['role'] . '_login'] = $row['user_id'];
                msg('สมัครมาชิกเสร็จสิ้น!', 'success', '../');
            }
        }
    }
}

if (isset($_REQUEST["saveChange-account"]) && isset($_GET["edit"]) && isset($_GET["user_id"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $c_password = $_POST["c_password"];

    $address = isset($_POST["address"]) ? $_POST["address"] : null;
    $tel = isset($_POST["tel"]) ? $_POST["tel"] : null;
    $old_password = isset($_POST["old_password"]) ? $_POST["old_password"] : null;

    $profile = $_FILES['profile']['name'];
    $tmp_name = $_FILES['profile']['tmp_name'];
    $path = '../assets/images/user_images/';

    $user_id = $_GET["user_id"];
    $row = sql("SELECT * FROM `users` WHERE `user_id` = ?", [$user_id])->fetch(PDO::FETCH_ASSOC);

    if ($password != $c_password) {
        msg('รหัสผ่านไม่ตรงกัน!', 'danger', $_SERVER['HTTP_REFERER']);
    } else {
        if (!empty($old_password) || !empty($password) || !empty($c_password)) {
            if ($old_password != password_verify($old_password, $row["password"])) {
                msg('รหัสผ่านเดิมไม่ถูกต้อง!', 'danger', $_SERVER['HTTP_REFERER']);
            }
        }
        if (empty($old_password) && (!empty($password) || !empty($c_password))) {
            msg('ไม่สามารถเปลี่ยนรหัสผ่านได้ กรุณากรอกรหัสผ่านเดิม!', 'danger', $_SERVER['HTTP_REFERER']);
        }
        if (!empty($old_password) && (empty($password) || empty($c_password))) {
            msg('ไม่สามารถเปลี่ยนรหัสผ่านได้ กรุณากรอกรหัสผ่านใหม่เพื่อทำการเปลี่ยนรหัสผ่่าน!', 'danger', $_SERVER['HTTP_REFERER']);
        }
        if (!empty($profile)) {
            $extension = pathinfo($profile, PATHINFO_EXTENSION);
            $profileImage = uniqid() . '.' . $extension;
            if (empty($tmp_name)) {
                msg('ไฟล์รูปภาพมีปัญหา กรุณาลองใหม่อีกครั้ง!', 'danger', $_SERVER['HTTP_REFERER']);
            } else {
                if ($row["profile_image"] != "default-profile.jpg") {
                    if (file_exists($path . $row["profile_image"])) {
                        unlink($path . $row["profile_image"]);
                    }
                }
                move_uploaded_file($tmp_name, $path . $profileImage);
            }
        } else {
            $profileImage =  $row["profile_image"];
        }
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $insert = sql("UPDATE `users` SET `firstname` = ?, `lastname` = ? , `tel` = ?, `email` = ?, `password` = ?, `profile_image` = ?, `address` = ? WHERE `user_id` = ?", [
            $firstname,
            $lastname,
            $tel,
            $email,
            $passwordHash,
            $profileImage,
            $address,
            $user_id
        ]);
        if ($insert) {
            msg('แก้ไขข้อมูลเสร็จสิ้น!', 'success', $_SERVER['HTTP_REFERER']);
        }
    }
}

if (isset($_REQUEST["add_user"]) && isset($_GET["add"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $tel = $_POST["tel"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $c_password = $_POST["c_password"];
    $address = $_POST["address"];

    $profile = $_FILES['profile']['name'];
    $tmp_name = $_FILES['profile']['tmp_name'];
    $path = '../assets/images/user_images/';

    if ($password != $c_password) {
        msg('รหัสผ่านไม่ตรงกัน!', 'danger', $_SERVER['HTTP_REFERER']);
    } else {
        if (!empty($profile)) {
            $extension = pathinfo($profile, PATHINFO_EXTENSION);
            $profileImage = uniqid() . '.' . $extension;
            if (empty($tmp_name)) {
                msg('ไฟล์รูปภาพมีปัญหา กรุณาลองใหม่อีกครั้ง!', 'danger', $_SERVER['HTTP_REFERER']);
            } else {
                move_uploaded_file($tmp_name, $path . $profileImage);
            }
        } else {
            $profileImage = 'default-profile.jpg';
        }
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $insert = sql("INSERT INTO `users`(`firstname`,`lastname`,tel,`email`,`password`,`profile_image`,`address`) VALUES(?,?,?,?,?,?,?)", [
            $firstname,
            $lastname,
            $tel,
            $email,
            $passwordHash,
            $profileImage,
            $address
        ]);
        if ($insert) {
            msg('เพิ่มสมาชิกเสร็จสิ้น!', 'success', $_SERVER['HTTP_REFERER']);
        }
    }
}

if (isset($_REQUEST["save-editUser"]) && isset($_GET["edit"]) && isset($_GET["user_id"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $c_password = $_POST["c_password"];

    $address = isset($_POST["address"]) ? $_POST["address"] : null;
    $tel = isset($_POST["tel"]) ? $_POST["tel"] : null;

    $profile = $_FILES['profile']['name'];
    $tmp_name = $_FILES['profile']['tmp_name'];
    $path = '../assets/images/user_images/';

    $user_id = $_GET["user_id"];
    $row = sql("SELECT * FROM `users` WHERE `user_id` = ?", [$user_id])->fetch(PDO::FETCH_ASSOC);

    if ($password != $c_password) {
        msg('รหัสผ่านไม่ตรงกัน!', 'danger', $_SERVER['HTTP_REFERER']);
    } else {
        if (!empty($profile)) {
            $extension = pathinfo($profile, PATHINFO_EXTENSION);
            $profileImage = uniqid() . '.' . $extension;
            if (empty($tmp_name)) {
                msg('ไฟล์รูปภาพมีปัญหา กรุณาลองใหม่อีกครั้ง!', 'danger', $_SERVER['HTTP_REFERER']);
            } else {
                if ($row["profile_image"] != "default-profile.jpg") {
                    if (file_exists($path . $row["profile_image"])) {
                        unlink($path . $row["profile_image"]);
                    }
                }
                move_uploaded_file($tmp_name, $path . $profileImage);
            }
        } else {
            $profileImage =  $row["profile_image"];
        }
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $insert = sql("UPDATE `users` SET `firstname` = ?, `lastname` = ? , `tel` = ?, `email` = ?, `password` = ?, `profile_image` = ?, `address` = ? WHERE `user_id` = ?", [
            $firstname,
            $lastname,
            $tel,
            $email,
            $passwordHash,
            $profileImage,
            $address,
            $user_id
        ]);
        if ($insert) {
            msg('แก้ไขข้อมูลเสร็จสิ้น!', 'success', $_SERVER['HTTP_REFERER']);
        }
    }
}

if (isset($_REQUEST["delete_user"]) && isset($_GET["delete"]) && isset($_GET["user_id"])) {
    $path = '../assets/images/user_images/';

    $user_id = $_GET["user_id"];
    $row = sql("SELECT * FROM `users` WHERE `user_id` = ?", [$user_id])->fetch(PDO::FETCH_ASSOC);

    if ($row["profile_image"] != "default-profile.jpg") {
        if (file_exists($path . $row["profile_image"])) {
            unlink($path . $row["profile_image"]);
        }
    }
    $delete = sql("DELETE FROM `users` WHERE `user_id` = ?", [$user_id]);

    if ($delete) {
        msg('ลบบัญชีเสร็จสิ้น!', 'success', $_SERVER['HTTP_REFERER']);
    }
}
