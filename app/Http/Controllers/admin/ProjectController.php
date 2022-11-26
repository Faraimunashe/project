<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Project;
use App\Models\ProjectRequirement;
use App\Models\Risk;
use Exception;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();
        return view('admin.projects', [
            'projects' => $projects
        ]);
    }

    public function see($project_id)
    {
        $project = Project::find($project_id);
        $requirements = ProjectRequirement::where('project_id', $project->id)->get();
        $risks = Risk::where('project_id', $project->id)->get();
        $activities = Activity::where('project_id', $project_id)->get();
        return view('admin.see-project', [
            'project' => $project,
            'requirements' => $requirements,
            'risks' => $risks,
            'activities' => $activities
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'employee_id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'cost' => ['required', 'numeric'],
            //'status' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'deadline' => ['required', 'date'],
            'description' => ['required', 'string']
        ]);

        try{
            $proj = new Project();
            $proj->assigned_to = $request->employee_id;
            $proj->name = $request->name;
            $proj->cost = $request->cost;
            $proj->status = $request->status;
            $proj->start_date = $request->start_date;
            $proj->deadline = $request->deadline;
            $proj->status = "in progress";
            $proj->description = $request->description;
            $proj->save();

            return redirect()->back()->with('success', 'Successfully added new project');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'project_id' => ['required', 'integer'],
            'employee_id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'cost' => ['required', 'numeric'],
            'status' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'deadline' => ['required', 'date'],
            'estimated_hours' => ['required', 'integer']
        ]);

        try{
            $proj = Project::find($request->project_id);
            $proj->assigned_to = $request->employee_id;
            $proj->name = $request->name;
            $proj->cost = $request->cost;
            $proj->status = $request->status;
            $proj->start_date = $request->start_date;
            $proj->deadline = $request->deadline;
            $proj->estimated_hours = $request->estimated_hours;
            $proj->save();

            return redirect()->back()->with('success', 'Successfully updated project');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'project_id' => ['required', 'integer']
        ]);

        try{
            $proj = Project::find($request->employee_id);

            $proj->delete();

            return redirect()->back()->with('success', 'Successfully deleted employee');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }

    public function add_risk(Request $request)
    {
        $request->validate([
            'project_id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string']
        ]);

        try{
            $risk = new Risk();
            $risk->project_id = $request->project_id;
            $risk->name = $request->name;
            $risk->description = $request->description;
            $risk->save();


            return redirect()->back()->with('success', 'You have successfully added a risk to project');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }

    public function add_requirement(Request $request)
    {
        $request->validate([
            'project_id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string']
        ]);

        try{
            $risk = new ProjectRequirement();
            $risk->project_id = $request->project_id;
            $risk->name = $request->name;
            $risk->price = 0;
            $risk->description = $request->description;
            $risk->save();


            return redirect()->back()->with('success', 'You have successfully added a requirement to project');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }

    public function add_activity(Request $request)
    {
        $request->validate([
            'project_id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'hours' => ['required', 'integer'],
            'description' => ['required', 'string']
        ]);

        try{
            $risk = new Activity();
            $risk->project_id = $request->project_id;
            $risk->name = $request->name;
            $risk->hours = $request->hours;
            $risk->description = $request->description;
            $risk->save();


            return redirect()->back()->with('success', 'You have successfully added an activity to project');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }
}
