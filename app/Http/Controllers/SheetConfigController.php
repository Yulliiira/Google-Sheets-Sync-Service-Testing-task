<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SheetConfig;

class SheetConfigController extends Controller
{
    public function create()
    {
        $config = SheetConfig::latest()->first();
        return view('sheet_config.create', compact('config'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sheet_url' => 'required|url'
        ]);

        preg_match('/\/d\/([a-zA-Z0-9-_]+)/', $request->sheet_url, $matches);
        $sheetId = $matches[1] ?? null;

        if (!$sheetId) {
            return back()->withErrors(['sheet_url' => 'Sheet ID не найден в ссылке']);
        }

        SheetConfig::create([
            'sheet_url' => $request->sheet_url,
            'sheet_id' => $sheetId,
        ]);

        return redirect()->route('records.index')->with('success', 'Ссылка сохранена');
    }
}
