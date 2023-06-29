<?php 

// Para rodar o código, rode php -S localhost:8080;

require_once 'config.php';
require_once 'db.php';
switch ($_SERVER['REQUEST_URI']) {
  case '/':
    require_once './public/home.php';
    break;
  default:
    require_once '404.php';
    break;
  }

?>