<html>
<body>
  <?php
      session_start();
      if (isset($_POST['to_return']) && isset($_SESSION['USER'])) {
        $ret = $_POST['to_return'];
        $conn = oci_connect($_SESSION['LOGIN'],$_SESSION['PASS'],"//labora.mimuw.edu.pl/LABS");
        if (!$conn) {
          echo "oci_connect failed\n";
          $e = oci_error();
          echo $e['message'];
        }
        $napis = "UPDATE BORROWING SET RETURN = CURRENT_DATE WHERE IDLENDER = ".$_SESSION['USER']." AND IDBOOK = ".$ret;
        $stmt = oci_parse($conn, $napis);
        oci_execute($stmt, OCI_NO_AUTO_COMMIT);
        oci_commit($conn);
        header("Location: zwrot.php");
        exit;
      } else {
        header("Location: login_library.html");
        exit;
      }
  ?>
</body>
</html>
