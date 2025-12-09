<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    protected array $coaPrefixes = [
        'Aset Lancar' => '1',
        'Aset Tetap' => '12',
        'Liability' => '2',
        'Equity' => '3',
        'Revenue' => '4',
        'Expense' => '5',
    ];

    public function index()
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $coas = DB::table('chart_of_accounts')
            ->where('user_id', $user->id)
            ->orderBy('code')
            ->get();

        return view('reports', [
            'coas' => $coas,
            'coaPrefixes' => $this->coaPrefixes,
        ]);
    }

    public function storeCoa(Request $request)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $data = $request->validate([
            'code' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:' . implode(',', array_keys($this->coaPrefixes))],
            'opening_balance' => ['nullable', 'integer', 'min:0'],
            'balance_nature' => ['required', 'string', 'in:debit,credit'],
        ]);

        if (! $this->codeMatchesPrefix($data['type'], $data['code'])) {
            return back()->withErrors(['code' => 'Kode harus diawali ' . $this->coaPrefixes[$data['type']] . ' sesuai jenis.'])->withInput();
        }

        $exists = DB::table('chart_of_accounts')
            ->where('user_id', $user->id)
            ->where('code', $data['code'])
            ->exists();
        if ($exists) {
            return back()->withErrors(['code' => 'Kode akun sudah digunakan.'])->withInput();
        }

        DB::table('chart_of_accounts')->insert([
            'user_id' => $user->id,
            'code' => $data['code'],
            'name' => $data['name'],
            'type' => $data['type'],
            'opening_balance' => $data['opening_balance'] ?? 0,
            'balance_nature' => $data['balance_nature'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('reports')->with('status', 'Akun berhasil ditambahkan.');
    }

    public function updateCoa(Request $request, int $id)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $coa = DB::table('chart_of_accounts')->where('id', $id)->where('user_id', $user->id)->first();
        if (! $coa) abort(404);

        $data = $request->validate([
            'code' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:' . implode(',', array_keys($this->coaPrefixes))],
            'opening_balance' => ['nullable', 'integer', 'min:0'],
            'balance_nature' => ['required', 'string', 'in:debit,credit'],
        ]);

        if (! $this->codeMatchesPrefix($data['type'], $data['code'])) {
            return back()->withErrors(['code' => 'Kode harus diawali ' . $this->coaPrefixes[$data['type']] . ' sesuai jenis.'])->withInput();
        }

        $duplicate = DB::table('chart_of_accounts')
            ->where('user_id', $user->id)
            ->where('code', $data['code'])
            ->where('id', '!=', $id)
            ->exists();
        if ($duplicate) {
            return back()->withErrors(['code' => 'Kode akun sudah digunakan.'])->withInput();
        }

        DB::table('chart_of_accounts')->where('id', $id)->update([
            'code' => $data['code'],
            'name' => $data['name'],
            'type' => $data['type'],
            'opening_balance' => $data['opening_balance'] ?? 0,
            'balance_nature' => $data['balance_nature'],
            'updated_at' => now(),
        ]);

        return redirect()->route('reports')->with('status', 'Akun berhasil diperbarui.');
    }

    public function destroyCoa(int $id)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $coa = DB::table('chart_of_accounts')->where('id', $id)->where('user_id', $user->id)->first();
        if (! $coa) abort(404);

        DB::table('chart_of_accounts')->where('id', $id)->delete();

        return redirect()->route('reports')->with('status', 'Akun berhasil dihapus.');
    }

    public function downloadCoa()
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $filename = 'chart_of_accounts_' . now()->format('Ymd_His') . '.csv';

        $rows = DB::table('chart_of_accounts')
            ->where('user_id', $user->id)
            ->orderBy('code')
            ->get(['code', 'name', 'type', 'opening_balance', 'balance_nature']);

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['code', 'name', 'type', 'opening_balance', 'balance_nature']);
            foreach ($rows as $row) {
                fputcsv($out, [$row->code, $row->name, $row->type, $row->opening_balance, $row->balance_nature]);
            }
            if ($rows->isEmpty()) {
                fputcsv($out, ['1001', 'Kas', 'Aset Lancar', '0', 'debit']);
                fputcsv($out, ['2001', 'Hutang Usaha', 'Liability', '0', 'credit']);
            }
            fclose($out);
        };

        return new StreamedResponse($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    public function uploadCoa(Request $request)
    {
        $user = Auth::user();
        if (! $user) abort(401);

        $request->validate([
            'coa_file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $path = $request->file('coa_file')->getRealPath();
        $handle = fopen($path, 'r');
        if (! $handle) {
            return back()->withErrors(['coa_file' => 'File tidak dapat dibaca.']);
        }

        $header = fgetcsv($handle);
        $imported = 0;
        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) < 5) continue;
            [$code, $name, $type, $opening, $balanceNature] = $data;
            if (! in_array($type, array_keys($this->coaPrefixes))) continue;
            if (! in_array($balanceNature, ['debit', 'credit'])) $balanceNature = 'debit';
            if (! $this->codeMatchesPrefix($type, $code)) continue;
            $openingVal = is_numeric($opening) ? (int) $opening : 0;

            $exists = DB::table('chart_of_accounts')
                ->where('user_id', $user->id)
                ->where('code', $code)
                ->first();

            if ($exists) {
                DB::table('chart_of_accounts')
                    ->where('id', $exists->id)
                    ->update([
                        'name' => $name,
                        'type' => $type,
                        'opening_balance' => $openingVal,
                        'balance_nature' => $balanceNature,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('chart_of_accounts')->insert([
                    'user_id' => $user->id,
                    'code' => $code,
                    'name' => $name,
                    'type' => $type,
                    'opening_balance' => $openingVal,
                    'balance_nature' => $balanceNature,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $imported++;
        }
        fclose($handle);

        return redirect()->route('reports')
            ->with('status', "Import selesai. {$imported} baris diproses.");
    }

    protected function codeMatchesPrefix(string $type, string $code): bool
    {
        $prefix = $this->coaPrefixes[$type] ?? null;
        if (! $prefix) return true;
        return str_starts_with($code, $prefix);
    }
}
