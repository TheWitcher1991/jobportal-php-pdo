<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $app->notFound();
    exit;
}

try {

    if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

        $client = clientInfo(getIp());

        $a = $app->fetch("SELECT * FROM `admin` WHERE `id` = :id AND `last_ip` = :ip", [
            ':id' => $_SESSION['id'],
            ':ip' => $client['query']
        ]);

        if (!isset($a['id'])) {
            exit("<div>
<h1>403 Forbidden</h1>
<span>ДОСТУП ЗАПРЕЩЁН</span>

</div>");
        }

    }

    $stmt = $PDO->prepare("DELETE FROM `online` WHERE `times` < SUBTIME(NOW(), '0 0:5:0')");
    $stmt->execute();

    $stmt = $PDO->prepare("DELETE FROM `temp_company` WHERE `time` < SUBTIME(NOW(), '0 23:0:0')");
    $stmt->execute();

    $stmt = $PDO->prepare("DELETE FROM `temp_users` WHERE `time` < SUBTIME(NOW(), '0 23:0:0')");
    $stmt->execute();

    $stmt = $PDO->prepare("DELETE FROM `temp_email_c` WHERE `time` < SUBTIME(NOW(), '0 6:0:0')");
    $stmt->execute();

    $stmt = $PDO->prepare("DELETE FROM `temp_email_u` WHERE `time` < SUBTIME(NOW(), '0 6:0:0')");
    $stmt->execute();

    $stmt = $PDO->prepare("DELETE FROM `online_job` WHERE `time` < SUBTIME(NOW(), '0 0:5:0')");
    $stmt->execute();

    $stmt = $PDO->prepare("DELETE FROM `online_resume` WHERE `time` < SUBTIME(NOW(), '0 0:5:0')");
    $stmt->execute();

    $stmt = $PDO->prepare("DELETE FROM `online_company` WHERE `time` < SUBTIME(NOW(), '0 0:5:0')");
    $stmt->execute();

    $stmts = $PDO->prepare("SELECT * FROM `vacancy` WHERE `status` = 0");
    $stmts->execute();
    if ($stmts->rowCount() > 0) {
        while ($r = $stmts->fetch()) {
            $now = date("Y-m-d");
            if (($r['task'] == $now) || ($r['task'] < $now)) {

                $app->execute('UPDATE `vacancy` SET `status` = 1, `trash` = :task WHERE `id` = :id', [
                    ':task' => $Date,
                    ':id' => $r['id']
                ]);

                $app->execute("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `company_id`, `job_id`, `who`)
                        VALUES(:typ, :title, :dat, :h, NOW(), :ci, :ji, :who)", [
                    ':typ' => 'company_vacancy',
                    ':title' => 'Вакансия закрылась!',
                    ':dat' => $Date,
                    ':h' => date("H:i"),
                    ':ci' => $r['company_id'],
                    ':ji' => $r['id'],
                    ':who' => 1
                ]);

                $app->execute('UPDATE `category` SET `job` = `job` - 1 WHERE `id` = :id', [
                    ':id' => $r['category_id']
                ]);

                $app->execute("UPDATE `company` SET `job` = `job` - 1 WHERE `id` = :id", [':id' => $r['company_id']]);

                sleep(1);

            }
        }
    }

    echo json_encode(array(
        'code' => 'success',
    ));

} catch (Exception $e) {
    echo json_encode(array(
        'code' => 'error',
        'message' => $e->getMessage()
    ));
    exit;
}

session_write_close();

exit;