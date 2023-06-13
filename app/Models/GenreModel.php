<?php

namespace App\Models;

use CodeIgniter\Model;

class GenreModel extends Model
{

    protected $table             = 'genre';
    protected $primaryKey        = 'id';
    protected $useAutoIncrement  = true;
    protected $allowFields       = [];

    public function getGenre()
    {
    $data =[
        [
            "nama_film" => "Sewu Dino",
            "genre"     => "horor",
            "duration"  => "1 jam 43 menit"
        ],
        [
            "nama_film" => "Avatar",
            "genre"     => "fantasi",
            "duration"  => "3 jam 30 menit"
        ],
        [
            "nama_film" => "Conjuring",
            "genre"     => "horor",
            "duration"  => "2 jam 40 menit"
        ],
        [
            "nama_film" => "Imperfect",
            "genre"     => "komedi",
            "duration"  => "2 jam 10 menit"
        ],
        [
            "nama_film" => "Transfomers: Rise Of The Beasts",
            "genre"     => "Laga",
            "duration"  => "2 jam 7 menit"
        ], 
    ];

    return $data;   

    }
    //findAll() digunakan untuk mengambil semua data dari tabel
    public function getAllData(){
       return $this->findAll();
    }

}