<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="pt-8 mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('admin.report.index') }}">
                <div class="flex items-end">
                    <div class="mr-3">
                        <x-label for="club" :value="__('Club')" />

                        <x-select id="club" class="block mt-1 w-full" type="text" name="club">
                            <option value="" selected>All</option>
                            @foreach(config('clubs') as $club)
                                <option value="{{ $club }}" @selected(request('club') === $club)>{{ $club }}</option>
                            @endforeach
                        </x-select>
                    </div>

                    <div class="mr-3">
                        <x-label for="status" :value="__('Status')" />

                        <x-select id="status" class="block mt-1 w-full" type="text" name="status">
                            <option value="" selected>All</option>
                            <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                            <option value="overdue" @selected(request('status') === 'overdue')>Overdue</option>
                            <option value="complete" @selected(request('status') === 'complete')>Complete</option>
                        </x-select>
                    </div>

                    <div class="mr-3">
                        <x-label for="financial_year" :value="__('Financial Year')" />
                        <x-input id="financial_year" class="block mt-1 w-full" type="text" name="financial_year" :value="request('financial_year')" />
                    </div>

                    <div>
                        <x-button href="{{ route('admin.report.index') }}" class="h-11 bg-gray-400 hover:bg-gray-500 active:bg-gray-600">
                            Reset
                        </x-button>
                        <x-button class="h-11">
                            Search
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="pb-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-table>
                <x-slot name="thead">
                    <x-th>Club</x-th>
                    <x-th>Financial Year</x-th>
                    <x-th>Status</x-th>
                    <x-th>Due</x-th>
                    <x-th>Submitted</x-th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Actions</span>
                    </th>
                </x-slot>
                <x-slot name="tbody">
                    @foreach($reports as $report)
                        <tr>
                            <x-td>{{ $report->club }}</x-td>
                            <x-td>{{ $report->financial_year }}</x-td>
                            <x-td>
                                <x-status status="{{ $report->status() }}" />
                            </x-td>
                            <x-td>{{ $report->due_at?->format('d/m/Y') }}</x-td>
                            <x-td>{{ $report->submitted_at?->format('d/m/Y') }}</x-td>
                            <x-td class="text-right">
                                <x-button href="{{ route('admin.report.show', $report) }}">
                                    View
                                </x-button>
                            </x-td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        </div>
    </div>
</x-app-layout>
