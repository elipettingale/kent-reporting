<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clubs') }}
        </h2>
    </x-slot>

    <div class="pt-8 mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-end justify-between">
                <div class="flex items-end">
                    <div id="club-search" class="mr-3 search__filter">
                        <x-label for="status" :value="__('Status')" />

                        <x-select id="status" class="block mt-1 w-full" type="text" name="status">
                            <option value="all" selected>All</option>
                            <option value="registered" @selected(request('status') === 'registered')>Registered</option>
                            <option value="not_registered" @selected(request('status') === 'not_registered')>Not Registered</option>
                        </x-select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="clubs-table" class="pb-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-table>
                <x-slot name="thead">
                    <x-th>Club</x-th>
                    <x-th>Email</x-th>
                    <x-th>
                        Season
                        <x-select id="season-filter" class="text-gray-900 ml-1">
                            <option value="2022" selected>21/22</option>
                            <option value="2023">22/23</option>
                        </x-select>
                    </x-th>
                    <x-th>Notes</x-th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Actions</span>
                    </th>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($clubs as $club)
                        <tr data-status="{{ $club->status }}">
                            <x-td>{{ $club->name }}</x-td>
                            <x-td>
                                @if ($club->email)
                                    {{ $club->email }}
                                @else
                                    <x-status status="{{ $club->status }}" />
                                @endif
                            </x-td>
                            <x-td>
                                @foreach ($club->reports as $report)
                                    @php
                                        $year = $report->financial_year ?? null;
                                    @endphp
                                    <span data-season="{{ $year }}"
                                        @if ($year != '2022') style="display: none" @endif>

                                        @if ($report)
                                            <x-status status="{{ $report->status() }}" />
                                        @endif
                                    </span>
                                @endforeach
                            </x-td>
                            <x-td>
                                <p class="text-xs whitespace-normal">{{ $club->notes }}</p>
                            </x-td>
                            <x-td class="flex justify-end">
                                @if ($club->status === 'registered')
                                    <div x-data="{ open: false }">
                                        <x-button @click="open = true">
                                            Edit
                                        </x-button>

                                        <div x-show="open" class="k-modal__wrapper" style="display: none;">
                                            <div class="k-modal text-left" @click.outside="open = false">
                                                <form method="post"
                                                    action="{{ route('admin.club.update', $club->user_id) }}">
                                                    @csrf

                                                    <div class="mb-3">
                                                        <x-label for="email" :value="__('Email')" />
                                                        <x-input id="email" type="email" name="email"
                                                            class="w-full" value="{{ $club->email }}" required />
                                                    </div>

                                                    <div class="mb-3">
                                                        <x-label for="notes" :value="__('Notes')" />
                                                        <x-textarea id="notes" name="notes" rows="5"
                                                            class="w-full">{{ $club->notes }}</x-textarea>
                                                    </div>

                                                    <x-button class="is-green">
                                                        Save
                                                    </x-button>
                                                </form>

                                                <p>Send Password Reset</p>
                                                {{-- maybe reset password here? could get a randomly generated one she can just send back? --}}
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
