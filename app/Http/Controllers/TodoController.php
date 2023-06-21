<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignmentRequest;
use App\Models\Assignment;
use App\Models\AssignmentAttachment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class TodoController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with('subject', 'user', 'class')->get()->toArray();
        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        $data['class'] = DB::table('class_models')->get();
        $data['subjects'] = DB::table('subjects')->get();
        $data['sections'] = DB::table('sections')->get();
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
            dd($exception);
            DB::rollBack();
            Log::error($exception->getMessage());
            return redirect()->route('assignments.index')->with('error', 'Assignment not saved.');
        }
    }

    private function saveAttachment($id, $attachments)
    {
        // dd('attachments');
        if (isset($attachments)) {
            foreach ($attachments as $key => $image) {
                dd('oka');
                $attachFiles = new AssignmentAttachment();
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                if (!Storage::disk('public')->exists('files')) {
                    Storage::disk('public')->makeDirectory('files');
                }
                //Saving image
                $logoImage = Image::make($image)->resize(600, 600)->save(storage_path('files'));
                Storage::disk('public')->put('files/' . $imageName, $logoImage);
                $attachFiles->files = $imageName;
                $attachFiles->assignment_id = $id;
                $attachFiles->save();
                dd('ok');
                return back();
            }
        }
    }

    public function edit(Assignment $assignment)
    {
        if ($assignment->user_id !== auth()->id()) {
            abort(403); // Unauthorized access
        }
        return view('assignments.edit', compact('assignment'));
    }

    public function show($id)
    {
        $item = Assignment::with('subject', 'user', 'class')->find($id);
        return view('assignments.show', compact('item'));
    }
    public function update(Request $request, Assignment $assignment)
    {
        if ($assignment->user_id !== auth()->id()) {
            abort(403); // Unauthorized access
        }

        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $assignment->update($validatedData);
        return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully.');
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
        // dd($file);
        return Response::download($file);
    }
}
