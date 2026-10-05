<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\verificationCodeMail;
class AdminController extends Controller
{
    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function AdminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Bypassed 2FA for development
            /*
            $user = Auth::user();

            $verifiacationCode = random_int(100000,999999);
            session(['verification_code'=>$verifiacationCode,'user_id'=>$user->id]);
            Mail::to($user->email)->send(new verificationCodeMail($verifiacationCode)); 

            Auth :: logout();

            return redirect()->route('custom.verification.form')->with('status', 'Verification code sent to your email.');
            */

            return redirect()->intended('/dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials provided.']);
    }
    public function ShowVerification()
    {
        return view('auth.verify');

    }
    public function VerificationVerify(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);

        if ($request->code == session('verification_code')) {
            Auth::loginUsingId(session('user_id'));

            session()->forget(['verification_code', 'user_id']);

            return redirect()->intended('/dashboard');

        }

        return back()->withErrors(['code' => 'Invalid verification code.']);
    }

    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile', compact('profileData'));
    }

    public function ProfileStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|max:10240', // Limit to 10MB
        ]);

        $id = Auth::user()->id;
        $data = User::find($id);
        
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        $oldPhotoPath = $data->photo;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/user_images'), $filename);
            $data->photo = $filename;

            if ($oldPhotoPath && $oldPhotoPath != $filename) {
                $this->deleteOldImage($oldPhotoPath);
            }
        }

        $data->save();

        $notification = array(
            'message' => 'Profile updated successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    private function deleteOldImage(string $oldPhotoPath): void
    {
        $fullpath = public_path('upload/user_images/' . $oldPhotoPath);
        if (file_exists($fullpath)) {
            @unlink($fullpath);
        }
    }

    public function PasswordUpdate(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            $notification = array(
                'message' => 'Old password does not match!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

        // Update database record
        User::whereId($user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        Auth::logout();

        $notification = array(
            'message' => 'Password changed successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('login')->with($notification);
    }
}
