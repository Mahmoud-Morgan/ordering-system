<?php
/**
 * Created by PhpStorm.
 * User: Omar
 * Date: 07/12/17
 * Time: 01:22 ص
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface IRepository
{
    public function create($data);

    public function lockForUpdate();

    public function update($data);

    public function where($key,$operator,$value=null);

    public function with($relations);

    public function get(): Collection;

    public function first();

    public function setModel($model);

    public function whereIn($key, $array): IRepository;

}
