<head>
    <title>Surat Masuk - {{ $surat->nama_kegiatan }}</title>
    <link rel="stylesheet" href="{{ asset('css/surat.css') }}">
</head>
<div >
    <!-- Header -->
    <div class="flex items-center border-b-4 border-black pb-4 ">
        <img src="{{ asset('storage/img/logo_smg.png') }}" class="w-16 h-auto"/>
        <div class="text-center flex-1">
            <h1 >DINAS ARSIP DAN PERPUSTAKAAN KOTA SEMARANG</h1>
            <h1 >PEMERINTAH KOTA SEMARANG</h1>
            <p class="text-sm">Jl. Prof. Sudarto No.116, Sumurboto, Kec. Banyumanik, Kota Semarang</p>
            <p class="text-sm">Telepon: 024 7466215 | Email: dinas_arpus@semarangkota.go.id</p>
        </div>
    </div>
    <hr >

    <div class="pt-4 text-right">
        <p>Semarang, {{ \Carbon\Carbon::parse($surat->jamkerja?->created_at)->isoFormat('D MMMM YYYY') }}</p>
    </div>

    <!-- Informasi Surat -->
    <div class="mt-6 space-y-1">
        <div class="flex">
            <span class="w-32">Nomor</span> 
            <span>: {{ $surat->nomor_surat }}</span>
        </div>
        <div class="flex">
            <span class="w-32">Lampiran</span> 
            <span>: -</span>
        </div>
        <div class="flex">
            <span class="w-32">Perihal</span> 
            <span>: Permohonan Pelaksanaan Perpustakaan Keliling</span>
        </div>
        <div class="flex">
            <span class="w-32">Kepada Yth</span> 
            <span>: Kepala Dinas Arsip dan Perpustakaan Kota Semarang</span>
        </div>
    </div>

    <!-- pembuka Surat -->
    <div class="mt-6">
        <p class="text-justify indent-8">
            Dengan hormat,  
        Sehubungan dengan program perpustakaan keliling yang bertujuan untuk meningkatkan minat baca masyarakat, 
        kami mengajukan permohonan untuk menyelenggarakan kegiatan perpustakaan keliling sebagai berikut:
        </p>
    </div>

    <!-- Detail Kegiatan -->
    <div class="mt-6 space-y-2">
        <div class="flex">
            <span class="w-32">Tanggal</span>  
            <span>: {{ $surat->jamkerja?->tgl }}</span>
        </div>
        <div class="flex">
            <span class="w-32">Jam Mulai</span>  
            <span>: {{ $surat->jamkerja?->jam_mulai }}</span>
        </div>
        <div class="flex">
            <span class="w-32">Jam Akhir</span>  
            <span>: {{ $surat->jamkerja?->jam_akhir }}</span>
        </div>
        <div class="flex">
            <span class="w-32">Nama Kegiatan</span>  
            <span>: {{ $surat->nama_kegiatan }}</span>
        </div>
        <div class="flex">
            <span class="w-32">Lokasi</span>  
            <span>: {{ $surat->lokasi?->nama_lokasi }}</span>
        </div>
        <div class="flex">
            <span class="w-32">Alamat</span>  
            <span>: {{ $surat->lokasi?->alamat }}</span>
        </div>
        <div class="flex">
            <span class="w-32">Narahubung</span>  
            <span>: {{ $surat->narahubung }}</span>
        </div>
    </div>
    
    <!-- Penutup Surat -->
    <div class="mt-6">
        <p class="text-justify indent-8">
            Demikian permohonan ini kami sampaikan. Besar harapan kami agar permohonan ini dapat disetujui.  
            Atas perhatian dan kerja samanya, kami ucapkan terima kasih.
        </p>
    </div>

    <div class="mt-4 flex justify-between items-end">
        <!-- QR Code (kiri) -->
        <div class="text-left">
            <div class="flex">
                {{ QrCode::size(130)->generate('http://127.0.0.1:8000/admin/surats/'.$surat->id.'/view-surat') }}
            </div>
            <p >Pindai QR untuk cek keaslian surat</p>
        </div>
        
        <!-- Tanda Tangan (kanan) -->
        <div class="text-left">
            <p>{{ $surat->jabatan_PJ }}</p>
            <!-- Gambar Tanda Tangan -->
            <div class="mb-2">
                <img src="{{ asset('storage/'.$surat->ttd_PJ) }}" class="w-auto h-32 object-contain" />
            </div>
            <!-- Nama & Jabatan PJ -->
            <p>{{ $surat->nama_PJ }}</p>
        </div>
    </div>    
</div>