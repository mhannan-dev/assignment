<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Models\Assignment;
use App\Models\AssignmentAttachment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $classes = DB::table('class_models')->get();
        $subjects = DB::table('subjects')->get();
        $user = auth()->user();

        if ($user->type === 'manager') {
            $assignments = $user->assignments;
        } elseif ($user->type === 'admin') {
            $assignments = Assignment::with('subject', 'user', 'class')->get()->toArray();
        }
        return view('assignments.index', compact('assignments', 'classes', 'subjects'));
    }
    public function filter(Request $request)
    {

        $classes = DB::table('class_models')->get();
        $subjects = DB::table('subjects')->get();

        $assignments = Assignment::with('subject', 'user', 'class')
            ->when($request->class_model_id != null, function ($q) {
                $q->where('class_model_id', request('class_model_id'));
            })->when($request->subject_id != null, function ($q) {
            $q->where('subject_id', request('subject_id'));
        })->when($request->status != null, function ($q) {
            $q->where('status', request('status'));
        })->get()->toArray();
        return view('assignments.index', compact('assignments', 'classes', 'subjects'));
    }

    public function create()
    {
        $data['class'] = DB::table('class_models')->get();
        $data['subjects'] = DB::table('subjects')->get();
        $data['sections'] = DB::table('sections')->get();
        $data['assignment'] = new Assignment();
        return view('assignments.create', $data);
    }

    public function store(StoreAssignmentRequest $request, Assignment $assignment)
    {
        try {
            DB::beginTransaction();
            $assignment->type = $request->type;
            $assignment->assigned_by = $request->assigned_by;
            $assignment->class_model_id = $request->class_model_id;
            $assignment->section_id = $request->section_id;
            $assignment->subject_id = $request->subject_id;
            $assignment->assign_date = $request->assign_date;
            $assignment->description = $request->description;
            $assignment->subject_id = $request->subject_id;
            $assignment->submission_date = $request->submission_date;
            $assignment->user_id = auth()->id();
            $assignment->marks = $request->marks;

            $image = $request->file('attachment');
            if (isset($image)) {
                $file = $request->file('attachment');
                $filename = time() . '_' . $file->getClientOriginalName();
                // File upload location
                $location = 'uploads';
                // Upload file
                $file->move($location, $filename);
            }
            $assignment->image = $filename;
            $assignment->save();
            DB::commit();
            return redirect()->route('assignments.index')->with('success', 'Assignment created successfully.');

        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return redirect()->route('assignments.index')->with('error', 'Assignment not saved.');
        }
    }

    public function addFilesSave($id, Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->hasFile('attachment')) {
                $images = $request->file('attachment');
                foreach ($images as $key => $file) {
                    // dd($image);
                    $attachFiles = new AssignmentAttachment();
                    $filename = time() . '_' . $file->getClientOriginalName();
                    // File upload location
                    $location = 'uploads';
                    // Upload file
                    $file->move($location, $filename);
                    $attachFiles->files = $filename;
                    $attachFiles->assignment_id = $id;
                    $attachFiles->save();
                }
                return redirect()->route('assignments.index')->with('success', 'File added successfully.');
            }
        }
        $assignment = Assignment::find($id);
        return view('assignments.add_files', compact('assignment'));
    }

    public function edit($id)
    {
        $data['assignment'] = Assignment::find($id);
        $data['class'] = DB::table('class_models')->get();
        $data['subjects'] = DB::table('subjects')->get();
        $data['sections'] = DB::table('sections')->get();
        return view('assignments.edit', $data);
    }

    public function show($id)
    {
        $item = Assignment::with('subject', 'user', 'class', 'files')->find($id);
        return view('assignments.show', compact('item'));
    }
    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        try {
            DB::beginTransaction();
            $assignment->type = $request->type;
            $assignment->assigned_by = $request->assigned_by;
            $assignment->class_model_id = $request->class_model_id;
            $assignment->section_id = $request->section_id;
            $assignment->subject_id = $request->subject_id;
            $assignment->assign_date = $request->assign_date;
            $assignment->description = $request->description;
            $assignment->subject_id = $request->subject_id;
            $assignment->submission_date = $request->submission_date;
            $assignment->user_id = auth()->id();
            $assignment->marks = $request->marks;

            $image = $request->file('attachment');
            if (isset($image)) {

                $oldFile = public_path("uploads/{$assignment->image}");
                if (File::exists($oldFile)) {
                    unlink($oldFile);
                }
                $file = $request->file('attachment');
                $filename = time() . '_' . $file->getClientOriginalName();
                // File upload location
                $location = 'uploads';
                // Upload file
                $file->move($location, $filename);
            } else {
                $filename = $assignment->image;
            }
            $assignment->image = $filename;
            $assignment->update();
            DB::commit();
            return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully.');

        } catch (Exception $exception) {
            dd($exception);
            DB::rollBack();
            Log::error($exception->getMessage());
            return redirect()->route('assignments.index')->with('error', 'Assignment not saved.');
        }
    }

    public function destroy(Assignment $assignment)
    {
        if (auth()->user()->type !== "admin") {
            abort(403); // Unauthorized access
        } else {
            $image_path = public_path('uploads/') . $assignment->image;
            if (!is_null($assignment)) {
                $assignment->delete();
                unlink($image_path);
            }
            return redirect()->route('assignments.index')->with('success', 'Assignment deleted successfully.');
        }
    }

    public function download($filename)
    {
        $file = public_path('uploads/' . $filename);
        return Response::download($file);
    }

    public function downloadFiles($filename)
    {
        $file = public_path('uploads/' . $filename);
        return Response::download($file);
    }

    public function changeStatus(Request $request)
    {
        $data = $request->all();
        $status = $data['selectedValue'];
        DB::table('assignments')->where('id', $data['assignment_id'])->update(['status' => $status]);
        return response()->json(['status' => 200, 'message' => 'Operation successful']);
    }
}
