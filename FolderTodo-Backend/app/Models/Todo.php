<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    Protected $fillable = ["nombre","estado"] ;

    public function agregarTodo($nombre) {
        $todoGuardada = Todo::Create($nombre);
    }
    public function selecionarTodo($id) {
        $todo = Todo::findOrFail($id);
        if (!$todo) {
            return response()->json(["success"=>false, "message" =>'No se pudo enbcontrar la todo'],500);
        }
        return response()->json(["success"=>true, 
                                 "message" =>'Encontrado con exito la todo', 
                                 "Todos" => $todo],200);
    }
    /*public function verTodo() {
        return todo();
    }*/ //esta es para ver una en especifico refactorizar
    public function eliminarTodo() {

    }

    public function modificarTodo() {

    }

    public function getAllTodos() {
        $todos = Todo::all();
        return $todos; 
    }
}
