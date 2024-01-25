<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AttendanceReportsExport implements FromCollection , WithMapping, WithHeadings
{
    protected $filters = [];

    public function __construct($filters)
    {
        $this->filters = $filters;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Attendance::with(['owner', 'site'])
            ->orderBy('created_at', 'DESC')
            ->where('company_id', auth()->user()->company_id)
            ->when(isset($this->filters['site']), function ($query) {
                return $query->where('site_id', $this->filters['site']);
            })
            ->when(isset($this->filters['guard']), function ($query) {
                return $query->where('guard_id', $this->filters['guard']);
            })
            ->when(isset($this->filters['range']), function ($query) {
                return $query->whereBetween('day', [$this->filters['range']['start'], $this->filters['range']['end']]);
            })->get();
    }

    public function headings(): array
    {
        return [
            'Guard',
            'Site',
            'Date',
            'Time In',
            'Time Out',
            'Total Hours'
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->owner->name,
            $attendance->site->name,
            $attendance->day,
            $attendance->time_in,
            $attendance->time_out,
            $attendance->time_out ?  date('H:i', strtotime($attendance->time_out) - strtotime($attendance->time_in)) : 'N/A'
        ];
    }
}
