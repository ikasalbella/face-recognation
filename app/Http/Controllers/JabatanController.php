<?php
namespace App\Http\Controllers;


use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Models\User;

class JabatanController extends Controller
{
    public function index()
{
    $users = User::whereNotNull('jabatan')
        ->select('name', 'jabatan')
        ->orderBy('jabatan')
        ->get();

    return view('admin.jabatan.index', compact('users'));
}


    public function create()
    {
        return view('admin.jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        Jabatan::create(['nama' => $request->nama]);
        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan ditambahkan.');
    }

    public function edit(Jabatan $jabatan)
    {
        return view('admin.jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        $jabatan->update(['nama' => $request->nama]);
        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan diperbarui.');
    }

    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan dihapus.');
    }
}
