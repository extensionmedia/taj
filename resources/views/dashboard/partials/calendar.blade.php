<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>

@php
    $schedules = [
        0 => [
            'due_date'          =>  '2021-09-22',
            'description'       =>  'Location de keftan'
        ],
        1 => [
            'due_date'          =>  '2021-09-20',
            'description'       =>  'Retour de keftan'
        ]
];
@endphp


<div class="bg-white bg-opacity-90 rounded py-8 px-8">
    <div id="calendar" class="text-xs"></div>
</div>

<script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            events : [
                <?php foreach($schedules as $schedule): ?>
                    {
                        title : "<?= $schedule['description'] ?>",
                        start : "<?= $schedule['due_date'] ?>"
                    },
                <?php endforeach; ?>
            ]
        })
    });
</script>
