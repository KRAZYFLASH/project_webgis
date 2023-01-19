<?= $this->extend('/admin/Fitur/fileInti/dataKebun') ?>

<?= $this->section('dataKebun') ?>
<div class="containerAdmin">
<div>
    <a href="/createDataKebun" type="button" class="btn btn-success m-4"><i class="fa fa-plus"></i> Tambah Data</a>
</div>
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>fid</th>
                        <th>Kebun</th>
                        <th>Afdeling</th>
                        <th>Blok</th>
                        <th>blok Sap</th>
                        <th>Komoditi</th>
                        <th>Tahun Tanam</th>
                        <th>Luas</th>
                        <th>Total poko</th>
                        <th>pokok per</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $key=>$value): ?>
                        <tr>
                            <td style="width: 10%;"><?= $key+1 ?></td>
                            <td><?= $value->fid_1?></td>
                            <td><?= $value->kebun?></td>
                            <td><?= $value->afdeling?></td>
                            <td><?= $value->blok?></td>
                            <td><?= $value->blok_sap?></td>
                            <td><?= $value->komoditi?></td>
                            <td><?= $value->tahuntanam?></td>
                            <td><?= $value->luas_ha?></td>
                            <td><?= $value->total_poko?></td>
                            <td><?= $value->pokok_per_?></td>
                            <td>
                                <div class="d-flex align-items-start">
                                    <a class="btn btn-warning" href="#" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>
                                    <form action="#" method="post">
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button type="submit" class="btn btn-danger" style="margin-right: 5px;"><i class="fa fa-trash"></i></button>
                                    </form>
                                    <a class="btn btn-primary" href="<?= site_url('ambilDataKebun/'.$value->gid) ?>"><i class="fa fa-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>

<?= $this->endSection() ?>