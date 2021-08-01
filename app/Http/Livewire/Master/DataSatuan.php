<?php

namespace App\Http\Livewire\Master;

use App\Models\DataSatuan as ModelsDataSatuan;
use Livewire\Component;


class DataSatuan extends Component
{
    
    public $data_satuan_id;
    public $data_satuan_nama;
    
   

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.master.data-satuan', [
            'items' => ModelsDataSatuan::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        
        $data = ['data_satuan_nama'  => $this->data_satuan_nama];

        ModelsDataSatuan::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = ['data_satuan_nama'  => $this->data_satuan_nama];
        $row = ModelsDataSatuan::find($this->data_satuan_id);

        

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsDataSatuan::find($this->data_satuan_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'data_satuan_nama'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($data_satuan_id)
    {
        $data_satuan = ModelsDataSatuan::find($data_satuan_id);
        $this->data_satuan_id = $data_satuan->id;
        $this->data_satuan_nama = $data_satuan->data_satuan_nama;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($data_satuan_id)
    {
        $data_satuan = ModelsDataSatuan::find($data_satuan_id);
        $this->data_satuan_id = $data_satuan->id;
    }

    public function toggleForm($form)
    {
        $this->form_active = $form;
        $this->emit('loadForm');
    }

    public function showModal()
    {
        $this->emit('showModal');
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->emit('refreshTable');
        $this->data_satuan_id = null;
        $this->data_satuan_nama = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
