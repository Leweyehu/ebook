<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display contact page with form
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * Store contact message from public
     */
    /**
 * Store contact message from public
 */
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    // Add only status for now, remove ip_address and user_agent
    $validated['status'] = 'unread';

    Contact::create($validated);

    return redirect()->route('contact')->with('success', 'Your message has been sent successfully! We will get back to you soon.');
}

    /**
     * Admin: View all messages
     */
    public function admin()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        $stats = [
            'total' => Contact::count(),
            'unread' => Contact::where('status', 'unread')->count(),
            'read' => Contact::where('status', 'read')->count(),
            'replied' => Contact::where('status', 'replied')->count(),
        ];
        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Admin: View single message
     */
    public function show(Contact $contact)
    {
        // Mark as read if unread
        $contact->markAsRead();
        
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Admin: Reply to message
     */
    public function reply(Request $request, Contact $contact)
    {
        $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $contact->update([
            'admin_reply' => $request->admin_reply,
            'status' => 'replied',
            'replied_at' => now(),
            'replied_by' => Auth::id(),
        ]);

        // Optional: Send email notification to user
        // You can implement Mail functionality here

        return redirect()->route('admin.contacts.show', $contact)->with('success', 'Reply sent successfully!');
    }

    /**
     * Admin: Delete message
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Message deleted successfully!');
    }

    /**
     * Admin: Mark as read
     */
    public function markAsRead(Contact $contact)
    {
        $contact->markAsRead();
        return redirect()->back()->with('success', 'Message marked as read.');
    }

    /**
     * Admin: Bulk delete old messages
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:30'
        ]);

        $date = now()->subDays($request->days);
        $deleted = Contact::where('created_at', '<', $date)->delete();

        return redirect()->route('admin.contacts.index')->with('success', "$deleted old messages deleted successfully.");
    }
}