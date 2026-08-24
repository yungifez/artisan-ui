<april:calendar
    class="rounded-md border"
    captionLayout="dropdown"
    :showOutsideDays="false"
    :showWeekNumber="true"
    :fromYear="now()->subYears(2)->year"
    :toYear="now()->addYears(2)->year"
    :defaultMonth="now()->startOfMonth()"
/>
