<?php

if (isset($_POST['id'])) {
    $path = str_replace("app", "", dirname(__FILE__));
    require_once($path . 'models/todos.php');
    
    $todos = new Todos();

    $id = $_POST['id'];

    if (empty($id)) {
        echo 0;
    } else {
        $res = $todos->delete($id);

        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
        $todos->close();
        exit();
    }
} else {
    header("Location: ../index.php?mess=error");
}
