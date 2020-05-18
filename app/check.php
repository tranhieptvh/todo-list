<?php

if (isset($_POST['id'])) {
    $path = str_replace("app", "", dirname(__FILE__));
    require_once($path . 'models/todos.php');

    $todos = new Todos();

    $id = $_POST['id'];

    if (empty($id)) {
        echo 'error';
    } else {
        $todo = $todos->getById($id);

        $checked = $todo['checked'];
        if ($checked == 0) {
            $checked = 1;
        } else {
            $checked = 0;
        }

        $res = $todos->update($id, $checked);

        if ($res) {
            echo $checked;
        } else {
            echo "error";
        }
        $todos->close();
        exit();
    }
} else {
    header("Location: ./../index.php?mess=error");
}
