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
    

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 5],
    ];

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
            $this->reset(['nama_industri', 'bidang_usaha', 'alamat_industri', 'kontak_industri', 'email_industri', 'website_industri']);
            $this->resetErrorBag();
        }
    }
    
    public function showIndustriDetail($id)
    {
        $industri = Industri::find($id);

        // Bisa disimpan sebagai array agar aman diserialisasi oleh Livewire
        $this->selectedIndustri = [
            'nama' => $industri->nama,
            'bidang_usaha' => $industri->bidang_usaha,
            'alamat' => $industri->alamat,
            'kontak' => $industri->kontak,
            'email' => $industri->email,
            'website' => $industri->website,
        ];

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
        ]);
        
        Industri::create([
            'nama' => $this->nama_industri,
            'bidang_usaha' => $this->bidang_usaha,
            'alamat' => $this->alamat_industri,
            'kontak' => $this->kontak_industri,
            'email' => $this->email_industri,
            'website' => $this->website_industri,
        ]);
        
        // Tutup form dan tampilkan pesan sukses
        $this->showIndustriForm = false;
        session()->flash('message', 'Industri berhasil ditambahkan');
        
        // Reset form fields
        $this->reset(['nama_industri', 'bidang_usaha', 'alamat_industri', 'kontak_industri', 'email_industri', 'website_industri']);
    }

        public function render()
        {


            return view('livewire.dashboard.daftar-industri', [
                'industris' => Industri::where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('bidang_usaha', 'like', '%' . $this->search . '%')
                    ->paginate($this->perPage),
                'gurus' => Guru::all(),
            ]);
        }
}
