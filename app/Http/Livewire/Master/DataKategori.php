<?php

namespace App\Http\Livewire\Master;

use App\Models\DataKategori as ModelsDataKategori;
use Livewire\Component;


class DataKategori extends Component
{
    
    public $data_kategori_id;
    public $data_kategori_nama;
    
   

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.master.data-kategori', [
            'items' => ModelsDataKategori::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        
        $data = ['data_kategori_nama'  => $this->data_kategori_nama];

        ModelsDataKategori::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = ['data_kategori_nama'  => $this->data_kategori_nama];
        $row = ModelsDataKategori::find($this->data_kategori_id);

        

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsDataKategori::find($this->data_kategori_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'data_kategori_nama'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($data_kategori_id)
    {
        $data_kategori = ModelsDataKategori::find($data_kategori_id);
        $this->data_kategori_id = $data_kategori->id;
        $this->data_kategori_nama = $data_kategori->data_kategori_nama;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($data_kategori_id)
    {
        $data_kategori = ModelsDataKategori::find($data_kategori_id);
        $this->data_kategori_id = $data_kategori->id;
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
        $this->data_kategori_id = null;
        $this->data_kategori_nama = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
