<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 copy">
                    <p class="text-lg mb-2 font-bold">Welcome!</p>
                    <p>Thank you for visiting and welcome to Kent RFU's online financial reporting website for clubs.</p>
                    <p>DON’T PANIC!!!!!!! - read the Q&A below first.</p>
                    <div class="mt-6">
                        <div class="mb-5">
                            <p class="font-bold">Why are you asking us to use this new way of reporting?</p>
                            <p>Due to some high profile problems, the RFU has introduced a higher financial reporting standard for clubs (Reg 5). This is so that the Country Boards & RFU itself can better monitor the financial health of the sport.</p>
                        </div>

                        <div class="mb-5">
                            <p class="font-bold">Seems like a lot of extra work.</p>
                            <p class="mb-2">It’s a national requirement. We have used a version of the suggested RFU template and simplified where possible. The difference with Kent and other CBs is that we have invested in an online process rather than formal paperwork.</p>
                            <p>Like you, we are volunteers and we think this investment will ultimately make it easier for everybody involved.</p>
                        </div>

                        <div class="mb-5">
                            <p class="font-bold">I don’t have a lot of this information, what do I do?</p>
                            <p>That’s fine. We had to design a single template that captured all clubs. This is very important just Fill in what you can, if we need more information we will contact you.</p>
                        </div>

                        <div class="mb-5">
                            <p class="font-bold">Does it have to be filled in, in one go?</p>
                            <p>No, it is designed to be filled in and updated over time. Fill in what you can or have time for and save it. Also, some of the data we ask for only needs to be updated when circumstances change.</p>
                        </div>

                        <div class="mb-5">
                            <p class="font-bold">Our annual accounts don’t quite match the playing season.</p>
                            <p>That’s fine, just fill in the details - where possible - where your annual accounts best matches the season in question. This is designed to revolve around you, not us.</p>
                        </div>

                        <div class="mb-5">
                            <p class="font-bold">What are you going to do with the data?</p>
                            <p>The data will be held on a secure database. The aim is to put clubs on a common standard with comparable reporting to better understand their health over time and to help with our planning for allocation of resources.</p>
                        </div>

                        <div class="mb-5">
                            <p class="font-bold">Will we be penalised if our financial condition is getting worse?</p>
                            <p>Quite the opposite, we view it as a safety net. We have resources at our disposal and its easier to help earlier rather than later.</p>
                        </div>

                        <div class="mb-5">
                            <p class="font-bold">What happens if we don’t comply?</p>
                            <p>You are required to submit financial information by the national RFU rules. This is common across all County Boards. As an additional incentive all clubs that keep up to date on their reporting requirements can claim a discount on their annual membership fees.</p>
                        </div>

                        <div class="mb-5">
                            <p class="font-bold">Am I exempt?</p>
                            <p>National Level 5 National clubs with no amateur or junior sides are not required to report. This currently does not apply to any clubs in Kent. So, yes all clubs are required to report.</p>
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
