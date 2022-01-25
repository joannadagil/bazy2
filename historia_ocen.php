<HTML>
  <HEAD>
    <TITLE> Moje książki </TITLE>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="utf-8">
    <style>
      table td input[type=submit] {
        border: none;
        cursor: pointer;
        width: 100%;
        background: #ccc;
        font-size: 17px;
        padding: 6px;
        float: center;
      }
      input[type=submit]:hover {
        background: #bbb;
      }
      table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        padding: 0px 15px;
      }
    </style>
  </HEAD>
  <BODY>
    <div class="header">
      <h1>Moje konto</h1>
    </div>
    <?PHP
      session_start();
      if (!isset($_SESSION['USER'])) {
        header("Location: login_library.html");
        exit;
      }
      $conn = oci_connect($_SESSION['LOGIN'],$_SESSION['PASS'],"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
        echo "oci_connect failed\n";
        $e = oci_error();
        echo $e['message'];
      }
      $stmt = oci_parse($conn,"SELECT B.BTITLE AS TITL, R.RATE AS OCENA, R.RDATE AS RDATA FROM BOOK B, RATING R WHERE B.BID = R.IDBOOK AND R.IDRATER = ".$_SESSION['USER']."ORDER BY R.RDATE DESC FETCH FIRST 100 ROWS ONLY");
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
    ?>

    <div class="topnav">
      <a href="main_page.php">Strona główna</a>
      <a href="zwrot.php">Aktywne książki</a>
      <a href="historia_wypozyczen.php">Historia wypożyczeń</a>
      <a class="active" href="historia_ocen.php">Historia ocen</a>
    </div>

    <table> 
      <thead>
        <tr>
          <td> Tytuł </td>
          <td> Ocena </td>
          <td> Data oceny </td>
        </tr>
      </thead>
      <?PHP
      while (($row = oci_fetch_array($stmt, OCI_BOTH))) {
        ?>
        <tr>
      	  <td><?php echo $row["TITL"]; ?></td>
          <td><?php echo $row["OCENA"]; ?></td>
          <td><?php echo $row["RDATE"]; ?></td>
	      </tr>
      <?php
      }
    ?>
    </table>
  </BODY>
</HTML>
