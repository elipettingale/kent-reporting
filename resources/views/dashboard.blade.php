<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="text-lg mb-2 font-bold">Welcome!</p>
                    <p>Thank you for visiting and welcome to Kent RFU's online reporting website for clubs.</p>
                    <p>Below are some Question & Answers to help you:</p>
                    <div class="mt-3">
                        <div class="mb-2">
                            <p class="font-bold">Why are you asking us to use this new way of reporting?</p>
                            <p>Due to some high profile problems, the RFU has introduced a higher reporting standard for clubs. This is so that the Country Boards can better monitor the financial health of their respective clubs.</p>
                        </div>
                        <div class="mb-2">
                            <p class="font-bold">Seems like a lot of extra work.</p>
                            <p>It’s a national requirement. We have used a version of the suggested RFU template and simplified where possible. The difference with Kent and other CBs is that we have invested in an online process rather than formal paperwork. Like you, we are volunteers and we think this investment will ultimately make it easier for everybody involved.</p>
                        </div>
                        <div class="mb-2">
                            <p class="font-bold">Does it have to be filled in, in one go?</p>
                            <p>No, it is designed to be filled in and updated over time. Fill in what you can or have time for and save it. Also, some of the data we ask for only needs to be updated when circumstances change.</p>
                        </div>
                        <div class="mb-2">
                            <p class="font-bold">What are you going to do with the data?</p>
                            <p>The data will be held on a secure database. The aim is to put clubs on a common standard with comparable reporting to better understand their health over time.</p>
                        </div>
                        <div class="mb-2">
                            <p class="font-bold">Will we be penalised if our financial condition is getting worse?</p>
                            <p>Quite the opposite, we view it as a safety net. We have resources at our disposal and its easier to help earlier rather than later.</p>
                        </div>
                        <div class="mb-2">
                            <p class="font-bold">What happens if we don’t comply?</p>
                            <p>You are required to submit financial information by the national RFU rules. This is common across all County Boards. As an additional incentive all clubs that keep up to date on their reporting requirements can claim a discount on their annual membership fees.</p>
                        </div>
                        <div class="mb-2">
                            <p class="font-bold">Am I exempt?</p>
                            <p>All clubs are required to report. National Level 5 National clubs with no amateur or junior sides are not required to report. This currently does not apply to any clubs in Kent.</p>
                        </div>
                        <div class="mb-2">
                            <p class="font-bold">There are more details being asked for than we have. </p>
                            <p>Don’t worry. We are aware one size doesn’t fit all. Fill in as best you can, we will come back if we need more details. Generally we ask for more details on larger complex clubs, particularly if there are junior players involved.</p>
                        </div>
                        <div class="mb-2">
                            <p class="font-bold">I have some suggestions for improvements.</p>
                            <p>All constructive feedback is welcome. This is version 1 of the system, we view it as an organic process. We aim to update it and improve it over time.</p>
                        </div>
                        <div>
                            <p class="font-bold">Who can I contact for help?</p>
                            <p>Ben Ashby, the treasurer - <a href="hon-treasurer@kent-org.uk">hon-treasurer@kent-org.uk</a> or Tracy Pettingale - <a href="office@kent-rugby.org.uk">office@kent-rugby.org.uk</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
