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

    public function update($id)
    {
        $decryptedId = decryptUrl($id);
        $data["genre"] = $this->genre->getAllData();
        $data["errors"] = session('errors');
        $data["film"] = $this->film->getDataByID($decryptedId);
        return view("film/edit", $data);
    }

    public function edit(){
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
            //ubah rulesnya
            'cover' => [
                'rules' => 'mime_in[cover,image/jpg,image/jpeg,image/png]|max_size[cover,2048]',
                'errors' => [
                    'mime_in' => 'Tipe file pada kolom cover harus berupa JPG, JPEG, atau PNG',
                    'max_size' => 'Ukuran file pada kolom Cover melebihi batas maksimum'
                ]
            ]

        ]);

        if (!$validation){
            $errors = \Config\Services::validation()->getErrors();

            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // ambil data lama
        $semuafilm = $this->film->find($this->request->getPost('id'));

        // tambah request id
        $data = [
            'id'=> $this->request->getPost('id'),
            'nama_film'=> $this->request->getPost('nama_film'),
            'id_genre'=> $this->request->getPost('id_genre'),
            'duration'=> $this->request->getPost('duration'),
        ];

        //cek apakah ada cover yang diupload
        $cover = $this->request->getFile('cover');
        if ($cover->isValid() && !$cover->hasMoved()){
            // Generated nama file yang unik
            $imageName = $cover->getRandomName();
            //pindahkan file ke direktori penyimpanan
            $image->move(ROOTPATH . 'public/assets/cover', $imageName);
            // Hapus file gambar lama jika ada
            if ($semuafilm['cover']) {
                unlink(ROOTPATH . 'public/assets/cover'. $semuafilm['cover']);
            }
            // jika ada tambahkan array cover pada variable $data
            $data['cover'] = $imageName;
        }

        $this->film->save($data);
        
        // ubah pesannya
        session()->setflashdata('success', 'Data berhasil diperbarui.');
        return redirect()->to('/film');
    }    

    public function destroy($id)
    {
        $decryptedId = decryptUrl($id);
        $this->film->delete($decryptedId);
        session()->setFlashdata('success', 'Data berhasil dihapus.');![a]('https://github.com/irfanltf/temankoding-ci4/assets/48278734/c50de6cb-d940-4119-b87c-50a08d258143');

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