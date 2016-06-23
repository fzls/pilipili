<?php
/**
 * Copyright (c) 2016. 
 * Contact me at fzls.zju@gmail.com [ Chen Ji ]
 */

# validate form data
require '../util/form_data_validation.php';

$email_or_id = $password = '';
$email_or_id_err = $password_err = '';
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    // data validation
    if (empty($_POST['email_or_id'])) {
        $email_or_id_err = 'Please enter your email or pilipili id';
    } else {
        $email_or_id = censor_input($_POST['email_or_id']);
    }

    if (empty($_POST['password'])) {
        $password_err = 'Please enter your password';
    } else {
        $password = censor_input($_POST['password']);
    }

    //check if password and user is matched
    if (empty($email_or_id_err) and empty($password_err)) {//everything is right
        require_once '../common/connect_db.php';
        $conn = connect_db();
        $res = $conn->query("SELECT * FROM user WHERE (email='" . $email_or_id . "' OR pilipili_id='" . $email_or_id . "')AND password=md5('" . $password . "')");
        // close db connection
        $conn->close();
        // if login successfully, redirect to homepage
        if ($res->num_rows != 0) {
            session_start();
            $current_user = $res->fetch_assoc();
            $_SESSION['current_user'] = $current_user;
            header('Location: ' . '../home/index.php', true, 301);
            exit;
        } else {
            $email_or_id_err = 'Please check your email or pilipili id.';
        }
    }
}
?>
<?php
$title = 'Login | pilipili';
$background_image = 'login.jpg';
$btn_text = 'Sign Up';
$btn_action = 'signup.php';
$form_content = 'login_form_content.php';
require '_Layout.php';
?>