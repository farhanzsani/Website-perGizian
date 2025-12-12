<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::with('roles')->latest();
            
            // Search Filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            
            // Role Filter
            if ($request->has('role') && !empty($request->role)) {
                $query->whereHas('roles', function($q) use ($request) {
                    $q->where('name', $request->role);
                });
            }
            
            // Pagination
            $limit = $request->input('limit', 10);
            $users = $query->paginate($limit);
            
            // Calculate Stats (Global counts, independent of pagination/search)
            // Note: If you want stats to respect search filters, move this after search logic but before pagination.
            // Usually dashboard stats are global, so we'll query fresh.
            $stats = [
                'total_users' => User::count(),
                'total_admins' => User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->count(),
                'total_regular_users' => User::whereHas('roles', fn($q) => $q->where('name', 'user'))->count(),
            ];

            return response()->json([
                'pagination' => $users,
                'stats' => $stats
            ]);
        }
        
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.users.index', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole($request->role);

            // Optional: Create profile entry if role is 'user'
            if ($request->role === 'user') {
                 // Logic untuk membuat entri tabel pengguna jika diperlukan
                 // $user->pengguna()->create([]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'User berhasil dibuat.',
                'data' => $user
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return response()->json([
            'status' => 'success',
            'data' => $user->load('roles')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $data = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            $user->syncRoles([$request->role]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'User berhasil diperbarui.',
                'data' => $user
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();
            
            // Delete related profile/data if exists? 
            // On delete cascade usually handles it, but good to be aware.
            
            $user->delete();
            
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'User berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus user: ' . $e->getMessage()
            ], 500);
        }
    }
}
