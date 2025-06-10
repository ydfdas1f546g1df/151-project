<?php
if(!isset($products)){$products = [];}
?>

<div class="productmgmt-page">
<h1>Product Management</h1>
<table class="productmgmt-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>quantity</th>
            <th>Author</th>
            <th>Actions</th>
        </tr>
        <a href="index.php?url=productmgmt/add" class="add-product-button"><button>Add Product</button></a>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo htmlspecialchars($product['product_id']); ?></td>
            <td><?php echo htmlspecialchars($product['title']); ?></td>
            <td><?php echo htmlspecialchars($product['content']); ?></td>
            <td><?php echo htmlspecialchars($product['quantity']); ?></td>
            <td><?php echo htmlspecialchars($product['username']); ?></td>
            <td class="table-actions">
                <a href="index.php?url=productmgmt/edit/<?php echo $product['product_id']; ?>">Edit</a> |
                <a href="index.php?url=productmgmt/delete/<?php echo $product['product_id']; ?>">Delete</a>
            </td>
        </tr>
        <?php //print_r($product); ?>
        <?php endforeach; ?>
    </tbody>
</table>
    <?php //print_r($products); ?>
</div>

<script>
    // Delete confirmation
    document.querySelectorAll('.table-actions a[href*="delete"]').forEach(link => {
        link.addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to delete this product?')) {
                event.preventDefault();
            }
        });
    });
</script>
