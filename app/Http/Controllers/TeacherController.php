<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB ;
use Illuminate\Validation\ValidationException;

use function Laravel\Prompts\error;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher = Teacher::orderBy('id','desc')->get();
        return view('admin.teachers.index',[
            'teacher' => $teacher
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Data tidak ditemukan'
            ]);
        }

        if ($user->hasRole('teacher')) {
            return back()->withErrors([
                'email' => 'Email tersebut telah menjadi guru'
            ]);
        }

        DB::transaction(function () use ($user, $validated) {

            $validated['user_id'] = $user->id;     
            $validated['is_active'] =true;     

            Teacher::create($validated);

            if ($user->hasRole('student')) {
                $user->removeRole('student');
            }
            $user->assignRole('teacher');
        });

        return redirect()->route('admin.teacher.index'); 
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        try {
            $teacher->delete();
            $user = User::find($teacher->user_id);
            $user->removeRole('teacher');
            $user->assignRole('student');

        } catch (\Throwable $th) {
            DB::rollBack();
            $error = ValidationException::withMessages([
                'system_error' => ['System error!'.$th->getMessage()]
            ]);
            throw $error;
        }
        return redirect()->route('admin.teacher.index');
    }
}
