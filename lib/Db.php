<?php

namespace Lib;

use PDO;

class Db
{
    /**
     * @var ?PDO $_connect
     *
     * Инстанс коннекта к бд
     */
    private static $_connect = null;

    /**
     * Возвращает коннект к базе данных
     *
     * @return PDO
     */
    private static function _getConnect(): PDO
    {
        // коннект к базе может быть только один, Singleton
        if (!empty(self::$_connect)) {
            return self::$_connect;
        }

        global $mainCfg;

        self::$_connect = new PDO('mysql:host=' . $mainCfg['db']['host'] . ';dbname=' . $mainCfg['db']['dbname'], $mainCfg['db']['user'], $mainCfg['db']['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'']);

        return self::$_connect;
    }

    /**
     * Возвращает все записи из таблицы бд
     *
     * @param string $sql
     * @param array $bind
     * @return bool|array
     */
    public static function getAll($sql, array $bind=[]): bool|array
    {
        $connect = self::_getConnect()->prepare($sql);
        $connect->execute($bind);
        return $connect->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getOne($sql, $bind=[]) {
        $connect = self::_getConnect()->prepare($sql);
        $connect->execute($bind);
        $res = $connect->fetch();
        if ( $res ) {
            return $res[0];
        }

        return false;
    }

    /**
     * @param string $table
     * @param array $data
     * @return void
     */
    public static function insertArray(string $table, array $data): void
    {
        $fields = '';
        $signs = '';
        $values = [];
        foreach ($data as $_key=>$_value) {
            $fields .= "`{$_key}`,";
            $signs  .= '?,';
            $values[] = $_value;
        }
        $fields = preg_replace('/,$/', '', $fields);
        $signs = preg_replace('/,$/', '', $signs);

        $sql = "INSERT INTO `{$table}` ($fields) VALUES($signs)";

        $connect = self::_getConnect()->prepare($sql);
        $connect->execute($values);
    }
}