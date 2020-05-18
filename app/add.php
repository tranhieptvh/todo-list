<?php

if (isset($_POST['title'])) {
    $path = str_replace("app", "", dirname(__FILE__));
    require_once($path . 'models/todos.php');
    $todos = new Todos();

    $title = $_POST['title'];

    if (empty($title)) {
        header("Location: ./../index.php?mess=error");
    } else {
        $lastInsertId = $todos->insert($_POST);

        if ($lastInsertId != 0) {
            header("Location: ./../index.php?mess=success");
        } else {
            header("Location: ./../index.php");
        }
        $todos->close();
        exit();
    }
} else {
    header("Location: ./../index.php?mess=error");
}
