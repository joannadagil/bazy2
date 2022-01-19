<HTML>
  <HEAD>
    <TITLE> Biblioteka - Rankingi </TITLE>
    <link rel="stylesheet" href="css/main.css">
    <style> /* idk czemu ale jak to jest w css to nie działa, a navibar wciąz działa xd?*/
      body {
      font-family: Arial, Helvetica, sans-serif;
      margin: 0;
      }

      /* Style the header */
      .header {
      padding: 80px;
      text-align: center;
      background: #1abc9c;
      color: white;
      }

      /* Increase the font size of the h1 element */
      .header h1 {
      font-size: 40px;
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
      $author_book_amount = oci_parse($conn, "SELECT aname, COUNT(*) AS amount FROM author JOIN authorship WHERE aid = idauthor GROUP BY aid ORDER BY amount FETCH FIRST 100 ROWS ONLY");
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
          <td><?php echo $row["aname"]; ?></td>
      	  <td><?php echo $row["amount"]; ?></td>
	    </tr>
      <?php
      }
    ?>
    </table>
    
  </BODY>
</HTML>
