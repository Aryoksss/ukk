<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Pkl;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Industri;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PklSummary extends Component
{
    public $pkl;
    public $siswa;
    public $industri;
    public $guru;
    public $durasi;
    public $statusPkl = 'Belum Mulai';
    public $progressPercentage = 0;
    public $hasPklData = false;

    public function mount()
    {
        $user = Auth::user();

        // Temukan siswa berdasarkan email user
        $this->siswa = Siswa::where('email', $user->email)->first();

        if ($this->siswa) {
            // Cari PKL berdasarkan siswa
            $this->pkl = Pkl::where('siswa_id', $this->siswa->id)->latest()->first();
            $this->hasPklData = $this->pkl != null;
        }

        $this->refreshData();
    }
    
    // Refresh data untuk memastikan selalu up-to-date
    public function refreshData()
    {
        if ($this->hasPklData) {
            $this->industri = $this->pkl->industri;
            $this->guru = $this->pkl->guru;

            // Hitung durasi PKL
            if ($this->pkl->mulai && $this->pkl->selesai) {
                $start = Carbon::parse($this->pkl->mulai);
                $end = Carbon::parse($this->pkl->selesai);
                $this->durasi = $start->diffInDays($end) + 1; // +1 untuk menghitung hari terakhir
                
                // Cek status PKL
                $today = Carbon::today();
                
                if ($today->lt($start)) {
                    $this->statusPkl = 'Belum Mulai';
                    $this->progressPercentage = 0;
                } elseif ($today->gte($end)) {
                    $this->statusPkl = 'Selesai';
                    $this->progressPercentage = 100;
                } else {
                    $this->statusPkl = 'Sedang Berlangsung';
                    $totalDays = $start->diffInDays($end) + 1;
                    $daysPassed = $start->diffInDays($today) + 1;
                    $this->progressPercentage = min(round(($daysPassed / $totalDays) * 100), 100);
                }
            }
        }
    }

    public function render()
    {
        $pkls = Pkl::all();

        return view('livewire.dashboard.pkl-summary', [
            'pkls' => $pkls,
        ]);
    }
}
