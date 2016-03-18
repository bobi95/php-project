<form class="form-signin" style="max-width: 550px; margin: 0 auto;" method="post">
    <h2 class="form-signin-heading">Please sign in</h2>
    <span class="text-danger"><?=$model->getError('auth');?></span>
    <label for="username" class="sr-only">Email address</label>
    <input type="test" name="username" id="username" class="form-control" placeholder="Username" required autofocus value="<?=$model->getUsername()?>">
    <span class="text-danger"><?=$model->getError('username');?></span>
    <label for="password" class="sr-only">Password</label>
    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
    <span class="text-danger"><?=$model->getError('password');?></span>
    <div class="checkbox">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>