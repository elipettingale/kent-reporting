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
            'registered' => [
                'label' => 'Registered',
                'icon' => 'success'
            ],
            'not_registered' => [
                'label' => 'Not Registered',
                'icon' => 'danger'
            ]
        ];

        return view('components.status')
            ->with($statuses[$this->status]);
    }
}
