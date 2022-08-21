<template>
    <header>
        <button @click="prev()">Prev</button>
        <button @click="next()">Next</button>
    </header>
    <section class="calendar-outer-container">
        <full-calendar ref="calendarRef" :options="calendarOptions" />
    </section>
</template>

<script lang="ts">
import {
    defineComponent,
    reactive,
    ref,
    Ref,
    toRefs,
    computed,
    onMounted,
} from "vue";

import FullCalendar, {
    Calendar,
    CalendarOptions,
    EventApi,
} from "@fullcalendar/vue3";
import '@fullcalendar/core/vdom';
import rrulePlugin from "@fullcalendar/rrule";
import dayGridPlugin from "@fullcalendar/daygrid";
import listPlugin, { NoEventsContentArg } from "@fullcalendar/list";
import interactionPlugin from "@fullcalendar/interaction";

export default defineComponent({
    components: {
        FullCalendar,
    },
    props: {
        EventsData: []
    },
    setup(props) {
        console.log('Events Data ====>>>>', props.EventsData)
        const calendarRef = ref<Calendar>();

        const calendarApi = ref();

        let eventGuid = 0;
        let todayStr = new Date().toISOString().replace(/T.*$/, ""); // YYYY-MM-DD of today

        function createEventId() {
            return String(eventGuid++);
        }

        const state = reactive({
            calendarOptions: {
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,listWeek",
                },
                events: [],
                displayEventTime: false,
                initialView: "dayGridMonth",
                plugins: [dayGridPlugin, listPlugin, interactionPlugin, rrulePlugin],

                eventsSet: handleEvents,
            } as CalendarOptions,

            currentEvents: [],
        });

        function handleEvents(events: EventApi[]) {
            state.currentEvents = events;
            console.log(calendarRef.value);

            //viewTitle.value = calendar.value.getDate().toDateString();
        }

        function getEvents() {
            return [
                // one-time events
                {
                    id: createEventId(),
                    title: "All-day event",
                    start: todayStr,
                },
                {
                    id: createEventId(),
                    title: "Timed event",
                    start: todayStr + "T12:00:00",
                },
                // repeating events
                {
                    title: "my recurring event",
                    rrule: "DTSTART:20210603T103000Z\nRRULE:FREQ=WEEKLY;INTERVAL=1;UNTIL=20210630;BYWEEKDAY=MO",
                },
            ];
        }

        // external buttons
        const next = () => calendarApi.value.next();
        const prev = () => calendarApi.value.prev();

        onMounted(() => {
            let events = props.EventsData;
            if (calendarRef.value) {
                // @ts-ignore
                calendarApi.value = calendarRef.value.getApi();
                calendarApi.value.addEventSource(events);
                //console.log(calendarApi.value);
            }
        });

        return {
            prev,
            next,
            calendarRef,
            ...toRefs(state),
        };
    },
});
</script>
<style>
.fc {
    /* the calendar root */
    max-width: 1100px;
    margin: 0 auto;
}
</style>
