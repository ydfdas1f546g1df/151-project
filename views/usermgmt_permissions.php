<form method="POST" action="index.php?url=usermgmt/edit-permissions/<?php echo $user['id']?>">
    <h2>Edit Permissions for <?php echo htmlspecialchars($user['username']); ?></h2>
    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">


    <?php foreach ($allPermissions as $permission): ?>
        <div>
            <label>
                <input type="checkbox" name="permissions[]" value="<?php echo $permission['role_name']; ?>"
                    <?php echo in_array($permission['role_name'], $user['roles']) ? 'checked' : ''; ?>>
                <?php echo htmlspecialchars($permission['role_name']); ?>
            </label>
        </div>
    <?php endforeach; ?>

    <button type="submit">Save Permissions</button>

</form>