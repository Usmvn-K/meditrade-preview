<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * List ALL users (all roles) — Admin sees everything
     */
    public function index(Request $request)
    {
        $query = User::latest();

        // Get all unique roles present in DB for filter dropdown
        $allRoles = User::select('role')->distinct()->pluck('role')->filter()->values();

        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('role', 'like', "%$search%");
            });
        }

        $users = $query->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users', 'allRoles'));
    }

    /**
     * Show form to create a new user
     */
    public function create()
    {
        $cities        = City::orderBy('name')->get();
        $categories    = ServiceCategory::orderBy('name')->get();
        $existingRoles = User::select('role')->distinct()->pluck('role')->filter()->values();
        return view('admin.users.create', compact('cities', 'categories', 'existingRoles'));
    }

    /**
     * Store a new user with custom or preset role & permissions
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:8|confirmed',
            'role'        => 'required|string|max:100',
            'custom_role' => 'nullable|string|max:100',
            'city_id'     => 'nullable|exists:cities,id',
            'category_id' => 'nullable|exists:service_categories,id',
            'is_verified' => 'nullable|boolean',
            'permissions' => 'nullable|array',
        ]);

        // If 'custom' is selected or custom_role is provided
        if ($data['role'] === 'custom' || (!empty($request->custom_role) && $request->filled('custom_role'))) {
            $data['role'] = strtolower(trim($request->custom_role ?: 'custom'));
        } else {
            $data['role'] = strtolower(trim($data['role']));
        }

        unset($data['custom_role']);

        $data['password']    = Hash::make($data['password']);
        $data['is_verified'] = $request->boolean('is_verified');
        $data['permissions'] = $request->input('permissions', []);

        User::create($data);

        return redirect()->route('admin.users.index')
                         ->with('success', "User created successfully with role '{$data['role']}'.");
    }

    /**
     * Show user detail
     */
    public function show(User $user)
    {
        $bookings = $user->bookings()->latest()->with('service')->get();
        return view('admin.users.show', compact('user', 'bookings'));
    }

    /**
     * Show edit form
     */
    public function edit(User $user)
    {
        $cities        = City::orderBy('name')->get();
        $categories    = ServiceCategory::orderBy('name')->get();
        $existingRoles = User::select('role')->distinct()->pluck('role')->filter()->values();
        return view('admin.users.edit', compact('user', 'cities', 'categories', 'existingRoles'));
    }

    /**
     * Update a user
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'    => 'nullable|string|min:8|confirmed',
            'role'        => 'required|string|max:100',
            'custom_role' => 'nullable|string|max:100',
            'city_id'     => 'nullable|exists:cities,id',
            'category_id' => 'nullable|exists:service_categories,id',
            'is_verified' => 'nullable|boolean',
            'permissions' => 'nullable|array',
        ]);

        // Handle custom role
        if ($data['role'] === 'custom' || (!empty($request->custom_role) && $request->filled('custom_role'))) {
            $data['role'] = strtolower(trim($request->custom_role ?: 'custom'));
        } else {
            $data['role'] = strtolower(trim($data['role']));
        }

        unset($data['custom_role']);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_verified'] = $request->boolean('is_verified');
        $data['permissions'] = $request->input('permissions', []);

        $user->update($data);

        return redirect()->route('admin.users.index')
                         ->with('success', "User updated successfully with role '{$data['role']}'.");
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User deleted successfully.');
    }
}
