<?php if(!isset($users)){$users = [];} ?>
<div class="usermgmt-page">
<h1>User Management</h1>
<table class="usermgmt-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <a href="index.php?url=usermgmt/add" class="add-user-button"><button>Add User</button></a>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['id']); ?></td>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><?php echo htmlspecialchars($user['roles']??''); ?></td>
            <td class="table-actions">
                <a href="index.php?url=usermgmt/edit/<?php echo $user['id']; ?>">Edit</a> |
                <a href="index.php?url=usermgmt/delete/<?php echo $user['id']; ?>">Delete</a>
                <a href="index.php?url=usermgmt/edit-permissions/<?php echo $user['id']; ?>">Edit Permissions</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
