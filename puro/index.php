<?php
// TODO: Criar arquivo ROUTE.PHP
$request = $_SERVER["REQUEST_URI"];

switch ($request):
    // HOME
    case "/":
    case "":
        require __DIR__ . "/controllers/home.php";
        break;

    // DASHBOARD
    case "/home":
        require __DIR__ . "/controllers/dashboard.php";
        break;

    // LOGIN
    case "/login": //GET
        require __DIR__ . "/controllers/home.php";
        break;
    case "/auth": // POST
        require __DIR__ . "/controllers/auth.php";
        break;
    case "/logout":
        require __DIR__ . "/controllers/logout.php";
        break;

    // 404: Não encontrado.
    default:
        http_response_code(404);
        require __DIR__ . "/templates/404.html";
        break;
endswitch;
