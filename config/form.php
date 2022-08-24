<?php

return [

    '1' => [
        'stats' => [
            [
                'label' => 'Current Financial Position',
                'values' => [
                    'current_financial_position_.*'
                ]
            ],
            [
                'label' => 'Staffing Costs (Player/Coach)',
                'values' => [
                    'running_costs_staffing_costs_players_monthly',
                    'running_costs_staffing_costs_coach_monthly'
                ]
            ],
            [
                'label' => 'Staffing Costs (Other)',
                'values' => [
                    'running_costs_staffing_costs_(?!players|coach).*_monthly',
                ]
            ],
            [
                'label' => 'Total Assets',
                'values' => [
                    'balance_sheet_fixed_assets_.*_accounting_value',
                    'balance_sheet_current_assets_.*_accounting_value'
                ]
            ],
        ]
    ]

];
