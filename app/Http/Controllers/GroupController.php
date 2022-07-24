<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Role;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Group::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return
                        '<button class="btn btn-success mr-1" onclick="updateData(this)" 
                            data-id="' . $item->id . '" 
                            data-name="' . $item->name . '"
                            data-city="' . $item->city . '" >
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
        return view('pages.group.index');
    }

    public function store(GroupRequest $request)
    {
        $validated = $request->validated();
        Group::create(
        [
            'name'      => $validated['name'],
            'city'      => $validated['city'],
        ]);

        return response()->json([
            'status'    => true,
            'message'   => 'Group Created '
        ], 200);
    }

    public function update(GroupRequest $request, Group $group)
    {
        $validated = $request->validated();
        $group->update([
            'name'      => $validated['name'] ?? $group->name,
            'city'      => $validated['city'] ?? $group->city,
        ]);
        return response()->json([
            'status'    => true,
            'message'   => 'Success Mengubah Data'
        ], 200);
    }

    public function destroy(Group $group)
    {
        $group->delete();

        return response()->json([
            'status'    => true,
            'message'   => 'Success Menghapus Data'
        ], 200);
    }
}
