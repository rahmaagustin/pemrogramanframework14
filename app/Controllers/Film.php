<?php

namespace App\Controllers;

use App\Controllers\BaseController;

// step 1
use App\Models\FilmModel;

class Film extends BaseController
{
    //step 2
    protected $film;
    //step 3 buat fungsi construct untuk inisasi class model
    public function __construct()
    {
        //step 4 
        $this->film = new FilmModel();
    }

    public function index()
    {
        $data['data_film'] = ($this->film->getFilm());
        return view("film/index", $data);
    }
    
    public function all(){
        $data['semuafilm'] = $this->film->getallData();
        return view("film/semuafilm", $data);
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