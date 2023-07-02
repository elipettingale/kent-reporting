<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="pt-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ open: false }">
            <x-button class="h-11 is-green" @click="open = true">
                Submit New Report
            </x-button>
            <div x-show="open" class="k-modal__wrapper" style="display: none;">
                <div class="k-modal" @click.outside="open = false">
                    <form method="post" action="{{ route('user.report.store') }}">
                        @csrf
                        <div>
                            <h2 class="mb-2 text-xl">New Report</h2>
                        </div>

                        <p>Create a new report for the Season:</p>

                        <div x-data="{ year: {{ now()->format('y') }} }" class="mb-4">
                            <input id="financial_year" type="hidden" name="financial_year" x-model="year + 2000" />

                            <p class="text-lg">
                                <span x-text="year - 1"></span>/<span x-text="year"></span>
                            </p>
                            <x-button type="button" @click="year--">-</x-button>
                            <x-button type="button" @click="year++">+</x-button>
                        </div>

                        <div>
                            <p>Save time by pre-filling with the previous season's data?</p>

                            <x-label class="cursor-pointer">
                                <span class="mr-1">Pre-Fill Fields</span> <x-input type="checkbox" name="pre_fill" checked />
                            </x-label>
                        </div>

                        <div class="flex justify-end">
                            <x-button class="is-green">Create</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-table>
                <x-slot name="thead">
                    <x-th>Season</x-th>
                    <x-th>Status</x-th>
                    <x-th>Created</x-th>
                    <x-th>Submitted</x-th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Actions</span>
                    </th>
                </x-slot>
                <x-slot name="tbody">
                    @foreach($reports as $report)
                        <tr>
                            <x-td>{{ $report->season() }}</x-td>
                            <x-td>
                                <x-status status="{{ $report->status() }}" />
                            </x-td>
                            <x-td>{{ $report->created_at?->format('d/m/Y') }}</x-td>
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
