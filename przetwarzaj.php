<html>
  <head>
    <title>Favourite word</title>
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
    <?php
      // Capture the values posted to this php program from the text fields which were named 'YourName' and 'FavoriteWord' respectively.
      // All values:
      $YourName = $_REQUEST['YourName'];
      // Values sent with GET method:
      // $YourName = $_GET['YourName'];
      // Values sent with POST method:
      // $YourName = $_POST['YourName'];
      $FavoriteWord = $_REQUEST['FavoriteWord'];
    ?>
    Hi <?php print $YourName; ?>! <br> <br>
    You like the word <b> <?php print $FavoriteWord; ?> </b>? <br> <br>
    How bizarre!
  </body>
</html>
