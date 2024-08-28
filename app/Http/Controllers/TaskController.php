<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    /**
     * TaskController Constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\TaskCollection
     */
    public function index()
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters('is_done')
            ->defaultSort('-created_at')
            ->allowedSorts(['title', 'is_done', 'created_at'])
            ->paginate();

        return new TaskCollection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaskRequest $request
     *@return \App\Http\Resources\TaskResource
     */
    public function store(StoreTaskRequest $request)
    {
        $validatedData = $request->validated();

    $task = auth()->user()->tasks()->create($validatedData);

    return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return \App\Http\Resources\TaskResource
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequest $request
     * @param $task
     * @return \App\Http\Resources\TaskResource
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validatedData = $request->validated();

        $task->update($validatedData);

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->noContent();
    }
}
