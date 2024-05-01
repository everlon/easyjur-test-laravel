<?php
session_start();
require_once "config/db.php";

class Auth
{
    private $pdo;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function login($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["role"] = $user["role"];
            return true;
        }
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST"):
    $username = $_POST["username"];
    $password = $_POST["password"];

    $auth = new Auth();

    if ($auth->login($username, $password)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Credenciais inválidas",
        ]);
    }
endif;
