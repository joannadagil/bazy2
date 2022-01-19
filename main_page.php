<HTML>
  <HEAD>
    <TITLE> Main Page </TITLE>
    <link rel="stylesheet" href="css/main.css">
  </HEAD>
  <BODY>

    <div class="header">
      <h1>Biblioteka Publiczna</h1>
      <p>im. Ignacego Makowskiego i Joanny Dagil</p>
    </div>

    <?PHP
      session_start();
      // Zapisanie loginu i hasla w ciasteczku sesyjnym.
      $_SESSION['LOGIN'] = $_POST['LOGN'];
      $_SESSION['PASS'] = $_POST['PASW'];
      $_SESSION['USER'] = $_POST['USER'];
      ///////////////////////////////////
      // Nawiazywanie polaczenia; login i haslo do oracla studenckiego.
      // Trzeci parametr to serwer bazodanowy; na students bywa ustawiony domyslnie.
      $conn = oci_connect($_SESSION['LOGIN'],$_SESSION['PASS'],"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
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

    <FORM ACTION="katalog.php" METHOD="POST">
      <INPUT TYPE="HIDDEN" NAME="search" VALUE=""><BR><BR>
      <INPUT TYPE="SUBMIT" VALUE="Katalog">
    </FORM>

    <a href="logowanie.php">Zaloguj się</a>
    <a href="rankingi.php">Rankingi</a>
    <a href="katalog.php">Katalog</a>

    <div class="header">
      <h1>Biblioteka Publiczna</h1>
      <p>im. Ignacego Makowskiego i Joanny Dagil</p>
    </div>

  </BODY>
</HTML>
