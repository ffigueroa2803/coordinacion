<?php

namespace App\Tools;

use Illuminate\Database\Eloquent\Builder;


class Filters {

    private $filters;
    private $datos;
    public function __construct(array $datos = [])
    {
        $this->datos = $datos;
        $this->filters = collect([]);
        // ejecutar handle
        $this->handle();
    }


    private function handle() 
    {
        foreach ($this->datos as $key => $data) {
            $this->filters->put($key, $data);
        }
    }


    public function all() 
    {
        return $this->filters;
    }


    public function where(Builder $build, $except = [], $signo = "=") {
        // clonar build
        $newBuild = $build;
        foreach ($this->filters->except($except) as $name  => $value) {
           try {
               $build = $build->where($name, $signo, $value);
           } catch (\Throwable $th) {
               return $newBuild;
           }
        }
        // response
        return $build;
    }


    public function __toString() {
        return json_encode($this->filters ? $this->filters : []);
    }

}