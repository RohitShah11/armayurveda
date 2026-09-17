<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceInquiry;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceInquiryController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate(['type' => ['nullable', Rule::in(['loan', 'hotel'])]]);
        $inquiries = ServiceInquiry::with('user')->when($filters['type'] ?? null, fn ($query, $type) => $query->where('type', $type))->latest()->paginate(20)->withQueryString();

        return view('admin.service-inquiries.index', compact('inquiries'));
    }

    public function show(ServiceInquiry $inquiry)
    {
        $inquiry->load('user');

        return view('admin.service-inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, ServiceInquiry $inquiry)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(ServiceInquiry::statuses($inquiry->type))],
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);
        $inquiry->update($data + ['reviewed_by' => $request->user('admin')->id, 'reviewed_at' => now()]);

        return back()->with('success', 'Request updated. The member can now see this status and note.');
    }
}
