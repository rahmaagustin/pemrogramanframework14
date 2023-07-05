<?php

namespace App\Models;

use CodeIgniter\Model;

class FilmModel extends Model
{

    protected $table             = 'film';
    protected $primaryKey        = 'id';
    protected $useAutoIncrement  = true;
    protected $allowedFields      = ['nama_film', 'id_genre', 'duration', 'cover'];

    public function getFilm()
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

    public function index()
    {
        $data['data_film'] = $this->film->getAllDatajoin();
        return view("film/index", $data);
    }

    public function getAllDatajoin(){

       $query  = $this-> db -> table("film")
        ->select("film.*,genre.nama_genre")
        ->join("genre", "genre.id_genre = film.id_genre");
        return $query->get()->getResultArray();
    }
    //findAll() digunakan untuk mengambil semua data dari tabel
    public function getAllData(){
       return $this->findAll();
    }
    //find($id) digunakan untuk mencari data berdasarkan ID
    public function getDataById($id){
        return $this->find($id);
    }
    //where($column, $value) digunakan untuk melakukan query dengan kondisi WHERE
    public function getDataBy($data){
        return $this->where('genre', $data)->findAll();
    }
    //orderBy($column, $order) digunakan untuk mengurutkan hasil query berdasarkan kolom tertentu
    public function getOrderBy(){
        return $this->orderBy('created_at', 'desc')->findAll();
    }
    //limit($limit, $offset) digunakan untuk membatasi jumlah data yang diambil dari tabel
    public function getLimit(){
        return $this->limit(10)->findAll();
    }
}