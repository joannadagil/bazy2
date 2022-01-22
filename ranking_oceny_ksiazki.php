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
      $book_ratings = oci_parse($conn, "SELECT BTITLE, AVG(RATE) as OCENA, COUNT(*) as ILOSC_OCEN FROM BOOK JOIN RATING ON idbook=bid GROUP BY btitle, bid HAVING COUNT(*) >= 1 ORDER BY ocena DESC, ilosc_ocen DESC FETCH FIRST 100 ROWS ONLY");
      // Wykonywanie wyrazenia SQL-owego
      oci_execute($book_ratings, OCI_NO_AUTO_COMMIT);
    ?>

    <div class="header">
      <h1>Rankingi biblioteczne</h1>
    </div>

    <div class="topnav">
      <a href="main_page.php">Strona główna</a>
      <a href="rankingi.php">Ilość książek</a>
      <a class="active" href="ranking_oceny_ksiazki.php">Oceny książek</a>
    </div>

    <p> Ksiązki po ocenie </p>

    <table> 
      <tr>
        <td> Tytuł </td>
        <td> Średnia ocena </td>
        <td> Ilość ocen </td>
      </tr>
      <?PHP
      while (($row = oci_fetch_array($book_ratings, OCI_BOTH))) {
        ?>
        <tr>
          <td><?php echo $row["BTITLE"]; ?></td>
          <td text-align=center><?php echo $row["OCENA"]; ?></td>
          <td text-align="center"><?php echo $row["ILOSC_OCEN"]; ?></td>
	    </tr>
      <?php
      }
    ?>
    </table>
  </BODY>
</HTML>
