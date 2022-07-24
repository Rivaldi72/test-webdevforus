<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Models\Role;
use App\Models\Member;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Member::with('group')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return
                        '<button class="btn btn-success mr-1" onclick="updateData(this)" 
                            data-id="' . $item->id . '" 
                            data-name="' . $item->name . '"
                            data-address="' . $item->address . '"
                            data-phone="' . $item->phone . '"
                            data-email="' . $item->email . '"
                            data-profile_pic="' . $item->profile_pic . '" >
                            <i class="fa fa-refresh"></i>
                        </button>
                        <button class="btn btn-danger" onclick="deleteData(this)" data-id="' . $item->id . '">
                            <i class="fa fa-trash"></i>
                        </button>';
                })
                ->editColumn('created_at', function ($item) {
                    return Carbon::parse($item->created_at)->format('d-m-Y H:i:s');
                })
                ->rawColumns([
                    'action',
                    'created_at'
                ])
                ->make(true);
        }
        $groups = Group::get();
        return view('pages.member.index', compact('groups'));
    }

    public function store(MemberRequest $request)
    {
        $validated = $request->validated();
        Member::create(
        [
            'group_id'      => $validated['group_id'],
            'name'          => $validated['name'],
            'address'       => $validated['address'],
            'phone'         => $validated['phone'],
            'email'         => $validated['email'],
            'profile_pic'   => $validated['profile_pic'],
        ]);

        return response()->json([
            'status'    => true,
            'message'   => 'Member Created '
        ], 200);
    }

    public function update(MemberRequest $request, Member $member)
    {
        $validated = $request->validated();
        $member->update([
            'group_id'      => $validated['group_id'],
            'name'          => $validated['name'],
            'address'       => $validated['address'],
            'phone'         => $validated['phone'],
            'email'         => $validated['email'],
            'profile_pic'   => $validated['profile_pic'],
        ]);
        return response()->json([
            'status'    => true,
            'message'   => 'Success Mengubah Data'
        ], 200);
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return response()->json([
            'status'    => true,
            'message'   => 'Success Menghapus Data'
        ], 200);
    }
}
