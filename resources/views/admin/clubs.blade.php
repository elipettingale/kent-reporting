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
                <div x-data="{ open: false, message_before: '', message_after: '' }">
                    <x-button @click="open = true" class="is-gray">
                        Send Reminders
                    </x-button>

                    <div x-show="open" class="k-modal__wrapper" style="display: none;">
                        <div id="reminder-form" class="k-modal text-left" style="width: 900px"
                            @click.outside="open = false">
                            <div class="mb-6">
                                <p class="text-xl mb-2">Send Reminder</p>

                                <small class="mb-4 block">To all clubs who have incomplete reports.</small>

                                <fieldset>
                                    <div>
                                        <x-label for="message_before" :value="__('Message')" />
                                        <x-textarea x-model="message_before" class="block mt-1 w-full" rows="6"
                                            id="message_before"></x-textarea>
                                    </div>

                                    <div class="my-2">[Breakdown]</div>

                                    <div>
                                        <x-label for="message_after" :value="__('Message')" />
                                        <x-textarea x-model="message_after" class="block mt-1 w-full" rows="4"
                                            id="message_after"></x-textarea>
                                    </div>
                                </fieldset>
                            </div>

                            <hr>

                            <div class="mt-6">
                                <p class="text-xl mb-2">Preview</p>
                                <div class="bg-gray-50 p-2 rounded mb-2">
                                    <p class="mb-2">To Dave Test (Test RFC),</p>
                                    <div x-html="message_before.replaceAll('\n', '<br>')"></div>
                                    <div class="mb-2 mt-4">
                                        <div class="flex">
                                            <strong class="mr-2">21/22 Season:</strong> Started, Not Submitted
                                        </div>
                                        <div class="flex">
                                            <strong class="mr-2">22/23 Season:</strong> Not Started
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <p>
                                            Please click <a href="#" class="text-blue-400 font-bold">here</a> to
                                            login.
                                        </p>
                                    </div>
                                    <div x-html="message_after.replaceAll('\n', '<br>')"></div>
                                </div>
                                <div class="flex justify-end items-center h-8">
                                    <p id="send-message"></p>
                                    <x-button id="send-reminder" class="is-green">Send</x-button>
                                </div>
                            </div>
                        </div>
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

                                                <div class="mb-4">
                                                    <p class="text-xl mb-1">Edit Details</p>

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
                                                </div>

                                                <hr>

                                                <div class="mt-4">
                                                    <x-button>Send Password Reset</x-button>
                                                </div>
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
