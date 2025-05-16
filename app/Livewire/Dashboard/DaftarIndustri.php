<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Industri;
use App\Models\Guru;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class DaftarIndustri extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $showIndustriForm = false;
    public $showDetail = false;
    public $selectedIndustri;
    public $daftarGuru = [];
    
    // Form fields untuk industri baru
    #[Validate('required|string|max:255')]
    public $nama_industri = '';
    
    #[Validate('required|string|max:255')]
    public $bidang_usaha = '';
    
    #[Validate('nullable|string|max:255')]
    public $alamat_industri = '';
    
    #[Validate('nullable|string|max:255')]
    public $kontak_industri = '';
    
    #[Validate('nullable|email|max:255')]
    public $email_industri = '';
    
    #[Validate('nullable|string|max:255')]
    public $website_industri = '';
    
    #[Validate('nullable|exists:gurus,id')]
    public $guru_id;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 5],
    ];
    
    public function mount()
    {
        $this->loadGuru();
    }
    
    public function loadGuru()
    {
        $this->daftarGuru = Guru::orderBy('nama')->get();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function searchIndustri()
    {
        $this->resetPage();
    }
    
    public function toggleIndustriForm()
    {
        $this->showIndustriForm = !$this->showIndustriForm;
        
        if ($this->showIndustriForm) {
            // Reset form fields
            $this->reset(['nama_industri', 'bidang_usaha', 'alamat_industri', 'kontak_industri', 'email_industri', 'website_industri', 'guru_id']);
            $this->resetErrorBag();
        }
    }
    
    public function showIndustriDetail($id)
    {
        $this->selectedIndustri = Industri::with('guru')->find($id);
        $this->showDetail = true;
    }
    
    public function closeDetail()
    {
        $this->showDetail = false;
        $this->selectedIndustri = null;
    }
    
    public function createIndustri()
    {
        $this->validate([
            'nama_industri' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'alamat_industri' => 'nullable|string|max:255',
            'kontak_industri' => 'nullable|string|max:255',
            'email_industri' => 'nullable|email|max:255',
            'website_industri' => 'nullable|string|max:255',
            'guru_id' => 'nullable|exists:gurus,id',
        ]);
        
        Industri::create([
            'nama' => $this->nama_industri,
            'bidang_usaha' => $this->bidang_usaha,
            'alamat' => $this->alamat_industri,
            'kontak' => $this->kontak_industri,
            'email' => $this->email_industri,
            'website' => $this->website_industri,
            'guru_id' => $this->guru_id,
        ]);
        
        // Tutup form dan tampilkan pesan sukses
        $this->showIndustriForm = false;
        session()->flash('message', 'Industri berhasil ditambahkan');
        
        // Reset form fields
        $this->reset(['nama_industri', 'bidang_usaha', 'alamat_industri', 'kontak_industri', 'email_industri', 'website_industri', 'guru_id']);
    }

    public function render()
    {
        return view('livewire.dashboard.daftar-industri', [
            'industris' => Industri::with('guru')
                ->where(function($query) {
                    $query->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('bidang_usaha', 'like', '%' . $this->search . '%');
                })
                ->paginate($this->perPage)
        ]);
    }
}
