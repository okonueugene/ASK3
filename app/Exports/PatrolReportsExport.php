<?php

namespace App\Exports;

use App\Models\PatrolHistory;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PatrolReportsExport implements  FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

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
        return PatrolHistory::when(isset($this->filters['site']), function ($query) {
            return $query->where('site_id', $this->filters['site']);
        })
            ->when(isset($this->filters['guard']), function ($q) {
                return $q->where('guard_id', $this->filters['guard']);
            })
            ->when(isset($this->filters['range']), function ($query) {
                return $query->whereBetween('date', [($this->filters['range']['start']), ($this->filters['range']['end'])]);
            })
            ->where('company_id', auth()->user()->company_id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Guard',
            'Tag',
            'Site',
            'Date',
            'Scanned At',
            'Status'
        ];
    }

    public function map($history): array
    {
        return [
            $history->owner->name,
            $history->tag->name,
            $history->site->name,
            $history->date,
            $history->time,
            $history->status,
        ];
    }
}
