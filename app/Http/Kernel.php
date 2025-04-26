protected $routeMiddleware = [
// Other middleware
'doctor' => \App\Http\Middleware\EnsureDoctorRole::class,
];