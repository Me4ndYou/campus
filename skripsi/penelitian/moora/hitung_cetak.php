<h1>Perhitungan</h1>
<?php
$rel_alternatif = get_rel_alternatif();
$bobot = array();
$atribut = array();
foreach ($KRITERIA as $key => $val) {
    $bobot[$key] = $val->bobot;
    $atribut[$key] = $val->atribut;
}
$moora = new MOORA($rel_alternatif, $bobot, $atribut);
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Hasil Analisa</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <?php foreach ($KRITERIA as $key => $val) : ?>
                        <th><?= $val->nama_kriteria ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php foreach ($moora->rel_alternatif as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $ALTERNATIF[$key] ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= $v ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
    <div class="panel-body">
        <p>Penjelasan Hasil Analisa</p>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Normalisasi</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <?php foreach ($KRITERIA as $key => $val) : ?>
                        <th><?= $val->nama_kriteria ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php foreach ($moora->normal as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $ALTERNATIF[$key] ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= round($v, 3) ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
    <div class="panel-body">
        <p>Penjelasan Normalisasi</p>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Terbobot</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <?php foreach ($KRITERIA as $key => $val) : ?>
                        <th><?= $val->nama_kriteria ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php foreach ($moora->terbobot as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $ALTERNATIF[$key] ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= round($v, 3) ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
    <div class="panel-body">
        <p>Penjelasan Terbobot</p>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Perangkingan</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Total</th>
                <th>Rank</th>
            </tr>
            <?php foreach ($moora->rank as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $ALTERNATIF[$key] ?></td>
                    <td><?= round($moora->total[$key], 4) ?></td>
                    <td><?= $val ?></td>
                </tr>
            <?php $no++;
            endforeach ?>
        </table>
    </div>
    <div class="panel-body">
        <?php
        reset($moora->rank);
        $kode_alternatif = key($moora->rank);
        $arr = array();
        foreach ($rel_alternatif[$kode_alternatif] as $key => $val) {
            $arr[] = '<b>' . $KRITERIA[$key]->nama_kriteria . '</b> = <b>' . $val . '</b>';
        }
        ?>
        Berdasarkan perhitungan alternatif paling baik adalah <b><?= $ALTERNATIF[$kode_alternatif] ?></b> dengan <?= implode(', ', $arr) ?> total nilai <b><?= round($moora->total[$kode_alternatif], 4) ?></b>.
    </div>
</div>