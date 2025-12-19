<?php

namespace App\Services;

use App\Models\AttendanceRule;
use App\Models\AttendanceRulePoint;

class AttendanceService
{
    /**
     * Cek apakah koordinat berada dalam radius yang diizinkan.
     */
    public function validateLocation(float $lat, float $lng): array
    {
        $rule = $this->getActiveRule();
        $points = $rule?->points ?? collect();

        // fallback ke single center jika tidak ada poin
        if ($points->isEmpty()) {
            $centerLat = $rule?->geofence_lat ?? (float) config('attendance.geofence.center_lat');
            $centerLng = $rule?->geofence_lng ?? (float) config('attendance.geofence.center_lng');
            $radius = $rule?->geofence_radius_m ?? (float) config('attendance.geofence.radius_m');

            if (! $centerLat || ! $centerLng || ! $radius) {
                return ['allowed' => false, 'distance_m' => null];
            }

            $distance = $this->haversineDistance($lat, $lng, $centerLat, $centerLng);
            return [
                'allowed' => $distance <= $radius,
                'distance_m' => round($distance, 2),
            ];
        }

        $minDistance = null;
        $allowed = false;
        foreach ($points as $p) {
            $d = $this->haversineDistance($lat, $lng, (float) $p->lat, (float) $p->lng);
            $minDistance = is_null($minDistance) ? $d : min($minDistance, $d);
            if ($d <= (float) $p->radius_m) {
                $allowed = true;
                break;
            }
        }

        return [
            'allowed' => $allowed,
            'distance_m' => is_null($minDistance) ? null : round($minDistance, 2),
        ];
    }

    /**
     * Ringkasan aturan presensi untuk ditampilkan di UI.
     */
    public function getRulesSummary(): array
    {
        $rule = $this->getActiveRule();
        return [
            'grace_minutes' => $rule?->grace_minutes ?? config('attendance.grace_minutes', 15),
            'require_gps' => $rule?->require_gps ?? config('attendance.require_gps', true),
            'require_selfie' => $rule?->require_selfie ?? config('attendance.require_selfie', false),
            'require_fingerprint' => $rule?->require_fingerprint ?? config('attendance.require_fingerprint', false),
            'radius_m' => $rule?->geofence_radius_m ?? config('attendance.geofence.radius_m'),
            'center' => [
                'lat' => $rule?->geofence_lat ?? config('attendance.geofence.center_lat'),
                'lng' => $rule?->geofence_lng ?? config('attendance.geofence.center_lng'),
            ],
            'points' => $rule?->points?->map(function ($p) {
                return [
                    'lat' => (float) $p->lat,
                    'lng' => (float) $p->lng,
                    'radius_m' => (int) $p->radius_m,
                ];
            })->values()->toArray() ?? [],
        ];
    }

    /**
     * Ambil aturan aktif (satu baris) bila ada di DB.
     */
    public function getActiveRule(): ?AttendanceRule
    {
        return AttendanceRule::query()->first();
    }

    /**
     * Haversine distance dalam meter.
     */
    private function haversineDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371000; // meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
