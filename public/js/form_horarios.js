let contador = 1;

        function agregarCampo() {
            // Crear un nuevo div contenedor para el nuevo grupo de campos
            const nuevoDiv = document.createElement('div');
            nuevoDiv.id = 'campo' + contador;
            nuevoDiv.className = 'form-row align-items-end mb-3';

            // Crear el select para el día de la semana
            const divSelect = document.createElement('div');
            divSelect.className = 'col-md-4';
            const selectDia = document.createElement('select');
            selectDia.name = 'dia' + contador;
            selectDia.className = 'form-control';
            const dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
            dias.forEach(function(dia) {
                const opcion = document.createElement('option');
                opcion.value = dia;
                opcion.textContent = dia;
                selectDia.appendChild(opcion);
            });
            divSelect.appendChild(selectDia);

            // Crear el input para la hora de inicio
            const divHoraInicio = document.createElement('div');
            divHoraInicio.className = 'col-md-3';
            const horaInicio = document.createElement('input');
            horaInicio.type = 'time';
            horaInicio.name = 'horaInicio' + contador;
            horaInicio.className = 'form-control';
            divHoraInicio.appendChild(horaInicio);

            // Crear el input para la hora de fin
            const divHoraFin = document.createElement('div');
            divHoraFin.className = 'col-md-3';
            const horaFin = document.createElement('input');
            horaFin.type = 'time';
            horaFin.name = 'horaFin' + contador;
            horaFin.className = 'form-control';
            divHoraFin.appendChild(horaFin);

            // Crear un botón para eliminar el grupo de campos
            const divBotonEliminar = document.createElement('div');
            divBotonEliminar.className = 'col-md-2';
            const botonEliminar = document.createElement('button');
            botonEliminar.type = 'button';
            botonEliminar.className = 'btn btn-danger btn-sm btn-circle';
            botonEliminar.textContent = 'X';
            botonEliminar.onclick = function() {
                eliminarCampo(nuevoDiv.id);
            };
            divBotonEliminar.appendChild(botonEliminar);

            // Agregar todos los elementos al div
            nuevoDiv.appendChild(divSelect);
            nuevoDiv.appendChild(divHoraInicio);
            nuevoDiv.appendChild(divHoraFin);
            nuevoDiv.appendChild(divBotonEliminar);

            // Agregar el div al contenedor de campos
            document.getElementById('contenedorCampos').appendChild(nuevoDiv);

            // Incrementar el contador para el siguiente grupo de campos
            contador++;
        }
         function eliminarCampo(id) {
            const campoAEliminar = document.getElementById(id);
            campoAEliminar.parentNode.removeChild(campoAEliminar);
        }