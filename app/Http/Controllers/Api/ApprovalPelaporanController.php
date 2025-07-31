<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApprovalPelaporan;
use App\Models\Evidence;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreApprovalPelaporanRequest;
use App\Http\Resources\ApprovalPelaporanResource;

class ApprovalPelaporanController extends Controller
{
    /**
     * GET /api/approval-pelaporan
     */
    public function index(Request $request)
    {
        try {
            $query = ApprovalPelaporan::with('evidences')
                ->orderByRaw('CASE WHEN created_at IS NULL THEN 1 ELSE 0 END') // null ke bawah
                ->orderBy('created_at', 'asc'); // yang valid dari lama ke baru

            $data = $query->paginate($request->input('per_page', 10));

            return response()->json([
                'message' => 'Data approval pelaporan retrieved successfully',
                'data' => ApprovalPelaporanResource::collection($data->items()),
                'meta' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/approval-pelaporan/{id}
     */
    public function show($id)
    {
        try {
            $data = ApprovalPelaporan::with('evidences')->findOrFail($id);

            return response()->json([
                'message' => 'Approval pelaporan retrieved successfully',
                'data' => new ApprovalPelaporanResource($data),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve approval pelaporan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * POST /api/approval-pelaporan
     */
    public function store(StoreApprovalPelaporanRequest $request)
    {
        try {
            $data = $request->validated();

            $uuid = (string) Str::uuid();

            $approval = ApprovalPelaporan::create([
                'id' => $uuid,
                'manufaktur' => $data['manufaktur'],
                'namaBarang' => $data['namaBarang'],
                'riwayat' => $data['riwayat'],
                'kelayakan' => $data['kelayakan'],
                'catatan' => $data['catatan'] ?? null,
            ]);

            foreach ($data['evidence'] as $item) {
                Evidence::create([
                    'id' => $uuid, // sama dengan approval.id
                    'approval_id' => $uuid, // FK
                    'name' => $item['name'],
                    'url' => $item['url'],
                    'user_maker' => $item['user_maker'],
                    'status_approve' => $item['status_approve'],
                    'approval_sequence' => $item['approval_sequence'],
                    'created_at' => now()
                ]);
            }


            return response()->json([
                'message' => 'Approval pelaporan created successfully',
                'data' => new ApprovalPelaporanResource($approval),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create approval pelaporan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $approval = ApprovalPelaporan::with('evidences')->findOrFail($id); // ambil approval beserta evidences-nya

            // Jika yang dikirim hanya update status (approve/reject)
            if ($request->has('status_approve')) {
                $status = $request->input('status_approve');

                foreach ($approval->evidences as $evidence) {
                    // Jika status sudah final, tolak perubahan
                    if (in_array($evidence->status_approve, ['approved', 'rejected'])) {
                        return response()->json([
                            'message' => 'Gagal, data sudah ' . $evidence->status_approve,
                        ], 400);
                    }

                    $evidence->update([
                        'status_approve' => $status,
                        'tanggal_approve' => now(),
                    ]);
                }

                return response()->json([
                    'message' => 'Status berhasil diubah menjadi ' . $status,
                    'data' => new ApprovalPelaporanResource($approval->fresh('evidences')),
                ]);
            }

            // Update data non-status
            $approval->update($request->only([
                'manufaktur',
                'nama_barang',
                'riwayat',
                'kelayakan',
                'catatan',
            ]));

            return response()->json([
                'message' => 'Approval pelaporan updated successfully',
                'data' => new ApprovalPelaporanResource($approval->fresh('evidences')),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update approval pelaporan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }





    /**
     * DELETE /api/approval-pelaporan/{id}
     */
    public function destroy($id)
    {
        try {
            $data = ApprovalPelaporan::findOrFail($id);
            $data->delete();

            return response()->json([
                'message' => 'Approval pelaporan deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete approval pelaporan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
