<?php

namespace App\Livewire\Dashboard;

use App\Models\Guru as GuruModel;
use Livewire\Component;
use Livewire\WithPagination;


class Guru extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $search = '';
    public $perPage = 10;
    public $showModal = false;
    public $guruId;
    public $nama;
    public $nip;
    public $selectedGuru;
    public $hasPklData = false;
    public $isEditing = false;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function openModal()
    {
        $this->showModal = true;
    }
    
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInputFields();
    }
    
    private function resetInputFields()
    {
        $this->guruId = null;
        $this->nama = '';
        $this->nip = '';
        $this->selectedGuru = null;
    }
    
    public function edit($id)
    {
        $guru = GuruModel::findOrFail($id);
        $this->guruId = $id;
        $this->nama = $guru->nama;
        $this->nip = $guru->nip;
        $this->selectedGuru = $guru;
        $this->showModal = true;
    }
        
    public function render()
    {
        return view('livewire.dashboard.guru', [
            'gurus' => GuruModel::where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('nip', 'like', '%' . $this->search . '%')
                ->orderBy('nama', 'asc')
                ->paginate($this->perPage)
        ]);
    }
}
