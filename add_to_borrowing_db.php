<html>
<body>
  <?php
      session_start();
      if (isset($_POST['reserve']) && isset($_SESSION['USER'])) {
        $reserved = $_POST['reserve'];
        $conn = oci_connect($_SESSION['LOGIN'],$_SESSION['PASS'],"//labora.mimuw.edu.pl/LABS");
        if (!$conn) {
          echo "oci_connect failed\n";
          $e = oci_error();
          echo $e['message'];
        }
        $napis = "INSERT INTO BORROWING VALUES (CURRENT_DATE, NULL,".$_SESSION['USER'].",".$_reserved.")";
        echo $napis;
        $stmt = oci_parse($conn, $napis);
        oci_execute($stmt, OCI_NO_AUTO_COMMIT);
        oci_commit($conn);
        echo "reserve";
      } else {
        if (isset($_POST['reserve'])) {
          echo $_POST['reserved'];
        }
        if (isset($_SESSION['USER'])) {
          echo $_SESSION['USER'];
        }
        echo "dont reserve\n";
      }
      //header("Location: katalog.php");
      //exit;
  ?>
</body>
</html>
