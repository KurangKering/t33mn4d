<?php
defined('BASEPATH') or exit('No direct script access allowed');
use \Colors\RandomColor;

class LibraryTreemap
{
    protected $_ci;

    protected $_db;

    protected $_pure_cond = array();

    protected $_ex_cond = array();

    protected $_top_data;

    protected $_urutan;

    protected $_result_data;

    public function __construct($params)
    {
        $this->_ci       = &get_instance();
        $this->_db       = $this->_ci->db;
        $this->_top_data = $params['top_data'];
        $this->_urutan   = $params['urutan'] ?? 'sama';

        $this->extractCondition($params['conditions']);

        $this->_ci->load->model('M_Kabupaten');
        $this->_ci->load->model('M_Penyakit');

        $this->_ci->load->helper('helper');

    }

    public function generate()
    {

        $array_data = array(
            'data'     => [],
            'table'    => [],
            'subtitle' => '',
        );

        $this->start();

        if ($this->_result_data) {
            $array_data['data']     = array_values($this->_result_data);
            $array_data['subtitle'] = $this->makeSubtitle();
        }

        $json = gzencode(json_encode($array_data));

        return $json;

    }


    public function report()
    {   

        $d_kes = ($this->getDataFromDB());
        $d_kes = array_slice($d_kes,0,222);
        $d_kes = collect($d_kes);

        $d_kes->each(function($q) {
            $q->bulan = hBulan($q->kesakitan_bulan);
        });
        $html = null;
        if (count($d_kes) > 0 ) {
            $data['kesakitan'] = $d_kes;
            $data['subtitle'] = $this->makeSubtitle();
            $html = $this->_ci->load->view('report/report', compact('data'), TRUE);
        }

        return $html;
    }

    protected function extractCondition($params)
    {
        $conditions = array();

        if (!is_array($params)) {
            return $conditions;
        }

        $params = array_filter($params);

        if (!isset($params['tahun'])) {
            $params['tahun'] = date('Y');
        }
        $conditions['ks.kesakitan_tahun'] = $params['tahun'];

        if (isset($params['bulan'])) {
            $conditions['ks.kesakitan_bulan'] = $params['bulan'];
        }

        if (isset($params['kabupaten'])) {
            $conditions['kb.kabupaten_id'] = $params['kabupaten'];
        }

        if (isset($params['kecamatan'])) {
            $conditions['kc.kecamatan_id'] = $params['kecamatan'];
        }

        if (isset($params['puskesmas'])) {
            $conditions['ks.kesakitan_puskesmas_id'] = $params['puskesmas'];
        }

        if (isset($params['status'])) {
            $conditions['py.penyakit_status'] = $params['status'];
        }

        if (isset($params['penyakit'])) {
            $conditions['ks.kesakitan_penyakit_id'] = $params['penyakit'];
        }

        $this->_pure_cond = $params;
        $this->_ex_cond   = $conditions;

    }

    protected function start()
    {
        $d_kes = collect($this->getDataFromDB());
        if (!$d_kes) {
            return false;
        }

        $d_kab = $d_kes->unique(function ($q) {return $q->kabupaten_id;});
        $d_kec = $d_kes->unique(function ($q) {return $q->kecamatan_id;});
        $d_pus = $d_kes->unique(function ($q) {return $q->puskesmas_id;});
        $d_pen = $d_kes->unique(function ($q) {return $q->kesakitan_penyakit_id;});
        $d_bul = $d_kes->pluck('kesakitan_bulan')->flatten()->unique();

        $h_bul     = hBulan();
        $h_stat    = hStatusPenyakit();
        $container = array();
        $id_tmp    = array();

        $w_kab  = RandomColor::many(count($d_kab));
        $w_kec  = RandomColor::many(count($d_kec));
        $w_pus  = RandomColor::many(count($d_pus));
        $w_stat = RandomColor::many(count($h_stat));
        $w_pen  = RandomColor::many(count($d_pen));
        $w_bul  = RandomColor::many(count($d_bul));

        $iwkab = 0;
        foreach ($d_kab as $kkab => $vkab) {
            $q_jum_kab = $d_kes->where('kabupaten_id', $vkab->kabupaten_id);
            $c_jum_kab = $q_jum_kab->sum('kesakitan_jumlah');

            if ($c_jum_kab < 1) {
                $iwkab++;
                continue;
            }

            $items_kab = array(
                'Kota / Kabupaten' => $vkab->kabupaten_nama,
                'Jumlah' => $c_jum_kab,
            );

            $html_kab  = $this->htmlVerticalHeaderTable($items_kab);
            $array_kab = array(
                'id'          => md5('kab' . $vkab->kabupaten_id),
                'name'        => $vkab->kabupaten_nama,
                // 'value'       => $c_jum_kab,
                'value'       => 1,
                'status'      => 1,
                'color'       => $w_kab[$iwkab++],
                'description' => $html_kab,

            );

            $x_kec = $d_kec->where('kabupaten_id', $vkab->kabupaten_id);
            $iwkec = 0;
            foreach ($x_kec as $kkec => $vkec) {
                $q_jum_kec = $q_jum_kab->where('kecamatan_id', $vkec->kecamatan_id);
                $c_jum_kec = $q_jum_kec->sum('kesakitan_jumlah');

                if ($c_jum_kec < 1) {
                    $iwkec++;
                    continue;
                }

                $items_kec = array(
                    'Kota / Kabupaten' => $vkab->kabupaten_nama,
                    'Kecamatan'        => $vkec->kecamatan_nama,
                    'Jumlah' => $c_jum_kec,

                );

                $html_kec  = $this->htmlVerticalHeaderTable($items_kec);
                $array_kec = array(
                    'id'          => md5('kec' . $vkec->kecamatan_id),
                    'name'        => $vkec->kecamatan_nama,
                    // 'value'       => $c_jum_kec,
                    'value'       => 1,
                    'status'      => 2,
                    'color'       => $w_kec[$iwkec++],
                    'description' => $html_kec,

                );
                $x_pus = $d_pus->where('kecamatan_id', $vkec->kecamatan_id);
                $iwpus = 0;
                foreach ($x_pus as $kpus => $vpus) {
                    $q_jum_pus = $q_jum_kec->where('puskesmas_id', $vpus->puskesmas_id);
                    $c_jum_pus = $q_jum_pus->sum('kesakitan_jumlah');

                    if ($c_jum_pus < 1) {
                        $iwpus++;
                        continue;
                    }

                    $items_pus = array(
                        'Kota / Kabupaten' => $vkab->kabupaten_nama,
                        'Kecamatan'        => $vkec->kecamatan_nama,
                        'Puskesmas'        => $vpus->puskesmas_nama,
                        'Jumlah' => $c_jum_pus,

                    );

                    $html_pus = $this->htmlVerticalHeaderTable($items_pus);

                    $array_pus = array(
                        'id'          => md5('pus' . $vpus->puskesmas_id),
                        'name'        => $vpus->puskesmas_nama,
                        // 'value'       => $c_jum_pus,
                        'value'       => 1,
                        'status'      => 3,
                        'color'       => $w_pus[$iwpus++],
                        'description' => $html_pus,

                    );

                    $iwstat = -1;
                    $iwpen  = -1;
                    foreach ($h_stat as $kstat => $vstat) {
                        $q_jum_stat = $q_jum_pus->where('penyakit_status', $kstat);
                        $c_jum_stat = $q_jum_stat->sum('kesakitan_jumlah');

                        $iwstat++;
                        if ($c_jum_stat < 1) {
                            continue;
                        }
                        $items_stat = array(
                            'Kota / Kabupaten' => $vkab->kabupaten_nama,
                            'Kecamatan'        => $vkec->kecamatan_nama,
                            'Puskesmas'        => $vpus->puskesmas_nama,
                            'Status'           => $vstat,
                            'Jumlah' => $c_jum_stat,

                        );

                        $html_stat = $this->htmlVerticalHeaderTable($items_stat);

                        $array_stat = array(
                            'id'          => md5('stat' . $kstat),
                            'name'        => $vstat,
                            // 'value'       => $c_jum_stat,
                            'value'       => 1,
                            'status'      => 4,
                            'color'       => $w_stat[$iwstat],
                            'description' => $html_stat,

                        );

                        $x_pen = $d_pen->where('penyakit_status', $kstat);

                        foreach ($x_pen as $kpen => $vpen) {

                            $iwpen++;
                            $q_jum_pen = $q_jum_stat->where('kesakitan_penyakit_id', $vpen->kesakitan_penyakit_id);
                            $c_jum_pen = $q_jum_pen->sum('kesakitan_jumlah');

                            if ($c_jum_pen < 1) {
                                continue;
                            }

                            $items_pen = array(
                                'Kota / Kabupaten' => $vkab->kabupaten_nama,
                                'Kecamatan'        => $vkec->kecamatan_nama,
                                'Puskesmas'        => $vpus->puskesmas_nama,
                                'Status'           => $vstat,
                                'Penyakit'         => $vpen->penyakit_nama,
                                'Jumlah' => $c_jum_pen,

                            );

                            $html_pen = $this->htmlVerticalHeaderTable($items_pen);

                            $array_pen = array(
                                'id'          => md5('pen' . $vpen->kesakitan_penyakit_id),
                                'name'        => (string) $vpen->kesakitan_penyakit_id,
                                'value'       => 1,
                                'status'      => 5,
                                'color'       => $w_pen[$iwpen],
                                'description' => $html_pen,

                            );

                            $iwbul = 0;
                            foreach ($d_bul as $vbul) {

                                $q_jum_bul = $q_jum_pen->where('kesakitan_bulan', $vbul);

                                $c_jum_bul = $q_jum_bul->sum('kesakitan_jumlah');

                                if ($c_jum_bul < 1) {
                                    $iwbul++;
                                    continue;
                                }

                                $items_bul = array(
                                    'Kota / Kabupaten' => $vkab->kabupaten_nama,
                                    'Kecamatan'        => $vkec->kecamatan_nama,
                                    'Puskesmas'        => $vpus->puskesmas_nama,
                                    'Status'           => $vstat,
                                    'Penyakit'         => $vpen->penyakit_nama,
                                    'Bulan'            => $h_bul[$vbul],
                                    'Jumlah'      => $c_jum_bul,
                                );

                                $html_bul  = $this->htmlVerticalHeaderTable($items_bul);
                                $array_bul = array(
                                    'id'          => md5('bul' . $vbul),
                                    'name'        => $h_bul[$vbul],
                                    // 'value'       => $c_jum_bul,
                                    'value'       => 1,
                                    'status'      => 6,
                                    'color'       => $w_bul[$iwbul++],
                                    'description' => $html_bul,

                                );

                                $tmpp = array(
                                    $array_kab,
                                    $array_kec,
                                    $array_pus,
                                    $array_stat,
                                    $array_pen,
                                    $array_bul,
                                );

                                if ($this->_urutan != "sama") {

                                    $urutan   = explode(',', $this->_urutan);
                                    $tmp      = array();
                                    $countTmp = count($tmpp);
                                    foreach ($tmpp as $i => $vtmpp) {
                                        $tmp[$i]           = $tmpp[$urutan[$i]];
                                        $tmp[$i]['status'] = $i + 1;
                                        if ($i + 1 < $countTmp) {
                                            $tmp[$i]['description'] = '';
                                        } else {
                                            $tmp[$i]['description'] = $vtmpp['description'];
                                        }
                                    }

                                } else {
                                    $tmp = $tmpp;
                                }

                                $tmp[0]['id']      = ($tmp[0]['id']);
                                $tmp[0]['parentt'] = '';

                                foreach ($tmp as $i => $vtmp) {
                                    if ($i > 0) {
                                        $tmp[$i]['id']      = md5($tmp[$i - 1]['id'] . $tmp[$i]['id']);
                                        $tmp[$i]['parentt'] = $tmp[$i - 1]['id'];
                                    }

                                    if (!isset($container[$tmp[$i]['id']])) {
                                        $container[$tmp[$i]['id']] = $tmp[$i];
                                    }

                                }

                            }

                        }

                    }

                }

            }

        }

        $this->_result_data = $container;
    }

    protected function makeSubtitle()
    {

        $params   = $this->_pure_cond;
        $subtitle = array();

        if (!empty($params['kabupaten'])) {
            $kabupaten  = $this->_ci->M_Kabupaten->findOrFail($params['kabupaten']);
            $subtitle[] = 'Kabupaten ' . $kabupaten->kabupaten_nama;
        }

        if (!empty($params['kecamatan'])) {
            $kecamatan  = $this->_ci->M_Kecamatan->findOrFail($params['kecamatan']);
            $subtitle[] = 'Kecamatan ' . $kecamatan->kecamatan_nama;

        }

        if (!empty($params['puskesmas'])) {
            $puskesmas  = $this->_ci->M_Puskesmas->findOrFail($params['puskesmas']);
            $subtitle[] = 'Puskesmas ' . $puskesmas->puskesmas_nama;

        }

        if (!empty($params['status'])) {
            $subtitle[] = 'Status Penyakit ' . hStatusPenyakit($params['status']);

        }

        if (!empty($params['penyakit'])) {
            $penyakit   = $this->_ci->M_Penyakit->findOrFail($params['penyakit']);
            $subtitle[] = 'Penyakit ' . $penyakit->penyakit_nama;

        }

        if (!empty($params['bulan'])) {
            $subtitle[] = 'Bulan ' . hBulan($params['bulan']);

        }

        if (!empty($params['tahun'])) {
            $subtitle[] = 'Tahun ' . $params['tahun'];

        }

        return implode(', ', $subtitle);

    }

    protected function getDataFromDB()
    {
        $query = $this->_db;
        if (!empty($this->_top_data)) {
            $ids_top = $this->getIdsTopData($this->_top_data);
            $query   = $query->where_in('ks.kesakitan_penyakit_id', $ids_top, false);}

            $query = $query->select('
                ks.kesakitan_bulan,
                ks.kesakitan_tahun,
                ks.kesakitan_puskesmas_id,
                ks.kesakitan_penyakit_id,
                ks.kesakitan_BL,
                ks.kesakitan_BP,
                ks.kesakitan_LL,
                ks.kesakitan_LP,
                (ks.kesakitan_BL +
                ks.kesakitan_BP +
                ks.kesakitan_LL +
                ks.kesakitan_LP) as kesakitan_jumlah,
                ps.puskesmas_id,
                ps.puskesmas_nama,
                kc.kecamatan_id,
                kc.kecamatan_nama,
                kb.kabupaten_id,
                kb.kabupaten_nama,
                py.penyakit_status,
                py.penyakit_nama,
                ');

            if ($this->_ex_cond) {
                $query = $query->where($this->_ex_cond);
            }

            $query = $query->from('kesakitan ks');
            $query = $query->join('puskesmas ps', 'ks.kesakitan_puskesmas_id = ps.puskesmas_id');
            $query = $query->join('kecamatan kc', 'ps.puskesmas_kecamatan_id = kc.kecamatan_id');
            $query = $query->join('kabupaten kb', 'kc.kecamatan_kabupaten_id = kb.kabupaten_id');
            $query = $query->join('penyakit py', 'ks.kesakitan_penyakit_id = py.penyakit_id');

            $d_kes = $query->get();
            $d_kes = $d_kes->result();

            return $d_kes;
        }

        protected function getIdsTopData($top)
        {
            $query_top = $this->_db->select('
              ks.kesakitan_penyakit_id,
              ');
            $query_top = $query_top->where($this->_ex_cond);
            $query_top = $query_top->from('kesakitan ks');
            $query_top = $query_top->join('puskesmas ps', 'ks.kesakitan_puskesmas_id = ps.puskesmas_id');
            $query_top = $query_top->join('kecamatan kc', 'ps.puskesmas_kecamatan_id = kc.kecamatan_id');
            $query_top = $query_top->join('kabupaten kb', 'kc.kecamatan_kabupaten_id = kb.kabupaten_id');
            $query_top = $query_top->join('penyakit py', 'ks.kesakitan_penyakit_id = py.penyakit_id');
            $query_top = $query_top->group_by('ks.kesakitan_penyakit_id');
            $query_top = $query_top->order_by('SUM(ks.kesakitan_BL +
              ks.kesakitan_BP +
              ks.kesakitan_LL +
              ks.kesakitan_LP)', 'desc');
            $query_top = $query_top->limit($this->_top_data);
            $ids_top   = $query_top->get();
            $ids_top   = array_values(array_column($ids_top->result_array(), 'kesakitan_penyakit_id'));
            return $ids_top;

        }

        protected function htmlVerticalHeaderTable($items,
            $open_tag = "<table class=\"table table-tooltip\">",
            $close_tag = "</table>") {

            $rows = $open_tag;
            $rows .= "<tbody>";
            foreach ($items as $key => $item) {
                $rows .=
                "<tr><th>{$key}</th><td>: {$item}</td></tr>";
            }
            $rows . "</tbody>";
            $rows .= $close_tag;
            return $rows;
        }

        protected function htmlHorizontalHeaderTable($items,
            $open_tag,
            $close_tag) {

        }
    }

    /* End of file Treemap.php */
    /* Location: ./application/libraries/Treemap.php */
