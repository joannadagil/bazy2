<HTML>
  <HEAD>
    <TITLE> Biblioteka </TITLE>
  </HEAD>
  <BODY>
    <H2> Naukowcy </H2>
    <?PHP // Wchodzimy do PHP
      //////////////////////////////////
      // Tworzenie ciasteczka sesyjnego.
      session_start();
      // Zapisanie loginu i hasla w ciasteczku sesyjnym.
      $_SESSION['LOGIN'] = $_POST['LOGN'];
      $_SESSION['PASS'] = $_POST['PASW'];
      $_SESSION['USER'] = $_POST['USER'];
      ///////////////////////////////////
      // Nawiazywanie polaczenia; login i haslo do oracla studenckiego.
      // Trzeci parametr to serwer bazodanowy; na students bywa ustawiony domyslnie.
      
      $_SESSION['conn'] = oci_connect($_SESSION['LOGIN'],$_SESSION['PASS'],"//labora.mimuw.edu.pl/LABS");
      if (!$_SESSION['conn']) {
    	echo "oci_connect failed\n";
    	$e = oci_error();
    	echo $e['message'];
      }
      /*
      // Tworzenie wyrazenia SQL-owego. Uzycie fmurlak.naukowiec zamiast naukowiec pozwala na odczytanie tabeli inego uzytkownika.
      $stmt = oci_parse($conn, "SELECT * FROM naukowiec");
      // Wykonywanie wyrazenia SQL-owego
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      // OCI_BOTH sprawia, tablica jest zarowno asocjacyjna, jak i zwykla
      while (($row = oci_fetch_array($stmt, OCI_BOTH))) {
        // Use UPPERCASE column names for the associative array indices and numbers for the ordinary array indices.
        echo "<BR><A HREF=\"doktoranci.php?id=".$row['ID']."\">".$row[1]." ".$row['NAZWISKO']."<A><BR>\n";
      }
      // Jesli modyfikujemy, to trzeba zrobic COMMIT:
      // oci_commit($conn);
      */
    ?>
    <a href="logowanie.php">Zaloguj się</a>
    <a href="rankingi.php">Rankingi</a>
    <a href="katalog.php">Katalog</a>

  </BODY>
</HTML>
