<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Task;
use Auth;

class TasksExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user = Auth::user();

        $tasks = Task::where("user_id", $user->id)->get();

        return $tasks;
    }

    public function headings()
    {
        return [
            'Id', 'Name', 'Description', 'Statys', 'Created At', 'Updated At'
        ];
    }
}
