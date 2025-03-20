<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KehadiranResource\Pages;
use App\Filament\Resources\KehadiranResource\RelationManagers;
use App\Models\Kehadiran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use App\Models\Penjadwalan;
use App\Models\Surat;
use App\Models\JamKerja;
use App\Models\Lokasi;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Set;
use Filament\Forms\Components\Livewire;
// use App\Livewire\CameraCapture;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Forms\Components\CameraCapture;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Support\Facades\Auth;
use Torgodly\Html2Media\Tables\Actions\Html2MediaAction;

class KehadiranResource extends Resource
{
    protected static ?string $model = Kehadiran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Select::make('id_user')
                //     ->relationship('users', 'name'),
                // Select::make('penjadwalan_id')
                Hidden::make('user_id'),
                Hidden::make('penjadwalan_id')
                    // // ->relationship('penjadwalan', 'id')
                    // ->options(function () {
                    //     $penjadwalan = Penjadwalan::whereHas('surat.jamkerja', function ($query) {
                    //         $query->whereDate('tgl', today());
                    //     })->pluck('id'); // Get matching assignment IDs
                
                    //     return Penjadwalan::whereIn('id', $penjadwalan)
                    //         ->pluck('id', 'id');
                    //         // ->with('surat')->get()->mapWithKeys(fn ($att) => [$att->id => "{$att->id} {$att->nama_kegiatan}"]);


                    // })
                    // ->reactive()
                    // ->afterStateUpdated(function ($state, callable $set, $livewire) {
                    //     // $findpenjadwalan = Penjadwalan::find($state)?->id_surat;
                    //     // $findsurat = Surat::find($findpenjadwalan)?->id_lokasi;
                    //     // $findlokasi = Lokasi::find($findsurat);
                    //     // $findjamkerja = JamKerja::find($findsurat);
                    //     $penjadwalan = Penjadwalan::with(['surat.lokasi', 'surat.jamkerja'])->find($state);
                    //     $lokasi = $penjadwalan->surat->lokasi ?? null;
                    //     $jamkerja = $penjadwalan->surat->jamkerja ?? null;
                    //     if($lokasi){
                    //         $set('jadwal_lokasi_peta', ['lat' => $lokasi->latitude, 'lng' => $lokasi->longtitude]);
                    //         $set('jadwal_lokasi_peta_latitude', $lokasi->latitude);
                    //         $set('jadwal_lokasi_peta_longtitude', $lokasi->longtitude);
                    //         $set('jadwal_lokasi_peta_radius', $lokasi->radius);
                            
                    //         $livewire->dispatch('refreshMap');    
                    //     }
                    //     if($jamkerja){
                    //         $set('jadwal_waktu_mulai', "{$jamkerja->tgl} {$jamkerja->jam_mulai}");
                    //         $set('jadwal_waktu_selesai', "{$jamkerja->tgl} {$jamkerja->jam_akhir}");
                    //     }
                    // })
                    ->afterStateHydrated(function ($state, callable $set, $livewire) {
                        // $findpenjadwalan = Penjadwalan::find($state)?->id_surat;
                        // $findsurat = Surat::find($findpenjadwalan)?->id_lokasi;
                        // $findlokasi = Lokasi::find($findsurat);
                        // $findjamkerja = JamKerja::find($findsurat);
                        $penjadwalan = Penjadwalan::with(['surat.lokasi', 'surat.jamkerja'])->find($state);
                        $lokasi = $penjadwalan->surat->lokasi ?? null;
                        $jamkerja = $penjadwalan->surat->jamkerja ?? null;
                        if($lokasi){
                            $set('jadwal_lokasi_peta', ['lat' => $lokasi->latitude, 'lng' => $lokasi->longtitude]);
                            $set('jadwal_lokasi_peta_latitude', $lokasi->latitude);
                            $set('jadwal_lokasi_peta_longtitude', $lokasi->longtitude);
                            $set('jadwal_lokasi_peta_radius', $lokasi->radius);
                            
                            $livewire->dispatch('refreshMap');    
                        }
                        if($jamkerja){
                            $set('jadwal_waktu_mulai', "{$jamkerja->jam_mulai}");
                            $set('jadwal_waktu_selesai', "{$jamkerja->jam_akhir}");
                        }
                    }),
                    Hidden::make('jadwal_lokasi_peta_latitude')
                    ->dehydrated(false),
                        // ->disabled(),
                    Hidden::make('jadwal_lokasi_peta_longtitude')
                    ->dehydrated(false),
                        // ->disabled(),
                    Hidden::make('jadwal_lokasi_peta_radius')
                    ->dehydrated(false),
                        // ->disabled(),
                    Map::make('jadwal_lokasi_peta')
                        ->disabled()    
                        ->columnSpanFull()
                        ->defaultLocation(latitude: -7.0530, longitude: 110.4092)
                        ->draggable(false)
                        ->showMarker(true)
                        ->showZoomControl(false)
                        ->minZoom(16)
                        ->maxZoom(16)
                        ->rangeSelectField('jadwal_lokasi_peta_radius')
                        ->showFullscreenControl(false),
                        // ->afterStateUpdated(function (Set $set, ?array $state): void {
                        //     $set('jadwal_lokasi_peta_latitude', $state['lat']);
                        //     $set('jadwal_lokasi_peta_longtitude', $state['lng']);
                        // }),
                        // ->afterStateHydrated(function ($state, $record, Set $set): void {
                        //     $latitude = $record->jadwal_lokasi_peta_latitude;
                        //     $longitude = $record->jadwal_lokasi_peta_longtitude;
                        //     }),  
                // TextInput::make('lokasi_peta'),
                Hidden::make('lokasi_peta_latitude'),
                    // ->readonly(),
                    // ->hidden(),                 
                Hidden::make('lokasi_peta_longtitude'),
                    // ->readonly(),
                    // ->hidden(), 
                Map::make('lokasi_peta')
                    ->disabled()
                    ->columnSpanFull()
                    ->defaultLocation(latitude: -7.0530, longitude: 110.4092)
                    ->showMarker(true)
                    ->showMyLocationButton()
                    ->draggable(false)
                    ->liveLocation(true, true)
                    ->showFullscreenControl(false)
                    ->afterStateUpdated(function (Set $set, ?array $state): void {
                        $set('lokasi_peta_latitude', $state['lat']);
                        $set('lokasi_peta_longtitude', $state['lng']);
                    }),
                    DateTimePicker::make('jadwal_waktu_mulai')->disabled(),
                    DateTimePicker::make('jadwal_waktu_selesai')->disabled(),
                    
                    
                    Select::make('Presensi')
                    ->dehydrated(false)
                    ->options([
                        'awal' => 'Awal',
                        'akhir' => 'Akhir',
                    ])
                ->reactive(),
                    Section::make('Awal')->schema([
                        DateTimePicker::make('waktu_mulai')->readonly(),
                        Actions::make([
                            Action::make('Set_Current_DateTime')
                            ->label('Set Now')
                            ->action(function ($record, callable $set, callable $get) {
                                $attendanceLat = $get('jadwal_lokasi_peta_latitude');
                                $attendanceLng = $get('jadwal_lokasi_peta_longtitude');
                                $userLat = $get('lokasi_peta_latitude');
                                $userLng = $get('lokasi_peta_longtitude');
                                $radius = $get('jadwal_lokasi_peta_radius');
                                if (time() < strtotime($get('jadwal_waktu_mulai')) - 3600) {
                                    return; // Button should be disabled already
                                }
                                if (time() >= strtotime($get('jadwal_waktu_mulai'))) {
                                    if(self::haversineDistance(
                                        $attendanceLat, $attendanceLng,
                                        $userLat, $userLng, $radius)){
                                            $set('waktu_mulai', now()->format('Y-m-d H:i:s'));
                                            $set('waktu_mulai_status', "Telat");
                                    } else {
                                        Notification::make()
                                        ->title('You are outside the attendance area!')
                                        ->danger()
                                        ->send();
                                    }
                                } else {
                                    if(self::haversineDistance(
                                        $attendanceLat, $attendanceLng,
                                        $userLat, $userLng, $radius)){
                                            $set('waktu_mulai', now()->format('Y-m-d H:i:s'));
                                            $set('waktu_mulai_status', "Hadir");
                                    }else{
                                        Notification::make()
                                        ->title('You are outside the attendance area!')
                                        ->danger()
                                        ->send();               
                                    }
                                }
                            }) 
                            ->icon('heroicon-o-clock')
                            ->disabled(function (callable $get) {
                                if ($get('jadwal_waktu_mulai')  === null) {
                                    return true; // Disable button if target time is not set
                                }
                                return 
                                time() < strtotime($get('jadwal_waktu_mulai')) - 3600;
                            }),
                        ]),
                        TextInput::make('waktu_mulai_status')->readonly(),
                        Hidden::make('photo_path')
                    ->reactive()->afterStateHydrated(function (Forms\Components\Hidden $component, $state) {
                        // Ensure we have a state in the component
                        $component->state($state);
                    })
                    ->dehydrated(true)
                    ->reactive(),
                    
                    Section::make('Camera Capture')
                    ->schema([
                        CameraCapture::make('camera')
                            ->columnSpan(2)
                            ->extraAttributes([
                                'class' => 'camera-capture-container',
                                'data-input-target' => 'photo_path',
                            ]),
                    ])
                    ->collapsible(),
                    ])->hidden(fn (callable $get) => $get('Presensi') !== 'awal'),
                    Section::make('Akhir')->schema([
                        DateTimePicker::make('waktu_selesai')->readonly(),
                        Actions::make([
                            Action::make('Set_Current_DateTime')
                            ->label('Set Now')
                            ->action(function ($record, callable $set, callable $get) {
                                $attendanceLat = $get('jadwal_lokasi_peta_latitude');
                                $attendanceLng = $get('jadwal_lokasi_peta_longtitude');
                                $userLat = $get('lokasi_peta_latitude');
                                $userLng = $get('lokasi_peta_longtitude');
                                $radius = $get('jadwal_lokasi_peta_radius');
                                if (time() < strtotime($get('jadwal_waktu_selesai'))) {
                                    return; // Button should be disabled already
                                }
                                if (time() > strtotime($get('jadwal_waktu_selesai')) + 3600) {
                                    if(self::haversineDistance(
                                        $attendanceLat, $attendanceLng,
                                        $userLat, $userLng, $radius)){
                                            $set('waktu_selesai', now()->format('Y-m-d H:i:s'));
                                            $set('waktu_selesai_status', "Telat");
                                    } else {
                                        Notification::make()
                                        ->title('You are outside the attendance area!')
                                        ->danger()
                                        ->send();
                                    }
                                } else {
                                    if(self::haversineDistance(
                                        $attendanceLat, $attendanceLng,
                                        $userLat, $userLng, $radius)){
                                            $set('waktu_selesai', now()->format('Y-m-d H:i:s'));
                                            $set('waktu_selesai_status', "Hadir");
                                    }else{
                                        Notification::make()
                                        ->title('You are outside the attendance area!')
                                        ->danger()
                                        ->send();               
                                    }
                                }
                            })
                            ->icon('heroicon-o-clock')
                            ->disabled(function (callable $get) {
                                if ($get('jadwal_waktu_selesai')  === null) {
                                    return true;
                                }
                                return time() < strtotime($get('jadwal_waktu_selesai'));} ),
                            ]),
                            TextInput::make('waktu_selesai_status')->readonly()
                    ])->hidden(fn (callable $get) => $get('Presensi') !== 'akhir'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->recordUrl(null)
            ->columns([
                TextColumn::make('users.name'),
                TextColumn::make('penjadwalan.surat.nama_kegiatan')->label('Nama Kegiatan'),
                TextColumn::make('waktu_mulai')->label('Presensi Awal'),
                TextColumn::make('waktu_selesai')->label('Presensi Akhir'),
                TextColumn::make('waktu_mulai_status')->label('Status Presensi Awal'),
                TextColumn::make('waktu_selesai_status')->label('Status Presensi Akhir'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Presensi')
                // ->hidden(fn($record) => $record->waktu_selesai_status !== null)
                // ->hidden(fn () => !Auth::user()->hasRole('Petugas'))
                ->hidden(fn ($record) => $record->waktu_selesai_status !== null || !Auth::user()->hasRole('Petugas')),
                Html2MediaAction::make('print')
                    ->icon('heroicon-o-printer')
                    ->openUrlInNewTab()
                    ->scale(2)
                    ->print() // Enable print option
                    ->preview() // Enable preview option
                    ->filename('kehadiran') // Custom file name
                    ->savePdf() // Enable save as PDF option
                    ->requiresConfirmation() // Show confirmation modal
                    ->pagebreak('section', ['css', 'legacy'])
                    ->orientation('portrait') // Portrait orientation
                    ->format('a4', 'mm') // A4 format with mm units
                    ->enableLinks() // Enable links in PDF
                    ->margin([10, 10, 10, 10]) // Set custom margins
                    ->content(fn($record) => view('reusable.laporan_kehadiran.laporan_kehadiran', ['surat' => $record->penjadwalan->surat ?? null,])),
                Tables\Actions\Action::make('Izin')
                    ->form([
                        Select::make('Izin_Presensi')
                        ->options([
                            'sakit' => 'Sakit',
                            'ijin' => 'Ijin',
                        ])
                    ])->action(function ($record, $data) {
                        $record->update([
                            'waktu_mulai' => now()->format('Y-m-d H:i:s'),
                            'waktu_selesai' => now()->format('Y-m-d H:i:s'),
                            'waktu_mulai_status' => $data['Izin_Presensi'],
                            'waktu_selesai_status' => $data['Izin_Presensi'],
                        ]);
                    })->hidden(fn($record) => $record->waktu_selesai_status !== null),
                    Tables\Actions\Action::make('Laporan')
                    ->url(fn($record)=>self::getUrl("laporan", ['record' => $record->id]))
                    ->hidden(fn($record) => $record->waktu_selesai_status == null),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function haversineDistance($lat1, $lng1, $lat2, $lng2, $radius)
    {
        $earthRadius = 6371000; // Radius of Earth in meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c; // Distance in meters
        return $distance <= $radius;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKehadirans::route('/'),
            'create' => Pages\CreateKehadiran::route('/create'),
            'edit' => Pages\EditKehadiran::route('/{record}/edit'),
            'laporan' => Pages\LaporanKehadiran::route('/{record}/laporan'),
        ];
    }
}
