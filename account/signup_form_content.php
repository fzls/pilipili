<div>
    <form action="signup.php" role="form" method="post">
        <div class="form-group">
            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail address">
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Password"/>
            <input type="text" class="form-control" id="id" name="id" placeholder="pilipili ID"/>
            <div class="form-control"><span class="input-xlarge uneditable-input pull-left"
                                            style="font-size: 10px;color:Silver;">This will be used in your profile URL etc.</span>
            </div>
        </div>
        <?php
        if ($email_err) {
            echo '
                    <div class="form-control error-prompt"><span class="input-xlarge uneditable-input pull-left"
                                                        style="font-size: 10px;color:Silver;"> ' . $email_err . ' </span>
                        </div>
                    ';
        }
        if ($password_err) {
            echo '
                    <div class="form-control error-prompt"><span class="input-xlarge uneditable-input pull-left"
                                                        style="font-size: 10px;color:Silver;"> ' . $password_err . ' </span>
                        </div>
                    ';
        }
        if ($id_err) {
            echo '
                    <div class="form-control error-prompt"><span class="input-xlarge uneditable-input pull-left"
                                                        style="font-size: 10px;color:Silver;"> ' . $id_err . ' </span>
                        </div>
                    ';
        }
        ?>
        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
    </form>
    <div class="pull-right" style="font-size: 12px; padding: 5px; text-decoration: none;color:#666;"><a
            href="#">I forgot</a></div>
</div>