<?php

namespace App\Livewire;

use App\Models\Patient;
use Livewire\Component;
use Livewire\WithPagination;

class PatientsList extends Component
{
    use WithPagination;

    public string $query = '';

    public function render()
    {
        $result = null;
        if (strlen($this->query) > 2) {

            $result = Patient::where('name', 'like', '%' . $this->query . '%')
                ->orWhere('file_id', 'like', '%' . $this->query . '%')
                ->orWhere('civil_id', 'like', '%' . $this->query . '%')
                ->limit(50)
                ->orderBy('name', 'asc')
                ->paginate(5, pageName: 'patients-list');
        }

        //return view('livewire.patients-list', ['patients' => $result,]);
        return view('livewire.patients-list', ['patients' => $result,]);
    }

    public function search()
    {
        //$result = \App\Models\Patient::paginate(10, pageName: 'patients-list');

        $this->resetPage(pageName: 'patients-list');
    }
}
