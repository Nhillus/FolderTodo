<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;

class FolderController extends Controller
{
    //
    public function index() {
        $folder = new Folder;
        $allFolder = $folder->getAllFolders();
        return ['Folders'=> $allFolder];
    }
    public function Store(Request $request) {
        $folder = new Folder;
        $response=$folder->agregarFolder($request->nombre);
        return $response;
    }
}
