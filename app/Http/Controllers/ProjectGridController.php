<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Project, ProjectGrid};
class ProjectGridController extends Controller
{
    public function index(Project $project){
        $title = 'Grid Management';
        if($project->id==1){
            if(auth()->user()->user_type!=1){
                return redirect()->route('dashboard')->with('redirect_errors', 'You are not allowed to access');
            }
            $title = 'Workforce Task Types';
        }
        $grids = $project->grids;
        return view('project.grids.index')->with('title', $title)
        ->with('gridMenu', true)
        ->with('grids', $grids)
        ->with('project', $project)
        ->with('hicon' ,'fa fa-link');
    }
    public function store(Request $request, Project $project){
        $orderMax = (intval($project->grids()->max('order'))+1);
        $project->grids()->create([
            'grid_name' => $request->grid_name,
            'order' => $orderMax
        ]);
        return redirect()->back()->with('redirect_success', 'Grid Created');
    }
    public function edit(Request $request, Project $project, ProjectGrid $grid){
        $grid->update($request->only('grid_name'));
        return response()->json(['status'=>true]);
    }
    public function orderUpdate(Project $project, ProjectGrid $grid, $type){
        if($type=='up'){
            $prevGrid = ProjectGrid::where('project_id', $project->id)->orderBy('order','desc')
            ->where('order', '<', $grid->order)->first();
            // $project->grids()->where('order', '<', $grid->order)->first();
            ProjectGrid::where('id',$prevGrid->id)->update([
                'order' => $grid->order
            ]);
            $grid->update([
                'order' => ($grid->order-1)
            ]);
        }else{
            $nextGrid = $project->grids()->where('order', '>', $grid->order)->first();
            ProjectGrid::where('id',$nextGrid->id)->update([
                'order' => $grid->order
            ]);
            $grid->update([
                'order' => ($grid->order+1)
            ]);
        }
        return redirect()->back()->with('notify_success','Order Updated');
    }
}
