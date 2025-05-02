<?php
require_once __DIR__ . '/config.php';

class Cart {
    private $pdo;
    private $user_id;
    private $cart_id;

    public function __construct($user_id) {
        $this->pdo = $GLOBALS['pdo'];
        $this->user_id = $user_id;
        $this->initializeCart();
    }

    private function initializeCart() {
        // Check if user has an active cart
        $stmt = $this->pdo->prepare("SELECT id FROM cart WHERE user_id = ?");
        $stmt->execute([$this->user_id]);
        $cart = $stmt->fetch();

        if (!$cart) {
            // Create new cart if none exists
            $stmt = $this->pdo->prepare("INSERT INTO cart (user_id) VALUES (?)");
            $stmt->execute([$this->user_id]);
            $this->cart_id = $this->pdo->lastInsertId();
        } else {
            $this->cart_id = $cart['id'];
        }
    }

    public function addItem($book_id, $quantity = 1) {
        // Check if item already exists in cart
        $stmt = $this->pdo->prepare("SELECT id, quantity FROM cart_items 
                                    WHERE cart_id = ? AND book_id = ?");
        $stmt->execute([$this->cart_id, $book_id]);
        $item = $stmt->fetch();

        if ($item) {
            // Update quantity if item exists
            $new_quantity = $item['quantity'] + $quantity;
            $stmt = $this->pdo->prepare("UPDATE cart_items SET quantity = ? 
                                        WHERE id = ?");
            $stmt->execute([$new_quantity, $item['id']]);
        } else {
            // Add new item
            $stmt = $this->pdo->prepare("INSERT INTO cart_items (cart_id, book_id, quantity) 
                                        VALUES (?, ?, ?)");
            $stmt->execute([$this->cart_id, $book_id, $quantity]);
        }
    }

    public function removeItem($book_id) {
        $stmt = $this->pdo->prepare("DELETE FROM cart_items 
                                    WHERE cart_id = ? AND book_id = ?");
        $stmt->execute([$this->cart_id, $book_id]);
    }

    public function updateQuantity($book_id, $quantity) {
        if ($quantity <= 0) {
            $this->removeItem($book_id);
            return;
        }

        $stmt = $this->pdo->prepare("UPDATE cart_items SET quantity = ? 
                                    WHERE cart_id = ? AND book_id = ?");
        $stmt->execute([$quantity, $this->cart_id, $book_id]);
    }

    public function getItems() {
        $stmt = $this->pdo->prepare("SELECT ci.*, b.title, b.author, b.price, b.image 
                                    FROM cart_items ci
                                    JOIN books b ON ci.book_id = b.id
                                    WHERE ci.cart_id = ?");
        $stmt->execute([$this->cart_id]);
        return $stmt->fetchAll();
    }

    public function getTotal() {
        $items = $this->getItems();
        $total = 0;

        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    public function clear() {
        $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE cart_id = ?");
        $stmt->execute([$this->cart_id]);
    }
}
?>