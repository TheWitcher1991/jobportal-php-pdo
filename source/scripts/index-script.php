<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $app->notFound();
    exit;
}

try {
  
	

   /* if (isset($_SESSION['id']) && $_SESSION['type'] == 'admin') {

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

    }*/

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
        $now = date("Y-m-d");
        $chuck = array_chunk($stmts->fetchAll(), 100);

        foreach ($chuck as $list) {
            foreach ($list as $r) {
                if (($r['task'] == $now) || ($r['task'] < $now)) {
                    $stmt = $PDO->prepare("UPDATE `vacancy` SET `status` = 1, `trash` = ? WHERE `id` = ?");
                    $stmt->execute([$Date, $r['id']]);

                    $stmt = $PDO->prepare("INSERT INTO `notice` (`type`, `title`, `date`, `hour`, `time`, `company_id`, `job_id`, `who`)
                        VALUES(?, ?, ?, ?, NOW(), ?, ?, ?)");
                    $stmt->execute(['company_vacancy', 'Вакансия закрылась', $Date, date("H:i"), $r['company_id'], $r['id'], 1]);

                    $stmt = $PDO->prepare("UPDATE `category` SET `job` = `job` - 1 WHERE `id` = ?");
                    $stmt->execute([$r['category_id']]);

                    $stmt = $PDO->prepare("UPDATE `company` SET `job` = `job` - 1 WHERE `id` = :id");
                    $stmt->execute([$r['company_id']]);
                }
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