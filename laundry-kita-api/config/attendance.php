<?php

return [
    // Dispensasi keterlambatan check-in (menit)
    'grace_minutes' => env('ATTENDANCE_GRACE_MINUTES', 15),

    // Apakah wajib GPS / selfie / fingerprint
    'require_gps' => env('ATTENDANCE_REQUIRE_GPS', true),
    'require_selfie' => env('ATTENDANCE_REQUIRE_SELFIE', false),
    'require_fingerprint' => env('ATTENDANCE_REQUIRE_FINGERPRINT', false),

    // Pengaturan geofence presensi
    'geofence' => [
        'center_lat' => env('ATTENDANCE_CENTER_LAT', -6.200000), // contoh Jakarta
        'center_lng' => env('ATTENDANCE_CENTER_LNG', 106.816666),
        'radius_m' => env('ATTENDANCE_RADIUS_M', 200), // meter
    ],
];
