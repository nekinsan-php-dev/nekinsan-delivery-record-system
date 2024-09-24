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
    public $sortOptions = [10, 25, 50, 100];
    public $showConfirmation = false;
    public $existingBarcode = null;
    public $rtoRemark = '';

    protected $rules = [
        'newBarcode' => 'required',
    ];

    public function save()
    {
        $this->validate();

        $existingBarcode = Barcode::where('barcode', $this->newBarcode)->first();

        if ($existingBarcode) {
            $scannedDate = Carbon::parse($existingBarcode->scanned_at);
            if ($scannedDate->isSameDay(Carbon::now())) {
                session()->flash('error', 'Record already exists and was added today. No update needed. Please come back in 2 or more days to update this record.');
                $this->newBarcode = '';
            } else {
                $this->existingBarcode = $existingBarcode;
            $this->showConfirmation = true;
            }
        }else{
            $this->createNewBarcode();
        }

        $this->newBarcode = '';
    }

    public function createNewBarcode()
    {
        Barcode::create([
            'barcode' => $this->newBarcode,
            'status' => 'dispatched',
            'scanned_at' => Carbon::now(),
        ]);

        session()->flash('success', 'Barcode saved successfully.');
        $this->newBarcode = '';
    }

    public function confirmUpdate()
    {
        if ($this->existingBarcode) {
            $daysSinceLastScan = Carbon::parse($this->existingBarcode->scanned_at)->diffInDays(Carbon::now());

            if ($daysSinceLastScan == 0) {
                session()->flash('error', 'Cannot update. Barcode was scanned today.');
            } else {
                // Update the status to 'RTO' and the scanned date
                $this->existingBarcode->update([
                    'status' => 'RTO',
                    'scanned_at' => Carbon::now(),
                    'rto_remark' => $this->rtoRemark,
                ]);
                session()->flash('message', 'Barcode updated to RTO status successfully.');
            }
        } else {
            session()->flash('error', 'No existing barcode found to update.');
        }

        $this->showConfirmation = false;
        $this->existingBarcode = null;
        $this->rtoRemark = '';
    }

    public function cancelUpdate()
    {
        $this->showConfirmation = false;
        $this->existingBarcode = null;
        $this->rtoRemark = '';
    }

    public function render()
    {
        $barcodes = Barcode::where('barcode', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.barcode-scanner', [
            'barcodes' => $barcodes,
        ]);
    }
}
