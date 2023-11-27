<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\File;
use Illuminate\Support\Facades\Storage;


class FileRepository implements BaseRepository {
    protected $model;
    public function __construct(File $model)
    {
        $this->model=$model;
    }
    public function find($id) : File {
        return $this->model->find($id);
    }
    public function findByTableOnly($table_name, $q){
        $data =  $this->model->where('table_name',$table_name);
        if($q){
            $data = $data->Where(
                function($query) use ($q){
                $query->orWhere('url', 'like', '%'.$q.'%');
            });
        }
        return $data->get();
    }
    public function findByTable($table_name, $ref_id, $type = 2) : File {
        if($type==2){
            return $this->model->where('table_name',$table_name)->where('ref_id',$ref_id)->get();
        }else{
            return $this->model->where('table_name',$table_name)->where('ref_id',$ref_id)->first();
        }
    }
    public function create($files, $table_name, $ref_id, $type=2) : Array {
        $iteration = 0;
        $result = [];
        $plural_table = Str::studly(Str::singular($table_name));
        if($type==1){
            File::where('fileable_id', $ref_id)->where('table_name',$table_name)->where('fileable_type','App\Models\\'.$plural_table)->delete();
        }
        foreach($files as $file){
            $path = $file->storePublicly($table_name,'public');
            $result[] = File::create([
                'url'=>$path,
                'fileable_id'=>$ref_id,
                'fileable_type'=>'App\Models\\'.$plural_table,
                'table_name'=>$table_name,
                'original_name' => $file->getClientOriginalName()
            ]);
            $iteration++;
            if($iteration==1&&$type==1){
                break;
            }
        }
        return $result;
    }
    public function delete($id){
        $this->model->where('id',$id)->delete();
    }
    public function deleteByType($table_name,$ref_id){
        $this->model->where('table_name',$table_name)->where('ref_id',$ref_id)->delete();
    }
    public function updateRefById($id, $ref_id){
        $model = $this->model->find($id);
        $model->fileable_id = $ref_id;
        $model->save();
    }
}