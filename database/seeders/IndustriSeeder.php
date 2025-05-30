<?php

namespace Database\Seeders;

use App\Models\Industri;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IndustriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industris = Industri::insert([
            [
                'nama' => 'PT Aksa Digital Group', 
                'bidang_usaha' => 'IT Service and IT Consulting (Information Technology Company)',
                'alamat' => 'Jl. Wongso Permono No.26, Klidon, Sukoharjo, Kec. Ngaglik, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55581',
                'kontak' => '08982909000',
                'email' => 'aksa@gmail.com',
                'website' => 'aksa.id',
            ],
            [
                'nama' => 'PT. Gamatechno Indonesia', 
                'bidang_usaha' => 'Penyedia layanan, solusi, dan produk inovasi teknologi informasi serta holding company yang melahirkan startup di bidang teknologi informasi.',
                'alamat' => 'Jl. Purwomartani, Karangmojo, Purwomartani, Kec. Kalasan, Kabupaten Sleman, Daerah Istimewa Yogyakarta',
                'kontak' => '0274-5044044',
                'email' => 'info@gamatechno.com',
                'website' => 'gamatechno.com',
            ],
            [
                'nama' => 'CV. Karya Hidup Sentosa ', 
                'bidang_usaha' => 'Alat pertanian',
                'alamat' => 'JJl. Magelang KM.8,8, Jongke Tengah, Sendangadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55285',
                'kontak' => '0274-512095',
                'email' => 'quick@gmail.com',
                'website' => 'quick.co.id',
            ],
            [
                'nama' => 'PT CyberKarta Tugu Teknologi',
                'bidang_usaha' => 'Cyber Security, IT Consulting, Penetration Testing, Digital Forensics, IT Audit, dan IT Training',
                'alamat' => 'Jl. Pogung Kidul No.17, Pogung Kidul, Sinduadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55284',
                'kontak' => '0851-6183-5865',
                'email' => 'business@cyberkarta.com',
                'website' => 'cyberkarta.com',
            ],
            [
                'nama' => 'PT Telekomunikasi Indonesia Tbk (Telkom Indonesia)',
                'bidang_usaha' => 'Telekomunikasi, Teknologi Informasi dan Komunikasi (TIK), Jaringan',
                'alamat' => 'Jl. Japati No.1, Citarum, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40115',
                'kontak' => '188 (Call Center)',
                'email' => 'customercare@telkom.co.id',
                'website' => 'telkom.co.id'
            ],
            [
                'nama' => 'PT Bank Central Asia Tbk (BCA)',
                'bidang_usaha' => 'Perbankan dan Jasa Keuangan',
                'alamat' => 'Menara BCA, Grand Indonesia, Jl. M.H. Thamrin No. 1, Jakarta Pusat 10310',
                'kontak' => '1500888 (Halo BCA)',
                'email' => 'halobca@bca.co.id',
                'website' => 'bca.co.id'
            ],
            [
                'nama' => 'PT Indofood Sukses Makmur Tbk',
                'bidang_usaha' => 'Produksi Makanan dan Minuman',
                'alamat' => 'Sudirman Plaza, Indofood Tower, Lantai 27, Jl. Jend. Sudirman Kav. 76-78, Jakarta 12910',
                'kontak' => '(021) 57958822',
                'email' => 'indofood@indofood.co.id',
                'website' => 'indofood.com'
            ],
            [
                'nama' => 'PT Bio Farma (Persero)',
                'bidang_usaha' => 'Farmasi, Vaksin, dan Produk Biologi',
                'alamat' => 'Jl. Pasteur No.28, Pasteur, Kec. Sukajadi, Kota Bandung, Jawa Barat 40161',
                'kontak' => '(022) 2033755',
                'email' => 'mail@biofarma.co.id',
                'website' => 'biofarma.co.id'
            ],
            [
                'nama' => 'PT GoTo Gojek Tokopedia Tbk',
                'bidang_usaha' => 'Teknologi, Layanan Transportasi Online, E-commerce, Jasa Keuangan Digital',
                'alamat' => 'Pasaraya Blok M Gedung B, Lt. 6-7, Jl. Iskandarsyah II No.7, Melawai, Kebayoran Baru, Jakarta Selatan 12160',
                'kontak' => 'Bervariasi tergantung layanan (Gojek/Tokopedia)',
                'email' => 'customerservice@gojek.com / care@tokopedia.com',
                'website' => 'hgotocompany.com'
            ]
            ]);
    }
}