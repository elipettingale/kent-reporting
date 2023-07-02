<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clubs') }}
        </h2>
    </x-slot>

    <div class="pt-8 mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('admin.club.index') }}">
                <div class="flex items-end justify-between">
                    <div class="flex items-end">
                        <div class="mr-3 search__filter">
                            <x-label for="status" :value="__('Status')" />

                            <x-select id="status" class="block mt-1 w-full" type="text" name="status">
                                <option value="" selected>All</option>
                                <option value="registered" @selected(request('status') === 'registered')>Registered</option>
                                <option value="not_registered" @selected(request('status') === 'not_registered')>Not Registered</option>
                            </x-select>
                        </div>
                    </div>

                    <div>
                        <x-button class="h-11">
                            Search
                        </x-button>
                        <x-button href="{{ route('admin.club.index') }}" class="h-11 is-gray">
                            Reset
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
                    <x-th>Email</x-th>
                    <x-th>Season {{ now()->subYears(2)->format('y') }}/{{ now()->subYears(1)->format('y') }}</x-th>
                    <x-th>Season {{ now()->subYears(1)->format('y') }}/{{ now()->format('y') }}</x-th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Actions</span>
                    </th>
                </x-slot>
                <x-slot name="tbody">
                    @foreach($clubs as $club)
                        <tr>
                            <x-td>{{ $club->name }}</x-td>
                            <x-td>
                                @if($club->email)
                                    {{ $club->email }}
                                @else
                                    <x-status status="{{ $club->status }}" />
                                @endif
                            </x-td>
                            <x-td>{{ $club->last_year_report_submitted_at }}</x-td>
                            <x-td>{{ $club->this_year_report_submitted_at }}</x-td>
                            <x-td class="text-right">
                                @if($club->status === 'registered')
                                    <div x-data="{ open: false }">
                                        <x-button @click="open = true">
                                            Edit
                                        </x-button>
                                        
                                        <div x-show="open" class="k-modal__wrapper" style="display: none;">
                                            <div class="k-modal text-left" @click.outside="open = false">
                                                <form method="post" action="{{ route('admin.club.update', $club->user_id) }}">
                                                    @csrf

                                                    <div class="mb-3">
                                                        <x-label for="email" :value="__('Email')" />
                                                        <x-input id="email" type="email" name="email" class="w-full" value="{{ $club->email }}" required />
                                                    </div>

                                                    <x-button class="is-green">
                                                        Save
                                                    </x-button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </x-td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        </div>
    </div>
</x-app-layout>
