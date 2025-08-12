<div x-data="{
    supported: [
        'calendly.com',
        'calendar.google.com',
        'outlook.office365.com/bookwithme',
        'youcanbook.me',
        'acuityscheduling.com',
        'simplybook.me',
        'setmore.com',
        'doodle.com'
    ],
    link: '',
    isValid() {
        if (!this.link) return true;
        return this.supported.some(domain => this.link.includes(domain));
    }
}" x-init="$watch('link', value => $refs.calenderInput && ($refs.calenderInput.value = value))">
    <div class="space-y-4 mb-4">
        <div>
            <label for="" class="text-sm font-semibold">Add your appointment scheduling link:</label>
            <div>
                <input type="text" class="form-control" placeholder="eg. https://calendly.com/videoaskteam/30min"
                    wire:model="calender_link" wire:keydown.debounce.2000ms="saveCalenderLink()"
                    x-model="link" x-ref="calenderInput">
            </div>
            <template x-if="!isValid()">
                <div class="mt-2 text-red-600 text-xs font-semibold">
                    This link does not appear to be from a supported calendar service.
                </div>
            </template>
        </div>
    </div>
    <div class="p-3 bg-blue-50 border-l-4 border-blue-400 text-blue-800 rounded">
        <strong>Supported Calendar Services:</strong>
        <ul class="list-disc ml-6">
            <li class="text-xs">Calendly (<a href="https://calendly.com/" target="_blank" class="underline">calendly.com</a>)<br><span class="text-xs">Example: <code>https://calendly.com/videoaskteam/30min</code></span></li>
            <li class="text-xs">Google Calendar Appointment Slots (<a href="https://calendar.google.com/" target="_blank" class="underline">calendar.google.com</a>)<br><span class="text-xs">Example: <code>https://calendar.google.com/calendar/appointments/schedules/AcZssZ2...</code></span></li>
            <li class="text-xs">Microsoft Bookings (<a href="https://outlook.office365.com/bookwithme/" target="_blank" class="underline">bookwithme</a>)<br><span class="text-xs">Example: <code>https://outlook.office365.com/bookwithme/user@domain.com/bookings</code></span></li>
            <li class="text-xs">YouCanBook.me (<a href="https://youcanbook.me/" target="_blank" class="underline">youcanbook.me</a>)<br><span class="text-xs">Example: <code>https://yourname.youcanbook.me/</code></span></li>
            <li class="text-xs">Acuity Scheduling (<a href="https://acuityscheduling.com/" target="_blank" class="underline">acuityscheduling.com</a>)<br><span class="text-xs">Example: <code>https://app.acuityscheduling.com/schedule.php?owner=12345678</code></span></li>
            <li class="text-xs">SimplyBook.me (<a href="https://simplybook.me/" target="_blank" class="underline">simplybook.me</a>)<br><span class="text-xs">Example: <code>https://yourcompany.simplybook.me/v2/</code></span></li>
            <li class="text-xs">Setmore (<a href="https://www.setmore.com/" target="_blank" class="underline">setmore.com</a>)<br><span class="text-xs">Example: <code>https://my.setmore.com/bookingpage/12345678-1234-1234-1234-1234567890ab</code></span></li>
            <li class="text-xs">Doodle (<a href="https://doodle.com/" target="_blank" class="underline">doodle.com</a>)<br><span class="text-xs">Example: <code>https://doodle.com/bp/yourname/meeting</code></span></li>
        </ul>
        <div class="mt-2 text-sm">
            Paste your public scheduling link from any of these services below.<br>
            <strong>Note:</strong> Not all services support embedding, but most will display in the iframe.
        </div>
    </div>
</div>