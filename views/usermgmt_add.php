<!-- views/usermgmt_add.php -->

<div class="container mt-1">
    <h2>Add User</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?url=usermgmt/add" method="post" style="max-width:28rem">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="<?php echo $username ?>" required autofocus>

        <label for="email" class="mt-1">Email</label>
        <input id="email" name="email" type="email" value="<?php echo $email ?>" required>

        <label for="password" class="mt-1">Password</label>
        <input id="password" name="password" type="password" value="<?php echo $password ?>" required
               placeholder="min 6 characters">

        <button type="submit" class="mt-1">Create user</button>
    </form>
</div>
