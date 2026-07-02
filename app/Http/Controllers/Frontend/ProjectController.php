<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $query = Project::active()->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        $projects = $query->paginate(12);
        $categories = Category::ofType('project')->active()->withCount('projects')->get();

        return view('frontend.projects.index', compact('projects', 'categories'));
    }

    public function show(string $slug): View
    {
        $project = Project::where('slug', $slug)->where('is_active', true)
            ->with('category', 'tags')
            ->firstOrFail();

        $relatedProjects = Project::active()
            ->where('id', '!=', $project->id)
            ->when($project->category_id, fn ($q) => $q->where('category_id', $project->category_id))
            ->limit(3)->get();

        $prevProject = Project::active()->where('id', '<', $project->id)->latest('id')->first();
        $nextProject = Project::active()->where('id', '>', $project->id)->oldest('id')->first();

        return view('frontend.projects.show', compact('project', 'relatedProjects', 'prevProject', 'nextProject'));
    }
}
