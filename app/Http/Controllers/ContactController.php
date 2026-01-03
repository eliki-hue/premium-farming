<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Display contact page
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Handle contact form submission
     */
    public function send(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:2000'
        ]);

        try {
            // Save to database
            ContactMessage::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ]);

            // Send email notification to admin
            $this->sendEmailNotification($validated);

            // Send auto-reply to customer
            $this->sendAutoReply($validated);

            return redirect()->back()->with([
                'success' => 'Thank you for your message! We will contact you within 24 hours.',
                'form_submitted' => true
            ]);

        } catch (\Exception $e) {
            Log::error('Contact form submission failed: ' . $e->getMessage());
            
            return redirect()->back()->with([
                'error' => 'Sorry, there was an error sending your message. Please try again or call us directly.',
                'old_input' => $request->all()
            ])->withInput();
        }
    }

    /**
     * Send email notification to admin
     */
    private function sendEmailNotification($data)
    {
        try {
            Mail::send('emails.contact-notification', ['data' => $data], function ($message) use ($data) {
                $message->to('premiumfeeds@gmail.com')
                        ->cc(['admin@premiumfarmingfeeds.com'])
                        ->subject('New Contact Form Submission: ' . $data['subject'])
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
        } catch (\Exception $e) {
            Log::error('Contact notification email failed: ' . $e->getMessage());
        }
    }

    /**
     * Send auto-reply to customer
     */
    private function sendAutoReply($data)
    {
        try {
            Mail::send('emails.contact-auto-reply', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])
                        ->subject('Thank you for contacting Premium Farming Feeds')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
        } catch (\Exception $e) {
            Log::error('Contact auto-reply email failed: ' . $e->getMessage());
        }
    }

    /**
     * Display all contact messages (admin only)
     */
    public function messages()
    {
        $messages = ContactMessage::latest()->paginate(20);
        return view('admin.contact.messages', compact('messages'));
    }

    /**
     * Show individual message
     */
    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['read_at' => now()]);
        
        return view('admin.contact.show', compact('message'));
    }

    /**
     * Mark message as replied
     */
    public function markReplied($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['replied_at' => now()]);
        
        return back()->with('success', 'Message marked as replied.');
    }

    /**
     * Delete message
     */
    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();
        
        return back()->with('success', 'Message deleted successfully.');
    }
}