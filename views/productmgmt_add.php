
<!-- views/usermgmt_add.php -->

<div class="container mt-1">
    <h2>Add Product</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?url=productmgmt/add" method="post" style="max-width:28rem">
        <label for="name">Product Name</label>
        <input id="name" name="name" type="text" value="<?php echo $_POST['name'] ?? '' ?>" required autofocus>

        <label for="desc" class="mt-1">Description</label>
        <input id="desc" name="desc" type="text" value="<?php echo $_POST['desc'] ?? '' ?>" required>

        <label for="category" class="mt-1">Category</label>
        <select id="category" name="category" required>
            <option value="" disabled selected>Select a category</option>

            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['category_id']); ?>">
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="quantity" class="mt-1">quantity</label>
        <input id="quantity" name="quantity" type="number" value="<?php echo $_POST['quantity'] ?? 0 ?>" required>
        <input type="hidden" name="submit" value="1">
        <button type="submit" class="mt-1">Create Product</button>


    </form>
</div>