<?php
require_once "config.php";
require_once "configspecial.php";
//check if the form has been submitted
//cleanup the variables
//prevent mysql

if (dontchangethetime() == 0) {
    header("location:index.php?TimeChanged=");
    exit();
}

if (closewhen2month() == 2) {
    header("location:index.php?SystemLock=");
    exit();
}

if (closewhen2month() == 1) {
    $Lastmonth = "Twitter";
}

// Validate input
if (!isset($_POST['fusername']) || !isset($_POST['fpassword'])) {
    header("location:index.php?TT=0");
    exit();
}

$username = safe_get('fusername', '', 'string');
$password = $_POST['fpassword']; // Don't escape password - will verify against hash

// Use prepared statement to prevent SQL injection
$stmt = $link->prepare("SELECT `member_type`, `M_Active`, `member_pass` FROM `members` WHERE `member_user` = ? LIMIT 1");
if (!$stmt) {
    error_log("Prepare failed: " . $link->error);
    header("location:index.php?TT=0");
    exit();
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    // Check if password is hashed or plain text (for migration)
    $password_valid = false;
    
    if (password_needs_rehash($row['member_pass'], PASSWORD_DEFAULT)) {
        // Old plain text or MD5 - verify and rehash
        if ($row['member_pass'] === $password || md5($password) === $row['member_pass']) {
            // Rehash with new secure method
            $new_hash = hash_password($password);
            $update_stmt = $link->prepare("UPDATE `members` SET `member_pass` = ? WHERE `member_user` = ?");
            if ($update_stmt) {
                $update_stmt->bind_param("ss", $new_hash, $username);
                try {
                    $update_stmt->execute();
                } catch (mysqli_sql_exception $e) {
                    // Most likely schema too small for modern hashes; log and continue without updating
                    error_log("Rehash update failed for user '$username': " . $e->getMessage());
                }
                $update_stmt->close();
            }
            $password_valid = true;
        }
    } else {
        // Modern password hash - use password_verify
        $password_valid = verify_password($password, $row['member_pass']);
    }
    
    if ($password_valid) {
        if ($row['M_Active'] == 0) {
            $stmt->close();
            header("location:index.php?lock");
            exit();
        }
        
        if ($row['M_Active'] == 1) {
            // Regenerate session ID for security
            session_regenerate_id(true);
            $_SESSION['suser_name'] = $username;
            $_SESSION['last_activity'] = time();
            
            if ($row['member_type'] == "admin") {
                header("location:homepageAdmin.php?Lastmonth=" . $Lastmonth);
            } elseif ($row['member_type'] == "LockMaster") {
                header("location:homepageLock.php?Lastmonth=" . $Lastmonth);
            } elseif ($row['member_type'] == "regis") {
                header("location:homepageRegis.php?Lastmonth=" . $Lastmonth);
            } else {
                header("location:index.php?TT=0");
            }
            $stmt->close();
            exit();
        }
    }
}

$stmt->close();
header("location:index.php?TT=0");
exit();
?>