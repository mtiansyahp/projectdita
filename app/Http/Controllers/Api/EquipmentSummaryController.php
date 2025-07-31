<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipmentSummaryController extends Controller
{
    /**
     * GET /api/equipment-summary
     * Mengembalikan ringkasan statistik aset
     */
    public function index(Request $request)
    {
        $summary = DB::table('v_equipment_and_report_summary_1')->first();

        return response()->json([
            'total_asset'               => (int)   $summary->total_asset,
            'total_asset_layak'         => (int)   $summary->total_asset_layak,
            'total_asset_tidak_layak'   => (int)   $summary->total_asset_tidak_layak,
            'ratio_asset_layak'         => (float) $summary->ratio_asset_layak,
            'ratio_asset_tidak_layak'   => (float) $summary->ratio_asset_tidak_layak,
            'total_pelaporan'           => (int)   $summary->total_pelaporan,
        ]);
    }

    /**
     * GET /api/equipment-detail-summary
     * Mengembalikan data detail equipment dan pelaporan
     */
    public function detailSummary(Request $request)
    {
        $query = DB::table('v_equipment_and_report_summary');

        if ($request->has('kondisi')) {
            $kondisi = $request->get('kondisi');

            // Tangani operator !=
            if (str_starts_with($kondisi, '!=')) {
                $value = trim(substr($kondisi, 2));
                $query->where('kondisi_barang', '!=', $value);
            } else {
                $query->where('kondisi_barang', $kondisi);
            }
        }

        $data = $query->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
