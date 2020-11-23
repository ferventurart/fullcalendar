<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barberia Peluquito | Citas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.4.0/main.min.css" integrity="sha256-uq9PNlMzB+1h01Ij9cx7zeE2OR2pLAfRw3uUUOOPKdA=" crossorigin="anonymous">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.css' rel='stylesheet' />
    <link href='https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.1/css/all.css' rel='stylesheet'>
    <style>
        body {
            padding-top: 5rem;
        }

        .starter-template {
            padding: 3rem 1.5rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="javascript:;"> <i class="fas fa-cut"></i> Barberia Peluquito | Citas <i class="fas fa-calendar-alt"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <main role="main" class="container">
        <div class="starter-template">
            <div id='calendar'></div>


            <div class="modal" tabindex="-1" id="createEventModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formEvento" autocomplete="off">
                                <div class="form-group">
                                    <label for="title">Titulo</label>
                                    <input type="email" class="form-control" id="title" name="title" placeholder="Ingrese el titulo de la cita">
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripcion</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Ingrese la descripcion de la cita"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="title">Inicio</label>
                                    <input type="datetime-local" class="form-control" id="start" name="start" placeholder="Ingrese Fecha Inicio de la Cita">
                                </div>
                                <div class="form-group">
                                    <label for="title">Fin</label>
                                    <input type="datetime-local" class="form-control" id="end" name="end" placeholder="Ingrese Fecha Fin de la Cita">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="allDay" name="allDay">
                                    <label class="form-check-label" for="allDay">
                                        Todo el Dia
                                    </label>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" id="btnSave" class="btn btn-primary">Crear Cita</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.4.0/main.min.js" integrity="sha256-oenhI3DRqaPoTMAVBBzQUjOKPEdbdFFtTCNIosGwro0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.4.0/locales-all.min.js" integrity="sha256-o+Kyw2gfzvG9f4D8cJQ6Ffkt6ZroHCNbjGUHH9qwnxE=" crossorigin="anonymous"></script>
    <script src="helper/HttpFactory.js"></script>
    <script src="helper/FormHelper.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const httpFactory = new HttpFactory();

            const calendarEl = document.getElementById('calendar'); //OBTENIENDO EL ELEMENTO HTML CON EL ID calendar
            const btnSave = document.getElementById('btnSave');


            const calendar = new FullCalendar.Calendar(calendarEl, { // CREAR UNA COSNTANTE CALENDAR = Calendar de la clase FullCalendar
                firstDay: 0, // CALENDARIO INICIA EL FORMATO CON EL DIA 0 --> DOMINGO
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth' // VISTAS
                }, /// CALENDARIO VAS A TENER EN TU BOTONERA A LA IZQUIERDA PAGINADOR, EN EL CENTRO EL TITULO, EN LA DERECHA LAS VISTAS
                initialView: 'dayGridMonth', // CALENDARIO TU VISTA INICIAL VA SER POR MES
                locale: 'es', //CALENDARIO TRADUCITE AL ESPAÑOL
                themeSystem: 'bootstrap', // CALENDARIO USA BOOTSTRAP
                navLinks: true, // CALENDARIO LOS DIAS QUE SEAN LINKS
                //DECLARAR TUS HORAS HABILES
                businessHours: [{
                        //DIAS HABILES DE LA SEMANA, QUE ESTARA HABILITADO EL SERVICIO
                        //0 es Domingo, 1 es Lunes ....
                        daysOfWeek: [1, 2, 3, 4, 5],
                        //HORAS HABILES DE LA SEMANA
                        startTime: '8:00', // HORA DE APERTURA DE LA TIENDA 8:00 A.M.
                        endTime: '19:00', // HORA DE CIERRE DE LA TIENDA 7:00 P.M

                    },
                    {
                        //HORARIO PARA SABADO
                        daysOfWeek: [6],
                        //HORAS HABILES PARA SABADO
                        startTime: '8:00', // HORA DE APERTURA DE LA TIENDA 8:00 A.M.
                        endTime: '12:00', // HORA DE CIERRE DE LA TIENDA 12:00 P.M

                    }
                ],
                dayMaxEvents: true, // SE VEAN TODOS LOS EVENTOS DE UN DIA EN UN POPOVER
                editable: true, // EDITABLES ES PARA MOVER LOS EVENTOS EN EL CALENDARIO
                events: {
                    url: '<?= base_url('api/eventos'); ?>',
                    method: 'POST',
                    /*extraParams: {
                        peluqueroId: 'something',
                        custom_param2: 'somethingelse'
                    },*/
                    failure: function() {
                        alert('Ocurrio un error cargando los eventos!');
                    }
                }
            });

            calendar.render();

            calendar.on('dateClick', function(info) { // CUANDO LE DAS CLICK A UNA FECHA DEL CALENDARIO
                const startDate = document.getElementById('start');
                const endDate = document.getElementById('end');

                startDate.value = info.dateStr + 'T08:00';
                endDate.value = info.dateStr + 'T08:30';

                $('#createEventModal').modal('show');
                $('.modal-title').text(`Crear Cita para el ${info.dateStr}`);
            });

            calendar.on('eventClick', function(info) { //CUANDO DAMOS CLICK A UN EVENTO DEL CALENDARIO
                httpFactory.get("<?= base_url('api/eventos/edit') ?>/" + info.event.id)
                    .then(evento => {
                        const {
                            title,
                            id
                        } = evento;
                        if (confirm(`¿Desea Eliminar la Cita de ${title}?`)) {
                            httpFactory.delete("<?= base_url('api/eventos/delete') ?>/" + id)
                                .then(data => {
                                    calendar.refetchEvents(); // VOY A REFRESCAR LOS EVENTOS DE MI CALENDARIO
                                    alert('¡Cita Eliminada!');
                                }).catch(err => {
                                    console.error(err);
                                });
                        }
                    }).catch(err => {
                        console.error(err);
                    });

                /*if (eventObj.url) {
                    alert(
                        'Clicked ' + eventObj.title + '.\n' +
                        'Will open ' + eventObj.url + ' in a new tab'
                    );

                    window.open(eventObj.url);

                    info.jsEvent.preventDefault(); // prevents browser from following link in current tab.
                } else {
                    alert('Clicked ' + eventObj.title);
                    console.log(eventObj);
                }*/
            });

            calendar.on('eventDrop', function(info) { //CUANDO ARRASTRAMOS LA CITA DE UNA CASILLA A OTRA OSEA CUANDO LE CAMBIAMOS LA FECHA
                if (confirm("¿Desea mover la Cita?")) {
                    httpFactory.put("<?= base_url('api/eventos/update') ?>/" + info.event.id, info.event)
                        .then(data => {
                            calendar.refetchEvents(); // VOY A REFRESCAR LOS EVENTOS DE MI CALENDARIO
                            alert('¡Fecha de la cita Actualizada!');
                        }).catch(err => {
                            console.error(err);
                        });
                }
            });

            calendar.on('eventResize', function(info) {
                if (confirm("¿Desea alargar la Cita?")) {
                    httpFactory.put("<?= base_url('api/eventos/update') ?>/" + info.event.id, info.event)
                        .then(data => {
                            calendar.refetchEvents(); // VOY A REFRESCAR LOS EVENTOS DE MI CALENDARIO
                            alert('¡Fecha de la cita Actualizada!');
                        }).catch(err => {
                            console.error(err);
                        });
                }
            });


            btnSave.addEventListener("click", function() {
                const evento = formToJson('#formEvento');
                httpFactory.post("<?= base_url('api/eventos/create') ?>", evento)
                    .then(data => {
                        calendar.refetchEvents(); // VOY A REFRESCAR LOS EVENTOS DE MI CALENDARIO
                        $('#createEventModal').modal('hide'); // OCULTO EL MODAL
                        limpiarFormulario();
                    }).catch(err => {
                        console.error(err);
                    });
            });

            const limpiarFormulario = () => {
                $('#formEvento').trigger('reset');
            }
        });
    </script>
</body>

</html>