<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kesakitan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data              = array();
        $this->data['bulan']     = hBulan();
        $this->data['puskesmas'] = $this->M_Puskesmas->orderBy('puskesmas_nama')->get();
        $this->data['penyakit']  = $this->M_Penyakit->orderBy('penyakit_nama')->get();
        return view('kesakitan.index', array('data' => $this->data));

    }

    public function getDataKesakitan()
    {
        $id        = $this->input->post('id');
        $kesakitan = $this->M_Kesakitan->findOrFail($id);

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($kesakitan));
    }

    public function delete()
    {
        $json             = array();
        $json['success']  = 1;
        $json['messages'] = array();

        $id         = $this->input->post('id');
        $data       = $this->M_Kesakitan->findOrFail($id);
        $deleteData = $data->delete();

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($json));

    }
    public function update()
    {
        $this->load->library('form_validation');
        $post = $this->input->post();

        $this->form_validation->set_rules('bulan', 'Bulan', 'trim|required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
        $this->form_validation->set_rules('puskesmas', 'Puskesmas', 'trim|required');
        $this->form_validation->set_rules('penyakit', 'Penyakit', 'trim|required');
        $this->form_validation->set_rules('BL', 'Pasien Baru Laki-Laki', 'trim|required');
        $this->form_validation->set_rules('BP', 'Pasien Baru Perempuan', 'trim|required');
        $this->form_validation->set_rules('LL', 'Pasien Lama Laki-Laki', 'trim|required');
        $this->form_validation->set_rules('LP', 'Pasien Lama Perempuan', 'trim|required');
        $json             = array();
        $json['success']  = 1;
        $json['messages'] = array();
        if (!$this->form_validation->run()) {
            $json['messages'] = array(
                'bulan'   => form_error('bulan', '<p class="mt-3 text-danger">', '</p>'),
                'tahun'   => form_error('tahun', '<p class="mt-3 text-danger">', '</p>'),
                'puskesmas'   => form_error('puskesmas', '<p class="mt-3 text-danger">', '</p>'),
                'penyakit'   => form_error('penyakit', '<p class="mt-3 text-danger">', '</p>'),
                'BL'   => form_error('BL', '<p class="mt-3 text-danger">', '</p>'),
                'BP'   => form_error('BP', '<p class="mt-3 text-danger">', '</p>'),
                'LL'   => form_error('LL', '<p class="mt-3 text-danger">', '</p>'),
                'LP'   => form_error('LP', '<p class="mt-3 text-danger">', '</p>'),
            );
            $json['messages'] = array_filter($json['messages']);
            $json['success']  = 0;
        } else {
            $postData = array(
                'kesakitan_bulan' => $post['bulan'],
                'kesakitan_tahun' => $post['tahun'],
                'kesakitan_puskesmas_id' => $post['puskesmas'],
                'kesakitan_penyakit_id' => $post['penyakit'],
                'kesakitan_BL' => $post['BL'],
                'kesakitan_BP' => $post['BP'],
                'kesakitan_LL' => $post['LL'],
                'kesakitan_LP' => $post['LP'],
            );
            try {
                $updateData = $this->M_Kesakitan->findOrFail($post['id']);
                $updateData = $updateData->update($postData);

            } catch (Exception $e) {
                $code = $e->getCode();
                if ($code == "23000") {
                    $json['messages'] = "Duplikasi Data Tidak Dibolehkan";
                    $json['success'] = 0;
                }
            }


        }

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($json));
    }

    public function store()
    {
        $this->load->library('form_validation');
        $post = $this->input->post();

        $this->form_validation->set_rules('bulan', 'Bulan', 'trim|required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
        $this->form_validation->set_rules('puskesmas', 'Puskesmas', 'trim|required');
        $this->form_validation->set_rules('penyakit', 'Penyakit', 'trim|required');
        $this->form_validation->set_rules('BL', 'Pasien Baru Laki-Laki', 'trim|required');
        $this->form_validation->set_rules('BP', 'Pasien Baru Perempuan', 'trim|required');
        $this->form_validation->set_rules('LL', 'Pasien Lama Laki-Laki', 'trim|required');
        $this->form_validation->set_rules('LP', 'Pasien Lama Perempuan', 'trim|required');
        $json             = array();
        $json['success']  = 1;
        $json['messages'] = array();
        if (!$this->form_validation->run()) {
            $json['messages'] = array(
                'bulan'   => form_error('bulan', '<p class="mt-3 text-danger">', '</p>'),
                'tahun'   => form_error('tahun', '<p class="mt-3 text-danger">', '</p>'),
                'puskesmas'   => form_error('puskesmas', '<p class="mt-3 text-danger">', '</p>'),
                'penyakit'   => form_error('penyakit', '<p class="mt-3 text-danger">', '</p>'),
                'BL'   => form_error('BL', '<p class="mt-3 text-danger">', '</p>'),
                'BP'   => form_error('BP', '<p class="mt-3 text-danger">', '</p>'),
                'LL'   => form_error('LL', '<p class="mt-3 text-danger">', '</p>'),
                'LP'   => form_error('LP', '<p class="mt-3 text-danger">', '</p>'),
            );
            $json['messages'] = array_filter($json['messages']);
            $json['success']  = 0;
        } else {
            $postData = array(
                'kesakitan_bulan' => $post['bulan'],
                'kesakitan_tahun' => $post['tahun'],
                'kesakitan_puskesmas_id' => $post['puskesmas'],
                'kesakitan_penyakit_id' => $post['penyakit'],
                'kesakitan_BL' => $post['BL'],
                'kesakitan_BP' => $post['BP'],
                'kesakitan_LL' => $post['LL'],
                'kesakitan_LP' => $post['LP'],
            );
            try {
                $insertData = $this->M_Kesakitan->insert($postData);
            } catch (Exception $e) {
                $code = $e->getCode();
                if ($code == "23000") {
                    $json['messages'] = "Duplikasi Data Tidak Dibolehkan";
                    $json['success'] = 0;
                }
            }


        }

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($json));
    }

    public function table()
    {
        $this->data['puskesmas'] = $this->M_Puskesmas->get();
        $this->data['kesakitan'] = $this->source();
        return view('kesakitan.table', array('data' => $this->data));
    }

    public function source()
    {
        $dKes = $this->M_Kesakitan->with('dataPenyakit')
        ->where('kesakitan_bulan', '1')
        ->where('kesakitan_tahun', '2017')
        ->orderBy('kesakitan_penyakit_id')
        ->get();

        $dPen = $this->M_Penyakit->orderBy('penyakit_id')->with('dataJenisPenyakit')->get();
        $dPus = $this->M_Puskesmas->orderBy('puskesmas_id')->get();

        $index     = 0;
        $container = array();
        for ($i = 0; $i < count($dPen); $i++) {
            for ($j = 0; $j < count($dPus); $j++) {

                $container[$i]['penyakit_kode']  = $dPen[$i]->penyakit_kode;
                $container[$i]['penyakit_jenis'] = $dPen[$i]->dataJenisPenyakit->jenis_penyakit_nama;
                $container[$i]['penyakit_nama']  = $dPen[$i]->penyakit_nama;
                if (isset($dKes[$index]) && $dKes[$index]->kesakitan_penyakit_id == $dPen[$i]->penyakit_id
                    && $dKes[$index]->kesakitan_puskesmas_id == $dPus[$j]->puskesmas_id
                ) {
                    $container[$i]['data'][$j] = array(
                        'BL' => $dKes[$index]->BL,
                        'BP' => $dKes[$index]->BP,
                        'LL' => $dKes[$index]->LL,
                        'LP' => $dKes[$index]->LP,
                    );
                $index++;

            } else {
                $container[$i]['data'][$j] = array(
                    'BL' => 'X',
                    'BP' => 'X',
                    'LL' => 'X',
                    'LP' => 'X',
                );

            }

        }
    }
    return $container;
}

public function jsonDataKesakitan()
{

    $this->dt->select('ks.kesakitan_id, 
        ks.kesakitan_bulan,
        ks.kesakitan_tahun,
        ks.kesakitan_BL,
        ks.kesakitan_BP,
        ks.kesakitan_LL,
        ks.kesakitan_LP,
        (ks.kesakitan_BL + ks.kesakitan_BP + ks.kesakitan_LL + ks.kesakitan_LP) as jumlah,
        pk.puskesmas_nama, 
        pt.penyakit_nama ');
    $this->dt->from('kesakitan ks');
    $this->dt->join('puskesmas pk', 'ks.kesakitan_puskesmas_id = pk.puskesmas_id');
    $this->dt->join('penyakit pt', 'ks.kesakitan_penyakit_id = pt.penyakit_id');
    $this->dt->add_column('nomor', '');
    $this->dt->add_column('action',
        '<a href="javascript:void(0)" class="btn btn-outline-warning" onClick="showModal($1,1)">Ubah</a>
        <a href="javascript:void(0)" class="btn btn-outline-danger" onClick="showModal($1,2)">Hapus</a>'
        , 'kesakitan_id'
    );

    function callback_bulan($bulan)
    {
        return hBulan($bulan);
    }
    $this->dt->edit_column('kesakitan_bulan', '$1', "callback_bulan(kesakitan_bulan)");

    echo $this->dt->generate();
    die();
}

public function jsonCekDatabase()
{
    $id        = $this->input->post('kesakitan_id');
    $kesakitan = null;
    if ($id) {
        $kesakitan = $this->M_Kesakitan->findOrFail($id);
    } else {
        $bulan     = $this->input->post('bulan');
        $tahun     = $this->input->post('tahun');
        $puskesmas = $this->input->post('puskesmas');
        $penyakit  = $this->input->post('penyakit');

        $kesakitan = $this->M_Kesakitan
        ->where('kesakitan_bulan', $bulan)
        ->where('kesakitan_tahun', $tahun)
        ->where('kesakitan_puskesmas_id', $puskesmas)
        ->where('kesakitan_penyakit_id', $penyakit)
        ->first();
    }

    $this->output
    ->set_content_type('application/json', 'utf-8')
    ->set_output(json_encode($kesakitan, JSON_HEX_APOS | JSON_HEX_QUOT))
    ->_display();
    exit;

}
}

/* End of file Kesakitan.php */
/* Location: ./application/controllers/Kesakitan.php */
