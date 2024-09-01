<?php
/**
 * Created by PhpStorm.
 * User: omar
 * Date: 01/01/18
 * Time: 11:25 ص
 */

namespace App\Repositories\Implementations;

use App\Models\BaseModel;
use App\Repositories\IRepository;
use App\Repositories\Pipeline\Pipeline;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;


class Repository implements IRepository
{


    /**
     * @var BaseModel|Builder|\Illuminate\Database\Eloquent\Builder $model
     */
    protected $model;


    /**
     * set database model to object
     * @param $model
     * @return $this
     */
    public function setModel($model){
        $this->model = $model;
        return $this;
    }

    /**
     * create a new record in database
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    public function lockForUpdate(){
        return $this->model->lockForUpdate();
    }

    /**
     * find record where permission
     * @param $key
     * @param null $operator
     * @param null $value
     * @return $this
     */
    public function where($key, $operator = null, $value = null)
    {
        return $this->model->where($key, $operator, $value);
    }

    /**
     * with relationship function
     * @param $relations
     * @return $this
     */
    public function with($relations)
    {
        if (! $relations) {
            return $this;
        }

        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * get first record in database
     * @return mixed
     */
    public function first()
    {
        $model= $this->model->first();
        $this->resetModel();
        return $model;
    }

    /**
     * get all matched data in database
     * @return Collection
     */
    public function get(): Collection
    {
        $collection = $this->model->get();
        $this->resetModel();
        return $collection ;
    }

    /**
     * update data in database
     * @param $data
     * @return mixed
     */
    public function update($data)
    {
        $model= $this->model->update($data);
        $this->resetModel();
        return $model;
    }


    /**
     * where in function database
     * @param string $key
     * @param array $array
     * @return IRepository
     */
    public function whereIn($key, $array): IRepository
    {
        if (!empty($array)) {
            $this->model = $this->model->whereIn($key, (array) $array);
        }

        return $this;
    }

}
