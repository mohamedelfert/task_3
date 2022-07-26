<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:users_read'])->only('index');
        $this->middleware(['permission:users_create'])->only('create');
        $this->middleware(['permission:users_update'])->only('edit');
        $this->middleware(['permission:users_delete'])->only('destroy');
    }

    public function index(Request $request)
    {
        $title = trans('site.users');
        $users = User::whereRoleIs('admin')->where(function ($q) use ($request) {
            return $q->when($request->search, function ($query) use ($request) {
                return $query->where('first_name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $request->search . '%');
            });
        })->latest()->paginate(10);
        return view('dashboard.users.index', compact('title', 'users'));
    }


    public function create()
    {
        $title = trans('site.users');
        return view('dashboard.users.create', compact('title'));
    }


    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'permissions' => 'required|min:1',
//            'image' => 'required|image|mimes:png,jpg,jpeg,gif',
            'image' => 'sometimes|nullable|image|mimes:png,jpg,jpeg,gif',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $data['password'] = bcrypt($request->password);

        if ($request->image) {
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/uploads/users_images/' . $request->image->hashName()));

            $data['image'] = $request->image->hashName();
        }

        $user = User::create($data);
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);

        session()->flash('success', trans('site.data_added_successfully'));
        return redirect()->route('dashboard.users.index');
    }


    public function show(User $user)
    {
        if($user->id !== auth()->user()->id){
            abort(403);
        }
        $title = trans('site.profile');
        return view('dashboard.users.show', compact('title', 'user'));
    }


    public function edit(User $user)
    {
        $title = trans('site.users');
        return view('dashboard.users.edit', compact('title', 'user'));
    }


    public function update(Request $request, User $user)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
//            'email' => 'required|email|unique:users,email,'.$user->id,
            'email' => ['required', Rule::unique('users')->ignore($user->id)],
            'permissions' => 'required|min:1',
//            'image' => 'required|image|mimes:png,jpg,jpeg,gif',
            'image' => 'sometimes|nullable|image|mimes:png,jpg,jpeg,gif',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $data = $request->except(['permissions', 'image']);

        if ($request->image) {

            if ($user->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/users_images/' . $user->image);
            }

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/uploads/users_images/' . $request->image->hashName()));

            $data['image'] = $request->image->hashName();

        }

        $user->update($data);
        $user->syncPermissions($request->permissions);

        session()->flash('success', trans('site.data_updated_successfully'));
        return redirect()->route('dashboard.users.index');
    }


    public function destroy(User $user)
    {
        if ($user->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/users_images/' . $user->image);
        }
        $user->delete();
        session()->flash('warning', trans('site.data_deleted_successfully'));
        return redirect()->back();
    }

    public function profile(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
//            'email' => ['required', Rule::unique('users')->ignore($id)],
            'password' => 'sometimes|nullable|confirmed',
            'image' => 'sometimes|nullable|image|mimes:png,jpg,jpeg,gif',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $data = $request->except(['password', 'password_confirmation', 'image']);

        if ($request->password != null){
            $data['password'] = bcrypt($request->password);
        }

        $user = User::findOrFail($id);

        if ($request->image) {

            if ($user->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/users_images/' . $user->image);
            }

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/uploads/users_images/' . $request->image->hashName()));

            $data['image'] = $request->image->hashName();

        }

        $user->update($data);

        session()->flash('success', trans('site.data_updated_successfully'));
        return redirect()->route('dashboard.users.index');
    }
}
