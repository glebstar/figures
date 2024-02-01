<?php

namespace App\Models;

use Lib\Db;

class Figure
{
    /**
     * Возвращает доступные фигуры
     *
     * @return bool|array
     */
    public function getFigures(): bool|array
    {
        return Db::getAll('SELECT * FROM figures');
    }

    /**
     * Возвращает все группы
     *
     * @return bool|array
     */
    public function getGroups(): bool|array
    {
        return Db::getAll('SELECT * FROM `groups` ORDER BY `id`');
    }

    /**
     * Добавляет новую группу
     *
     * @param string $name
     * @return int
     */
    public function addGroup(string $name): int
    {
        Db::insertArray('groups', ['name' => $name]);

        return Db::getOne('SELECT LAST_INSERT_ID()');
    }

    /**
     * Добавляет нарисованную фигуру
     *
     * @param array $data
     * @return void
     */
    public function addResult(array $data): void
    {
        Db::insertArray('results', $data);
    }

    /**
     * Возвращает все нарисованные фигуры
     *
     * @return bool|array
     */
    public function getResults(): bool|array
    {
        return Db::getAll('SELECT * FROM `results` ORDER BY `id`');
    }
}