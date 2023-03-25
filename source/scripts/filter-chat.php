<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $app->notFound();
    exit;
}

if (isset($_SESSION['id']) && isset($_SESSION['password'])) {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        $app->notFound();
        exit;
    }

    try {

        function getOptions()
        {
            $id = (isset($_POST['id'])) ? (int)$_POST['id'] : null;
            $key = (isset($_POST['search'])) ? $_POST['search'] : null;


            return array(
                'id' => $id,
                'key' => $key
            );
        }

        function getData($options, $PDO)
        {
            $options = getOptions();

            $id = (int)$options['id'];
            $key = $options['key'];

            $where = "";


            if ($key != null and $_SESSION['type'] == 'users') $where = addWhere($where, "`company` LIKE '%$key%'");
            if ($key != null and $_SESSION['type'] == 'company') $where = addWhere($where, "`user` LIKE '%$key%'");
            $sql = "SELECT * FROM `chat`";
            if ($where) $sql .= " WHERE $where";

            if ($sql == "SELECT * FROM `chat`") {
                if ($_SESSION['type'] == 'company') $sql .= " WHERE `creates` = $id ORDER BY `id` DESC";
                if ($_SESSION['type'] == 'users') $sql .= " WHERE `user_id` = $id ORDER BY `id` DESC";
            } else {
                if ($_SESSION['type'] == 'company') $sql .= " AND `creates` = $id ORDER BY `id` DESC";
                if ($_SESSION['type'] == 'users') $sql .= " AND `user_id` = $id ORDER BY `id` DESC";
            }


            $stmt = $PDO->prepare($sql);
            $stmt->execute();
            $count = $stmt->rowCount();
            return array(
                'list' => $stmt->fetchAll(),
                'online',
                'count' => $count,
                'type' => $_SESSION['type']
            );
        }


        echo json_encode(array(
            'code' => 'success',
            'data' => getData(getOptions(), $PDO)
        ));
    } catch (Exception $e) {
        echo json_encode(array(
            'code' => 'error',
            'message' => $e->getMessage()
        ));
    }

} else {
    $app->notFound();
}

session_write_close();

exit;