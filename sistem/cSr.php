<?php
session_start();

function rtn($url)
{
    header("Location: $url");
}

if (base64_decode($_SESSION['type_session']) != "kepala_uptd") {
    rtn($urlweb);
    die();
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $db_con->prepare("SELECT * FROM sertifikattb WHERE id_sr=:id");
    $stmt->execute(array(":id" => $id));
    $rowuser = $stmt->rowCount();
    if ($rowuser != 0) {
        $stmt = $db_con->prepare("UPDATE sertifikattb SET status =:status WHERE id_sr=:id");
        $stmt->execute(array(":id" => $id, ":status" => 1));
        $_SESSION['sKr'] = true;
        rtn($urlweb);
    }
    rtn($urlweb);
} else {
    rtn($urlweb);
    die();
}
