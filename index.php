<?php
require_once('models/todos.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="main-section">
        <div class="add-section">
            <form action="app/add.php" method="POST" autocomplete="off">

                <?php
                if (isset($_GET['mess']) && $_GET['mess'] == 'error') {
                ?>
                    <input type="text" name="title" style="border-color: #ff6666" placeholder="This field is required..." />
                    <button type="submit">Add &nbsp; <span>&#43;</span></button>
                <?php
                } else {
                ?>
                    <input type="text" name="title" placeholder="What do you need to do?" />
                    <button type="submit">Add &nbsp; <span>&#43;</span></button>
                <?php
                }
                ?>
            </form>
        </div>

        <div class="show-todo-section">

            <?php
            $todos = new Todos();
            $list = $todos->getAll();
            $count = count($list);
            ?>

            <?php
            if ($count == 0) {
            ?>
                <div class="todo-item">
                    <div class="empty">
                        <img src="img/f.png" width="100%" />
                        <img src="img/Ellipsis.gif" width="80px">
                    </div>
                </div>
                <?php
            } else {
                foreach ($list as $r) {
                    if ($r['checked'] == 0) {
                ?>
                        <div class="todo-item">
                            <span id="<?php echo $r['id'] ?>" class="remove-to-do">x</span>
                            <input type="checkbox" data-todo-id="<?php echo $r['id'] ?>" class="check-box" />
                            <h2><?php echo $r['title'] ?></h2>
                            <br>
                            <small>created: <?php echo $r['date_created'] ?></small>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="todo-item">
                            <span id="<?php echo $r['id'] ?>" class="remove-to-do">x</span>
                            <input type="checkbox" class="check-box" data-todo-id="<?php echo $r['id'] ?>" checked />
                            <h2 class="checked"><?php echo $r['title'] ?></h2>
                            <br>
                            <small>created: <?php echo $r['date_created'] ?></small>
                        </div>
                <?php
                    }
                }
                ?>
            <?php
            }
            ?>
        </div>
    </div>

    <script src="js/jquery-3.2.1.min.js"></script>

    <script>
        $(document).ready(function() {

            $('.remove-to-do').click(function() {
                var id = $(this).attr('id');
                // ajax
                $.post("app/delete.php", {
                        id: id
                    },
                    (data) => {
                        if (data) {
                            $(this).parent().hide(600);
                        }
                    }
                );
            });

            $('.check-box').click(function() {
                var id = $(this).attr('data-todo-id');
                //ajax
                $.post("app/check.php", {
                        id: id
                    },
                    (data) => {
                        if (data != 'error') {
                            if (data == 1) {
                                $(this).next().addClass('checked');
                            } else {
                                $(this).next().removeClass('checked');
                            }
                        }
                    }
                );
            });
        });
    </script>
</body>

</html>