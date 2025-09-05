<?php

namespace App\Livewire;

use App\Models\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Logs extends Component
{
    use WithPagination;

    public string $search = '';
    public array $levelFilters = [];
    public string $sourceFilter = '';
    public string $userIdFilter = '';
    public string $sessionIdFilter = '';
    public string $dateFrom = '';
    public string $dateTo = '';
    public string $sortField = 'timestamp';
    public string $sortDirection = 'desc';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingLevelFilters(): void
    {
        $this->resetPage();
    }

    public function updatingSourceFilter(): void
    {
        $this->resetPage();
    }

    public function updatingUserIdFilter(): void
    {
        $this->resetPage();
    }

    public function updatingSessionIdFilter(): void
    {
        $this->resetPage();
    }

    public function updatingDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatingDateTo(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->levelFilters = [];
        $this->sourceFilter = '';
        $this->userIdFilter = '';
        $this->sessionIdFilter = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    public function render()
    {
        $logs = Log::query()
            ->with('user')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('message', 'like', '%' . $this->search . '%')
                      ->orWhere('source', 'like', '%' . $this->search . '%')
                      ->orWhere('url', 'like', '%' . $this->search . '%')
                      ->orWhere('user_agent', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->levelFilters, function ($query) {
                $query->whereIn('level', $this->levelFilters);
            })
            ->when($this->sourceFilter, function ($query) {
                $query->where('source', 'like', '%' . $this->sourceFilter . '%');
            })
            ->when($this->userIdFilter, function ($query) {
                $query->where('user_id', $this->userIdFilter);
            })
            ->when($this->sessionIdFilter, function ($query) {
                $query->where('session_id', $this->sessionIdFilter);
            })
            ->when($this->dateFrom, function ($query) {
                $query->where('timestamp', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->where('timestamp', '<=', $this->dateTo . ' 23:59:59');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(20);

        $logLevels = Log::getLogLevels();

        return view('livewire.logs', [
            'logs' => $logs,
            'logLevels' => $logLevels,
        ]);
    }
}
