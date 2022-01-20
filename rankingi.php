<HTML>
  <HEAD>
    <TITLE> Biblioteka - Rankingi </TITLE>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="utf-8">
  </HEAD>
  <BODY>

    <?PHP
      session_start();
      $conn = oci_connect($_SESSION['LOGIN'],$_SESSION['PASS'],"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
        echo "oci_connect failed\n";
        $e = oci_error();
        echo $e['message'];
      }

      // Tworzenie wyrazenia SQL-owego. Uzycie fmurlak.naukowiec zamiast naukowiec pozwala na odczytanie tabeli inego uzytkownika.
      $author_book_amount = oci_parse($conn, "WITH a AS (SELECT aname, COUNT(*) AS amount FROM author JOIN authorship ON aid = idauthor GROUP BY aname, aid ORDER BY amount DESC FETCH FIRST 100 ROWS ONLY) SELECT ROWNUM, a.* FROM a");
      // Wykonywanie wyrazenia SQL-owego
      oci_execute($author_book_amount, OCI_NO_AUTO_COMMIT);
    ?>

    <div class="header">
      <h1>Rankingi biblioteczne</h1>
    </div>

    <div class="topnav">
      <a class="active" href="#home">Home</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
    </div>

    <p> Autorzy po ilości książek </p>

    <table> <?PHP
      while (($row = oci_fetch_array($author_book_amount, OCI_BOTH))) {
        ?>
        <tr>
          <td><?php echo $row["ROWNUM"]; ?></td>
          <td><?php echo $row["ANAME"]; ?></td>
      	  <td><?php echo $row["AMOUNT"]; ?></td>
	    </tr>
      <?php
      }
    ?>
    </table>

  </BODY>
</HTML>
