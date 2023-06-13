<?php

namespace App\Controllers;

use App\Controllers\BaseController;

// step 1
use App\Models\GenreModel;

class Genre extends BaseController
{
    //step 2
    protected $genre;
    //step 3 buat fungsi construct untuk inisasi class model
    public function __construct()
    {
        //step 4 
        $this->genre = new GenreModel();
    }

    public function index()
    {
        $data['data_film'] = ($this->film->getGenre());
        return view("film/index", $data);
    }

    public function all(){
        $data['semuagenre'] = $this->genre->getallData();
        return view("genre/semuagenre", $data);
    }

    public function film_by_id(){
        dd($this->film->getDataById(2));
    }

    public function film_by_genre(){
        dd($this->film->getDataBy('komedi'));
    }

    public function film_order(){
        dd($this->film->getOrderBy());
    }

    public function film_limit_Four(){
        dd($this->film->getLimit());
    }
}