<?php $this->extend ("layout/layout") ?>
<?php $this->section("content")?>

<div class="container">

<div class="row">
<div class="col-md-12">
  <div class ="card">

    <div class="card-header">
      <div class="row">
        <div class="col-md-6">
            <h1>Semua Film</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="/film/add" class="btn btn-primary">Tambah Data</a>
        </div>
        </div>
      </div>
    </div>
    
  <div class="card-body"></div>
    <table class="table table-striped">
        <tr>
            <th>No</th>
            <th>Nama Film</th>
            <th>Gambar</th>
            <th>Genre</th>
            <th>Duration</th>
            <th>Action</th>
        </tr>
        <?php $i = 1;?>
        <?php foreach ($data_film as $film) :  ?> 
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $film["nama_film"] ?></td>
                <td><img src="/assets/cover/<?= $film["cover"] ?>" class="card-img-top full-width-image"
                alt="Poster Film" style="width:50px" ></td>
                <td><?= $film["nama_genre"] ?></td>
                <td><?= $film["duration"] ?></td>
                <td>
                    <a href="" class="btn btn-success">Update</a>
                    <a href="" class="btn btn-warning">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>        
</div>    
</div>
</div>

<?php $this->endsection();