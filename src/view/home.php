<?php
  echo '<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/style.css">
    <title>To-do List</title>
  </head>';

  echo '<body>';
  require_once 'components/header.php';  
  require_once 'components/list.php';
  // require_once  'components/footer.php';

  echo '<script src="public/script.js"></script></body>
  </html>';
?>