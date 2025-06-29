<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipmentSummaryController extends Controller
{
    /**
     * GET  /api/equipment-summary
     * Return JSON from the v_equipment_and_report_summary view
     */
    public function index(Request $request)
    {
        // Ambil satu baris ringkasan dari view
        $summary = DB::table('v_equipment_and_report_summary')->first();
        // ini untuk ambil data view dari table dan tampilkan di frontend

        // Pastikan kita casting ke tipe primitif
        return response()->json([
            'total_asset'               => (int)   $summary->total_asset,
            'total_asset_layak'         => (int)   $summary->total_asset_layak,
            'total_asset_tidak_layak'   => (int)   $summary->total_asset_tidak_layak,
            'ratio_asset_layak'         => (float) $summary->ratio_asset_layak,
            'ratio_asset_tidak_layak'   => (float) $summary->ratio_asset_tidak_layak,
            'total_pelaporan'           => (int)   $summary->total_pelaporan,
        ]);
    }
}
