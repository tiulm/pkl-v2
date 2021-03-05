<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\User;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = User::findOrFail(Auth::user()->id);
        $user = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('users.id', '=', $profile->id)->first();
        $role = ($user->role_name);
        return view('profile.profile', array('user' => Auth::user()), compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $user = User::findOrFail($id);
        request()->validate(
            [
                'image_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2000',
                'email' => 'nullable|email',
                'telp' => 'nullable|numeric|min:11'
            ],
            [
                'image' => 'Files yang di-upload harus merupakan Foto dengan ekstensi jpeg, png, atau jpg',
                'mimes' => 'Ekstensi file harus jpeg, png, atau jpg',
                'email' => 'Format email tidak sesuai',
                'numeric' => 'Hanya boleh di isi menggunakan angka',
                'min' => 'Minimal :min karakter',
                'max' =>  'Ukuran foto tidak boleh lebih dari :max kilobyter',
            ]
        );

        if ($files = $request->file('image_profile')) {
            $destinationPath = 'public/image/'; // upload path
            $profileImage = time() . "." . $files->getClientOriginalExtension();
            Image::make($files)->resize(300, 300)->save($destinationPath . $profileImage);
            $user->image_profile = $profileImage;
        }
        $user->email = $request->input('email');
        $user->phone_number = $request->input('telp');

        $user->save();
        return redirect('profil')->with('success', 'Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
