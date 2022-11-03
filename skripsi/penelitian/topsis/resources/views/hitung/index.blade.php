@extends('layout.app')
@section('title', $title)
@section('content')
{{ show_msg() }}
<div class="card mb-3">
    <div class="card-header">
        <strong class="card-title">Kriteria</strong>
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <th>Kode</th>
                <th>Nama</th>
                <th>Atribut</th>
                <th>Bobot</th>
            </thead>
            @foreach($kriterias as $key => $val)
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $val->nama_kriteria }}</td>
                <td>{{ $val->atribut }}</td>
                <td>{{ round($val->bobot, 4) }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <strong class="card-title">Data Alternatif</strong>
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <th>Kode</th>
                <th>Nama</th>
                @foreach($kriterias as $key => $val)
                <th>{{ $val->nama_kriteria }}</th>
                @endforeach
            </thead>
            @foreach($rel_alternatif as $key => $val)
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $alternatifs[$key]->nama_alternatif }}</td>
                @foreach($val as $k => $v)
                <td>{{ $v }}</td>
                @endforeach
            </tr>
            @endforeach
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <strong class="card-title">Normalisasi</strong>
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <th>Kode</th>
                @foreach($kriterias as $key => $val)
                <th>{{ $key }}</th>
                @endforeach
            </thead>
            @foreach($topsis->normal as $key => $val)
            <tr>
                <td>{{ $key }}</td>
                @foreach($val as $k => $v)
                <td>{{ round($v, 4) }}</td>
                @endforeach
            </tr>
            @endforeach
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <strong class="card-title">Terbobot</strong>
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <th>Kode</th>
                @foreach($kriterias as $key => $val)
                <th>{{ $key }}</th>
                @endforeach
            </thead>
            @foreach($topsis->terbobot as $key => $val)
            <tr>
                <td>{{ $key }}</td>
                @foreach($val as $k => $v)
                <td>{{ round($v, 4) }}</td>
                @endforeach
            </tr>
            @endforeach
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <strong class="card-title">Matriks Solusi Ideal</strong>
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <th>Ideal</th>
                @foreach($kriterias as $key => $val)
                <th>{{ $key }}</th>
                @endforeach
            </thead>
            @foreach($topsis->solusi_ideal as $key => $val)
            <tr>
                <td>{{ $key }}</td>
                @foreach($val as $k => $v)
                <td>{{ round($v, 4) }}</td>
                @endforeach
            </tr>
            @endforeach
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <strong class="card-title">Jarak Solusi Ideal</strong>
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Positif</th>
                    <th>Negatif</th>
                    <th>Preferensi</th>
                </tr>
            </thead>
            @foreach($topsis->jarak_solusi as $key => $val)
            <tr>
                <td>{{ $key }}</td>
                <td>{{ round($val['positif'], 4) }}</td>
                <td>{{ round($val['negatif'], 4) }}</td>
                <td>{{ round($topsis->pref[$key], 4) }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <strong class="card-title">Perangkingan</strong>
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Total</th>
                </tr>
            </thead>
            @foreach($topsis->rank as $key => $val)
            <tr>
                <td>{{ $val }}</td>
                <td>{{ $key }}</td>
                <td>{{ $alternatifs[$key]->nama_alternatif }}</td>
                <td>{{ round($topsis->pref[$key], 4) }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="card-footer">
        <a class="btn btn-secondary" href="{{ route('hitung.cetak') }}" target="_blank"><span class="fa fa-print"></span> Cetak</a>
    </div>
</div>
@endsection