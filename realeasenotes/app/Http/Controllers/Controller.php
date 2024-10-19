<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
class Controller extends BaseController
{


}
namespace App\Http\Controllers;

use App\Models\Release;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ReleaseController extends Controller
{
    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        return view('release_form', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'main_text' => 'required',
            'version' => 'required|regex:/^\d{1,2}\.\d{1,2}$/',
            'release_date' => 'required|date',
            'project_id' => 'required|exists:projects,id',
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
            'media' => 'nullable|file',
            'link' => 'nullable|url',
            'is_protected' => 'boolean',
        ]);

        $release = Release::create($validatedData);
        $release->users()->sync($request->users);

        return redirect()->route('releases.index')->with('success', 'Реліз успішно створено!');
    }

    public function edit(Release $release)
    {
        $projects = Project::all();
        $users = User::all();
        return view('release_form', compact('release', 'projects', 'users'));
    }

    public function update(Request $request, Release $release)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'main_text' => 'required',
            'version' => 'required|regex:/^\d{1,2}\.\d{1,2}$/',
            'release_date' => 'required|date',
            'project_id' => 'required|exists:projects,id',
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
            'media' => 'nullable|file',
            'link' => 'nullable|url',
            'is_protected' => 'boolean',
        ]);

        $release->update($validatedData);
        $release->users()->sync($request->users);

        return redirect()->route('releases.index')->with('success', 'Реліз успішно оновлено!');
    }
}
