
<!--Full Calendar-->
<link href='<?php echo base_url() ?>assets/fullcalendar/packages/core/main.css' rel='stylesheet' />
<link href='<?php echo base_url() ?>assets/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
<style>

  body {
    margin: 40px 30px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 16px;
  }

  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

</style>
</head>
  <div class="shadow p-3 mb-5 bg-white rounded" id='calendar'></div>
<script src='<?php echo base_url() ?>assets/fullcalendar/packages/core/main.js?<? echo time_unix(); ?>'></script>
<script src='<?php echo base_url() ?>assets/fullcalendar/packages/interaction/main.js?<? echo time_unix(); ?>'></script>
<script src='<?php echo base_url() ?>assets/fullcalendar/packages/daygrid/main.js?<? echo time_unix(); ?>'></script>
<script src='<?php echo base_url() ?>assets/js/admin/calendario.js?<? echo time_unix(); ?>'></script>
