<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\Services\ServiceExceptions\WrongUserException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(private ProfileService $profileService)
    {
    }

    public function delete(Request $request)
    {
        $currentUser = Auth::user();

        try {
            $this->profileService->delete($currentUser);
        } catch (\Throwable $e) {
            return back()->withErrors(['errors' => 'Something goes wrong.']);
        }
        auth()->logout();

        return redirect('/')->with('success', 'Goodbye!');
    }
}
