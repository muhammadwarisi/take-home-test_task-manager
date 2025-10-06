<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
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
            Alert::success('Sukses', 'Tugas berhasil dihapus.');
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Gagal', 'Tugas gagal dihapus.');
        }
        // return kembali ke halaman index tasks
        return redirect()->route('tasks.index');
    }
}
