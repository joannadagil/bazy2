<html>
<body>
  <?php
      session_start();
      if (isset($_POST['reserved']) && isset($_SESSION['USER'])) {
        $reserved = $_POST['reserved'];
        $conn = oci_connect($_SESSION['LOGIN'],$_SESSION['PASS'],"//labora.mimuw.edu.pl/LABS");
        if (!$conn) {
          echo "oci_connect failed\n";
          $e = oci_error();
          echo $e['message'];
        }
        $stmt = oci_parse($conn,"INSERT INTO BORROWING VALUES (CURRENT_DATE, NULL, ".$_SESSION['USER'].", ".$_reserved.")");
        oci_execute($stmt, OCI_NO_AUTO_COMMIT);
        oci_commit($conn);
        echo "reserve";
      } else {
        
        echo "dont reserve\n";
      }
      //header("Location: katalog.php");
      //exit;
  ?>
</body>
</html>
