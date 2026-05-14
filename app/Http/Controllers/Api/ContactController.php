<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Resources\ContactResource;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Services\PHPMailerService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ContactController extends Controller
{
    public function index(Request $request) {
        $q = Contact::query();

        if ($search = $request->string('search')->toString()){
            $q->where(function ($qq) use ($search) {
                $qq->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        $perPage = max(1, min(100, (int) $request->integer('perPage', 15)));

        $contact = $q->orderByDesc('id')->paginate($perPage);

        return ContactResource::collection($contact);
    }

    public function store(StoreContactRequest $request, PHPMailerService $mailer)
    {
    //     Log::info('STORE HIT', [
    //     'driver'   => DB::connection()->getDriverName(),
    //     'database' => DB::connection()->getDatabaseName(),
    //     'payload'  => $request->all(),
    // ]);

        $contact = Contact::create($request->validated());

        try {
            // build HTML emails from Blade views
            $adminHtml = View::make('emails.contact-admin', ['a' => $contact])->render();
            $userHtml  = View::make('emails.contact-user', ['a' => $contact])->render();

            // send to admin
            $adminEmail = env('ADMIN_EMAIL', env('MAIL_FROM_ADDRESS'));
            $mailer->send(
                $adminEmail,
                'New Contact Request',
                $adminHtml
            );

            // send confirmation to user
            if (!empty($contact->email)) {
                $mailer->send(
                    $contact->email,
                    'We received your question',
                    $userHtml
                );
            }

            Log::info('Contact emails sent', ['contacts_id' => $contact->id]);
        } catch (\Throwable $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
        }



        return (new ContactResource($contact))
        ->additional(['message' => 'Contact created'])
        ->response()
        ->setStatusCode(201)
        ->header('Location', route('contacts.show', $contact));
    }

    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contact->update($request->validated());
        return (new ContactResource($contact))
            ->additional(['message' => 'Contact updated']);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json(['message' => 'Contact deleted']);
    }
}
