<?php

namespace Core;

use core\App;
use core\Singleton;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use JetBrains\PhpStorm\Internal\TentativeType;
use PDO;

class SessionHandler implements \SessionHandlerInterface {
    private string $_sessionTable = 'session';
    private string $_sessionName;
    const SESSION_EXPIRE = 10;

    public function __construct() {
    }

    public function close(): bool{
        // TODO: Implement close() method.
        return 0;
    }

    public function destroy(string $id): bool {
        // TODO: Implement destroy() method.
        $res = $PDO->query("DELETE FROM {$this->_sessionTable} WHERE `sid` = '{$id}'");
        return $res ? 1 : 0;
    }

    public function gc(int $max_lifetime): int|false {
        // TODO: Implement gc() method.
        $res = $PDO->query("DELETE FROM {$this->_sessionTable} 
                            WHERE UNIX_TIMESTAMP(`sdate`) < UNIX_TIMESTAMP(NOW()) - " . self::SESSION_EXPIRE);
        return $res ? 1 : 0;
    }

    public function open(string $path, string $name): bool {
        // TODO: Implement open() method.
        $this->_sessionName = $name;
        return 0;
    }

    public function read(string $id): string|false {
        // TODO: Implement read() method.
        $stmt = $PDO->prepare("SELECT `stext` FROM {$this->_sessionTable} WHERE `sid` = ? AND 
                               UNIX_TIMESTAMP(`sdate`) + ? > UNIX_TIMESTAMP(NOW())");
        $stmt->execute([$id, self::SESSION_EXPIRE]);
        if (!isset($value) || empty($value)) {
            $value = "";
            return $value;
        }
        $stmt2 = $PDO->prepare("UPDATE {$this->_sessionTable} SET `sdate` = CURRENT_TIMESTAMP() WHERE `sid` = ?");
        $stmt2->execute([$id]);
        $value = $stmt->fetch();
        return $value['stext'];
    }

    public function write(string $id, string $data): bool
    {
        // TODO: Implement write() method.
        $stmt = $PDO->prepare("SELECT `stext` FROM {$this->_sessionTable} WHERE `sid` = ?
                              AND UNIX_TIMESTAMP(`sdate`) + ? > UNIX_TIMESTAMP(NOW())");
        $stmt->execute([$id, self::SESSION_EXPIRE]);
        $res = $stmt->fetch();
        if (!empty($res)) {
            $res = $PDO->query("UPDATE {$this->_sessionTable} SET `stext` = {$data} WHERE `sid` = {$id}");
        } else {
            $res = $PDO->query("INSERT INTO {$this->_sessionTable} (`sid`, `stext`) VALUES ('{$id}', '{$data}')");
        }
        return $res ? 1 : 0;
    }
}

class Session {

    use Singleton;

    public function start() {
        session_start();
    }

    public function set(array $data) {
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $_SESSION[$key] = $val;
            }
        }
    }

    public function setData(string $key, $value) {
        $_SESSION[$key] = $value;
    }

    public function setCookie($key, $value, $time) {
        setcookie($key, $value, $time);
    }

    public function generateId() {
        session_regenerate_id();
    }

    public function getData(string $key) {
        return !empty($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function save() {
        session_write_close();
    }

    public function flush(string $key) {
        $value = $this->getData($key);
        $this->unset($key);

        return $value;
    }

    public function unset(string $key) {
        unset($_SESSION[$key]);
    }

}