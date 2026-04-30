<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\User;
use App\Services\Mail\MailWorkflowService;
use Illuminate\Http\Request;

class AdminContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = trim((string) $request->query('search', ''));

        $memberEmails = User::query()
            ->whereNotNull('email')
            ->pluck('email')
            ->map(fn ($email) => strtolower((string) $email))
            ->all();

        $messages = ContactMessage::with(['repliedBy', 'user', 'replies.user'])
            ->when($status === 'replied', function ($query) {
                $query->whereNotNull('replied_at');
            })
            ->when($status === 'not_replied', function ($query) {
                $query->whereNull('replied_at');
            })
            ->when($status === 'unread', function ($query) {
                $query->whereNull('read_at');
            })
            ->when($status === 'read', function ($query) {
                $query->whereNotNull('read_at');
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('subject', 'like', '%' . $search . '%')
                        ->orWhere('message', 'like', '%' . $search . '%');
                });
            })
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.content.contact-messages', [
            'messages' => $messages,
            'filters' => [
                'status' => $status,
                'search' => $search,
            ],
            'stats' => [
                'total' => ContactMessage::count(),
                'unread' => ContactMessage::unread()->count(),
                'read' => ContactMessage::whereNotNull('read_at')->count(),
                'replied' => ContactMessage::whereNotNull('replied_at')->count(),
            ],
            'memberEmails' => $memberEmails,
        ]);
    }

    public function reply(Request $request, ContactMessage $contactMessage, MailWorkflowService $mailWorkflow)
    {
        $validated = $request->validate([
            'reply_message' => ['required', 'string', 'min:2', 'max:3000'],
        ]);

        $contactMessage->update([
            'reply_message' => $validated['reply_message'],
            'replied_by_user_id' => auth()->id(),
            'replied_at' => now(),
            'read_at' => $contactMessage->read_at ?: now(),
        ]);

        $contactMessage->replies()->create([
            'user_id' => auth()->id(),
            'message' => $validated['reply_message'],
        ]);

        $mailWorkflow->sendContactMessageReply($contactMessage->fresh(['repliedBy']));

        return redirect()->back()->with('success', 'Reply sent successfully.');
    }

    public function markRead(ContactMessage $contactMessage)
    {
        if ($contactMessage->read_at === null) {
            $contactMessage->update(['read_at' => now()]);
        }

        return redirect()->back()->with('success', 'Message marked as read.');
    }

    public function markUnread(ContactMessage $contactMessage)
    {
        $contactMessage->update(['read_at' => null]);

        return redirect()->back()->with('success', 'Message marked as unread.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()->back()->with('success', 'Message deleted.');
    }
}
