<HTML>
  <HEAD>
    <TITLE> Katalog </TITLE>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="utf-8">
    <style>
      *{
        margin: 0;
        padding: 0;
      }
      thead {
        background-color: #1abc9c;
        color: white;
        font-size: 19px;
      }
      .topnav input[type=submit] {
        float: right;
        padding: 14px 16px;
        border: none;
        margin-top: 8px;
        margin-right: 16px;
        background: #e9e9e9;
        border: none;
        font-size: 30px;
        width: 100%;
      }

      table td input[type=submit] {
        border: none;
        cursor: pointer;
        width: 100%;
        background: #ccc;
        font-size: 17px;
        padding: 6px;
        /*float: center;*/
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
      <h1>Katalog biblioteczny</h1>
    </div>
    <?PHP
      session_start();

      $search = $_GET['search'];

      $conn = oci_connect($_SESSION['LOGIN'],$_SESSION['PASS'],"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
        echo "oci_connect failed\n";
        $e = oci_error();
        echo $e['message'];
      }
      if (isset($_GET['ratedbook']) && isset($_GET['rate']) && isset($_SESSION['USER'])) {
        $napis = "INSERT INTO RATING VALUES (".$_GET['rate'].", CURRENT_DATE,".$_SESSION['USER'].",".$_GET['ratedbook'].")";
        $sinsrt = oci_parse($conn, $napis);
        oci_execute($sinsrt, OCI_NO_AUTO_COMMIT);
        oci_commit($conn);
      }
      // Wykonywanie wyrazenia SQL-owego
      $stmt = oci_parse($conn, "SELECT * FROM BOOK WHERE BTITLE LIKE '%".$search."%' ORDER BY BID FETCH FIRST 100 ROWS ONLY");
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
    ?>

    <div class="topnav">
      <a href="main_page.php">Strona główna</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
      <div class="search-container">
        <form action="katalog.php">
          <input type="text" placeholder="Search.." name="search">
          <button type="submit">Submit</button>
        </form>
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <td> ID </td>
          <td> Tytuł </td>
          <td> ISBN </td>
          <td> Wypożyczanie </td>
          <td> Ocenianie </td>
        </tr>
      </thead>
      <?PHP
      while (($row = oci_fetch_array($stmt, OCI_BOTH))) {
        ?>
        <tr>
          <td><?php echo $row["BID"]; ?></td>
      		<td><?php echo $row["BTITLE"]; ?></td>
          <td><?php echo $row["ISBN"]; ?></td>
          <td>
            <form ACTION="wypozyczanie.php" METHOD="POST">
              <input TYPE="HIDDEN" NAME="available" VALUE="<?php echo $row["BID"];?>">
              <input TYPE="SUBMIT" VALUE="Wypozyczanie">
            </form>
          </td>
          <td>
            <div class="dropdown">
              <button class="dropbtn">Oceń
                <i class="fa fa-caret-down"></i>
              </button>
              <div class="dropdown-content">
              <?PHP
              for ($i = 0; $i <= 9; $i++) {
                ?>
                  <a href=<?php echo "?ratedbook=".$row["BID"]."&rate=".$i; ?>><?php echo $i; ?></a>
              <?php
              }
              ?>
              </div>
            </div>
          </td>
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
