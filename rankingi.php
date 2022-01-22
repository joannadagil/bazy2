<HTML>
  <HEAD>
    <TITLE> Biblioteka - Rankingi </TITLE>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="utf-8">
    <style>
      thead {
        background-color: #1abc9c;
        color: white;
        font-size: 19px;
      }
      h2 {
        text-align: center;
      }
    </style>
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
      <a href="main_page.php">Strona główna</a>
      <a class="active" href="rankingi.php">Ilość książek</a>
      <a href="ranking_oceny_ksiazki.php">Oceny książek</a>
    </div>

    <h2> Ranking autorów względem ilości książek posiadanych przez bibliotekę </h2>

    <table> 
      <thead>
        <tr>
          <td> Miejsce </td>
          <td> Tytuł </td>
          <td> Ilość książek </td>
        </tr>
      </thead>
      <?PHP
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
    <div class="footer">
      <p style="text-align:left;">
        Biblioteka Publiczna im. Ignacego Makowskiego i Joanny Dagil
        <span style="float:right;">
        All rights reserved
        </span>
      </p>
    </div>
  </BODY>
</HTML>
