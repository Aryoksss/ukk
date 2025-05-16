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
    public $guru;
    public $durasi;
    public $hasSiswaData = false;
    public $hasPklData = false;
    
    // Form untuk edit PKL
    public $isEditing = false;
    public $showIndustriForm = false;
    
    // Form fields untuk PKL
    #[Validate('required|date')]
    public $tanggal_mulai;
    
    #[Validate('required|date|after:tanggal_mulai')]
    public $tanggal_selesai;
    
    #[Validate('required')]
    public $industri_id;
    
    // Form fields untuk industri baru
    #[Validate('required|string|max:255')]
    public $nama_industri;
    
    #[Validate('required|string|max:255')]
    public $bidang_usaha;
    
    #[Validate('nullable|string|max:255')]
    public $alamat_industri;
    
    #[Validate('nullable|string|max:255')]
    public $kontak_industri;
    
    #[Validate('nullable|email|max:255')]
    public $email_industri;
    
    #[Validate('nullable|string|max:255')]
    public $website_industri;
    
    public $daftarIndustri = [];

    protected $queryString = ['activeTab'];

    public function mount()
    {
        // Set locale ke Indonesia
        Carbon::setLocale('id');
        
        // Ambil data siswa dari user yang login
        $user = Auth::user();
        $this->siswa = $user->siswa;
        $this->hasSiswaData = $this->siswa !== null;

        if ($this->hasSiswaData) {
            // Ambil data PKL siswa
            $this->pkl = $this->siswa->pkl;
            $this->hasPklData = $this->pkl !== null;

            if ($this->hasPklData) {
                $this->industri = $this->pkl->industri;
                $this->guru = $this->industri ? $this->industri->guru : null;
                
                // Set form values dengan menggunakan Carbon::parse untuk memastikan format yang benar
                $this->tanggal_mulai = $this->pkl->mulai ? Carbon::parse($this->pkl->mulai)->format('Y-m-d') : null;
                $this->tanggal_selesai = $this->pkl->selesai ? Carbon::parse($this->pkl->selesai)->format('Y-m-d') : null;
                $this->industri_id = $this->industri ? $this->industri->id : null;

                // Hitung durasi PKL
                if ($this->pkl->mulai && $this->pkl->selesai) {
                    $start = Carbon::parse($this->pkl->mulai);
                    $end = Carbon::parse($this->pkl->selesai);
                    $this->durasi = $start->diffInDays($end) + 1; // +1 untuk menghitung hari terakhir
                }
            } else {
                // Set default values for new PKL data - mulai hari ini, selesai 3 bulan dari sekarang
                $now = Carbon::now();
                $this->tanggal_mulai = $now->format('Y-m-d');
                $this->tanggal_selesai = $now->copy()->addMonths(3)->format('Y-m-d');
            }
        }
        
        // Load daftar industri
        $this->loadIndustri();
    }
    
    public function loadIndustri()
    {
        $this->daftarIndustri = Industri::orderBy('nama')->get();
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
        // Validasi hanya jika punya data siswa
        if (!$this->hasSiswaData) {
            return;
        }
        
        // Jika sudah ada data PKL, tidak boleh diedit lagi
        if ($this->hasPklData) {
            session()->flash('error', 'Data PKL yang sudah ada tidak dapat diubah. Silakan hubungi administrator jika ada kesalahan.');
            return;
        }
        
        $this->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'industri_id' => 'required|exists:industris,id',
        ]);
        
        // Pastikan format tanggal valid
        $mulai = Carbon::parse($this->tanggal_mulai);
        $selesai = Carbon::parse($this->tanggal_selesai);
        
        // Buat data PKL baru
        $this->pkl = Pkl::create([
            'siswa_id' => $this->siswa->id,
            'industri_id' => $this->industri_id,
            'mulai' => $mulai->format('Y-m-d'),
            'selesai' => $selesai->format('Y-m-d'),
        ]);
        
        // Update status siswa
        $this->siswa->update([
            'status_lapor_pkl' => 'True', // Sudah Melapor
        ]);
        
        $this->hasPklData = true;
        
        // Refresh data
        $this->pkl->refresh();
        $this->industri = $this->pkl->industri;
        $this->guru = $this->industri->guru;
        
        // Refresh durasi
        $start = Carbon::parse($this->pkl->mulai);
        $end = Carbon::parse($this->pkl->selesai);
        $this->durasi = $start->diffInDays($end) + 1;
        
        // Reset form untuk next time edit
        $this->tanggal_mulai = Carbon::parse($this->pkl->mulai)->format('Y-m-d');
        $this->tanggal_selesai = Carbon::parse($this->pkl->selesai)->format('Y-m-d');
        
        // Tutup form edit
        $this->isEditing = false;
        
        // Tampilkan pesan sukses
        session()->flash('message', 'Data PKL berhasil ditambahkan. Data ini tidak dapat diubah lagi.');
        
        // Emit event untuk komponen lain
        $this->dispatch('pkl-updated');
    }

    public function render()
    {
        return view('livewire.dashboard.detail-pkl');
    }
}
