<html>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<head>
    <title>用户列表</title>
</head>
<body>

    <?php if (isset($logged_user)&&!empty($logged_user['username'])) :?>
        当前用户：<?php echo $logged_user['username'] ?>
        <a href="log_out">退出</a>
        <br/>
    <?php endif ?>
    <?php foreach ($users as $user): ?>
        <?php echo $user['username'] ?>
        <?php echo $user['email'] ?>
        <!--<a href="detail/<?php echo $user['id'] ?>">详情</a>-->
        <!--<a href="edit/<?php echo $user['id'] ?>">编辑</a>-->
        <a href="delete/<?php echo $user['id'] ?>">删除</a><br/>

    <?php endforeach ?>
</body>
</html>
