<HTML>
  <HEAD>
    <TITLE> Genealogia matematyczna - Naukowcy </TITLE>
  </HEAD>
  <BODY>
    <H2> Naukowcy </H2>
    <?PHP // Wchodzimy do PHP
      //////////////////////////////////
      // Tworzenie ciasteczka sesyjnego.
      session_start();
      ///////////////////////////////////
      // Nawiazywanie polaczenia; login i haslo do oracla studenckiego.
      // Trzeci parametr to serwer bazodanowy; na students bywa ustawiony domyslnie.
      $conn = oci_connect($_SESSION['LOGIN'],$_SESSION['PASS'],"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
        echo "oci_connect failed\n";
        $e = oci_error();
        echo $e['message'];
      }
      // Tworzenie wyrazenia SQL-owego. Uzycie fmurlak.naukowiec zamiast naukowiec pozwala na odczytanie tabeli inego uzytkownika.
      $stmt = oci_parse($conn, "SELECT * FROM BOOK");
      // Wykonywanie wyrazenia SQL-owego
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      // Jesli modyfikujemy, to trzeba zrobic COMMIT:
      // oci_commit($conn);
    ?>
  </BODY>
</HTML>
