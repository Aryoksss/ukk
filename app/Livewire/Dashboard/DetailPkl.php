<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\Industri;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;

class DetailPkl extends Component
{
    public $hasPklData = false;
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $industri_id;
    public $guru_id;
    public $daftarIndustri;
    public $daftarGuru;

    public function mount()
    {
        // Ambil siswa berdasarkan user yang sedang login
        $siswa = Siswa::where('email', Auth::user()->email)->first();

        if ($siswa) {
            $this->hasPklData = $siswa->status_lapor_pkl;
        }

        $this->daftarIndustri = Industri::all();
        $this->daftarGuru = Guru::all();
    }

    public function updatePkl()
    {
        // Validasi dan simpan data PKL
        $this->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'industri_id' => 'required|exists:industris,id',
            'guru_id' => 'required|exists:gurus,id',
        ]);

        $siswa = Siswa::where('email', Auth::user()->email)->first();

        $siswa->pkl()->create([
            'guru_id' => $this->guru_id,
            'industri_id' => $this->industri_id,
            'mulai' => $this->tanggal_mulai,
            'selesai' => $this->tanggal_selesai,
        ]);

        // Update status lapor
        $siswa->status_lapor_pkl = true;
        $siswa->save();

        session()->flash('message', 'Data PKL berhasil disimpan.');
        $this->hasPklData = true;
        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.dashboard.detail-pkl');
    }
}

