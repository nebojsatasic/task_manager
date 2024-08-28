<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectCollection;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller
{
    /**
     * ProjectController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\ProjectCollection
     */
    public function index()
    {
        $projects = QueryBuilder::for(Project::class)
            ->allowedIncludes(['tasks', 'members'])
        ->paginate();

        return new ProjectCollection($projects);
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return \App\Http\Resources\ProjectResource
     */
    public function show(Project $project)
    {
        return new ProjectResource($project->load('tasks')->load('members'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequest $request
     * @return \App\Http\Resources\ProjectResource
     */
    public function store(StoreProjectRequest $request)
    {
        $validatedData = $request->validated();

        $project = auth()->user()->projects()->create($validatedData);

        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return \App\Http\Resources\ProjectResource
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validatedData = $request->validated();

        $project->update($validatedData);

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response()->noContent();
    }
}
