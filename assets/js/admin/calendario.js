console.log("calendario2");
$.ajax({
    url: base_url + 'admin_ajax/cumpleanos',
    type: 'GET',
    dataType: 'json',
    beforeSend: function () {},
    success: function (r) {
        console.log("array con las fechas de cumpleaños", r);
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
            header: {
                left: 'prevYear,prev,next,nextYear today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            },
            defaultDate: new Date(),
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: r.response
        });

        calendar.render();


    },
    error: function (xhr, status, msg) {
        console.log(xhr.responseText);
    }
});