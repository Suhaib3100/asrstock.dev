<?php


namespace App\Tools\Repositories;


use App\Tools\Interfaces\CrudInterface;
use Illuminate\Database\Eloquent\Model;

class Crud implements CrudInterface
{
// model property on class instance
    protected $model;

    //constructor method to bind repo

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // get all instances of the model

    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param string $ord //contain 'DESC' or 'ASC'. default value 'DESC'
     * @param int $record_per_page // refer to number of record per page. default value 25
     * @return mixed // all instances of the model order by id
     */

    public function getOrderById($ord = 'DESC', $record_per_page = 25)
    {
        return $this->model->orderBy('id', $ord)->paginate($record_per_page);
    }

    /**
     * @param $id
     * @return mixed
     */

    public function getRecordById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param $uuid
     * @return mixed
     */

    public function getRecordByUuid($uuid)
    {
        return $this->model->whereUuid($uuid)->firstOrFail();
    }


    // create a new record in database

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database

    public function update(array $data, $id)
    {
        $record = $this->model->find($id);
        $record->update($data);
        return $record;
    }

    public function updateByUuid(array $data, $uuid)
    {
        $record = $this->model->whereUuid($uuid)->firstOrFail();
        $record->update($data);
        return $record;
    }


    // remove record from database


    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function deleteByUuid($uuid)
    {
        return $this->model->whereUuid($uuid)->delete();
    }

    // get the associated model

    public function getModel()
    {
        return $this->model;
    }

    // set the associated model

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships

    public function with($relations)
    {
        return $this->model->with($relations);
    }
}
