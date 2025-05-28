<form method="post" action="index.php?url=usermgmt/delete/<?php echo $userId?>" style="max-width:28rem">
    <div class="container mt-1">
        <h2>Delete User</h2>
        <p>Are you sure you want to delete the user <strong><?php echo htmlspecialchars($username); ?></strong>?</p>
        <button type="submit" class="mt-1">Delete User</button>
    </div>

</form>

<a href="index.php?url=usermgmt/index" class="mt-1"><button>Cancel</button></a>