@extends('layouts.app')

<html>
	<head>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
	</head>
@section('content')
    <div id='calendar' class="container mx-auto w-1/2">
            @foreach ($absences as $absence)
                    <div class="absolute bottom-0 left-0 right-0 bg-red-500 text-white text-xs text-center py-1 px-2 rounded">
                        {{ $absence->user->name }}
                    </div>
            @endforeach
        <script>
            $(document).ready(function () {

            var SITEURL = "{{ url('/') }}";

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var calendar = $('#calendar').fullCalendar({
                                editable: true,
                                events: SITEURL + "/full-calender",
                                displayEventTime: false,
                                editable: true,
                                eventRender: function (event, element, view) {
                                    if (event.allDay === 'true') {
                                            event.allDay = true;
                                    } else {
                                            event.allDay = false;
                                    }
                                },
                                selectable: true,
                                selectHelper: true,
                                select: function (debut, fin, allDay) {
                                    var titre = prompt('Titre de l\'Evenement:');
                                    if (titre) {
                                        var debut = $.fullCalendar.formatDate(debut, "Y-MM-DD");
                                        var fin = $.fullCalendar.formatDate(fin, "Y-MM-DD");
                                        $.ajax({
                                            url: SITEURL + "/full-calender-ajax",
                                            data: {
                                                titre: titre,
                                                debut: debut,
                                                fin: fin,
                                                type: 'ajoute'
                                            },
                                            type: "POST",
                                            success: function (data) {
                                                displayMessage("Event Created Successfully");

                                                calendar.fullCalendar('renderEvent',
                                                    {
                                                        id: data.id,
                                                        titre: titre,
                                                        debut: debut,
                                                        fin: fin,
                                                        allDay: allDay
                                                    },true);

                                                calendar.fullCalendar('unselect');
                                            }
                                        });
                                    }
                                },
                                eventDrop: function (event, delta) {
                                    var debut = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                                    var fin = $.fullCalendar.formatDate(event.end, "Y-MM-DD");

                                    $.ajax({
                                        url: SITEURL + '/full-calender-ajax',
                                        data: {
                                            titre: event.titre,
                                            debut: debut,
                                            fin: fin,
                                            id: event.id,
                                            type: 'metre à jr'
                                        },
                                        type: "POST",
                                        success: function (response) {
                                            displayMessage("Event Updated Successfully");
                                        }
                                    });
                                },
                                eventClick: function (event) {
                                    var deleteMsg = confirm("Do you really want to delete?");
                                    if (deleteMsg) {
                                        $.ajax({
                                            type: "POST",
                                            url: SITEURL + '/full-calender-ajax',
                                            data: {
                                                    id: event.id,
                                                    type: 'delete'
                                            },
                                            success: function (response) {
                                                calendar.fullCalendar('removeEvents', event.id);
                                                displayMessage("Event Deleted Successfully");
                                            }
                                        });
                                    }
                                }

                            });

            });

            function displayMessage(message) {
                toastr.success(message, 'Event');
            }

        </script>
    </div>
@endsection
