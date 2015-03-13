<html>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <head>
        <title>用户注册</title>
    </head>
    <body >

    <?php echo validation_errors(); ?>

        <?php echo form_open('user/sign_up'); ?>

            <label for="username">用户名:</label>
            <input type="text" name="username" value="<?php echo set_value('username'); ?>" /><br />

            <label for="password">密码:</label>
            <input type="password" name="password" value="" /><br />

            <label for="pass_confirm">密码确认:</label>
            <input type="password" name="pass_confirm" value="" /><br />

            <label for="email">邮箱:</label>
            <input type="text" name="email" value="<?php echo set_value('email'); ?>" /><br />

            <div>
                <input type="submit" name='submit' value="提交" />
                <a href="log_in">登录</a>
            </div>
        </form>

    </body>
</html>