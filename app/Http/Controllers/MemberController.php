<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Models\MemberProfile;
use App\Models\MemberKyc;
use App\Models\FundRequest;
use App\Models\User;

class MemberController extends Controller
{
   public function create()
   {
    $user = auth()->user();
    $totalDirect = User::where('sponsor_id', $user->member_id)->count();
    $members = User::where('sponsor_id', auth()->user()->member_id)
                    ->latest()
                    ->paginate(5);
     return view('pages.add-member',compact('user','members','totalDirect'));
   }
   public function store(Request $request)
    {
        $request->validate([

            'name'=>'required',

            'mobile'=>'required|unique:users,mobile',

            'email'=>'nullable|email|unique:users,email',

            'password'=>'required|confirmed|min:6',

        ]);

        DB::beginTransaction();

        try{

            $user = User::create([

                'member_id'=>$this->generateMemberId(),

                'sponsor_id'=>auth()->user()->member_id,

                'name'=>$request->name,

                'mobile'=>$request->mobile,

                'email'=>$request->email,

                'password'=>Hash::make($request->password),

                'role'=>'member',

                'status'=>'Active',

                'main_wallet'=>0,

            ]);

            MemberProfile::create([

                'user_id'=>$user->id,

                'address'=>$request->address,

                'state'=>$request->state,

                'pin_code'=>$request->pin_code,

            ]);

            DB::commit();

            return back()->with('success','Member Registered Successfully.');

        }catch(\Exception $e){

            DB::rollBack();

            return back()->with('error',$e->getMessage());

        }

    }

    private function generateMemberId()
    {
        $last = User::latest()->first();

        if(!$last){

            return 'ARM1001';

        }

        return 'ARM'.($last->id+1001);
    }

    public function memberList(Request $request)
    {
        $query = User::where('sponsor_id', auth()->user()->member_id);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('member_id', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $members = $query->latest()->paginate(10);
        
        return view('pages.direct-member', compact('members'));
    }

    public function memberDetails($id)
    {
        $member = User::withCount('children')->findOrFail($id);

        return response()->json([
            'name' => $member->name,
            'member_id' => $member->member_id,
            'mobile' => $member->mobile,
            'email' => $member->email,
            'sponsor' => optional($member->sponsor)->member_id,
            'joining' => $member->created_at->format('d M Y'),
            'package' => $member->package_name ?? 'Not Purchased',
            'kyc' => ucfirst($member->kyc_status),
            'status' => ucfirst($member->status),
            'team' => $member->children_count,
            'address' => $member->memberProfile->address ?? '-',
            'photo' => $member->profile_photo
                ? asset('storage/'.$member->profile_photo)
                : asset('images/default-user.png'),
        ]);
    }
}
