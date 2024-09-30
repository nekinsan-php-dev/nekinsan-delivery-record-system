<?php

namespace App\Livewire;

use App\Models\Barcode;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class BarcodeScanner extends Component
{
    use WithPagination;

    public $newBarcode = '';
    public $search = '';
    public $perPage = 10;
    public $showConfirmation = false;
    public $existingBarcode = null;
    public $rtoRemark = '';

    protected $rules = [
        'newBarcode' => 'required|string|max:255',
        'rtoRemark' => 'nullable|string|max:1000',
    ];

    public function save()
    {
        $this->validate();

        
        $existingBarcode = Barcode::with('order')->where('barcode', $this->newBarcode)->first();


        if ($existingBarcode) {
            $this->handleExistingBarcode($existingBarcode);
        } else {
            $this->createNewBarcode();
        }

        $this->newBarcode = '';
    }

    private function handleExistingBarcode(Barcode $barcode)
    {
        $scannedDate = Carbon::parse($barcode->scanned_at);

        if ($scannedDate->isSameDay(Carbon::now())) {
            $this->dispatch('show-error', 'Record already exists and was added today. No update needed. Please come back in 2 or more days to update this record.');
        } else {
            $this->showConfirmation = true;
            $this->existingBarcode = $barcode;
        }
    }

    private function createNewBarcode()
    {
        Barcode::create([
            'barcode' => $this->newBarcode,
            'scanned_at' => Carbon::now(),
            'status' => 'dispatched'
        ]);
        $this->dispatch('show-success', 'Barcode saved successfully.');
    }

    public function render()
    {
        $query = Barcode::query()->orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $barcodeArray = array_filter(array_map('trim', explode(',', $this->search)));
            $query->when(count($barcodeArray) == 1, function ($q) use ($barcodeArray) {
                return $q->where('barcode', 'like', '%' . $barcodeArray[0] . '%');
            })->when(count($barcodeArray) > 1, function ($q) use ($barcodeArray) {
                return $q->whereIn('barcode', $barcodeArray);
            });
        }

        return view('livewire.barcode-scanner', [
            'barcodes' => $query->paginate($this->perPage),
        ]);
    }

    public function confirmUpdate()
    {
        if (!$this->existingBarcode) {
            $this->dispatch('show-error', 'No barcode selected for update.');
            return;
        }

        $this->validate([
            'rtoRemark' => 'required|string|max:1000',
        ]);

        $daysSinceLastScan = Carbon::parse($this->existingBarcode->scanned_at)->diffInDays(Carbon::now());

        if ($daysSinceLastScan == 0) {
            $this->dispatch('show-error', 'Cannot update. Barcode was scanned today.');
        } else {
            $updateData = [
                'status' => 'rto',
                'scanned_at' => Carbon::now(),
                'rto_remark' => $this->rtoRemark,
            ];

            $this->existingBarcode->update($updateData);

            if ($this->existingBarcode->order) 
            {
                unset($updateData['scanned_at']);
                $this->existingBarcode->order->update($updateData);
            }

            $this->dispatch('show-success', 'Barcode updated to RTO status successfully.');
        }

        $this->resetConfirmationState();
    }

    public function cancelUpdate()
    {
        $this->resetConfirmationState();
    }

    private function resetConfirmationState()
    {
        $this->showConfirmation = false;
        $this->existingBarcode = null;
        $this->rtoRemark = '';
    }
}