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

    <!-- Informasi Orang -->
    <div class="mt-6 space-y-1">
        <div class="flex">
            <span class="w-32">Nama</span> 
            
        </div>
    </div>


    <!-- pembuka Surat -->
    <div class="mt-6">
        <p class="text-justify indent-8">
            Dengan hormat,

Laporan ini disusun sebagai bentuk pertanggungjawaban atas pelaksanaan kegiatan {{ $surat->nama_kegiatan }} yang telah dilaksanakan pada {{ \Carbon\Carbon::parse($surat->jamkerja?->tgl)->isoFormat('D MMMM YYYY') }}. Laporan ini bertujuan untuk memberikan gambaran secara rinci mengenai kegiatan yang dilakukan, termasuk tujuan, pelaksanaan, serta hasil yang diperoleh. Kami berharap laporan ini dapat menjadi bahan evaluasi dan acuan untuk perbaikan serta pengembangan kegiatan serupa di masa mendatang.
        </p>
    </div>

    <!--  Surat -->
    <div class="mt-6">
        <p class="text-justify indent-8">
            Kegiatan yang telah dilaksanakan berdasarkan surat berikut:
        </p>
    </div>

    <!-- Detail Surat -->
    <div class="mt-6 space-y-2">
        <div class="flex">
            <span class="w-32">Nomor Surat</span> 
            <span>: {{ $surat->nomor_surat }}</span>
        </div>
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
            <span class="w-32">Alamat</span>  
            <span>: {{ $surat->lokasi?->nama_lokasi }}</span>
        </div>
        <div class="flex">
            <span class="w-32">Nama Kegiatan</span>  
            <span>: {{ $surat->nama_kegiatan }}</span>
        </div>
        <div class="flex">
            <span class="w-32">Narahubung</span>  
            <span>: {{ $surat->narahubung }}</span>
        </div>
        <div class="flex">
            <span class="w-32">Nama PJ</span>  
            <span>: {{ $surat->nama_PJ }}</span>
        </div>
        <div class="flex">
            <span class="w-32">Jabatan PJ</span>  
            <span>: {{ $surat->jabatan_PJ }}</span>
        </div>
        <div class="flex">
            <span class="w-32">Waktu Datang</span> 
            <span>: {{ \Carbon\Carbon::parse($surat->waktu_mulai)->format('H:i:s') }}</span>
        </div>
        <div class="flex">
            <span class="w-32">Waktu Pulang</span>  
            <span>: {{ \Carbon\Carbon::parse($surat->waktu_selesai)->format('H:i:s') }}</span>
        </div>
    </div>
   
    

    <!-- Penutup Surat -->
    <div class="mt-6">
        <p class="text-justify indent-8">
            Demikian laporan ini kami susun dengan sebenar-benarnya sebagai bentuk pertanggungjawaban atas kegiatan yang telah dilaksanakan. Kami menyadari bahwa masih terdapat kekurangan dalam pelaksanaan maupun penyusunan laporan ini. Oleh karena itu, kami terbuka untuk saran dan masukan yang dapat menjadi bahan perbaikan di masa yang akan datang.
            Atas perhatian dan dukungan yang telah diberikan, kami mengucapkan terima kasih. Semoga laporan ini dapat memberikan manfaat bagi semua pihak yang berkepentingan.
        </p>
    </div>

    {{-- <!-- QR Code -->
    <div class="mt-6 text-center">
        <p class="font-semibold">Pindai QR untuk validasi:</p>
        <div class="flex justify-center">
            {{ QrCode::size(200)->generate('http://127.0.0.1:8000/admin/surats/'.$surat->id.'/view-surat') }}
        </div>
    </div> --}}
</div>