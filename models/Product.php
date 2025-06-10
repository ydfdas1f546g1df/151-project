<?php

namespace models;
use core\Database;

class Product
{
    function getAllProducts()
    {
        $db = new Database();
        $query = "SELECT * FROM product LEFT JOIN user ON product.author_id = user.id";
        $db->query($query);
        $db->execute();
        return $db->results();
    }
    function getProductById($id)
    {
        $db = new Database();
        $query = "SELECT * FROM product LEFT JOIN user ON product.author_id = user.id WHERE id = :id ";
        $db->query($query);
        $db->bind(':id', $id);
        $db->execute();
        return $db->single();
    }

    function getAllCategories()
    {
        $db = new Database();
        $query = "SELECT * FROM product_category";
        $db->query($query);
        $db->execute();
        return $db->results();
    }

    function createProduct($name, $desc, $category, $quantity, $author_id)
    {
        $db = new Database();
        $query = "INSERT INTO product (title, content, category_id, quantity, author_id) VALUES (:name, :desc, :category, :quantity, :author_id)";
        $db->query($query);
        $db->bind(':name', $name);
        $db->bind(':desc', $desc);
        $db->bind(':category', $category);
        $db->bind(':quantity', $quantity);
        $db->bind(':author_id', $author_id);
        return $db->execute();
    }

    function deleteProduct($id)
    {
        $db = new Database();
        $query = "DELETE FROM product WHERE product_id = :id";
        $db->query($query);
        $db->bind(':id', $id);
        return $db->execute();
    }

}