<x-filament-panels::page>
<head>
    
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
    
    <!-- Informasi Surat -->
    <div class="mt-6 space-y-1">
        <div class="flex">
            <span class="w-40">Nama Pemohon</span> 
            <span>: {{ $reimburse->users->name }}</span>
        </div>
        <div class="flex">
            <span class="w-40">Jenis Reimburse</span> 
            <span>: {{ $reimburse->jenis_reimburse }}</span>
        </div>
        <div class="flex">
            <span class="w-40">Tanggal pengajuan</span> 
            <span>: {{ $reimburse->tgl_pengajuan }}</span>
        </div>
        <div class="flex">
            <span class="w-40">Tanggal disetujui</span> 
            <span>: {{ $reimburse->tgl_diterima }}</span>
        </div>
    </div>

    <!-- pembuka Surat -->
    <div class="mt-6">
        <p class="text-justify indent-8">
            Dengan hormat, Sehubungan dengan program perpustakaan keliling, kami mengajukan permohonan reimburse atas biaya yang telah dikeluarkan dalam rangka penyelenggaraan kegiatan perpustakaan keliling. Adapun rincian pengeluaran yang kami ajukan untuk reimburse adalah sebagai berikut:
        </p>
    </div>

    <!-- tabel souvenir -->
    @if ($reimburse->souvenir->isNotEmpty())
    <div class="max-w-6xl mx-auto ">
        <h2 class=" font-bold mb-4">Souvenirs</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">No</th>
                    <th class="border border-gray-300 px-4 py-2">Nama</th>
                    <th class="border border-gray-300 px-4 py-2">Jenis</th>
                    <th class="border border-gray-300 px-4 py-2">Merk</th>
                    <th class="border border-gray-300 px-4 py-2">Stok</th>
                    <th class="border border-gray-300 px-4 py-2">Harga</th>
                    <th class="border border-gray-300 px-4 py-2">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1;?>
                @foreach($reimburse->souvenir as $thing)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{$no++}}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $thing->nama }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $thing->jenis }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $thing->merk }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $thing->stok }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $thing->harga }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $thing->total_harga }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- tabel BBM -->
    @if ($reimburse->bbm)
    <div class="max-w-6xl mx-auto ">
        <h2 class=" font-bold mb-4">BBM</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Tanggal Pengisian</th>
                    <th class="border border-gray-300 px-4 py-2">Jumlah Liter</th>
                    <th class="border border-gray-300 px-4 py-2">Harga</th>
                    <th class="border border-gray-300 px-4 py-2">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $reimburse->bbm?->tgl_pengisian }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $reimburse->bbm?->jml_liter }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $reimburse->bbm?->harga }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $reimburse->bbm?->total_harga }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    <!-- Penutup Surat -->
    <div class="mt-6">
        <p class="text-justify indent-8">
            Demikian permohonan reimburse ini kami sampaikan. Kami berharap permohonan ini dapat diproses dan disetujui sesuai dengan ketentuan yang berlaku. Atas perhatian dan kerja samanya, kami ucapkan terima kasih.
        </p>
    </div>

    {{-- <!-- QR Code -->
    <div class="mt-6 text-center">
        <p class="font-semibold">Pindai QR untuk validasi:</p>
        <div class="flex justify-center">
            
        </div>
    </div> --}}
</div>
</x-filament-panels::page>
