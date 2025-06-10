<div class="container mt-1">
    <h2>Add User</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?url=productmgmt/add" method="post" style="max-width:28rem">
        <label for="name">Product Name</label>
        <input id="name" name="name" type="text" value="<?php echo $product['title'] ?>" required autofocus>

        <label for="desc" class="mt-1">Description</label>
        <input id="desc" name="desc" type="text" value="<?php echo $product['content'] ?>" required>

        <label for="category" class="mt-1">Category</label>
        <select id="category" name="category" required>

            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['category_id']); ?> <?php if($product['category_id'] == $category['category_id']){echo 'selected';} ?>) ?>">
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="quantity" class="mt-1">quantity</label>
        <input id="quantity" name="quantity" type="number" value="<?php echo $product['quantity'] ?>" required>
        <input type="hidden" name="submit" value="1">
        <button type="submit" class="mt-1">Change Product</button>
        <button id="backButton">Back</button>

    </form>
</div>

<script>
    document.getElementById('backButton').addEventListener('click', function(event) {
        event.preventDefault();
        // Go to last page
        window.history.back();
    });
</script>