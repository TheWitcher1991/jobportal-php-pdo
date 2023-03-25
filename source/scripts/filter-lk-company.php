<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $app->notFound();
    exit;
}

try {

    function getOptions()
    {
        $id = (isset($_POST['id'])) ? (int) $_POST['id'] : null;
        $key = (isset($_POST['key'])) ? $_POST['key'] : null;


        return array(
            'id' => $id,
            'key' => $key
        );
    }

    function getData($options, $PDO) {
        $options = getOptions();

        $id = $options['id'];
        $key = $options['key'];

        $where = "";

        if ($key != null) $where = addWhere($where, "`title` LIKE '%$key%'");
        $sql = "SELECT * FROM `vacancy`";
        if ($where) $sql .= " WHERE $where";

        if ($sql == "SELECT * FROM `vacancy`") {
            $sql .= " WHERE `status` = 0 AND `company_id` = $id ORDER BY `id` DESC";
        } else {
            $sql .= " AND `status` = 0 AND `company_id` = $id ORDER BY `id` DESC";
        }

        $stmt = $PDO->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();
        return array (
            'list' => $stmt->fetchAll(),
            'count' => $count,
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

session_write_close();

exit;