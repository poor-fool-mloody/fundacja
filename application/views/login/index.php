<p>
    <div class="container">
        <?php

        if (isset($login_failed) && $login_failed === true)
            echo '<h3 style="color: red;">Podano złe dane!</h3>';

        $attributes = array('class' => 'form-signin');
        echo form_open('login/login/', $attributes); ?>
                <h2 class="form-signin-heading">Logowanie</h2>
                <input type="text" class="form-control" name="login" placeholder="Login" required="" autofocus="" />
                <input type="password" class="form-control" name="password" placeholder="Hasło" required=""/>
                <input class="btn btn-lg btn-primary btn-block" type="submit" value="Zaloguj"></input>
        <?php echo form_close(); ?>
    </div>
</p>