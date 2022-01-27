<html>
<body>
  <?php
      session_start();
      unset($_SESSION['USER']);
      header("Location: main_page.php");
      exit;
  ?>
</body>
</html>
