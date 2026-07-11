<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\MemberProfile;
use App\Models\MemberKyc;
use App\Models\FundRequest;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $profile = $user->profile;
        $kyv = $user->kyc;

        return view('pages.profile', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),

            'mobile' => 'nullable|max:20',
            'dob' => 'nullable|date',
            'gender' => 'nullable',

            'address' => 'nullable',
            'state' => 'nullable|max:100',
            'pincode' => 'nullable|max:20',

            'nominee_name' => 'nullable|max:150',
            'nominee_relation' => 'nullable|max:100',

            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $profile = MemberProfile::firstOrCreate([
            'user_id' => $user->id
        ]);

        $photo = $profile->profile_photo;

        if ($request->hasFile('profile_photo')) {

            if ($photo && file_exists(public_path($photo))) {
                unlink(public_path($photo));
            }

            $file = $request->file('profile_photo');

            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/profile'), $filename);

            $photo = 'uploads/profile/' . $filename;
        }

        $profile->update([
            'mobile' => $request->mobile,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'address' => $request->address,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'nominee_name' => $request->nominee_name,
            'nominee_relation' => $request->nominee_relation,
            'profile_photo' => $photo,
        ]);

        return back()->with('success', 'Profile Updated Successfully.');
    }

    public function changePassword()
    {
        return view('pages.change-password');
    }

    /**
     * Update Password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {

            return back()->withInput()->with('error', 'Current password is incorrect.');
        }

        // Prevent same password
        if (Hash::check($request->password, $user->password)) {

            return back()->withInput()->with('warning', 'New password cannot be the same as the current password.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }


    public function kyc()
    {
        $user = auth()->user();

        $kyc = MemberKyc::firstOrCreate([
            'user_id' => $user->id
        ]);

        return view('pages.kyc', compact('user', 'kyc'));
    }

    public function updateKyc(Request $request)
    {
        $request->validate([

            'pan_number' => 'required',

            'aadhaar_number' => 'required',

            'account_holder_name' => 'required',

            'bank_name' => 'required',

            'account_number' => 'required',

            'ifsc_code' => 'required',

            'branch_name' => 'required',

            'pan_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'aadhaar_front' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'aadhaar_back' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'passbook_image' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:4096',

        ]);

        $kyc = MemberKyc::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        $data = $request->except([
            'pan_image',
            'aadhaar_front',
            'aadhaar_back',
            'passbook_image'
        ]);

        foreach ([
            'pan_image',
            'aadhaar_front',
            'aadhaar_back',
            'passbook_image'
        ] as $file) {

            if ($request->hasFile($file)) {

                if (!empty($kyc->$file) && file_exists(public_path($kyc->$file))) {
                    unlink(public_path($kyc->$file));
                }

                $image = $request->file($file);

                $name = time() . '_' . $file . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('uploads/kyc'), $name);

                $data[$file] = 'uploads/kyc/' . $name;
            }
        }

        $data['status'] = 'Pending';

        $kyc->update($data);

        return back()->with('success', 'KYC submitted successfully.');
    }

    public function fundRequest()
    {
        $userId = auth()->id();

        // Recent Fund Requests
        $fundRequests = FundRequest::where('user_id', $userId)
                        ->latest()
                        ->paginate(10);

        // Dashboard Statistics
        $totalRequested = FundRequest::where('user_id', $userId)
                            ->sum('amount');

        $approvedFund = FundRequest::where('user_id', $userId)
                            ->where('status', 'Approved')
                            ->sum('amount');

        $pendingFund = FundRequest::where('user_id', $userId)
                            ->where('status', 'Pending')
                            ->sum('amount');

        return view('pages.fund-request', compact(
            'fundRequests',
            'totalRequested',
            'approvedFund',
            'pendingFund'
        ));
    }

    public function storeFundRequest(Request $request)
    {

        $request->validate([

            'amount'=>'required|numeric|min:1',

            'payment_mode'=>'required',

            'transaction_id'=>'required',

            'payment_date'=>'required|date',

            'depositor_name'=>'required',

            'payment_proof'=>'required|mimes:jpg,jpeg,png,pdf|max:4096',

            'remark'=>'nullable'

        ]);

        $proof='';

        if($request->hasFile('payment_proof')){

            $file=$request->file('payment_proof');

            $filename=time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/fund-proof'),$filename);

            $proof='uploads/fund-proof/'.$filename;

        }

        FundRequest::create([

            'user_id'=>auth()->id(),

            'amount'=>$request->amount,

            'payment_mode'=>$request->payment_mode,

            'transaction_id'=>$request->transaction_id,

            'payment_date'=>$request->payment_date,

            'depositor_name'=>$request->depositor_name,

            'payment_proof'=>$proof,

            'remark'=>$request->remark,

            'status'=>'Pending'

        ]);

        return redirect()->back()->with('success','Fund request submitted successfully.');

    }

    public function fundRequestList(Request $request)
    {
        $query = FundRequest::where('user_id', auth()->id());
        $columns = Schema::getColumnListing('fund_requests');

        // Filter by From Date
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        // Filter by To Date
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Payment Mode
        if ($request->filled('payment_mode')) {
            $query->where('payment_mode', $request->payment_mode);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search, $columns) {
                $searchableColumns = array_intersect(
                    ['request_id', 'transaction_id', 'depositor_name', 'remark', 'admin_remark'],
                    $columns
                );

                foreach ($searchableColumns as $column) {
                    $q->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        }

        $requests = $query->latest()->paginate(10)->withQueryString();

        return view('pages.fund-report', [
            'requests' => $requests,

            'totalRequests' => FundRequest::where('user_id', auth()->id())->count(),

            'approvedRequests' => FundRequest::where('user_id', auth()->id())
                ->where('status', 'Approved')
                ->count(),

            'pendingRequests' => FundRequest::where('user_id', auth()->id())
                ->where('status', 'Pending')
                ->count(),

            'rejectedRequests' => FundRequest::where('user_id', auth()->id())
                ->where('status', 'Rejected')
                ->count(),
        ]);
    }
}
