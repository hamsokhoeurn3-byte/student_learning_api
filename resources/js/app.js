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