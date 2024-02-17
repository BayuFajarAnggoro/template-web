<?php
function parent($judul, $anak, $isparent = false, $ishasInduk = false, $issupervisor, $m_cabang)
{
    // die(var_dump($issupervisor));
    $data = '<tr data-widget="expandable-table" aria-expanded="false"><td>';
    if ($isparent) {
        $data .= '<button type="button" class="btn btn-primary p-0"><i class="expandable-table-caret fas fa-caret-right fa-fw"></i></button>&ensp;&emsp;&nbsp;';
    }
    $data .= '(' . $judul['KodeAkun'] . ')&nbsp;&nbsp;' . $judul['NamaAkun'];
    if ($ishasInduk) {
        if ($m_cabang == '0') {
            if ($issupervisor == '1') {
                $data .= "&ensp;&emsp;<a class='btn-edit' data-obj='" . json_encode($judul) . "'href='#'><span><i class='fa fa-edit ml-4'></i></span></a>
            &nbsp;<a class='btn-hapus' data-kode='" . $judul['KodeAkun'] . "'href='#'><span><i class='fa fa-trash ml-4'></i></span></a>";
            } else {
                $data .= "&ensp;&emsp;<a class='btn-edit' data-obj='" . json_encode($judul) . "'href='#'><span><i class='fa fa-edit ml-4'></i></span></a>";
            }
        }
    } else {
        $data .= '</td></tr>';
    }
    $data .= anak($anak, $issupervisor, $m_cabang);
    return $data;
}

function anak($anak, $issupervisor, $m_cabang)
{
    $data = '';
    $data .= '<tr class="expandable-body d-none">
    <td>
        <div class="p-0" style="display: none;">
            <table class="table table-hover">
                <tbody>';

    foreach ($anak as $key => $value) {
        $data .= parent($value, $value['anak'], $value['IsParent'], true, $issupervisor, $m_cabang);
    }

    $data .= ' </tbody>
            </table>
        </div>
    </td>
 </tr>';
    return $data;
}

function draw_table($judul, $space = '&nbsp;', $m_cabang)
{
    $data = '<tr>';
    $data .= '<td>' . $judul['KodeAkun'] . '</td>';
    $data .= '<td>' . ($space != '' ? $space . '- '   : $space . '* ') . $judul['NamaAkun'] . '</td>';
    $data .= '<td>' . @$judul['KategoriArusKas'] . '</td>';
    $data .= '</tr>';
    foreach ($judul['anak'] as $key => $value) {
        $data .= draw_table($value, ($space . '&ensp;&emsp;'), $m_cabang);
    }
    return $data;
}

?>

<div class="col-md-12 col-sm-6">
    <div class="card card-primary card-outline card-outline-tabs">
        <form action="" method="get" id="form1">
            
            <div class="card-header p-0 border-bottom-0" style="margin-left: 20px; margin-right: 20px;">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link <?php echo @$tab1 == "true" ? "active" : ""; ?>" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="<?= @$tab1 ?>">Tree View</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo @$tab2 == "true" ? "active" : ""; ?>" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="<?= @$tab2 ?>">Table View</a>
                    </li>
                    <li class="nav-item ml-auto p-2" <?php echo ($this->session->userdata['m_cabang'] == '0' ? '' : 'hidden'); ?>>
                        <button id="btntambah" type="button" class="btn btn-block btn-primary">Tambah Data</button>
                    </li>
                </ul>
                <input type="hidden" id="tab-selection" name="tab-selection" value="<?php echo @$tab1 == "true" ? base64_encode("1") : base64_encode("2"); ?>""/>
            </div>
        </form>
        <div class=" card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade <?php echo @$tab1 == "true" ? "show active" : ""; ?>" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                        <table class="table table-hover">
                            <tbody>
                                <?php foreach ($data as $key => $row) : ?>
                                    <?= parent($row, $row['anak'], true, false, $this->session->userdata['IsSupervisor'], $m_cabang) ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade <?php echo @$tab2 == "true" ? "show active" : ""; ?>" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th>Kategori Akun</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $key => $row) : ?>
                                    <?= draw_table($row, '', $m_cabang) ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>

    <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modaltitle"> Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="myform" action="<?= base_url('master/akun/simpan') ?>" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group grp-cabang" <?php echo $m_cabang == '0' ? '' : 'hidden'; ?>>
                                    <label class="form-control-label">Cabang</label>
                                    <select name="m_cabang" class="form-control select2" id="combo-cabang1">
                                        <?php if (@$model['NoTransJurnal'] == '') {
                                            if ($m_cabang == '0') { ?>
                                                <!-- <option selected value="">Pilih Cabang</option> -->
                                                <?php foreach ($cabang as $key) {
                                                    if ($key['id'] == '1') {
                                                ?>
                                                        <option <?php echo $m_cabang == $key['id'] ? 'selected' : ''; ?> value="<?= $key['id'] ?>"><?= $key['nama'] ?></option>
                                                <?php }
                                                }
                                            } else { ?>
                                                <option value="">Pilih Cabang</option>
                                                <?php foreach ($cabang as $key) { ?>
                                                    <!-- <option <?php // echo $m_cabang == $key['id'] ? 'selected' : ''; 
                                                                    ?> value="<?= $key['id'] ?>"><?= $key['nama'] ?></option> -->
                                            <?php }
                                            }
                                        } else { ?>
                                            <!-- <option value="">Pilih Cabang</option> -->
                                            <?php foreach ($cabang as $key) {
                                                if ($key['id'] == '1') {
                                            ?>
                                                    <option <?php echo @$model['m_cabang'] == $key['id'] ? 'selected' : ''; ?> value="<?= $key['id'] ?>"><?= $key['nama'] ?></option>
                                        <?php  }
                                            }
                                        } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Kelompok Akun</label>
                                    <select id="cbkelompok" name="KelompokAkun" class="form-control select2">
                                        <option value="">Pilih Kelompok</option>
                                        <?php foreach ($kelompok as $key) { ?>
                                            <option data-kode="<?= @$key['KodeAkun'] ?>" <?= (@$data['KelompokAkun'] == $key['NamaAkun'] ? 'selected' : '') ?> required value="<?= $key['NamaAkun'] ?>"><?= $key['NamaAkun'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Akun Induk</label>
                                    <select id='indukakun' name="AkunInduk" class="form-control  select2">
                                        <option value="">Pilih Induk</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="NamaAkun">Nama Akun</label>
                                    <input type="hidden" name="KodeAkun">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span id="txt-kode-akun-add" class="input-group-text">-</span>
                                        </div>
                                        <input required name="NamaAKun" class="form-control" id="namaakun" placeholder="Masukkan Nama Akun">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Keterangan">Keterangan</label>
                                    <input name="Keterangan" class="form-control" id="Keterangan" placeholder="Masukkan Keterangan">
                                </div>
                                <div class="form-group">
                                    <label>Kategori Arus Kas</label>
                                    <select id="KategoriArusKas" name="KategoriArusKas" class="form-control  select2">
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($kat as $key) { ?>
                                            <option <?= (@$data['KategoriArusKas'] == $key ? 'selected' : '') ?> value="<?= $key ?>"><?= $key ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" name="IsParent" type="checkbox" id="cbparent" value="1" checked>
                                        <label for="cbparent" class="custom-control-label">Akun Induk</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" name="IsAktif" type="checkbox" id="cbaktif" value="1" checked>
                                        <label for="cbaktif" class="custom-control-label">Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-default2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modaltitle2"> Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="myform2" action="<?= base_url('master/akun/simpan') ?>" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group grp-cabang" <?php echo $m_cabang == '0' ? '' : 'hidden'; ?>>
                                    <label class="form-control-label">Cabang</label>
                                    <!-- <select disabled required name="m_cabang" class="form-control select2" id="combo-cabang2">
                                        <?php if (@$model['NoTransJurnal'] == '') {
                                            if ($m_cabang == '0') { ?>
                                                <option selected value="">Pilih Cabang</option>
                                                <?php foreach ($cabang as $key) { ?>
                                                    <option value="<?= $key['id'] ?>"><?= $key['nama'] ?></option>
                                                <?php }
                                            } else { ?>
                                                <option value="">Pilih Cabang</option>
                                                <?php foreach ($cabang as $key) { ?>
                                                    <option <?php echo $m_cabang == $key['id'] ? 'selected' : ''; ?> value="<?= $key['id'] ?>"><?= $key['nama'] ?></option>
                                            <?php }
                                            }
                                        } else { ?>
                                            <option value="">Pilih Cabang</option>
                                            <?php foreach ($cabang as $key) { ?>
                                                <option <?php echo @$model['m_cabang'] == $key['id'] ? 'selected' : ''; ?> value="<?= $key['id'] ?>"><?= $key['nama'] ?></option>
                                        <?php  }
                                        } ?>
                                    </select> -->
                                    <input id="combo-cabang2" required class="form-control" placeholder="Pilih Cabang">
                                    <input type="hidden" id="id-cabang2" name="m_cabang" class="form-control">

                                </div>
                                <div class="form-group">
                                    <label>Kelompok Akun</label>
                                    <input required name="KelompokAkun" class="form-control" id="KelompokAkun2" placeholder="Masukkan Kelompok Akun">
                                </div>
                                <div class="form-group">
                                    <label>Akun Induk</label>
                                    <input required name="AkunInduk" class="form-control" id="AkunInduk2" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="NamaAkun">Nama Akun</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span id="txt-kode-akun-add2" class="input-group-text">-</span>
                                        </div>
                                        <input required name="NamaAKun" class="form-control" id="NamaAkun2" placeholder="Masukkan Nama Akun">
                                    </div>
                                    <input id="KodeAkun2" type="hidden" name="KodeAkun">
                                    <!-- <input required name="NamaAKun" class="form-control" id="NamaAkun2" placeholder="Masukkan Nama Akun"> -->
                                </div>
                                <div class="form-group">
                                    <label for="Keterangan">Keterangan</label>
                                    <input name="Keterangan" class="form-control" id="Keterangan2" placeholder="Masukkan Keterangan">
                                </div>
                                <div class="form-group">
                                    <label>Kategori Arus Kas</label>
                                    <select id="KatArusKas" required name="KategoriArusKas" class="form-control  select2">
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($kat as $key) { ?>
                                            <option <?= (@$data['KategoriArusKas'] == $key ? 'selected' : '') ?> value="<?= $key ?>"><?= $key ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" name="IsParent" type="checkbox" id="cbparent2">
                                        <label for="cbparent2" class="custom-control-label">Akun Induk</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" name="IsAktif" type="checkbox" id="cbaktif2">
                                        <label for="cbaktif2" class="custom-control-label">Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <script>
        $("#custom-tabs-four-home-tab").on("click", function() {
            // alert("tab no 2 is clicked....");
            $("#tab-selection").val(btoa("1"));
        });
        $("#custom-tabs-four-profile-tab").on("click", function() {
            // alert("tab no 2 is clicked....");
            $("#tab-selection").val(btoa("2"));
        });

        $('.btn-edit').click(function(e) {
            e.preventDefault();
            $('#modaltitle2').html("Edit Data")
            $('#modal-default2').modal('show');
            const model = JSON.parse($(this).attr('data-obj'));
            document.getElementById("AkunInduk2").disabled = true;
            document.getElementById("KelompokAkun2").disabled = true;
            document.getElementById("cbparent2").disabled = model.IsParent == 1;
            $('#KelompokAkun2').val(model.KelompokAkun);
            $('#cbparent2').prop('checked', model.IsParent == 1)
            $('#KatArusKas').val(model.KategoriArusKas).change()
            $('#Keterangan2').val(model.Keterangan)
            $('#NamaAkun2').val(model.NamaAkun);
            $('#KodeAkun2').val(model.KodeAkun);
            $('#AkunInduk2').val(model.AkunInduk);
            $('#txt-kode-akun-add2').html(model.KodeAkun);

            // $('#combo-cabang2').val(model.m_cabang).change();
            $.ajax({
                type: "GET",
                url: "<?= base_url('master/akun/getOneCabang') ?>",
                data: {
                    id: model.m_cabang
                },
                dataType: "JSON",
                success: function(response) {
                    const data = response.data;
                    // console.log(data.nama);
                    $('#combo-cabang2').val(data.nama);
                }
            });

            $('#id-cabang2').val(model.m_cabang);

            document.getElementById("combo-cabang2").disabled = true;

            $("#cbaktif2").prop("checked", model.IsAktif == 1);
        })

        $('#btntambah').click(function(e) {
            e.preventDefault()
            $('#modaltitle').html("Tambah Data")
            $('#myform')[0].reset()
            $('#modal-default').modal('show');
        })
        // reset induk akun agar bisa generate kode akun baru
        $('#cbkelompok').change(function(event) {
            var kelompok = $(this).find('option:selected').attr('value');
            var m_Cabang = $("#combo-cabang1").find('option:selected').attr('value');

            let kode = $(this).find('option:selected').attr('data-kode')

            var draw = '<option value="">Pilih Akun Induk</option>';
            draw += '<option value="' + kode + '">' + kode + ' - ' + kelompok + '</option>';
            $.ajax({
                type: "GET",
                url: "<?= base_url('master/akun/getIndukByKelompok') ?>",
                data: {
                    kelompok: kelompok,
                    m_cabang: m_Cabang
                },
                dataType: "JSON",
                success: function(response) {

                    if (response.status) {
                        const res = response.data;

                        for (i = 0; i < res.length; i++) {
                            draw += '<option value="' + res[i]['KodeAkun'] + '">' + res[i]['KodeAkun'] + ' - ' + res[i]['NamaAkun'] + '</option>';
                        }
                    }
                    $('#indukakun').html(draw);

                },
                error: function(xhr, status, error) {
                    // $('#indukakun').html(draw);
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });
            $('#txt-kode-akun-add').html('-');
        })

        $('#btn-cari').click(function(event) {
            document.getElementById("form1").submit();
        })

        $('#combo-cabang1').change(function(event) {
            var kelompokAkun = $("#cbkelompok").find('option:selected').attr('value');
            var draw = '<option>Pilih Kelompok</option>';
            // let kode = $("#cbkelompok").find('option:selected').attr('data-kode')

            // draw += '<option value="' + kode + '">' + kode + ' - ' + kelompokAkun + '</option>';
            $.ajax({
                type: "GET",
                url: "<?= base_url('master/akun/generateKelompokakun') ?>",
                data: {},
                dataType: "JSON",
                success: function(response) {

                    if (response.status) {
                        const res = response.data;
                        for (i = 0; i < res.length; i++) {
                            // draw += '<option value="' + res[i]['KodeAkun'] + '">' + res[i]['KodeAkun'] + ' - ' + res[i]['NamaAkun'] + '</option>';
                            draw += '<option data-kode="' + res[i]['KodeAkun'] + '"' + (res[i]['KodeAkun'] == kelompokAkun ? 'selected' : '') + ' required value="' + res[i]['NamaAkun'] + '">' + res[i]['NamaAkun'] + '</option>';
                        }
                    }
                    $('#cbkelompok').html(draw);
                },
                error: function(xhr, status, error) {
                    // $('#indukakun').html(draw);
                    // var err = eval("(" + xhr.responseText + ")");
                    // console.log(err.Message);
                }
            });
            // $('#txt-kode-akun-add').html('-');
        })

        $('#indukakun').change(function(event) {
            var kodeinduknya = $(this).find('option:selected').attr('value');
            var m_Cabang = $("#combo-cabang1").find('option:selected').attr('value');

            $.ajax({
                type: "GET",
                url: "<?= base_url('master/akun/generatecode') ?>",
                data: {
                    kodeakun: kodeinduknya,
                    m_cabang: m_Cabang
                },
                dataType: "JSON",
                success: function(response) {
                    const data = response.data;
                    $('#txt-kode-akun-add').html(data);
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });
        })

        $('.btn-hapus').click(function(e) {
            e.preventDefault();
            const kode = $(this).data('kode');
            var m_Cabang = $("#combo-cabang").find('option:selected').attr('value');
            console.log(kode + ' ini m cabang' + m_Cabang);
            Swal.fire({
                title: 'Apa anda yakin?',
                text: "data terhapus tidak dapat di kembalikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus data!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = '<?= base_url('master/akun/hapus/') ?>' + kode + '/' + m_Cabang
                }
            })
        })
        $("#myform").on('submit', function(e) {
            if ($('#combo-cabang1').val() == '' || $('#cbkelompok').val() == '' || $('#indukakun').val() == '' || $('#KategoriArusKas').val() == '') {
                e.preventDefault();
                Swal.fire('Peringatan!', 'Mohon Isi Data dengan Lengkap', 'warning');
            } else {
                return true;
            }
            // console.log($('#combo-cabang1').val()+' || '+$('#cbkelompok').val()+' || '+$('#indukakun').val()+' || '+$('#KategoriArusKas').val());
        });
    </script>