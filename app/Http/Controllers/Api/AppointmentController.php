<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Http\Resources\AppointmentResource;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Services\PHPMailerService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AppointmentController extends Controller
{
    public function index(Request $request) {
        $q = Appointment::query();

        if ($search = $request->string('search')->toString()){
            $q->where(function ($qq) use ($search) {
                $qq->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        $perPage = max(1, min(100, (int) $request->integer('perPage', 15)));

        $appointments = $q->orderByDesc('id')->paginate($perPage);

        return AppointmentResource::collection($appointments);
    }

    public function store(StoreAppointmentRequest $request, PHPMailerService $mailer)
    {
    //     Log::info('STORE HIT', [
    //     'driver'   => DB::connection()->getDriverName(),
    //     'database' => DB::connection()->getDatabaseName(),
    //     'payload'  => $request->all(),
    // ]);

        $appointment = Appointment::create($request->validated());

        try {
            // build HTML emails from Blade views
            $adminHtml = View::make('emails.appointment-admin', ['a' => $appointment])->render();
            $userHtml  = View::make('emails.appointment-user', ['a' => $appointment])->render();

            // send to admin
            $adminEmail = env('ADMIN_EMAIL', env('MAIL_FROM_ADDRESS'));
            $mailer->send(
                $adminEmail,
                'New Appointment Request',
                $adminHtml
            );

            // send confirmation to user
            if (!empty($appointment->email)) {
                $mailer->send(
                    $appointment->email,
                    'We received your appointment request',
                    $userHtml
                );
            }

            Log::info('Appointment emails sent', ['appointment_id' => $appointment->id]);
        } catch (\Throwable $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
        }



        return (new AppointmentResource($appointment))
        ->additional(['message' => 'Appointment created'])
        ->response()
        ->setStatusCode(201)
        ->header('Location', route('appointments.show', $appointment));
    }

    public function show(Appointment $appointment)
    {
        return new AppointmentResource($appointment);
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->validated());
        return (new AppointmentResource($appointment))
            ->additional(['message' => 'Appointment updated']);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json(['message' => 'Appointment deleted']);
    }
}
