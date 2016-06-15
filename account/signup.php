<?php
/**
 * Copyright (c) 2016. 
 * Contact me at fzls.zju@gmail.com [ Chen Ji ]
 */

# validate form data
require '../util/form_data_validation.php';

$email = $password = $id = '';
$email_err = $password_err = $id_err = '';
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    // data validation
    if (empty($_POST['email'])) {
        $email_err = 'Please enter your email';
    } else if (email_registered(censor_input($_POST['email']))) {
        $email_err = 'Email already exists';
    } else {
        $email = censor_input($_POST['email']);
    }

    if (empty($_POST['password'])) {
        $password_err = 'Please enter your password';
    } else {
        $password = censor_input($_POST['password']);
    }

    if (empty($_POST['id'])) {
        $id_err = 'Please enter your id';
    } else if (id_registered(censor_input($_POST['id']))) {
        $id_err = 'Id already exists';
    } else {
        $id = censor_input($_POST['id']);
    }
    if (empty($email_err) and empty($password_err) and empty($id_err)) {//everything is right
        $conn = new mysqli('localhost', 'root', 'root', 'pilipili');
        // add new user to db
        $stmt = $conn->prepare("INSERT INTO user(email,password,pilipili_id,avatar_filepath,custom_background_image_filepath) VALUES (?,md5(?), ?,'../img/default_avatar.jpg','../img/default_background.jpg')");
        $stmt->bind_param('sss', $email, $password, $id);
        $stmt->execute();
        $stmt->close();

        //fetch user from db
        $res = $conn->query("SELECT * FROM user WHERE pilipili_id='" . $id . "'");
        $current_user = $res->fetch_assoc();

        //close db connection
        $conn->close();
        // redirect to homepage
        session_start();
        $_SESSION['current_user'] = $current_user;
        header('Location: ' . '../home/index.php', true, 301);
        exit;
    }
}
?>
<?php
$title = 'Sign Up | pilipili';
$background_image = 'signup.jpg';
$btn_text = 'Login';
$btn_action = 'login.php';
$form_content = 'signup_form_content.php';
require '_Layout.php';
?>
