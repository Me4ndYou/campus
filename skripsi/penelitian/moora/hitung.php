<div class="page-header">
    <h1>Perhitungan</h1>
</div>
<?php
$c = $db->get_results("SELECT * FROM tb_rel_alternatif WHERE nilai < 0 ");

$bobot = array();
$atribut = array();
foreach ($KRITERIA as $key => $val) {
    $bobot[$key] = $val->bobot;
    $atribut[$key] = $val->atribut;
}

if (!$ALTERNATIF || !$KRITERIA) :
    print_msg("Tampaknya anda belum mengatur alternatif dan kriteria. Silahkan tambahkan minimal 3 alternatif dan 3 kriteria.");
elseif ($c) :
    print_msg("Tampaknya anda belum mengatur nilai alternatif. Silahkan atur pada menu <strong>Nilai Alternatif</strong>.");
elseif (array_sum($bobot) != $TOTAL_BOBOT) :
    print_msg("Total bobot kriteria harus <strong>$TOTAL_BOBOT</strong>, silahkan atur pada menu Kriteria.");
else :

    $rel_alternatif = get_rel_alternatif();
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
                <?php endforeach ?>
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
        <div class="panel-footer">
            <a class="btn btn-default" href="cetak.php?m=hitung" target="_blank"><span class="glyphicon glyphicon-plus"></span> Cetak</a>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Grafik</h3>
        </div>
        <div class="panel-body">
            <style>
                .highcharts-credits {
                    display: none;
                }
            </style>
            <?php
            function get_chart1()
            {
                global $moora, $ALTERNATIF;

                foreach ($moora->rank as $key => $val) {
                    $data[$ALTERNATIF[$key]] = $moora->total[$key] * 1;
                }

                $chart = array();

                $chart['chart']['type'] = 'column';
                // $chart['chart']['options3d'] = array(
                //     'enabled' => true,
                //     'alpha' => 15,
                //     'beta' => 15,
                //     'depth' => 50,
                //     'viewDistance' => 25,
                // );
                $chart['title']['text'] = 'Grafik Hasil Perangkingan';
                $chart['plotOptions'] = array(
                    'column' => array(
                        'depth' => 25,
                    )
                );

                $chart['xAxis'] = array(
                    'categories' => array_keys($data),
                );
                $chart['yAxis'] = array(
                    'min' => 0,
                    'title' => array('text' => 'Rank'),
                );
                $chart['tooltip'] = array(
                    'headerFormat' => '<span style="font-size:10px">{point.key}</span><table>',
                    'pointFormat' => '<tr><td style="color:{series.color};padding:0">{series.name}: </td>
                    <td style="padding:0"><b>{point.y:.4f}</b></td></tr>',
                    'footerFormat' => '</table>',
                    'shared' => true,
                    'useHTML' => true,
                );

                $chart['series'] = array(
                    array(
                        'name' => 'Rangking',
                        'data' => array_values($data),
                    )
                );
                return $chart;
            }

            ?>
            <script>
                $(function() {
                    $('#chart1').highcharts(<?= json_encode(get_chart1()) ?>);
                })
            </script>
            <div id="chart1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
    </div>
<?php endif ?>