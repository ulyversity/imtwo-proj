<?php
declare(strict_types=1);


interface IRepository {
    public function getAll();
    public function get(int $id);
    public function add(object $model);
    public function update(object $model);
    public function delete(int $id);
    public function query(string $queryString);
}
