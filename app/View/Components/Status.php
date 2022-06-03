<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Status extends Component
{
    private $status;
    
    public function __construct($status)
    {
        $this->status = $status;
    }

    public function render()
    {
        $statuses = [
            'complete' => [
                'label' => 'Complete',
                'icon' => 'success'
            ],
            'pending' => [
                'label' => 'Pending',
                'icon' => 'warning'
            ],
            'overdue' => [
                'label' => 'Overdue',
                'icon' => 'danger'
            ]
        ];

        return view('components.status')
            ->with($statuses[$this->status]);
    }
}
