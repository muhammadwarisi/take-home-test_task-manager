<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil parameter status dari request
        $status = $request->query('status');

        // Query tasks, filter jika status ada
        $tasksQuery = Tasks::query();
        if ($status) {
            $tasksQuery->where('status', $status);
        }
        $tasks = $tasksQuery->get();

        // return view dengan data tasks dan status filter
        return view('pages.task.index', compact('tasks', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Belum Selesai,Selesai',
        ]);
        try {
            //input data tasks ke database
            Tasks::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
            ]);
            Alert::success('Sukses', 'Tugas berhasil ditambahkan.');
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Gagal', 'Tugas gagal ditambahkan.');
        }
        // return kembali ke halaman index tasks
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // tes git checkout
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //cari data tasks berdasarkan id
        $task = Tasks::findOrFail($id);
        //return view edit dengan data tasks
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Belum Selesai,Selesai',
        ]);
        try {
            //cari data tasks berdasarkan id
            $task = Tasks::findOrFail($id);
            //update data tasks
            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
            ]);
            Alert::success('Sukses', 'Tugas berhasil diupdate.');
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Gagal', 'Tugas gagal diupdate.');
        }
        // return kembali ke halaman index tasks
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //cari data tasks berdasarkan id
        try {
            $task = Tasks::findOrFail($id);
            //hapus data tasks
            $task->delete();
            // return kembali ke halaman index tasks
            return response()->json([
                'success' => true,
                'message' => 'Tugas berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Gagal menghapus tugas: ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus tugas'
            ], 500);
        }
    }


    public function updateStatus(Request $request, string $id)
    {
        $task = Tasks::findOrFail($id);

        // Toggle status
        $task->status = strtolower($task->status) === 'belum selesai' ? 'Selesai' : 'Belum Selesai';
        $task->save();

        return response()->json([
            'success' => true,
            'new_status' => $task->status
        ]);
    }
}
