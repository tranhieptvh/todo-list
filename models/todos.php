<?php
$path = str_replace("models", "", dirname(__FILE__));
require_once($path . 'db.php');

class Todos extends DB
{
    const tableName = 'todos';
    public function __construct()
    {
        parent::__construct();
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function getAll()
    {
        $stm = $this->db->prepare('SELECT * FROM ' . self::tableName);
        $stm->execute();
        return $stm->fetchAll();
    }

    function getById($id)
    {
        $stm = $this->db->prepare('SELECT id, checked FROM ' . self::tableName . ' WHERE id=' . $id);
        $stm->execute();
        return $stm->fetch();
    }

    function insert($payload)
    {
        $title = $payload['title'];
        try {
            $stm = $this->db->prepare('INSERT INTO ' . self::tableName . ' (title) VALUE (:title)');
            $stm->execute(array('title' => $title));
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $this->db->lastInsertId();
    }

    function update($id, $checked)
    {
        $stm = $this->db->prepare('UPDATE ' . self::tableName . ' SET checked=' . $checked . ' WHERE id=' . $id);
        return $stm->execute();
    }

    function delete($id)
    {
        $stm = $this->db->prepare('DELETE FROM ' . self::tableName . ' WHERE id=' . $id);
        return $stm->execute();
    }
}
