<?php

namespace App\Http\Controllers;

use Faker\Factory;

use App\Http\Requests\StoreRecordRequest;
use App\Http\Requests\UpdateRecordRequest;
use App\Models\Record;

class RecordController extends Controller
{
    public function index()
    {
        $records = Record::all();
        return view('records.index', compact('records'));
    }

    public function create()
    {
        return view('records.create');
    }

    public function store(StoreRecordRequest $request)
    {
        $record = Record::create($request->validated());

        return redirect()->route('records.index', $record);
    }

    public function show(Record $record)
    {
        return view('records.show', compact('record'));
    }

    public function edit(Record $record)
    {
        return view('records.update', compact('record'));
    }

    public function update(UpdateRecordRequest $request, Record $record)
    {
        $record->update($request->validated());
        return redirect()->route('records.index', $record);
    }

    public function destroy(Record $record)
    {
        $record->delete();
        return redirect()->route('records.index');
    }

    public function generate()
    {
        $faker = Factory::create();
        $data = [];

        for ($i = 0; $i < 1000; $i++) {
            $status = $i % 2 === 0 ? 'Allowed' : 'Prohibited';
            $data[] = [
                'title' => $faker->sentence,
                'content' => $faker->text(100),
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Record::insert($data);

        return redirect()->route('records.index');
    }

    public function clear()
    {
        Record::truncate();
        return redirect()->route('records.index');
    }
}
