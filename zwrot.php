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
      $stmt = oci_parse($conn,"SELECT BI.BIID AS ID, B.BTITLE AS TITL, D.DNAME AS NAM, D.DADDRESS AS ADRS FROM BOOK B, BOOKINSTANCE BI, DEPARTMENT D , BORROWING BR WHERE BI.BOOK = B.BID AND BI.DEPARTMENT = D.DID AND BR.IDBOOK = BI.BIID AND BR.RETURN IS NULL AND BR.IDLENDER = ".$_SESSION['USER']."ORDER BY BI.BIID FETCH FIRST 100 ROWS ONLY");
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
    ?>

    <div class="topnav">
      <a href="main_page.php">Strona główna</a>
      <a class="active" href="zwrot.php">Aktywne książki</a>
      <a href="historia_wypozyczen.php">Historia wypożyczeń</a>
      <a href="historia_ocen.php">Historia ocen</a>
      <a href="polecenie.php">Moja rekomendacja</a>
    </div>

    <table> 
      <thead>
        <tr>
          <td> ID </td>
          <td> Tytuł </td>
          <td> Departament </td>
          <td> Adres </td>
          <td> Zwrot </td>
        </tr>
      </thead>
      <?PHP
      while (($row = oci_fetch_array($stmt, OCI_BOTH))) {
        ?>
        <tr>
          <td><?php echo $row["ID"]; ?></td>
      		<td><?php echo $row["TITL"]; ?></td>
          <td><?php echo $row["NAM"]; ?></td>
          <td><?php echo $row["ADRS"]; ?></td>
          <td>
            <form ACTION="add_return_date.php" METHOD="POST">
              <input TYPE="HIDDEN" NAME="to_return" VALUE="<?php echo $row["ID"];?>">
              <input TYPE="SUBMIT" VALUE="Zwróć">
            </form>
          </td>
	      </tr>
      <?php
      }
    ?>
    </table>
  </BODY>
</HTML>
