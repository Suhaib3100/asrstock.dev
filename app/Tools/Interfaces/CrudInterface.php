<?php


namespace App\Tools\Interfaces;


interface CrudInterface
{
    public function all();

    public function getOrderById($ord, $record_per_page);

    public function getRecordById($id);

    public function getRecordByUuid($uuid);

    public function create(array $data);

    public function update(array $data, $id);

    public function updateByUuid(array $data, $uuid);

    public function delete($id);

    public function deleteByUuid($uuid);
}
