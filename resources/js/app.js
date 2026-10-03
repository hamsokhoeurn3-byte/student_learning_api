import './bootstrap';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

import '../css/app.css';
import '../css/pages/dashboard.css';

import './pages/dashboard';

import 'bootstrap-icons/font/bootstrap-icons.css';

import ApexCharts from 'apexcharts';
window.ApexCharts = ApexCharts;

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

window.FullCalendar = {
    Calendar,
    dayGridPlugin,
    timeGridPlugin,
    interactionPlugin
};

const liveClockElements = document.querySelectorAll('[data-live-clock]');
if (liveClockElements.length > 0) {
    const clockFormatter = new Intl.DateTimeFormat(undefined, {
        month: 'short',
        day: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    });

    const updateLiveClocks = () => {
        const currentTime = new Date();
        liveClockElements.forEach((clock) => {
            clock.dateTime = currentTime.toISOString();
            clock.childNodes.forEach((node) => {
                if (node.nodeType === Node.TEXT_NODE) {
                    node.textContent = clockFormatter.format(currentTime);
                }
            });
        });
    };

    updateLiveClocks();
    window.setInterval(updateLiveClocks, 1000);
}