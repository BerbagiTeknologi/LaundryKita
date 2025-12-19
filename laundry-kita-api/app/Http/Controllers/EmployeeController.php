<?php

namespace App\Http\Controllers;

use App\Services\AttendanceService;
use App\Models\Shift;
use App\Models\EmployeeGrade;
use App\Models\Employee;
use App\Models\AttendanceRule;
use App\Models\AttendanceRuleItem;
use App\Models\AttendanceRulePoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Halaman kelola pegawai dengan data dummy yang selaras UI.
     */
    public function manage(AttendanceService $attendanceService)
    {
        $shifts = Shift::all()->toArray();
        $attendanceRules = $attendanceService->getRulesSummary();
        $grades = EmployeeGrade::all()->toArray();
        $ruleItems = AttendanceRuleItem::all();
        $employees = Employee::with(['grade', 'shift'])->get();
        $rulePoints = AttendanceRulePoint::all();
        $attendanceStatuses = [
            'hadir' => 'Hadir',
            'terlambat' => 'Terlambat',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
        ];
        $jobStatuses = [
            'mencuci' => 'Sedang mencuci',
            'istirahat' => 'Istirahat',
            'antar' => 'Antar baju ke pelanggan',
            'validasi' => 'Validasi/cek kualitas',
            'lainnya' => 'Lainnya',
        ];

        return view('employees.manage', [
            'shifts' => $shifts,
            'attendanceRules' => $attendanceRules,
            'grades' => $grades,
            'ruleItems' => $ruleItems,
            'employees' => $employees,
            'rulePoints' => $rulePoints,
            'attendanceStatuses' => $attendanceStatuses,
            'jobStatuses' => $jobStatuses,
        ]);
    }

    /**
     * Simpan shift baru.
     */
    public function storeShift(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'days' => 'nullable|string|max:100',
            'quota' => 'required|integer|min:0',
        ]);

        Shift::create($validated);

        return redirect()->route('employees.manage', '#shift')->with('status', 'Shift baru disimpan.');
    }

    /**
     * Perbarui shift.
     */
    public function updateShift(Request $request, Shift $shift)
    {
        $validated = $request->validate([
          'name' => 'required|string|max:50',
          'start_time' => 'required|date_format:H:i',
          'end_time' => 'required|date_format:H:i',
          'days' => 'nullable|string|max:100',
          'quota' => 'required|integer|min:0',
        ]);

        $shift->update($validated);

        return redirect()->route('employees.manage', '#shift')->with('status', 'Shift diperbarui.');
    }

    /**
     * Hapus shift.
     */
    public function deleteShift(Shift $shift)
    {
        $shift->delete();
        return redirect()->route('employees.manage', '#shift')->with('status', 'Shift dihapus.');
    }

    /**
     * Simpan golongan pegawai.
     */
    public function storeGrade(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:5',
            'role' => 'required|string|max:100',
            'allowance' => 'nullable|integer|min:0',
            'benefit' => 'nullable|string|max:150',
        ]);

        EmployeeGrade::create($validated);

        return redirect()->route('employees.manage', '#golongan')->with('status', 'Golongan pegawai disimpan.');
    }

    /**
     * Perbarui golongan pegawai.
     */
    public function updateGrade(Request $request, EmployeeGrade $grade)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:5',
            'role' => 'required|string|max:100',
            'allowance' => 'nullable|integer|min:0',
            'benefit' => 'nullable|string|max:150',
        ]);

        $grade->update($validated);

        return redirect()->route('employees.manage', '#golongan')->with('status', 'Golongan pegawai diperbarui.');
    }

    /**
     * Hapus golongan pegawai.
     */
    public function deleteGrade(EmployeeGrade $grade)
    {
        $grade->delete();
        return redirect()->route('employees.manage', '#golongan')->with('status', 'Golongan pegawai dihapus.');
    }

    /**
     * Simpan pegawai.
     */
    public function storeEmployee(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'grade_id' => 'nullable|exists:employee_grades,id',
            'shift_id' => 'nullable|exists:shifts,id',
            'attendance_status' => 'nullable|string|max:30',
            'job_status' => 'nullable|string|max:50',
            'contact' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:8',
        ]);

        $password = $validated['password'] ?? '12345678';

        Employee::create([
            'name' => $validated['name'],
            'grade_id' => $validated['grade_id'] ?? null,
            'shift_id' => $validated['shift_id'] ?? null,
            'attendance_status' => $validated['attendance_status'] ?? null,
            'job_status' => $validated['job_status'] ?? null,
            'contact' => $validated['contact'] ?? null,
            'password' => Hash::make($password),
        ]);

        return redirect()->route('employees.manage', '#pegawai')->with('status', 'Pegawai disimpan.');
    }

    /**
     * Update pegawai.
     */
    public function updateEmployee(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'grade_id' => 'nullable|exists:employee_grades,id',
            'shift_id' => 'nullable|exists:shifts,id',
            'attendance_status' => 'nullable|string|max:30',
            'job_status' => 'nullable|string|max:50',
            'contact' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:8',
        ]);

        $update = [
            'name' => $validated['name'],
            'grade_id' => $validated['grade_id'] ?? null,
            'shift_id' => $validated['shift_id'] ?? null,
            'attendance_status' => $validated['attendance_status'] ?? null,
            'job_status' => $validated['job_status'] ?? null,
            'contact' => $validated['contact'] ?? null,
        ];
        if (!empty($validated['password'])) {
            $update['password'] = Hash::make($validated['password']);
        }

        $employee->update($update);

        return redirect()->route('employees.manage', '#pegawai')->with('status', 'Pegawai diperbarui.');
    }

    /**
     * Hapus pegawai.
     */
    public function deleteEmployee(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.manage', '#pegawai')->with('status', 'Pegawai dihapus.');
    }

    /**
     * Simpan aturan presensi (geofence & grace).
     */
    public function saveAttendanceRule(Request $request)
    {
        $validated = $request->validate([
            'grace_minutes' => 'required|integer|min:0|max:120',
            'require_gps' => 'nullable|boolean',
            'require_selfie' => 'nullable|boolean',
            'require_fingerprint' => 'nullable|boolean',
            'geofence_lat' => 'required|numeric|between:-90,90',
            'geofence_lng' => 'required|numeric|between:-180,180',
            'geofence_radius_m' => 'required|integer|min:50|max:5000',
        ]);

        $payload = [
            'grace_minutes' => $validated['grace_minutes'],
            'require_gps' => (bool) ($validated['require_gps'] ?? false),
            'require_selfie' => (bool) ($validated['require_selfie'] ?? false),
            'require_fingerprint' => (bool) ($validated['require_fingerprint'] ?? false),
            'geofence_lat' => $validated['geofence_lat'],
            'geofence_lng' => $validated['geofence_lng'],
            'geofence_radius_m' => $validated['geofence_radius_m'],
        ];

        $rule = AttendanceRule::query()->first();
        if ($rule) {
            $rule->update($payload);
        } else {
            $rule = AttendanceRule::create($payload + ['name' => 'default']);
        }

        // waypoint tambahan
        $pointsLat = $request->input('waypoints_lat', []);
        $pointsLng = $request->input('waypoints_lng', []);
        $pointsRadius = $request->input('waypoints_radius', []);
        $pointsName = $request->input('waypoints_name', []);

        $rule->points()->delete();
        $points = [];
        $count = min(count($pointsLat), count($pointsLng), count($pointsRadius));
        for ($i = 0; $i < $count; $i++) {
            if ($pointsLat[$i] === null || $pointsLng[$i] === null || $pointsRadius[$i] === null) {
                continue;
            }
            $points[] = new AttendanceRulePoint([
                'lat' => (float) $pointsLat[$i],
                'lng' => (float) $pointsLng[$i],
                'radius_m' => (int) $pointsRadius[$i],
                'name' => $pointsName[$i] ?? null,
            ]);
        }
        if (!empty($points)) {
            $rule->points()->saveMany($points);
            // set center ke waypoint pertama agar kompatibel dengan UI lama
            $first = $points[0];
            $rule->update([
                'geofence_lat' => $first->lat,
                'geofence_lng' => $first->lng,
                'geofence_radius_m' => $first->radius_m,
            ]);
        }

        return redirect()->route('employees.manage', '#presensi')->with('status', 'Aturan presensi diperbarui.');
    }

    /**
     * Hapus/reset aturan presensi.
     */
    public function deleteAttendanceRule()
    {
        if ($rule = AttendanceRule::query()->first()) {
            $rule->points()->delete();
            $rule->delete();
        }
        return redirect()->route('employees.manage', '#presensi')->with('status', 'Aturan presensi dihapus.');
    }

    /**
     * Simpan poin kontrol presensi (rule item).
     */
    public function storeRuleItem(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'icon_class' => 'nullable|string|max:100',
        ]);

        AttendanceRuleItem::create($validated);

        return redirect()->route('employees.manage', '#presensi')->with('status', 'Poin kontrol presensi ditambahkan.');
    }

    /**
     * Hapus poin kontrol presensi.
     */
    public function deleteRuleItem(AttendanceRuleItem $item)
    {
        $item->delete();
        return redirect()->route('employees.manage', '#presensi')->with('status', 'Poin kontrol presensi dihapus.');
    }

    /**
     * Check-in presensi dengan validasi geofence.
     */
    public function checkIn(Request $request, AttendanceService $attendanceService)
    {
        $validated = $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'selfie' => 'nullable|file|image|max:2048',
        ]);

        $result = $attendanceService->validateLocation((float) $validated['lat'], (float) $validated['lng']);
        if (! $result['allowed']) {
            return response()->json([
                'status' => 'denied',
                'message' => 'Anda berada di luar jangkauan lokasi yang diizinkan untuk presensi.',
                'distance_m' => $result['distance_m'],
            ], 403);
        }

        // Placeholder pencatatan presensi (belum disimpan DB)
        return response()->json([
            'status' => 'ok',
            'message' => 'Check-in berhasil',
            'distance_m' => $result['distance_m'],
        ]);
    }
}
