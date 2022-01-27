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
      .header2 {
        padding: 16px; /* some padding */
        text-align: center; /* center the text */
        background: #e9e9e9; /* green background */
        color: black; /* white text color */
        width: 48%;
        margin: auto;
      }

        /* Increase the font size of the <h1> element */
      .header2 h1 {
        font-size: 40px;
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

      $genre_oci = oci_parse($conn, "SELECT bgenre, SUM(AG_DIFF) AS WAGA FROM (SELECT a.*, (10-((SELECT BIRTH FROM MEMBER WHERE ".($_SESSION['USER']."=MID;))-birth)/365) AS AG_DIFF FROM (SELECT bgenre, birth FROM BOOKINSTANCE JOIN BORROWING ON biid=idbook JOIN BOOK ON book=bid JOIN MEMBER ON idlender=mid) a) b WHERE AG_DIFF >= 0 GROUP BY bgenre ORDER BY WAGA DESC;");
      oci_execute($genre_oci, OCI_NO_AUTO_COMMIT);

    ?>

    <div class="topnav">
      <a href="main_page.php">Strona główna</a>
      <a href="zwrot.php">Aktywne książki</a>
      <a href="historia_wypozyczen.php">Historia wypożyczeń</a>
      <a href="historia_ocen.php">Historia ocen</a>
      <a class="active" href="polecenie.php">Moja rekomendacja</a>
    </div>
    
    <H2> Rekomendacja specjalnie dla ciebie,</H2>
    <H2> wyselekcjonowana przez AI o niezwykłej złożoności, wykwintnym guście i prawdziwie ludzkiej świadomości </H2>

    <div class="header2">
      <h1>magia tu się ziści <?php echo $TITLE ?></h1>
    </div>

    <div class="container">
      <FORM ACTION="polecenie.php" METHOD="POST">    
        <INPUT TYPE="SUBMIT" VALUE="Nowa rekomendacja">
      </FORM>
    </div>

    <table>
    <?PHP
      while (($row = oci_fetch_array($genre_oci, OCI_BOTH))) {
        ?>
        <tr>
          <td><?php echo $row["BGENRE"]; ?></td>
      		<td><?php echo $row["WAGA"]; ?></td>
	      </tr>
      <?php
      }
    ?>
    </table>

  </BODY>
</HTML>
