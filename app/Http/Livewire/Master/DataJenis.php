<?php

namespace App\Http\Livewire\Master;

use App\Models\DataJenis as ModelsDataJenis;
use Livewire\Component;


class DataJenis extends Component
{
    
    public $data_jenis_id;
    public $data_jenis_nama;
    
   

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.master.data-jenis', [
            'items' => ModelsDataJenis::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        
        $data = ['data_jenis_nama'  => $this->data_jenis_nama];

        ModelsDataJenis::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = ['data_jenis_nama'  => $this->data_jenis_nama];
        $row = ModelsDataJenis::find($this->data_jenis_id);

        

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsDataJenis::find($this->data_jenis_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'data_jenis_nama'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($data_jenis_id)
    {
        $data_jenis = ModelsDataJenis::find($data_jenis_id);
        $this->data_jenis_id = $data_jenis->id;
        $this->data_jenis_nama = $data_jenis->data_jenis_nama;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($data_jenis_id)
    {
        $data_jenis = ModelsDataJenis::find($data_jenis_id);
        $this->data_jenis_id = $data_jenis->id;
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
        $this->data_jenis_id = null;
        $this->data_jenis_nama = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
