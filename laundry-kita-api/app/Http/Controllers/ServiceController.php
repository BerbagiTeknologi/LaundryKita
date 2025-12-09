<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function manage()
    {
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $defaultUnits = ['Kg', 'Pasang', 'Buah', 'Lembar', 'L', 'Botol'];
        $units = DB::table('service_units')
            ->where('user_id', $user->id)
            ->orderBy('name')
            ->get();
        if ($units->isEmpty()) {
            $insert = collect($defaultUnits)->map(fn ($name) => [
                'user_id' => $user->id,
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('service_units')->insert($insert->all());
            $units = DB::table('service_units')
                ->where('user_id', $user->id)
                ->orderBy('name')
                ->get();
        }

        $categories = DB::table('service_categories')
            ->leftJoin('service_units', 'service_categories.unit_id', '=', 'service_units.id')
            ->where('service_categories.user_id', $user->id)
            ->orderBy('service_categories.name')
            ->select('service_categories.*', 'service_units.name as unit_name')
            ->get();

        $regularServices = DB::table('regular_services')
            ->where('user_id', $user->id)
            ->orderBy('group_name')
            ->orderBy('name')
            ->get()
            ->groupBy('group_name');
        $regularGroups = $regularServices->keys();

        $packageServices = DB::table('package_services')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $addonTypes = DB::table('addon_types')
            ->where('user_id', $user->id)
            ->orderBy('name')
            ->get();

        // Pastikan tipe yang sudah dipakai oleh add-on tetap muncul di dropdown meski tipe belum terdaftar di tabel addon_types
        $addonTypeNames = $addonTypes->pluck('name')->all();
        $usedTypes = DB::table('addons')
            ->where('user_id', $user->id)
            ->select('type')
            ->distinct()
            ->pluck('type')
            ->filter()
            ->all();
        $missingTypes = collect($usedTypes)
            ->diff($addonTypeNames)
            ->map(fn ($name) => (object) ['name' => $name]);
        $addonTypes = $addonTypes->concat($missingTypes)->sortBy('name')->values();

        $addons = DB::table('addons')
            ->where('user_id', $user->id)
            ->orderBy('name')
            ->get();

        $promos = DB::table('promos')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $rawProducts = DB::table('service_products')
            ->leftJoin('service_units', 'service_products.unit_id', '=', 'service_units.id')
            ->where('service_products.user_id', $user->id)
            ->select('service_products.*', 'service_units.name as unit_name')
            ->orderBy('service_products.created_at', 'desc')
            ->get();

        $products = $rawProducts->map(function ($item) {
            $status = 'Aman';
            if ($item->stock <= 0) {
                $status = 'Harus Restock';
            } elseif ($item->stock <= ($item->reorder_point ?? 0)) {
                $status = 'Perlu Restock';
            }
            return [
                'id' => $item->id,
                'sku' => $item->sku,
                'name' => $item->name,
                'stock' => $item->stock,
                'uom' => $item->unit_name ?? '-',
                'reorder' => $item->reorder_point,
                'status' => $status,
                'unit_id' => $item->unit_id,
            ];
        });

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
            'addonTypes',
            'addons',
            'promos',
            'units',
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

        $request->merge([
            'price_per_kg' => preg_replace('/\D+/', '', (string) $request->price_per_kg) ?: 0,
        ]);

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

        $request->merge([
            'price_per_kg' => preg_replace('/\D+/', '', (string) $request->price_per_kg) ?: 0,
        ]);

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

    public function renameRegularGroup(Request $request, string $groupName)
    {
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $validated = $request->validate([
            'new_group_name' => ['required', 'string', 'max:100'],
        ]);

        $exists = DB::table('regular_services')
            ->where('user_id', $user->id)
            ->where('group_name', $groupName)
            ->exists();

        if (! $exists) {
            abort(404);
        }

        DB::table('regular_services')
            ->where('user_id', $user->id)
            ->where('group_name', $groupName)
            ->update([
                'group_name' => $validated['new_group_name'],
                'updated_at' => now(),
            ]);

        return redirect()->to(route('services.manage') . '#tab-services-regular')
            ->with('status', 'Nama grup layanan berhasil diperbarui.');
    }

    public function deleteRegularGroup(Request $request, string $groupName)
    {
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $exists = DB::table('regular_services')
            ->where('user_id', $user->id)
            ->where('group_name', $groupName)
            ->exists();

        if (! $exists) {
            abort(404);
        }

        DB::table('regular_services')
            ->where('user_id', $user->id)
            ->where('group_name', $groupName)
            ->delete();

        return redirect()->to(route('services.manage') . '#tab-services-regular')
            ->with('status', 'Grup layanan berhasil dihapus beserta layanan di dalamnya.');
    }

    public function storePackage(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $request->merge([
            'price' => preg_replace('/\D+/', '', (string) $request->price) ?: 0,
        ]);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'regular_group_name' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'max:2048'],
            'price' => ['required', 'integer', 'min:0'],
            'quota_value' => ['required', 'integer', 'min:1'],
            'quota_unit_id' => ['required', 'integer', 'exists:service_units,id'],
            'work_hours' => ['required', 'integer', 'min:1', 'max:168'],
            'has_expiry' => ['nullable', 'boolean'],
            'expires_in_days' => ['nullable', 'integer', 'min:1', 'max:365'],
        ]);
        if ($validator->fails()) {
            return redirect()->to(route('services.manage') . '#tab-services-package')
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', '#tab-services-package');
        }
        $validated = $validator->validated();

        $groupExists = DB::table('regular_services')
            ->where('user_id', $user->id)
            ->where('group_name', $validated['regular_group_name'])
            ->exists();
        if (! $groupExists) {
            return back()->withErrors(['regular_group_name' => 'Grup layanan reguler tidak ditemukan.'])->withInput();
        }

        $unit = DB::table('service_units')
            ->where('user_id', $user->id)
            ->where('id', $validated['quota_unit_id'])
            ->first();
        if (! $unit) {
            return back()->withErrors(['quota_unit_id' => 'Satuan tidak ditemukan.'])->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('package_images', 'public');
        }

        $quotaLabel = $validated['quota_value'] . ' ' . $unit->name;

        DB::table('package_services')->insert([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'regular_group_name' => $validated['regular_group_name'],
            'image_path' => $imagePath,
            'price' => $validated['price'],
            'quota' => $quotaLabel,
            'quota_value' => $validated['quota_value'],
            'quota_unit_id' => $unit->id,
            'work_hours' => $validated['work_hours'],
            'has_expiry' => $request->boolean('has_expiry'),
            'expires_in_days' => $request->boolean('has_expiry') ? ($validated['expires_in_days'] ?? null) : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('services.manage') . '#tab-services-package')
            ->with('status', 'Paket layanan berhasil ditambahkan.');
    }

    public function updatePackage(Request $request, int $packageId)
    {
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $package = DB::table('package_services')
            ->where('id', $packageId)
            ->where('user_id', $user->id)
            ->first();

        if (! $package) {
            abort(404);
        }

        $request->merge([
            'price' => preg_replace('/\D+/', '', (string) $request->price) ?: 0,
        ]);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'regular_group_name' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'max:2048'],
            'price' => ['required', 'integer', 'min:0'],
            'quota_value' => ['required', 'integer', 'min:1'],
            'quota_unit_id' => ['required', 'integer', 'exists:service_units,id'],
            'work_hours' => ['required', 'integer', 'min:1', 'max:168'],
            'has_expiry' => ['nullable', 'boolean'],
            'expires_in_days' => ['nullable', 'integer', 'min:1', 'max:365'],
        ]);
        if ($validator->fails()) {
            return redirect()->to(route('services.manage') . '#tab-services-package')
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', '#tab-services-package');
        }
        $validated = $validator->validated();

        $groupExists = DB::table('regular_services')
            ->where('user_id', $user->id)
            ->where('group_name', $validated['regular_group_name'])
            ->exists();
        if (! $groupExists) {
            return back()->withErrors(['regular_group_name' => 'Grup layanan reguler tidak ditemukan.'])->withInput();
        }

        $unit = DB::table('service_units')
            ->where('user_id', $user->id)
            ->where('id', $validated['quota_unit_id'])
            ->first();
        if (! $unit) {
            return back()->withErrors(['quota_unit_id' => 'Satuan tidak ditemukan.'])->withInput();
        }

        $imagePath = $package->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('package_images', 'public');
        }

        $quotaLabel = $validated['quota_value'] . ' ' . $unit->name;

        DB::table('package_services')
            ->where('id', $packageId)
            ->update([
                'name' => $validated['name'],
                'regular_group_name' => $validated['regular_group_name'],
                'image_path' => $imagePath,
                'price' => $validated['price'],
                'quota' => $quotaLabel,
                'quota_value' => $validated['quota_value'],
                'quota_unit_id' => $unit->id,
                'work_hours' => $validated['work_hours'],
                'has_expiry' => $request->boolean('has_expiry'),
                'expires_in_days' => $request->boolean('has_expiry') ? ($validated['expires_in_days'] ?? null) : null,
                'updated_at' => now(),
            ]);

        return redirect()->to(route('services.manage') . '#tab-services-package')
            ->with('status', 'Paket layanan berhasil diperbarui.');
    }

    public function destroyPackage(Request $request, int $packageId)
    {
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $package = DB::table('package_services')
            ->where('id', $packageId)
            ->where('user_id', $user->id)
            ->first();

        if (! $package) {
            abort(404);
        }

        if ($package->image_path) {
            Storage::disk('public')->delete($package->image_path);
        }

        DB::table('package_services')
            ->where('id', $packageId)
            ->delete();

        return redirect()->to(route('services.manage') . '#tab-services-package')
            ->with('status', 'Paket layanan berhasil dihapus.');
    }

    public function storeAddon(Request $request)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $request->merge([
            'price' => preg_replace('/\D+/', '', (string) $request->price) ?: 0,
        ]);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:100'],
            'price' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        if ($validator->fails()) {
            return redirect()->to(route('services.manage') . '#tab-services-addon')
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', '#tab-services-addon');
        }
        $validated = $validator->validated();

        // Create type if it doesn't exist
        $typeExists = DB::table('addon_types')
            ->where('user_id', $user->id)
            ->where('name', $validated['type'])
            ->exists();
        if (! $typeExists) {
            DB::table('addon_types')->insert([
                'user_id' => $user->id,
                'name' => $validated['type'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('addons')->insert([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'price' => $validated['price'],
            'is_active' => $request->boolean('is_active'),
            'product_id' => $this->ensureAddonProduct($user->id, $validated['name']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('services.manage') . '#tab-services-addon')
            ->with('status', 'Add-on berhasil ditambahkan.');
    }

    public function updateAddon(Request $request, int $addonId)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $addon = DB::table('addons')->where('id', $addonId)->where('user_id', $user->id)->first();
        if (! $addon) abort(404);

        $request->merge([
            'price' => preg_replace('/\D+/', '', (string) $request->price) ?: 0,
        ]);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:100'],
            'price' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        if ($validator->fails()) {
            return redirect()->to(route('services.manage') . '#tab-services-addon')
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', '#tab-services-addon');
        }
        $validated = $validator->validated();

        // Create type if it doesn't exist (consistent with storeAddon)
        $typeExists = DB::table('addon_types')
            ->where('user_id', $user->id)
            ->where('name', $validated['type'])
            ->exists();
        if (! $typeExists) {
            DB::table('addon_types')->insert([
                'user_id' => $user->id,
                'name' => $validated['type'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('addons')->where('id', $addonId)->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'price' => $validated['price'],
            'is_active' => $request->boolean('is_active'),
            'product_id' => $this->ensureAddonProduct($user->id, $validated['name'], $addon->product_id),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('services.manage') . '#tab-services-addon')
            ->with('status', 'Add-on berhasil diperbarui.');
    }

    public function destroyAddon(Request $request, int $addonId)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $addon = DB::table('addons')->where('id', $addonId)->where('user_id', $user->id)->first();
        if (! $addon) abort(404);

        DB::table('addons')->where('id', $addonId)->delete();

        return redirect()->to(route('services.manage') . '#tab-services-addon')
            ->with('status', 'Add-on berhasil dihapus.');
    }

    public function storePromo(Request $request)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $request->merge([
            'value' => $request->value !== null ? (preg_replace('/\D+/', '', (string) $request->value) ?: 0) : null,
        ]);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:50'],
            'value' => ['nullable', 'integer', 'min:0'],
            'period' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        if ($validator->fails()) {
            return redirect()->to(route('services.manage') . '#tab-services-promo')
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', '#tab-services-promo');
        }
        $validated = $validator->validated();

        DB::table('promos')->insert([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'value' => $validated['value'] ?? null,
            'period' => $validated['period'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('services.manage') . '#tab-services-promo')
            ->with('status', 'Promo berhasil ditambahkan.');
    }

    public function updatePromo(Request $request, int $promoId)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $promo = DB::table('promos')->where('id', $promoId)->where('user_id', $user->id)->first();
        if (! $promo) abort(404);

        $request->merge([
            'value' => $request->value !== null ? (preg_replace('/\D+/', '', (string) $request->value) ?: 0) : null,
        ]);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:50'],
            'value' => ['nullable', 'integer', 'min:0'],
            'period' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        if ($validator->fails()) {
            return redirect()->to(route('services.manage') . '#tab-services-promo')
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', '#tab-services-promo');
        }
        $validated = $validator->validated();

        DB::table('promos')->where('id', $promoId)->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'value' => $validated['value'] ?? null,
            'period' => $validated['period'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('services.manage') . '#tab-services-promo')
            ->with('status', 'Promo berhasil diperbarui.');
    }

    public function destroyPromo(Request $request, int $promoId)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $promo = DB::table('promos')->where('id', $promoId)->where('user_id', $user->id)->first();
        if (! $promo) abort(404);

        DB::table('promos')->where('id', $promoId)->delete();

        return redirect()->to(route('services.manage') . '#tab-services-promo')
            ->with('status', 'Promo berhasil dihapus.');
    }

    public function storeAddonType(Request $request)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $exists = DB::table('addon_types')
            ->where('user_id', $user->id)
            ->where('name', $validated['name'])
            ->exists();
        if ($exists) {
            return back()->withErrors(['name' => 'Jenis sudah ada.'])->withInput();
        }

        DB::table('addon_types')->insert([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('services.manage') . '#tab-services-addon')
            ->with('status', 'Jenis produk berhasil ditambahkan.');
    }

    public function updateAddonType(Request $request, int $typeId)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $type = DB::table('addon_types')->where('id', $typeId)->where('user_id', $user->id)->first();
        if (! $type) abort(404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $duplicate = DB::table('addon_types')
            ->where('user_id', $user->id)
            ->where('name', $validated['name'])
            ->where('id', '!=', $typeId)
            ->exists();
        if ($duplicate) {
            return back()->withErrors(['name' => 'Jenis sudah ada.'])->withInput();
        }

        DB::table('addon_types')->where('id', $typeId)->update([
            'name' => $validated['name'],
            'updated_at' => now(),
        ]);

        return redirect()->to(route('services.manage') . '#tab-services-addon')
            ->with('status', 'Jenis produk berhasil diperbarui.');
    }

    public function destroyAddonType(Request $request, int $typeId)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $type = DB::table('addon_types')->where('id', $typeId)->where('user_id', $user->id)->first();
        if (! $type) abort(404);

        if ($type->name === 'Tidak dikategorikan') {
            return back()->withErrors(['name' => 'Jenis default tidak dapat dihapus.']);
        }

        // Reassign addons to fallback type if this type is in use
        $inUse = DB::table('addons')
            ->where('user_id', $user->id)
            ->where('type', $type->name);

        if ($inUse->exists()) {
            $fallback = DB::table('addon_types')
                ->where('user_id', $user->id)
                ->where('name', 'Tidak dikategorikan')
                ->first();
            
            if (! $fallback) {
                DB::table('addon_types')->insert([
                    'user_id' => $user->id,
                    'name' => 'Tidak dikategorikan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $fallback = (object) ['name' => 'Tidak dikategorikan'];
            }

            DB::table('addons')
                ->where('user_id', $user->id)
                ->where('type', $type->name)
                ->update([
                    'type' => $fallback->name,
                    'updated_at' => now(),
                ]);
        }

        DB::table('addon_types')->where('id', $typeId)->delete();

        return redirect()->to(route('services.manage') . '#tab-services-addon')
            ->with('status', 'Jenis produk berhasil dihapus.');
    }

    public function storeUnit(Request $request)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
        ]);
        if ($validator->fails()) {
            return redirect()->to(route('services.manage') . '#tab-services-category')
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', '#tab-services-category');
        }
        $validated = $validator->validated();

        $exists = DB::table('service_units')
            ->where('user_id', $user->id)
            ->where('name', $validated['name'])
            ->exists();
        if ($exists) {
            return redirect()->to(route('services.manage') . '#tab-services-category')
                ->withErrors(['name' => 'Satuan sudah ada.'])
                ->withInput()
                ->with('active_tab', '#tab-services-category');
        }

        DB::table('service_units')->insert([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('services.manage') . '#tab-services-category')
            ->with('status', 'Satuan berhasil ditambahkan.');
    }

    public function updateUnit(Request $request, int $unitId)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $unit = DB::table('service_units')->where('id', $unitId)->where('user_id', $user->id)->first();
        if (! $unit) abort(404);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
        ]);
        if ($validator->fails()) {
            return redirect()->to(route('services.manage') . '#tab-services-category')
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', '#tab-services-category');
        }
        $validated = $validator->validated();

        $duplicate = DB::table('service_units')
            ->where('user_id', $user->id)
            ->where('name', $validated['name'])
            ->where('id', '!=', $unitId)
            ->exists();
        if ($duplicate) {
            return redirect()->to(route('services.manage') . '#tab-services-category')
                ->withErrors(['name' => 'Satuan sudah ada.'])
                ->withInput()
                ->with('active_tab', '#tab-services-category');
        }

        DB::table('service_units')->where('id', $unitId)->update([
            'name' => $validated['name'],
            'updated_at' => now(),
        ]);

        return redirect()->to(route('services.manage') . '#tab-services-category')
            ->with('status', 'Satuan berhasil diperbarui.');
    }

    public function destroyUnit(Request $request, int $unitId)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $unit = DB::table('service_units')->where('id', $unitId)->where('user_id', $user->id)->first();
        if (! $unit) abort(404);

        DB::table('service_units')->where('id', $unitId)->delete();

        return redirect()->to(route('services.manage') . '#tab-services-category')
            ->with('status', 'Satuan berhasil dihapus.');
    }

    public function storeCategory(Request $request)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'unit_id' => ['nullable', 'integer', 'exists:service_units,id'],
        ]);
        if ($validator->fails()) {
            return redirect()->to(route('services.manage') . '#tab-services-category')
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', '#tab-services-category');
        }
        $validated = $validator->validated();

        $duplicate = DB::table('service_categories')
            ->where('user_id', $user->id)
            ->where('name', $validated['name'])
            ->exists();
        if ($duplicate) {
            return redirect()->to(route('services.manage') . '#tab-services-category')
                ->withErrors(['name' => 'Kategori sudah ada.'])
                ->withInput()
                ->with('active_tab', '#tab-services-category');
        }

        if (! empty($validated['unit_id'])) {
            $unit = DB::table('service_units')
                ->where('user_id', $user->id)
                ->where('id', $validated['unit_id'])
                ->first();
            if (! $unit) {
                return redirect()->to(route('services.manage') . '#tab-services-category')
                    ->withErrors(['unit_id' => 'Satuan tidak ditemukan.'])
                    ->withInput()
                    ->with('active_tab', '#tab-services-category');
            }
        }

        DB::table('service_categories')->insert([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'unit_id' => $validated['unit_id'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('services.manage') . '#tab-services-category')
            ->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function updateCategory(Request $request, int $categoryId)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $category = DB::table('service_categories')->where('id', $categoryId)->where('user_id', $user->id)->first();
        if (! $category) abort(404);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'unit_id' => ['nullable', 'integer', 'exists:service_units,id'],
        ]);
        if ($validator->fails()) {
            return redirect()->to(route('services.manage') . '#tab-services-category')
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', '#tab-services-category');
        }
        $validated = $validator->validated();

        $duplicate = DB::table('service_categories')
            ->where('user_id', $user->id)
            ->where('name', $validated['name'])
            ->where('id', '!=', $categoryId)
            ->exists();
        if ($duplicate) {
            return redirect()->to(route('services.manage') . '#tab-services-category')
                ->withErrors(['name' => 'Kategori sudah ada.'])
                ->withInput()
                ->with('active_tab', '#tab-services-category');
        }

        if (! empty($validated['unit_id'])) {
            $unit = DB::table('service_units')
                ->where('user_id', $user->id)
                ->where('id', $validated['unit_id'])
                ->first();
            if (! $unit) {
                return redirect()->to(route('services.manage') . '#tab-services-category')
                    ->withErrors(['unit_id' => 'Satuan tidak ditemukan.'])
                    ->withInput()
                    ->with('active_tab', '#tab-services-category');
            }
        }

        DB::table('service_categories')->where('id', $categoryId)->update([
            'name' => $validated['name'],
            'unit_id' => $validated['unit_id'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()->to(route('services.manage') . '#tab-services-category')
            ->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroyCategory(Request $request, int $categoryId)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $category = DB::table('service_categories')->where('id', $categoryId)->where('user_id', $user->id)->first();
        if (! $category) abort(404);

        DB::table('service_categories')->where('id', $categoryId)->delete();

        return redirect()->to(route('services.manage') . '#tab-services-category')
            ->with('status', 'Kategori berhasil dihapus.');
    }

    public function storeProduct(Request $request)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:100'],
            'unit_id' => ['nullable', 'integer', 'exists:service_units,id'],
            'stock' => ['required', 'integer', 'min:0'],
            'reorder_point' => ['required', 'integer', 'min:0'],
        ]);
        if ($validator->fails()) {
            return redirect()->to(route('services.manage') . '#tab-services-product')
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', '#tab-services-product');
        }
        $data = $validator->validated();

        if (! empty($data['sku'])) {
            $exists = DB::table('service_products')
                ->where('user_id', $user->id)
                ->where('sku', $data['sku'])
                ->exists();
            if ($exists) {
                return redirect()->to(route('services.manage') . '#tab-services-product')
                    ->withErrors(['sku' => 'SKU sudah digunakan.'])
                    ->withInput()
                    ->with('active_tab', '#tab-services-product');
            }
        }

        DB::table('service_products')->insert([
            'user_id' => $user->id,
            'name' => $data['name'],
            'sku' => $data['sku'],
            'unit_id' => $data['unit_id'] ?? null,
            'stock' => $data['stock'],
            'reorder_point' => $data['reorder_point'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('services.manage') . '#tab-services-product')
            ->with('status', 'Produk berhasil ditambahkan.');
    }

    public function updateProduct(Request $request, int $productId)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $product = DB::table('service_products')->where('id', $productId)->where('user_id', $user->id)->first();
        if (! $product) abort(404);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:100'],
            'unit_id' => ['nullable', 'integer', 'exists:service_units,id'],
            'stock' => ['required', 'integer', 'min:0'],
            'reorder_point' => ['required', 'integer', 'min:0'],
        ]);
        if ($validator->fails()) {
            return redirect()->to(route('services.manage') . '#tab-services-product')
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', '#tab-services-product');
        }
        $data = $validator->validated();

        if (! empty($data['sku'])) {
            $exists = DB::table('service_products')
                ->where('user_id', $user->id)
                ->where('sku', $data['sku'])
                ->where('id', '!=', $productId)
                ->exists();
            if ($exists) {
                return redirect()->to(route('services.manage') . '#tab-services-product')
                    ->withErrors(['sku' => 'SKU sudah digunakan.'])
                    ->withInput()
                    ->with('active_tab', '#tab-services-product');
            }
        }

        DB::table('service_products')->where('id', $productId)->update([
            'name' => $data['name'],
            'sku' => $data['sku'],
            'unit_id' => $data['unit_id'] ?? null,
            'stock' => $data['stock'],
            'reorder_point' => $data['reorder_point'],
            'updated_at' => now(),
        ]);

        return redirect()->to(route('services.manage') . '#tab-services-product')
            ->with('status', 'Produk berhasil diperbarui.');
    }

    public function destroyProduct(Request $request, int $productId)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $product = DB::table('service_products')->where('id', $productId)->where('user_id', $user->id)->first();
        if (! $product) abort(404);

        DB::table('addons')
            ->where('user_id', $user->id)
            ->where('product_id', $productId)
            ->delete();

        DB::table('service_products')->where('id', $productId)->delete();

        return redirect()->to(route('services.manage') . '#tab-services-product')
            ->with('status', 'Produk dan add-on terkait berhasil dihapus.');
    }

    protected function ensureAddonProduct(int $userId, string $name, ?int $existingProductId = null): ?int
    {
        if ($existingProductId) {
            return $existingProductId;
        }

        $unitId = DB::table('service_units')
            ->where('user_id', $userId)
            ->value('id');

        return DB::table('service_products')->insertGetId([
            'user_id' => $userId,
            'name' => $name,
            'sku' => null,
            'unit_id' => $unitId,
            'stock' => 0,
            'reorder_point' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
