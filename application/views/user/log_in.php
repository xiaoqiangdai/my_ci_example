<html>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <head>
        <title>用户登录</title>
    </head>
    <body >

        <?php echo form_open('user/log_in'); ?>

        <label for="username">用户名:</label>
        <input type="text" name="username" value="<?php echo set_value('username'); ?>" />
        <?php echo form_error('username'); ?><br />

        <label for="password">密码:</label>
        <input type="password" name="password" value="" />
        <?php echo form_error('password'); ?><br />

        <div>
            <input type="submit" name='submit' value="登录" />
            <a href="sign_up">注册</a>
        </div>
        </form>

    </body>
</html>