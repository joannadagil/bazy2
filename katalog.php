<HTML>
  <HEAD>
    <TITLE> Katalog </TITLE>
    <link rel="stylesheet" href="css/main.css">
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
      // Tworzenie wyrazenia SQL-owego. Uzycie fmurlak.naukowiec zamiast naukowiec pozwala na odczytanie tabeli inego uzytkownika.
      $stmt = oci_parse($conn, "SELECT * FROM BOOK WHERE BTITLE LIKE '%".$search."%' ORDER BY BID FETCH FIRST 100 ROWS ONLY");
      // Wykonywanie wyrazenia SQL-owego
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
    ?>

    <div class="topnav">
      <a class="active" href="#home">Home</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
      <div class="search-container">
        <form action="katalog.php">
          <input type="text" placeholder="Search.." name="search">
          <button type="submit">Submit</button>
        </form>
      </div>
    </div>

    <table> <?PHP
      while (($row = oci_fetch_array($stmt, OCI_BOTH))) {
        ?>
        <tr>
          <td><?php echo $row["BID"]; ?></td>
      		<td><?php echo $row["BTITLE"]; ?></td>
          <td><?php echo $row["ISBN"]; ?></td>
          <div>
            <form ACTION="rankingi.php" METHOD="POST">
              <input TYPE="SUBMIT" VALUE="Rankingi">
            </form>
          </div>
	      </tr>
      <?php
      }
    ?>
    </table>

  </BODY>
</HTML>
