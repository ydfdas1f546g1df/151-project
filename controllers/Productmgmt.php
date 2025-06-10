<?php

namespace controllers;

class Productmgmt extends \core\Controller
{
    protected \models\Product $product_model;
    protected \models\User $author_model;

    public function __construct()
    {
        $this->product_model = new \models\Product();
        $this->author_model = new \models\User();
    }

    public function index()
    {
        $products = $this->product_model->getAllProducts();
        $this->renderView('productmgmt_index', [
            'products' => $products
        ], 'KSH ERP - Product Management', '');
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['submit'])) {
                $name = trim($_POST['name']);
                $desc = trim($_POST['desc']);
                $category = trim($_POST['category']);
                $quantity = (int)$_POST['quantity'];
                $author_id = $_SESSION['user']['id']; // Assuming user_id is stored in session
                if (empty($name) || empty($desc) || empty($category) || $quantity < 0) {
                    $error = 'All fields are required and quantity must be a non-negative number.';
                } else {
                    if ($this->product_model->createProduct($name, $desc, $category, $quantity, $author_id)) {
                        header('Location: index.php?url=productmgmt/index');
                        echo 'Product created successfully!';
                        echo '<br>';
                        echo '<a href="index.php?url=productmgmt/index">Go back to product list</a>';
                        exit;
                    } else {
                        $error = 'Failed to create product. Please try again.';
                    }
                }

            }
        }

        $this->renderView('productmgmt_add', ['categories' => $this->product_model->getAllCategories()], 'KSH ERP - Add Product', 'public/css/productmgmt_add.css');
    }

    public function delete($params = []){
        $id = $params[0] ?? null;
        if (!empty($id)) {
            $product_id = (int)$id;
            if ($this->product_model->deleteProduct($product_id)) {
                header('Location: index.php?url=productmgmt/index');
                exit;
            } else {
                $error = 'Failed to delete product. Please try again.';
            }
        } else {
            $error = 'Invalid product ID.';
        }
        print_r($error);
    }

    public function edit($params = []){
        $id = $params[0] ?? null;
        $id = (int)$id; // Ensure $id is an integer
        if (empty($id)) {
            http_response_code(400);
            echo "Product ID is required.";
            header("Location: index.php?url=productmgmt/index");
            return;
        }
        $product = $this->product_model->getProductById($id);
        if (!$product) {
            http_response_code(404);
            echo "Product not found.";
            header("Location: index.php?url=productmgmt/index");
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $desc = trim($_POST['desc']);
            $category = trim($_POST['category']);
            $quantity = (int)$_POST['quantity'];
            if (empty($name) || empty($desc) || empty($category) || $quantity < 0) {
                $error = 'All fields are required and quantity must be a non-negative number.';
            } else {
                if ($this->product_model->createProduct($name, $desc, $category, $quantity, $_SESSION['user']['id'])) {
                    header('Location: index.php?url=productmgmt/index');
                    echo 'Product updated successfully!';
                    echo '<br>';
                    echo '<a href="index.php?url=productmgmt/index">Go back to product list</a>';
                    exit;
                } else {
                    $error = 'Failed to update product. Please try again.';
                }
            }
        }
        $categories = $this->product_model->getAllCategories();

        $this->renderView('productmgmt_edit', [
            'product' => $product,
            'categories' => $categories,
            'error' => $error ?? ''
        ], 'KSH ERP - Edit Product');
    }
}