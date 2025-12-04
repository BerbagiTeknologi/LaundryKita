<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function manage()
    {
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $regularServices = DB::table('regular_services')
            ->where('user_id', $user->id)
            ->orderBy('group_name')
            ->orderBy('name')
            ->get()
            ->groupBy('group_name');
        $regularGroups = $regularServices->keys();

        $packageServices = [
            ['name' => 'Paket Hemat 30 Kg', 'price' => 200000, 'quota' => '30 kg', 'expires' => '60 hari', 'status' => 'Aktif'],
            ['name' => 'Paket Eksekutif 60 Kg', 'price' => 360000, 'quota' => '60 kg', 'expires' => '90 hari', 'status' => 'Aktif'],
        ];

        $addons = [
            ['name' => 'Parfum Premium', 'price' => 3000, 'unit' => 'order', 'status' => 'Aktif'],
            ['name' => 'Pewangi Hypoallergenic', 'price' => 4000, 'unit' => 'order', 'status' => 'Aktif'],
            ['name' => 'Anti Kusut', 'price' => 2500, 'unit' => 'kg', 'status' => 'Nonaktif'],
        ];

        $promos = [
            ['name' => 'Diskon 10% Senin-Kamis', 'type' => 'Persen', 'value' => '10%', 'period' => '01-15 Des', 'status' => 'Aktif'],
            ['name' => 'Gratis Antar Jemput > Rp50k', 'type' => 'Gratis Ongkir', 'value' => '-', 'period' => 'Berlaku', 'status' => 'Aktif'],
        ];

        $categories = [
            ['name' => 'Pakaian', 'unit' => 'Kg', 'items' => 24],
            ['name' => 'Sepatu', 'unit' => 'Pasang', 'items' => 8],
            ['name' => 'Helm', 'unit' => 'Buah', 'items' => 4],
        ];

        $products = [
            ['sku' => 'PRD-001', 'name' => 'Detergen Cair', 'stock' => 12, 'uom' => 'L', 'reorder' => 5, 'status' => 'Aman'],
            ['sku' => 'PRD-002', 'name' => 'Parfum Botol', 'stock' => 6, 'uom' => 'Botol', 'reorder' => 6, 'status' => 'Perlu Restock'],
            ['sku' => 'PRD-003', 'name' => 'Plastik Laundry', 'stock' => 320, 'uom' => 'Lembar', 'reorder' => 200, 'status' => 'Aman'],
        ];

        $productPurchases = [
            ['vendor' => 'Clean Supply', 'product' => 'Detergen Cair', 'qty' => 10, 'uom' => 'L', 'cost' => 150000, 'date' => '2024-12-01', 'status' => 'Selesai'],
            ['vendor' => 'Aroma Wangi', 'product' => 'Parfum Botol', 'qty' => 12, 'uom' => 'Botol', 'cost' => 180000, 'date' => '2024-11-28', 'status' => 'Menunggu'],
            ['vendor' => 'Kemasan Jaya', 'product' => 'Plastik Laundry', 'qty' => 500, 'uom' => 'Lembar', 'cost' => 95000, 'date' => '2024-11-25', 'status' => 'Selesai'],
        ];

        $stockOpnames = [
            ['date' => '2024-12-01', 'product' => 'Detergen Cair', 'system' => '12 L', 'actual' => '11 L', 'diff' => '-1 L', 'note' => 'Tumpah di area cuci'],
            ['date' => '2024-11-30', 'product' => 'Parfum Botol', 'system' => '6 Botol', 'actual' => '6 Botol', 'diff' => '0', 'note' => '-'],
            ['date' => '2024-11-29', 'product' => 'Plastik Laundry', 'system' => '320 Lembar', 'actual' => '315 Lembar', 'diff' => '-5 Lembar', 'note' => 'Rusak saat packing'],
        ];

        return view('service.manage', compact(
            'user',
            'regularServices',
            'regularGroups',
            'packageServices',
            'addons',
            'promos',
            'categories',
            'products',
            'productPurchases',
            'stockOpnames'
        ));
    }

    public function storeRegular(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $validated = $request->validate([
            'group_name' => ['nullable', 'string', 'max:100'],
            'new_group' => ['nullable', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'price_per_kg' => ['required', 'integer', 'min:0'],
            'process_hours' => ['required', 'integer', 'min:1', 'max:168'], // up to 7 days
        ]);

        $group = $validated['new_group'] ?: $validated['group_name'];
        if (! $group) {
            return back()->withErrors(['group_name' => 'Pilih grup atau buat grup baru.'])->withInput();
        }

        DB::table('regular_services')->insert([
            'user_id' => $user->id,
            'group_name' => $group,
            'name' => $validated['name'],
            'price_per_kg' => $validated['price_per_kg'],
            'process_minutes' => $validated['process_hours'] * 60,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('services.manage') . '#tab-services-regular')
            ->with('status', 'Layanan reguler berhasil ditambahkan.');
    }

    public function updateRegular(Request $request, int $serviceId)
    {
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $service = DB::table('regular_services')
            ->where('id', $serviceId)
            ->where('user_id', $user->id)
            ->first();

        if (! $service) {
            abort(404);
        }

        $validated = $request->validate([
            'group_name' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'price_per_kg' => ['required', 'integer', 'min:0'],
            'process_hours' => ['required', 'integer', 'min:1', 'max:168'],
        ]);

        DB::table('regular_services')
            ->where('id', $serviceId)
            ->update([
                'group_name' => $validated['group_name'],
                'name' => $validated['name'],
                'price_per_kg' => $validated['price_per_kg'],
                'process_minutes' => $validated['process_hours'] * 60,
                'updated_at' => now(),
            ]);

        return redirect()->to(route('services.manage') . '#tab-services-regular')
            ->with('status', 'Layanan reguler berhasil diperbarui.');
    }

    public function destroyRegular(Request $request, int $serviceId)
    {
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $service = DB::table('regular_services')
            ->where('id', $serviceId)
            ->where('user_id', $user->id)
            ->first();

        if (! $service) {
            abort(404);
        }

        DB::table('regular_services')
            ->where('id', $serviceId)
            ->delete();

        return redirect()->to(route('services.manage') . '#tab-services-regular')
            ->with('status', 'Layanan reguler berhasil dihapus.');
    }
}
