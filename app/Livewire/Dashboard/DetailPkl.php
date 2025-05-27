<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Pkl;
use App\Models\Siswa;
use App\Models\Industri;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Livewire\Attributes\Validate;

class DetailPkl extends Component
{
    public $activeTab = 'detail-pkl';
    public $pkl;
    public $siswa;
    public $industri;
    public $guru_id;
    public $guru;
    public $durasi;
    public $hasPklData;
    
    // Form untuk edit PKL
    public $isEditing = false;
    public $showIndustriForm = false;
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $industri_id;
    public $nama_industri;
    public $bidang_usaha;
    public $alamat_industri;
    public $kontak_industri;
    public $email_industri;
    public $website_industri;
    
    public $daftarIndustri = [];
    public $daftarGuru = [];

    protected $queryString = ['activeTab'];

    public function mount()
    {
        Carbon::setLocale('id');

        $user = Auth::user();
        $this->siswa = $user->siswa;

        if ($this->siswa) {
            $this->hasPklData = $this->siswa->pkl()->exists();

            // ambil data PKL dan industri
            $this->pkl = $this->siswa->pkl;
            $this->hasPklData = $this->pkl !== null;

            if ($this->hasPklData) {
                $this->industri = $this->pkl->industri;
                $this->guru = $this->industri ? $this->industri->guru : null;

                $this->tanggal_mulai = $this->pkl->mulai ? Carbon::parse($this->pkl->mulai)->format('Y-m-d') : null;
                $this->tanggal_selesai = $this->pkl->selesai ? Carbon::parse($this->pkl->selesai)->format('Y-m-d') : null;
                $this->industri_id = $this->industri ? $this->industri->id : null;

                if ($this->pkl->mulai && $this->pkl->selesai) {
                    $start = Carbon::parse($this->pkl->mulai);
                    $end = Carbon::parse($this->pkl->selesai);
                    $this->durasi = $start->diffInDays($end) + 1;
                }
            } else {
                $now = Carbon::now();
                $this->tanggal_mulai = $now->format('Y-m-d');
                $this->tanggal_selesai = $now->copy()->addMonths(3)->format('Y-m-d');
            }
        } else {
            // Jika siswa tidak ditemukan, bisa log error atau set default
            $this->hasPklData = false;
            session()->flash('error', 'Data siswa tidak ditemukan. Silakan hubungi administrator.');
        }

        $this->loadIndustri();
        $this->loadGuru();
    }
    
    public function loadIndustri()
    {
        $this->daftarIndustri = Industri::orderBy('nama')->get();
    }

    public function loadGuru()
    {
        $this->daftarGuru = \App\Models\Guru::orderBy('nama')->get();
    }


    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
    
    public function startEdit()
    {
        // Jika sudah ada data PKL, tidak boleh diedit lagi
        if ($this->hasPklData) {
            session()->flash('error', 'Data PKL yang sudah ada tidak dapat diubah. Silakan hubungi administrator jika ada kesalahan.');
            return;
        }
        
        $this->isEditing = true;
        
        // Load daftar industri
        $this->loadIndustri();
    }
    
    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->showIndustriForm = false;
        $this->resetErrorBag();
        
        // Reset form values
        if ($this->hasPklData) {
            $this->tanggal_mulai = $this->pkl->mulai ? Carbon::parse($this->pkl->mulai)->format('Y-m-d') : null;
            $this->tanggal_selesai = $this->pkl->selesai ? Carbon::parse($this->pkl->selesai)->format('Y-m-d') : null;
            $this->industri_id = $this->industri ? $this->industri->id : null;
        }
    }
    
    public function toggleIndustriForm()
    {
        // Jika sudah ada data PKL, tidak boleh menambahkan industri baru
        if ($this->hasPklData) {
            session()->flash('error', 'Data PKL yang sudah ada tidak dapat diubah.');
            return;
        }
        
        $this->showIndustriForm = !$this->showIndustriForm;
        
        if ($this->showIndustriForm) {
            // Reset form industri
            $this->reset(['nama_industri', 'bidang_usaha', 'alamat_industri', 'kontak_industri', 'email_industri', 'website_industri']);
        }
    }
    
    public function createIndustri()
    {
        // Jika sudah ada data PKL, tidak boleh menambahkan industri baru
        if ($this->hasPklData) {
            session()->flash('error', 'Data PKL yang sudah ada tidak dapat diubah.');
            return;
        }
        
        $this->validate([
            'nama_industri' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'alamat_industri' => 'nullable|string|max:255',
            'kontak_industri' => 'nullable|string|max:255',
            'email_industri' => 'nullable|email|max:255',
            'website_industri' => 'nullable|string|max:255',
        ]);
        
        $industri = Industri::create([
            'nama' => $this->nama_industri,
            'bidang_usaha' => $this->bidang_usaha,
            'alamat' => $this->alamat_industri,
            'kontak' => $this->kontak_industri,
            'email' => $this->email_industri,
            'website' => $this->website_industri,
        ]);
        
        // Refresh daftar industri
        $this->loadIndustri();
        
        // Set industri yang baru dibuat sebagai pilihan
        $this->industri_id = $industri->id;
        
        // Tutup form industri
        $this->showIndustriForm = false;
        
        // Tampilkan pesan sukses
        session()->flash('message', 'Industri berhasil ditambahkan.');
    }
    
    public function updatePkl()
    {
        if (!$this->siswa) {
            session()->flash('error', 'Data siswa tidak ditemukan. Silakan hubungi administrator.');
            return;
        }

        $this->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'industri_id' => 'required|exists:industris,id',
            'guru_id' => 'required|exists:gurus,id',
        ]);

        Pkl::create([
            'siswa_id' => $this->siswa->id,
            'mulai' => $this->tanggal_mulai,
            'selesai' => $this->tanggal_selesai,
            'industri_id' => $this->industri_id,
            'guru_id' => $this->guru_id,
        ]);

        $this->isEditing = false;
        $this->hasPklData = true;
        $this->mount(); // reload semua data
        session()->flash('message', 'Data PKL berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.dashboard.detail-pkl');
    }
}
