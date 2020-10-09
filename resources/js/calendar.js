import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

function formatDate() {
    var d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

document.addEventListener('DOMContentLoaded', function() {
    
    var calendarEl = document.getElementById('calendar');

    if ( calendarEl ) {
        
        var calendar = new Calendar(calendarEl, {
            plugins: [ dayGridPlugin ],
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridMonth'
            },
            defaultDate: formatDate(),
            editable: true,
            navLinks: true,
            eventLimit: true,
            eventColor: '#3498db',
            eventBorderColor: '#2980b9',
            eventTextColor: 'white',
            events: {
                url: '/api/events/json',
                failure: function() {
                    //document.getElementById('script-warning').style.display = 'block'
                    console.log('failed to load events');
                }
            },
            eventClick: function(info) {
                console.log(info.event);
                // window.location.href= "/board";
            },
        });
    
        calendar.render();
    }
    
});