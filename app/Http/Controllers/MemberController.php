<?php
namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\MemberApproved;
use App\Events\NewMemberRegistered;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();
    
        // Filter pencarian
        if ($request->filled('search') && $request->filled('filter_by')) {
            $search = $request->search;
            $filterBy = $request->filter_by;
    
            if ($filterBy === 'registered_at') {
                $query->whereDate('registered_at', $search);
            } else {
                $query->where($filterBy, 'like', '%' . $search . '%');
            }
        }
    
        // Filter status
        if ($request->filled('status')) {
            $query->where('membership_status', $request->status);
        }
    
        $members = $query->latest()->paginate(10)->withQueryString();
    
        return view('members.index', compact('members'));
    }
    

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:members',
            'phone' => 'required',
            'address' => 'required'
        ]);

        $member = new Member();
        $member->user_id = auth()->id(); // Simpan user_id dari yang login
        $member->name = $request->name;
        $member->email = $request->email;
        $member->phone = $request->phone;
        $member->address = $request->address;
        $member->save();

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $member = Member::find($id);

        if (!$member) {
            dd("Data tidak ditemukan untuk ID: " . $id);
        }
    
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);
    
        $member->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
    
        return response()->json(['success' => 'Member updated successfully']);
    
       }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }

    public function approve($id)
{
    $member = Member::findOrFail($id);
    $member->update(['membership_status' => 'approved']);

    return back()->with('success', 'Anggota berhasil di-approve.');
}
}
