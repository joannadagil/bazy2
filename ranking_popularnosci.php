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
      if (!isset($_GET['time'])) {
        $time = 'Wszechczasów';
      } else {
        $time = $_GET['time'];
      }
      $genre = $_GET['genre'];
      $book_genre = oci_parse($conn, "SELECT DISTINCT BGENRE FROM BOOK");
      if ($time == 'Wszechczasów') {
        $book_ratings = oci_parse($conn, "SELECT RANK() OVER (ORDER BY COUNT(*) DESC) RANKING, BTITLE, COUNT(*) as IL_WYPO FROM BOOKINSTANCE JOIN BORROWING ON biid=idbook JOIN BOOK ON book=bid WHERE BGENRE LIKE '%".$genre."%' GROUP BY btitle, bid ORDER BY IL_WYPO DESC FETCH FIRST 100 ROWS ONLY");
      } elseif ($time == 'Roku') {
        $book_ratings = oci_parse($conn, "SELECT RANK() OVER (ORDER BY COUNT(*) DESC) RANKING, BTITLE, COUNT(*) as IL_WYPO FROM BOOKINSTANCE JOIN BORROWING ON biid=idbook JOIN BOOK ON book=bid WHERE BORROW - CURRENT_DATE < 366 AND BGENRE LIKE '%".$genre."%' GROUP BY btitle, bid ORDER BY IL_WYPO DESC FETCH FIRST 100 ROWS ONLY");
      } elseif ($time == 'Miesiąca') {
        $book_ratings = oci_parse($conn, "SELECT RANK() OVER (ORDER BY COUNT(*) DESC) RANKING, BTITLE, COUNT(*) as IL_WYPO FROM BOOKINSTANCE JOIN BORROWING ON biid=idbook JOIN BOOK ON book=bid WHERE BORROW - CURRENT_DATE < 31 AND BGENRE LIKE '%".$genre."%' GROUP BY btitle, bid ORDER BY IL_WYPO DESC FETCH FIRST 100 ROWS ONLY");
      }
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
      <a href="ranking_uzytkownikow.php">Aktywność użytkowników</a>
      <div class="dropdown">
        <button class="dropbtn"><?php echo $time; ?>
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <a href="?time=Miesiąca">Miesiąca</a>
            <a href="?time=Roku">Roku</a>
            <a href="?time=Wszechczasów">Wszechczasów</a>
        </div>
      </div>
      <div class="dropdown">
        <button class="dropbtn">Gatunek <?php echo " ".$genre; ?>
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
        <?PHP
        while (($rowg = oci_fetch_array($book_genre, OCI_BOTH))) {
          ?>
            <a href=<?php echo "?genre=".$rowg["BGENRE"]; ?>><?php echo $rowg["BGENRE"]; ?></a>
        <?php
        }
        ?>
        </div>
      </div>
    </div>

    <h2> Najpopularniejsze Książki <?php echo $time; ?> </h2>

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
