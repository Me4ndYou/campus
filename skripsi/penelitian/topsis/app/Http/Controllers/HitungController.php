<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\TOPSIS;

class HitungController extends Controller
{
    function index()
    {

        $data['rel_alternatif'] = get_rel_alternatif();
        $kriteria = Kriteria::all();
        $atribut = array();
        $bobot = array();
        foreach ($kriteria as $row) {
            $atribut[$row->kode_kriteria] = $row->atribut;
            $bobot[$row->kode_kriteria] = $row->bobot;
            $data['kriterias'][$row->kode_kriteria] = $row;
        }
        $topsis = new TOPSIS($data['rel_alternatif'], $bobot, $atribut);
        $data['categories'] = [];
        $data['series'][0] = [
            'name' => 'Total',
            'data' => [],
        ];
        foreach ($topsis->pref as $key => $val) {
            $alternatif = Alternatif::find($key);
            $alternatif->total = $val;
            $alternatif->rank = $topsis->rank[$key];
            $alternatif->save();
            $data['categories'][$key] = $alternatif->nama_alternatif;
            $data['series'][0]['data'][$key] = $val * 1;
        }
        $data['categories'] = array_values($data['categories']);
        $data['series'][0]['data'] = array_values($data['series'][0]['data']);
        $data['topsis'] = $topsis;
        $data['alternatifs'] = get_alternatif();
        $data['title'] = 'Perhitungan';

        return view('hitung.index', $data);
    }

    function cetak()
    {
        $data['title'] = 'Laporan Hasil Perhitungan';
        $data['rows'] = Alternatif::orderBy('rank')->get();
        return view('hitung.cetak', $data);
    }
}
