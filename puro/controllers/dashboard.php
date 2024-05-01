<?php
session_start();
require_once "config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: /login");
    exit();
}

class Dashboard
{
    private $pdo;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function getTasks($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Uso da classe Dashboard
$dashboard = new Dashboard();
$user_id = $_SESSION["user_id"];
$tasks = $dashboard->getTasks($user_id);

echo "<h1>Dashboard</h1>";
print_r($tasks);

echo '<p><a href="/logout">Sair</a></p>';
