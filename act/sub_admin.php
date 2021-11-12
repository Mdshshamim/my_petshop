<?php
    session_start();
    include('../include/config.php');

    if(isset($_POST['create'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        $stmt = $db->prepare("SELECT id FROM users WHERE email=?");
        $stmt->execute([
            $email,
        ]);

        if($stmt->rowCount() > 0){
            $_SESSION['error'] = $email." email are already used.";
            header('Location: ../sub_admin_list.php');
            exit();
        } else{
            $stmt = $db->prepare("INSERT INTO users(name, email, phone, password, user_type) VALUES(?,?,?,?,?)");
            $stmt->execute([
                $name,
                $email,
                $phone,
                $password,
                'sub_admin'
            ]);
            $_SESSION['success'] = "Sub Admin store Success.";
            header('Location: ../sub_admin_list.php');
            exit();
        }
    }

    if(isset($_POST['update'])){
        $sub_admin_id = $_POST['sub_admin_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        $stmt = $db->prepare("SELECT id FROM users WHERE id=?");
        $stmt->execute([
            $sub_admin_id,
        ]);

        if($stmt->rowCount() > 0){
            $stmt = $db->prepare("UPDATE users SET name=?, email=?, phone=?, password=? WHERE id=?");
            $stmt->execute([
                $name,
                $email,
                $phone,
                $password,
                $sub_admin_id
            ]);
            $_SESSION['success'] = "Sub Admin Profile Successfully Updated.";
            header('Location: ../sub_admin_list.php');
            exit();
        } else{
            $_SESSION['error'] = "Sub Admin Profile Not Found.";
            header('Location: ../sub_admin_list.php');
            exit();
        }
    }

    if(isset($_GET['delete_id'])){
        $stmt = $db->prepare("SELECT id FROM users WHERE id=? AND user_type=?");
        $stmt->execute([
            $_GET['delete_id'],
            'sub_admin'
        ]);
        if($stmt->rowCount() > 0){
            $stmt = $db->prepare("DELETE FROM users WHERE id=?");
            $stmt->execute([
                $_GET['delete_id'],
            ]);
            $_SESSION['success'] = "Sub Admin successfully deleted.";
            header('Location: ../sub_admin_list.php');
            exit();
        } else{
            $_SESSION['error'] = "Sub Admin not found.";
            header('Location: ../sub_admin_list.php');
            exit();
        }
    }

    if(isset($_GET['active_id'])){
        $stmt = $db->prepare("SELECT id FROM users WHERE id=? AND user_type=?");
        $stmt->execute([
            $_GET['active_id'],
            'sub_admin'
        ]);

        if($stmt->rowCount() > 0){
            $stmt = $db->prepare("UPDATE users SET status=? WHERE id=?");
            $stmt->execute([
                1,
                $_GET['active_id'],
            ]);
            $_SESSION['success'] = "Sub Admin Account are Activated.";
            header('Location: ../sub_admin_list.php');
            exit();
        } else{
            $_SESSION['error'] = "Failed to Activate Sub Admin id.";
            header('Location: ../sub_admin_list.php');
            exit();
        }
    }

    header('Location: ../sub_admin_list.php');
    exit();