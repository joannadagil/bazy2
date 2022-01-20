<HTML>
  <HEAD>
    <TITLE> Katalog </TITLE>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="utf-8">
  </HEAD>
  <BODY>
    <div class="header">
      <h1>Wypożyczanie</h1>
    </div>
    <?PHP
      session_start();
      $available_book = $_POST['available'];
      $conn = oci_connect($_SESSION['LOGIN'],$_SESSION['PASS'],"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
        echo "oci_connect failed\n";
        $e = oci_error();
        echo $e['message'];
      }
      $stmt = oci_parse($conn,"SELECT BI.BIID AS ID, B.BTITLE AS TITL, D.DNAME AS NAM, D.DADDRESS AS ADRS FROM BOOK B, BOOKINSTANCE BI, DEPARTMENT D WHERE BI.BOOK = ".$available_book." AND BI.BOOK = B.BID AND BI.DEPARTMENT = D.DID AND ((SELECT COUNT(*) FROM BORROWING BR WHERE BR.IDBOOK = BI.BIID AND BR.RETURN IS NULL) > 0) ORDER BY BI.BIID FETCH FIRST 100 ROWS ONLY");
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
    ?>

    <table> <?PHP
      while (($row = oci_fetch_array($stmt, OCI_BOTH))) {
        ?>
        <tr>
          <td><?php echo $row["ID"]; ?></td>
      		<td><?php echo $row["TITL"]; ?></td>
          <td><?php echo $row["NAM"]; ?></td>
          <td><?php echo $row["ADRS"]; ?></td>
	      </tr>
      <?php
      }
    ?>
    </table>
  </BODY>
</HTML>
