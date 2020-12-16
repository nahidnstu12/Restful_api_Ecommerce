<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponse {
    private function successResponse($data,$code){
        return \response()->json($data,$code);
    }
    private function errorResponse($msg,$code){
        return \response()->json(['error'=>$msg,'code'=>$code],$code);
    }
    protected function showAll(Collection $coll,$code=200){
        return $this->successResponse(['data'=>$coll],$code);
    }
    protected function showOne(Model $model,$code=200){
        return $this->successResponse(['data'=>$model],$code);
    }
}


?>