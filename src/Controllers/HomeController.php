<?php

namespace App\Controllers;

use Lib\Db;
use App\Models\Figure;

class HomeController
{
    /**
     * @var Figure
     */
    private Figure $figure;

    public function __construct()
    {
        $this->figure = new Figure();
    }

    /**
     * @param int $scriptVersion Версия для стилей и скриптов
     * @return bool
     */
    public function index(int $scriptVersion=0): bool
    {
        $figures = $this->figure->getFigures();
        $groups = $this->figure->getGroups();
        $results = $this->figure->getResults();

        require_once ROOT_DIR . 'src/Views/index.php';
        return true;
    }

    /**
     * Добавляет новую группу
     *
     * @return bool|string
     */
    public function newGroup(): bool|string
    {
        if (empty($_POST['name'])) {
            return json_encode(['status' => 'error', 'message' => 'Введите название группы!']);
        }

        return json_encode(['status' => 'ok', 'newId' => $this->figure->addGroup($_POST['name'])]);
    }

    /**
     * Добавляет новую фигуру в таблицу нарисованных фигур
     *
     * @return bool|string
     */
    public function newFigure(): bool|string
    {
        if (empty($_POST['group'])) {
            return json_encode(['status' => 'error', 'message' => 'Не выбрана группа!']);
        }

        if (empty($_POST['figure'])) {
            return json_encode(['status' => 'error', 'message' => 'Не выбрана фигура!']);
        }

        if (empty($_POST['size']) || !is_numeric($_POST['size'])) {
            return json_encode(['status' => 'error', 'message' => 'Не выбран размер!']);
        }

        if (empty($_POST['color'])) {
            return json_encode(['status' => 'error', 'message' => 'Не выбран цвет!']);
        }

        $this->figure->addResult([
            'group_id' => $_POST['group'],
            'figure_id' => $_POST['figure'],
            'size' => $_POST['size'],
            'color' => $_POST['color'],
        ]);

        return json_encode(['status' => 'ok']);
    }

    /**
     * Отображает "Страница не найдена"
     *
     * @return bool
     */
    public function action404(): bool
    {
        http_response_code(404);
        require_once ROOT_DIR . 'src/Views/404.php';
        return false;
    }
}
