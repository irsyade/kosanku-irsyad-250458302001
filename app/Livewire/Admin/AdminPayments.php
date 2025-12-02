<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class AdminPayments extends Component
{
    use WithPagination;

    public $perPage = 10;


public $selectedImage = null;
public $showImageModal = false;

public function lihatBukti($id)
{
    $payment = Payment::find($id);

    if ($payment) {
        $this->selectedImage = $payment->proof_image;
        $this->showImageModal = true;
    }
}

public function verify($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->update(['status' => 'lunas']);

        // KUNCI: Update status Booking menjadi 'lunas'
        if ($payment->booking) {
            $payment->booking->update(['status' => 'lunas']);
        }
        
        // PENTING: Kirim sinyal ke Admin Rooms untuk refresh kapasitas
        $this->dispatch('roomDataChanged');

        session()->flash('success', 'Pembayaran berhasil diverifikasi! Kapasitas kamar diperbarui.');
    }

    public function reject($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->update(['status' => 'gagal']);

        if ($payment->booking) {
            $payment->booking->update(['status' => 'gagal']);
        } 
        
        // Kirim sinyal untuk refresh (opsional, tapi bagus untuk konsistensi view)
        $this->dispatch('roomDataChanged'); 

        session()->flash('success', 'Pembayaran berhasil ditolak!');
    }
    
    public function print($paymentId)
    {
        $this->redirectRoute('admin.payments.print', $paymentId );
        
        
    }

    public function render()
    {
        $payments = Payment::with(['user', 'room'])
                          ->orderBy('created_at', 'desc')
                          ->paginate($this->perPage);

        return view('livewire.admin.admin-payments', compact('payments'));
    }
}
