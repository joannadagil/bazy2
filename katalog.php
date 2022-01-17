<HTML>
  <HEAD>
    <TITLE> Genealogia matematyczna - Naukowcy </TITLE>
    <link rel="stylesheet" href="css/main.css">
  </HEAD>
  <BODY>
    <H2> Naukowcy </H2>
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
      $stmt = oci_parse($conn, "SELECT * FROM BOOK WHERE BTITLE LIKE \'%".$search."%\' ORDER BY BID FETCH FIRST 100 ROWS ONLY");
      // Wykonywanie wyrazenia SQL-owego
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
?>

    <table>
        <tr>
          <td><?php echo "<p>SELECT * FROM BOOK WHERE BTITLE LIKE \'%".$search."%\' ORDER BY BID FETCH FIRST 100 ROWS ONLY<\p>" ?></td>
      		<td><?php echo $row["BTITLE"]; ?></td>
          <td><?php echo $row["ISBN"]; ?></td>
	      </tr>
      }
    </table>

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
	      </tr>
      <?php
      }
    ?>
    </table>
  </BODY>
</HTML>
