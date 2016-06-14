<div>
    <form action="login.php" role="form" method="post">
        <div class="form-group">
            <input type="text" class="form-control" id="email_or_id" name="email_or_id"
                   placeholder="E-mail address / pilipili ID">
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Password"/>
        </div>
        <?php
        if ($email_or_id_err) {
            echo '
                    <div class="form-control error-prompt"><span class="input-xlarge uneditable-input pull-left"
                                                        style="font-size: 10px;color:Silver;"> ' . $email_or_id_err . ' </span>
                        </div>
                    ';
        }
        if ($password_err) {
            echo '
                    <div class="form-control error-prompt"><span class="input-xlarge uneditable-input pull-left"
                                                        style="font-size: 10px;color:Silver;display: block;"> ' . $password_err . ' </span>
                        </div>
                    ';
        }
        ?>
        <button type="submit" class="btn btn-info btn-block">Login</button>
    </form>
    <div class="pull-right" style="font-size: 12px; padding: 5px; text-decoration: none; color: #666;"><a
            href="#">I forgot</a>
    </div>
</div>