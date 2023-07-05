<?php

namespace App\Controllers;

use App\Controllers\BaseController;

// step 1
use App\Models\FilmModel;
use App\Models\GenreModel; //tambahan(1)

class Film extends BaseController
{
    //step 2
    protected $film;
    protected $genre; //tambahan(2)
    //step 3 buat fungsi construct untuk inisasi class model
    public function __construct()
    {
        //step 4 
        $this->film = new FilmModel();
        $this->genre = new GenreModel(); //tambahan(3)
    }

    public function index()
    {
        $data['data_film'] = ($this->film->getAllDataJoin());
        return view("film/index", $data);
    }
    
    public function add(){
        $data["genre"] = $this->genre->getAllData();
        $data["errors"] = session('errors');
        return view("film/add", $data);
    }

    public function store(){
        $validation = $this->validate([
            'nama_film' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Nama Film Harus diisi'
                ]
            ],
            'id_genre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Genre Harus diisi'
                ]
            ],
            'duration' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Durasi Harus diisi'
                ]
            ],
            'cover' => [
                'rules' => 'uploaded[cover]|mime_in[cover,/image/jpg,image/jpeg,image/png]|max_size[cover,2048]',
                'errors' => [
                    'uploaded' => 'Kolom Cover Harus berisi file.',
                    'mime_size' => 'Tipe file pada kolom cover harus berupa JPG, JPEG, atau PNG',
                    'max_size' => 'Ukuran file pada kolom Cover melebihi batas maksimum'
                ]
            ]

        ]);

        if (!$validation){
            $errors = \Config\Services::validation()->getErrors();

            return redirect()->back()->withInput()->with('errors', $errors);
        }
        $image = $this->request->getFile('cover');
        //generate nama file yang unik
        $imageName = $image->getRandomName();
        //pindahkan file ke direktori penyimpanan
        $image->move(ROOTPATH . 'public/assets/cover', $imageName);

        $data = [
            'nama_film'=> $this->request->getPost('nama_film'),
            'id_genre'=> $this->request->getPost('id_genre'),
            'duration'=> $this->request->getPost('duration'),
            'cover' => $imageName,
        ];
        $this->film->save($data);
        session()->setflashdata('success', 'Data berhasil disimpan.'); //tambahkan ini
        return redirect()->to('/film');
    }


    public function all()
    {
        $data['semuafilm'] = ($this->film->getAllDataJoin());
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