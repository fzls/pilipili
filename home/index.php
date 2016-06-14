<?php require '../common/check_loged_in.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>pilipili - powered by 风之凌殇</title>
    <?php require '../common/head.php' ?>
</head>
<body>
<!-- navigation -->
<?php require '../common/navbar.php' ?>
<div class="container">
    <!--body-->
    <div>
        <h1><?php if (isset($_SESSION['current_user'])) echo 'Hi ' . $_SESSION['current_user']['pilipili_id'] . ' ,'; ?>
            welcome to
            pilipili, and the homepage is still being implemented, please wait :)</h1>
    </div>
    <!--    TODO: implement homepage-->
    <div>
        <a href="../image/detail.php">Debug detail page :) delete it after implemented</a>
    </div>
    <!--footer-->
    <?php require '../common/footer.php' ?>
</div>
</body>
</html>