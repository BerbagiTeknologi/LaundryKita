<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{
    public function edit()
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        return view('outlet.edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $validated = $request->validate([
            'outlet_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:25'],
            'province' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'timezone' => ['required', 'in:WIB,WITA,WIT'],
        ]);

        $user->update([
            'name' => $validated['outlet_name'],
            'phone' => $validated['phone'],
            'province' => $validated['province'] ?? null,
            'city' => $validated['city'] ?? null,
            'address' => $validated['address'] ?? null,
            'timezone' => $validated['timezone'],
        ]);

        return redirect()->route('outlet.edit')->with('status', 'Profil outlet berhasil diperbarui.');
    }

    public function hours()
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $hours = DB::table('outlet_hours')->where('user_id', $user->id)->get()->keyBy('day');

        return view('outlet.hours', compact('user', 'days', 'hours'));
    }

    public function updateHours(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $rules = [
            'days' => ['nullable', 'array'],
            'days.*' => ['in:' . implode(',', $days)],
        ];
        foreach ($days as $day) {
            $rules["open.$day"] = ['nullable', 'date_format:H:i'];
            $rules["close.$day"] = ['nullable', 'date_format:H:i'];
        }

        $validated = $request->validate($rules);

        $userId = $user->id;
        $selectedDays = collect($validated['days'] ?? []);

        DB::transaction(function () use ($days, $selectedDays, $validated, $userId) {
            foreach ($days as $day) {
                $isOpen = $selectedDays->contains($day);

                DB::table('outlet_hours')->updateOrInsert(
                    ['user_id' => $userId, 'day' => $day],
                    [
                        'is_open' => $isOpen,
                        'open_time' => $isOpen ? ($validated['open'][$day] ?? null) : null,
                        'close_time' => $isOpen ? ($validated['close'][$day] ?? null) : null,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        });

        return redirect()->route('outlet.hours')->with('status', 'Jam operasional berhasil diperbarui.');
    }

    public function pickup()
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $pickup = DB::table('outlet_pickup_windows')->where('user_id', $user->id)->first();

        return view('outlet.pickup', compact('user', 'pickup'));
    }

    public function updatePickup(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        // Normalize empty inputs to null so "nullable" rules pass
        $request->merge([
            'start_time' => $request->input('start_time') ?: null,
            'end_time' => $request->input('end_time') ?: null,
        ]);

        $validated = $request->validate([
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
        ]);

        DB::table('outlet_pickup_windows')->updateOrInsert(
            ['user_id' => $user->id],
            [
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return redirect()->route('outlet.pickup')->with('status', 'Jam antar jemput berhasil diperbarui.');
    }
}
