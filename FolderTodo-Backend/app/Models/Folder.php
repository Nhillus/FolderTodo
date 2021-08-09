<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    //
    Protected $fillable  = ['nombre'];

    public function getAllFolders() {
        $folder = Folder::all();
        return $folder; 
    }

    public function agregarFolder($nombre) {
        $folder = new Folder;
        $folder->nombre = $nombre;
        $folder->save();
        if (!$folder) {
            return response()->json(["success"=>false, "message" =>'Registro de Folder fallida'],500);
        }
        return response()->json(["success"=>true, 
                                 "message" =>'Registro de Folder exitoso', 
                                 "Folder" => $folder],201);
    }
    
}
