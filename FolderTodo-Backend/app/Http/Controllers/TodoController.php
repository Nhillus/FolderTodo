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

}
