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
      $member_rating = oci_parse($conn, "SELECT RANK() OVER (ORDER BY COUNT(*) DESC) RANKING, MID, MNAME, COUNT(*) as ILE FROM RATING JOIN MEMBER ON IDRATER = MID GROUP BY MID, MNAME ORDER BY ILE DESC FETCH FIRST 100 ROWS ONLY");
      // Wykonywanie wyrazenia SQL-owego
      oci_execute($member_rating, OCI_NO_AUTO_COMMIT);
    ?>

    <div class="header">
      <h1>Rankingi biblioteczne</h1>
    </div>

    <div class="topnav">
      <a href="main_page.php">Strona główna</a>
      <a href="rankingi.php">Ilość książek</a>
      <a href="ranking_oceny_ksiazki.php">Oceny książek</a>
      <a href="ranking_popularnosci.php">Popularność książek</a>
      <a class="active" href="ranking_uzytkownikow.php">Aktywność użytkowników</a>
    </div>

    <h2> Ranking aktywności użytkowników </h2>

    <table>
      <thead>
        <tr>
          <td> Miejsce </td>
          <td> Identyfikator </td>
          <td> Imię i nazwisko </td>
          <td> Ilość ocen </td>
        </tr>
      </thead>
      <?PHP
      while (($row = oci_fetch_array($member_rating, OCI_BOTH))) {
        ?>
        <tr>
          <td><?php echo $row["RANKING"]; ?></td>
          <td><?php echo $row["ID"]; ?></td>
          <td><?php echo $row["MNAME"]; ?></td>
          <td text-align="center"><?php echo $row["ILE"]; ?></td>
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
