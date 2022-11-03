<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
//GENERAL
function is_able($action)
{
    $role = [
        'admin' => [
            'home',
            'user.index', 'user.create', 'user.store', 'user.edit', 'user.update', 'user.destroy', 'user.cetak',
            'user.password', 'user.password.update', 'user.logout', 'user.profil', 'user.profil.update',
            'kriteria.index', 'kriteria.create', 'kriteria.store', 'kriteria.edit', 'kriteria.update', 'kriteria.destroy', 'kriteria.cetak',
            'rel_kriteria.index', 'rel_kriteria.simpan',
            'alternatif.index', 'alternatif.create', 'alternatif.store', 'alternatif.edit', 'alternatif.update', 'alternatif.destroy', 'alternatif.cetak',
            'rel_alternatif.index', 'rel_alternatif.edit', 'rel_alternatif.update', 'rel_alternatif.import', 'rel_alternatif.import_action',
            'hitung.index', 'hitung.cetak',
        ],
        'manager' => [
            'home',
            'user.password', 'user.password.update', 'user.logout', 'user.profil', 'user.profil.update',
            'hitung.index', 'hitung.cetak',
        ],
    ];
    $user = Auth::user();
    if ($user) {
        if (in_array(strtolower($user->level), array_keys($role))) {
            return in_array($action, $role[strtolower($user->level)]);
        }
    }
}

function is_hidden($action)
{
    return is_able($action) ? '' : 'hidden';
}

function is_admin()
{
    return Auth::user()->level == 'admin';
}

function is_user()
{
    return Auth::user()->level == 'user';
}

function get_kriteria_option($selected = '')
{
    $arr = get_kriteria();
    $a = '';
    foreach ($arr as $key => $val) {
        if ($key == $selected)
            $a .= '<option value="' . $key . '" selected>' . $val->nama_kriteria . '</option>';
        else
            $a .= '<option value="' . $key . '">' . $val->nama_kriteria . '</option>';
    }
    return $a;
}

function get_kriteria()
{
    $rows = get_results("SELECT * FROM tb_kriteria ORDER BY kode_kriteria");
    $arr = array();
    foreach ($rows as $row) {
        $arr[$row->kode_kriteria] = $row;
    }
    return $arr;
}

function get_alternatif()
{
    $rows = get_results("SELECT * FROM tb_alternatif ORDER BY kode_alternatif");
    $arr = array();
    foreach ($rows as $row) {
        $arr[$row->kode_alternatif] = $row;
    }
    return $arr;
}

function get_rel_alternatif()
{
    $rows = get_results("SELECT * FROM tb_rel_alternatif ORDER BY kode_alternatif, kode_kriteria");
    $arr = array();
    foreach ($rows as $row) {
        $arr[$row->kode_alternatif][$row->kode_kriteria] = $row->nilai;
    }
    return $arr;
}

function format_date($data, $format = 'd-M-Y')
{
    return date($format, strtotime($data));
}

function current_user()
{
    return User::find(Auth::id());
}

function get_atribut_option($selected = '')
{
    $arr = [
        'benefit' => 'Benefit',
        'cost' => 'Cost'
    ];
    $a = '';
    foreach ($arr as $key => $value) {
        if ($selected == $key)
            $a .= "<option value='$key' selected>$value</option>";
        else
            $a .= "<option value='$key'>$value</option>";
    }
    return $a;
}

function get_level_option($selected = '')
{
    $arr = [
        'Admin' => 'Admin',
        'Manager' => 'Manager'
    ];
    $a = '';
    foreach ($arr as $key => $value) {
        if ($selected == $key)
            $a .= "<option value='$key' selected>$value</option>";
        else
            $a .= "<option value='$key'>$value</option>";
    }
    return $a;
}

function get_status_user_option($selected = '')
{
    $arr = [
        1 => 'Aktif',
        0 => 'NonAktif'
    ];
    $a = '';
    foreach ($arr as $key => $value) {
        if ($selected == $key)
            $a .= "<option value='$key' selected>$value</option>";
        else
            $a .= "<option value='$key'>$value</option>";
    }
    return $a;
}

function print_msg($msg, $type = 'danger')
{
    echo ('<div class="alert alert-' . $type . ' alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $msg . '</div>');
}

function show_error($errors)
{
    if ($errors->any()) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <ul class="m-0">';
        foreach ($errors->all() as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
}
function show_msg()
{
    if ($messsage = session()->get('message')) {
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">'
            . $messsage . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}

function rp($number)
{
    return 'Rp ' . number_format($number);
}

function kode_oto($field, $table, $prefix, $length)
{
    $var = get_var("SELECT $field FROM $table WHERE $field REGEXP '{$prefix}[0-9]{{$length}}' ORDER BY $field DESC");
    if ($var) {
        return $prefix . substr(str_repeat('0', $length) . ((int)substr($var, -$length) + 1), -$length);
    } else {
        return $prefix . str_repeat('0', $length - 1) . 1;
    }
}

function get_row($sql = '')
{
    $rows =  DB::select($sql);
    if ($rows)
        return $rows[0];
}

function get_results($sql = '')
{
    return DB::select($sql);
}

function get_var($sql = '')
{
    $row = DB::select($sql);
    if ($row) {
        return current(current($row));
    }
}

function query($sql, $params = [])
{
    return DB::statement($sql, $params);
}
