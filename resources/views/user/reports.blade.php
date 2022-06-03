<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-table>
                <x-slot name="thead">
                    <x-th>Financial Year</x-th>
                    <x-th>Status</x-th>
                    <x-th>Submitted</x-th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Actions</span>
                    </th>
                </x-slot>
                <x-slot name="tbody">
                    @foreach($reports as $report)
                        <tr>
                            <x-td>{{ $report->financial_year }}</x-td>
                            <x-td>
                                <x-status status="{{ $report->status() }}" />
                            </x-td>
                            <x-td>{{ $report->submitted_at?->format('d/m/Y') }}</x-td>
                            <x-td class="text-right">
                                <x-button href="{{ route('user.report.show', $report) }}">
                                    @if($report->hasNotBeenSubmitted())
                                        Continue
                                    @else
                                        View
                                    @endif
                                </x-button>
                            </x-td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        </div>
    </div>
</x-app-layout>
