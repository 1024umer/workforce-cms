<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;

interface  BaseRepository {
    public function find($id): ?Model;
    public function delete($model);
}