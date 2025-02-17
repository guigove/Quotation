<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Rules\AgeRange;
use App\Rules\AllowedCurrencies;
use App\Rules\CommaSeparatedNumbers;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function quotation(Request $request)
    {
        $request->validate([
            'age' => ['required', 'string', new CommaSeparatedNumbers, new AgeRange] ,
            'currency_id' => ['required', 'string', new AllowedCurrencies],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        try {
            $quotation = new Quotation([
                'age' => $request->age,
                'currency_id' => $request->currency_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
    
            $quotation->calculate();
    
            if (!$quotation->save()) {
                return response()->error('Failed to quote', 500);
            }
    
            return response()->success([
                'total' => $quotation->total,
                'currency_id' => $quotation->currency_id,
                'quotation_id' => $quotation->id
            ]);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }
}
