<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EquipmentLaboratorium;
use Illuminate\Http\Request;
use App\Http\Resources\EquipmentLaboratoriumResource;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;


class EquipmentLaboratoriumController extends Controller
{
    /**
     * GET /api/equipment
     */
    public function index(Request $request)
    {
        $query = EquipmentLaboratorium::query();

        if ($search = $request->input('search')) {
            $query->where('nama_item', 'like', "%$search%");
        }

        $data = $query->paginate($request->input('per_page', 10));

        return response()->json([
            'message' => 'Data equipment retrieved successfully',
            'data' => $data->items(),
            'meta' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
            ]
        ]);
    }


    /**
     * POST /api/equipment
     */
    public function store(StoreEquipmentRequest $request)
    {
        try {
            $equipment = EquipmentLaboratorium::create($request->validated());

            return response()->json([
                'message' => 'Equipment created successfully',
                'data'    => new EquipmentLaboratoriumResource($equipment),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create equipment',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // in app/Http/Controllers/Api/EquipmentLaboratoriumController.php

    public function show(EquipmentLaboratorium $equipment)
    {
        return response()->json([
            'message' => 'Equipment retrieved successfully',
            'data'    => new EquipmentLaboratoriumResource($equipment),
        ], 200);
    }


    /**
     * PUT/PATCH /api/equipment/{unique_id}
     */
    public function update(UpdateEquipmentRequest $request, EquipmentLaboratorium $equipment)
    {
        try {
            $equipment->update($request->validated());

            $equipment->update($request->validated());

            return response()->json([
                'message' => 'Equipment updated successfully',
                'data'    => new EquipmentLaboratoriumResource($equipment->refresh()),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update equipment',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * DELETE /api/equipment/{unique_id}
     */
    public function destroy(EquipmentLaboratorium $equipment)
    {
        try {
            $equipment->delete();

            return response()->json([
                'message' => 'Equipment deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete equipment',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function getRouteKeyName(): string
    {
        return 'unique_id';
    }
}
