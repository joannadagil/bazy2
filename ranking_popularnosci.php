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
      /* -------------------------- dropdown --------------------------- */

      .dropdown {
        float: left;
        overflow: hidden;
      }

      .dropdown .dropbtn {
        font-size: 16px;
        border: none;
        outline: none;
        color: white;
        padding: 14px 16px;
        background-color: inherit;
        font-family: inherit;
        margin: 0;
      }

      .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
      }

      .dropdown-content a {
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
      }

      .dropdown-content a:hover {
        background-color: #ddd;
      }

      .dropdown:hover .dropdown-content {
        display: block;
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
      //Gatunek do wyboru
      $book_genre = oci_parse($conn, "SELECT DISTINCT BGENRE FROM BOOK");
      // Tworzenie wyrazenia SQL-owego. Uzycie fmurlak.naukowiec zamiast naukowiec pozwala na odczytanie tabeli inego uzytkownika.
      $book_ratings = oci_parse($conn, "SELECT RANK() OVER (ORDER BY COUNT(*) DESC) RANKING, BTITLE, COUNT(*) as IL_WYPO FROM BOOKINSTANCE JOIN BORROWING ON biid=idbook JOIN BOOK ON book=bid GROUP BY btitle, bid ORDER BY IL_WYPO DESC FETCH FIRST 100 ROWS ONLY");
      // Wykonywanie wyrazenia SQL-owego
      oci_execute($book_genre, OCI_NO_AUTO_COMMIT);
      oci_execute($book_ratings, OCI_NO_AUTO_COMMIT);
    ?>

    <div class="header">
      <h1>Rankingi biblioteczne</h1>
    </div>

    <div class="topnav">
      <a href="main_page.php">Strona główna</a>
      <a href="rankingi.php">Ilość książek</a>
      <a href="ranking_oceny_ksiazki.php">Oceny książek</a>
      <a class="active" href="ranking_popularnosci.php">Popularność książek</a>
      <div class="dropdown">
        <button class="dropbtn">Dropdown
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
          <a href="#">Link 1</a>
          <a href="#">Link 2</a>
          <a href="#">Link 3</a>
        </div>
      </div>
    </div>

    <h2> Ranking książek wg. ocen </h2>

    <table>
      <thead>
        <tr>
          <td> Miejsce </td>
          <td> Tytuł </td>
          <td> Ilość wypożyczeń </td>
        </tr>
      </thead>
      <?PHP
      while (($row = oci_fetch_array($book_ratings, OCI_BOTH))) {
        ?>
        <tr>
          <td><?php echo $row["RANKING"]; ?></td>
          <td><?php echo $row["BTITLE"]; ?></td>
          <td text-align="center"><?php echo $row["IL_WYPO"]; ?></td>
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
