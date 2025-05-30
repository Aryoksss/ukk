<?php

namespace App\Livewire\Dashboard;

use App\Models\Siswa as SiswaModel;
use Livewire\Component;
use Livewire\WithPagination;

class Siswa extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedSiswa = null;
    public $showModal = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function viewDetails($siswaId)
    {
        $this->selectedSiswa = SiswaModel::with('pkl')->find($siswaId);
        if (!$this->selectedSiswa) {
            return;
        }
        $this->showModal = true;
    }
    
    public function showDetailModal($siswaId)
    {
        $this->viewDetails($siswaId);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedSiswa = null;
    }

    public function render()
    {
        $siswa = SiswaModel::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('nis', 'like', '%' . $this->search . '%')
            ->paginate(7);

        return view('livewire.dashboard.siswa', compact('siswa'));
    }
}
