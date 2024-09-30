<?php

namespace App\Services;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FilterOrders
{
    public function filter(Request $request, $query)
    {

        if ($request->has('barcode')) {
            $query->where('barcode', 'like', '%' . $request->barcode . '%');
        }

        if ($request->has('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('barcode', 'like', $searchTerm)
                  ->orWhere('mobile', 'like', $searchTerm)
                  ->orWhere('city', 'like', $searchTerm);
            });
        }

        if ($request->has('mobile')) {
            $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }

        if ($request->has('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);

            \Log::info('Date range filter applied', [
                'start_date' => $startDate->toDateTimeString(),
                'end_date' => $endDate->toDateTimeString(),
                'query' => $query->toSql(),
            ]);
        }

        return $query;
    }
}
