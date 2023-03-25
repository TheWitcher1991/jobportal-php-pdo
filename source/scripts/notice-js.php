<?php

if (isset($_SESSION['id'])) {
    try {

        function getOptions()
        {
            $id = (isset($_POST['id'])) ? (int) $_POST['id'] : null;
            $type = (isset($_POST['type'])) ? (int) $_POST['type'] : null;

            return array(
                'id' => $id,
                'type' => $type
            );
        }

        $options = getOptions();

        $id = $options['id'];
        $type = $options['type'];
        $count = null;

        if ($id != null && $type == 1) {
            $app->execute("UPDATE `notice` SET `status` = 1 WHERE `id` = :id AND `who` = 1", [
                ':id' => $id
            ]);
            $count = $app->count("SELECT * FROM `notice` WHERE `company_id` = '$_SESSION[id]' AND `status` = 0 AND `who` = 1");
        }

        if ($id != null && $type == 2) {
            $app->execute("UPDATE `notice` SET `status` = 1 WHERE `id` = :id AND `who` = 2", [
                ':id' => $id
            ]);
            $count = $app->count("SELECT * FROM `notice` WHERE `user_id` = '$_SESSION[id]' AND `status` = 0 AND `who` = 2");
        }

        echo json_encode(array(
            'code' => 'success',
            'count' => $count
        ));
    } catch (Exception $e) {
        echo json_encode(array(
            'code' => 'error',
        ));
    }
} else {
    $app->notFound();
}


session_write_close();

exit;
