<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(20);
        $unreadCount = Contact::where('is_read', false)->count();
        return view('admin.contact.index', compact('contacts', 'unreadCount'));
    }

    public function show(Contact $contact)
    {
        if (!$contact->is_read) {
            $contact->markAsRead();
        }
        return view('admin.contact.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dihapus'
        ]);
    }

    public function markAsRead(Contact $contact)
    {
        $contact->markAsRead();
        return response()->json([
            'success' => true,
            'message' => 'Pesan ditandai sebagai sudah dibaca',
            'is_read' => $contact->is_read
        ]);
    }

    public function markAsReplied(Contact $contact)
    {
        $contact->markAsReplied();
        return response()->json([
            'success' => true,
            'message' => 'Pesan ditandai sebagai sudah dibalas',
            'is_replied' => $contact->is_replied
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contacts,id',
        ]);

        Contact::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' pesan berhasil dihapus'
        ]);
    }

    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 20;
        $status = $request->get('status', 'all');

        $query = Contact::orderBy('created_at', 'desc');

        if ($status === 'unread') {
            $query->where('is_read', false);
        } elseif ($status === 'read') {
            $query->where('is_read', true)->where('is_replied', false);
        } elseif ($status === 'replied') {
            $query->where('is_replied', true);
        }

        $contacts = $query->paginate($perPage, ['*'], 'page', $page);

        // 🔥 Jika tidak ada data, kirim HTML kosong
        $html = '';
        foreach ($contacts as $contact) {
            $html .= view('admin.contact._item', compact('contact'))->render();
        }

        return response()->json([
            'success' => true,
            'html' => $html,
            'hasMore' => $contacts->hasMorePages(),
            'currentPage' => $contacts->currentPage(),
            'total' => $contacts->total(),
        ]);
    }
}