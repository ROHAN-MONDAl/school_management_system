<?php
include '../server_database.php';

if (isset($_GET['tid'])) {
    $id = intval($_GET['tid']);

    $sql_delete = "DELETE FROM transactions WHERE tid = $id";

    if (mysqli_query($conn, $sql_delete)) {
        header("Location: expenses.php"); // Redirect back to the transactions page
        exit;
    }
}

mysqli_close($conn);
