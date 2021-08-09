<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    //
    public function index() {
        $todo = new Todo;
        $allTodos = $todo->getAllTodos();
        return ['todos'=> $allTodos];
    }
    public function store(Request $request) {
            $todo = new Todo;
            $response=$todo->agregarTodo($request->nombre);
            return $response;
    }
    public function update (request $request) {
        $todo = new Todo;
        $response = $todo->modificarTodo($request->id,$request->nombre);
        return $response;
    }
    public function destroy ($id) {
        $todo = new Todo;
        $response = $todo->eliminarTodo($id);
        return $response;
    }
}
