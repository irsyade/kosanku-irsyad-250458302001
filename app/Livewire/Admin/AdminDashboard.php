<?php

namespace App\Livewire\Admin;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use Livewire\Component;
use App\Models\Favorite;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

#[Layout('layouts.admin')]
class AdminDashboard extends Component
{
    // --- Public Properties untuk Statistik (Nilai Tunggal/Scalar) ---
    public $roomsCount; 
    public $bookingsCount; 
    public $paymentsCount;
    public $favoritesCount;

    // --- Public Properties untuk Chart (Array Bulanan - 12 Elemen) ---
    public $chartLabels = [];
    public $totalRooms = [];       
    public $totalBookings = [];    
    public $totalPayments = [];    
    public $totalFavorites = [];   

    public function mount()
    {
        $this->loadStats();
        $this->loadChart();
    }

    public function loadStats()
    {
        // Pemuatan data statistik (Count)
        $this->roomsCount     = Room::count();
        $this->bookingsCount  = Booking::count();
        $this->paymentsCount  = Payment::count();
        $this->favoritesCount = Favorite::count();
    }

    // Fungsi utama untuk mengambil data bulanan
    private function getMonthlyData($model, $year)
    {
        return $model::select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
    }

    public function loadChart()
    {
        $year = Carbon::now()->year;
        
        $namaBulan = [
            1=>"Jan",2=>"Feb",3=>"Mar",4=>"Apr",5=>"Mei",6=>"Jun",
            7=>"Jul",8=>"Agu",9=>"Sep",10=>"Okt",11=>"Nov",12=>"Des"
        ];

        $this->chartLabels = array_values($namaBulan);
        
        // 1. Ambil data count per bulan dari Database
        $monthlyRooms = $this->getMonthlyData(Room::class, $year);
        $monthlyBookings = $this->getMonthlyData(Booking::class, $year);
        $monthlyPayments = $this->getMonthlyData(Payment::class, $year);
        $monthlyFavorites = $this->getMonthlyData(Favorite::class, $year);

        // 2. Isi array 12 bulan. Jika bulan tidak ada data, isi dengan 0.
        for ($i = 1; $i <= 12; $i++) {
            // Room Count per bulan
            $this->totalRooms[] = $monthlyRooms[$i] ?? 0;
            
            // Booking Count per bulan
            $this->totalBookings[] = $monthlyBookings[$i] ?? 0;
            
            // Payment Count per bulan
            $this->totalPayments[] = $monthlyPayments[$i] ?? 0;

            // Favorite Count per bulan
            $this->totalFavorites[] = $monthlyFavorites[$i] ?? 0;
        }
    }

    public function render()
    { 
        return view('livewire.admin.dashboard'); 
    }
}