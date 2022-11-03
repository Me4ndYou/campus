<?php
class MOORA
{
	function __construct($rel_alternatif, $bobot, $atribut)
	{
		$this->rel_alternatif = $rel_alternatif;
		$this->bobot = $bobot;
		$this->atribut = $atribut;

		$this->hitung();
	}

	function hitung()
	{
		$this->normal();
		$this->terbobot();
		$this->total();
		$this->rank();
	}

	function rank()
	{
		$temp = $this->total;
		arsort($temp);
		$no = 1;
		$this->rank = array();
		foreach ($temp as $key => $value) {
			$this->rank[$key] = $no++;
		}
	}

	function total()
	{
		$this->total = array();
		foreach ($this->terbobot as $key => $val) {
			$this->total[$key] = array_sum($val);
		}
	}

	function terbobot()
	{
		$this->terbobot = array();
		foreach ($this->normal as $key => $val) {
			foreach ($val as $k => $v) {
				$this->terbobot[$key][$k] = $v * $this->bobot[$k] * (strtolower($this->atribut[$k]) == 'benefit' ? 1 : -1);
			}
		}
	}

	function normal()
	{
		$arr = array();
		foreach ($this->rel_alternatif as $key => $val) {
			foreach ($val as $k => $v) {
				if (!isset($arr[$k]))
					$arr[$k] = 0;
				$arr[$k] += $v * $v;
			}
		}
		$this->normal = array();
		foreach ($this->rel_alternatif as $key => $val) {
			foreach ($val as $k => $v) {
				$this->normal[$key][$k] = $v / sqrt($arr[$k]);
			}
		}
	}
}
