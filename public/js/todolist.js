document.addEventListener('DOMContentLoaded', function () {
  const todoInput = document.getElementById('todo-input');
  const todoList = document.getElementById('todo-list');
  const addTaskBtn = document.getElementById('add-task-btn');
  const notificationList = document.getElementById('notification-list');
  const notificationBadge = document.getElementById('notification-badge');
  const noNotificationsText = document.getElementById('no-notifications');
  const notificationDropdown = document.getElementById('notificationDropdown');
  const soundUrl = document.querySelector('meta[name="sound-url"]').getAttribute('content');

  // Archivo de audio para el sonido de notificación
  const notificationSound = new Audio(soundUrl);

  // Cargar las tareas del día al cargar la página
  fetchTasksForToday();

  // Añadir una tarea
  addTaskBtn.addEventListener('click', function (event) {
    event.preventDefault();
    const taskDescription = todoInput.value.trim();

    console.log('Intentando agregar tarea:', taskDescription);

    if (taskDescription) {
      // Realizar una solicitud POST para agregar la tarea
      fetch('api/v1/tasks/add', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ description: taskDescription })
      })
        .then(response => response.json())
        .then(task => {
          console.log('Tarea agregada:', task);
          addTaskToDOM(task);  // Agregar la tarea al DOM
          todoInput.value = ''; // Limpiar el input
        })
        .catch(error => console.error('Error al agregar la tarea:', error));
    }
  });

  // Cargar las tareas del día
  function fetchTasksForToday() {
    console.log('Cargando tareas del día...');
    fetch('api/v1/tasks/today', {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
      .then(response => response.json())
      .then(tasks => {
        console.log('Tareas recibidas:', tasks);
        todoList.innerHTML = '';  // Limpiar la lista de tareas existente

        tasks.forEach(task => {
          addTaskToDOM(task);  // Agregar cada tarea al DOM
        });
      })
      .catch(error => console.error('Error al cargar las tareas:', error));
  }

  // Añadir una tarea al DOM
  function addTaskToDOM(task) {
    console.log('Añadiendo tarea al DOM:', task);
    const listItem = document.createElement('li');
    listItem.dataset.id = task.id;

    // Verificar si la tarea está completada y agregar la clase correspondiente
    const completedClass = task.is_completed ? 'completed' : '';

    // Si `completedClass` no es una cadena vacía, agregarla a la lista de clases
    if (completedClass) {
      listItem.classList.add(completedClass);
    }

    listItem.innerHTML = `
      <div class="form-check form-check-primary">
          <label class="form-check-label">
              <input class="checkbox" type="checkbox"${task.is_completed ? 'checked' : ''}> ${task.description} <i class="input-helper"></i></label>
      </div>
      <i class="remove mdi mdi-close-box"></i>
    `;
    todoList.appendChild(listItem);

    // Alternar el estado completado de la tarea
    listItem.querySelector('.checkbox').addEventListener('change', function () {
      console.log('Alternando estado de tarea:', task.id);
      toggleTaskCompletion(task.id);
      listItem.classList.toggle('completed');
    });

    // Eliminar la tarea
    listItem.querySelector('.remove').addEventListener('click', function () {
      console.log('Eliminando tarea:', task.id);
      deleteTask(task.id);
      listItem.remove();
    });
  }

  // Alternar el estado completado de una tarea
  function toggleTaskCompletion(taskId) {
    fetch(`api/v1/tasks/${taskId}/toggle`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
      .then(response => response.json())
      .then(data => console.log('Estado de tarea alternado:', data.success))
      .catch(error => console.error('Error al alternar estado de la tarea:', error));
  }

  // Eliminar una tarea del backend
  function deleteTask(taskId) {
    fetch(`api/v1/tasks/${taskId}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
      .then(response => response.json())
      .then(data => console.log('Tarea eliminada:', data.success))
      .catch(error => console.error('Error al eliminar la tarea:', error));
  }

  notificationDropdown.addEventListener('click', function () {
    const notificationIds = Array.from(notificationList.querySelectorAll('.dropdown-item'))
      .map(item => item.dataset.id);  // Obtener los IDs de las notificaciones mostradas

    if (notificationIds.length > 0) {
      markNotificationsAsRead(notificationIds);  // Marcar como leídas
    }
  });

  // Mostrar notificaciones de tareas pendientes
  function checkPendingTasks() {
    console.log('Verificando notificaciones pendientes...');
    fetch('api/v1/notifications/check')
      .then(response => response.json())
      .then(data => {
        console.log('Notificaciones recibidas:', data);
        notificationList.innerHTML = '';  // Limpiar las notificaciones anteriores

        if (data.success) {
          if (data.notifications.length > 0) {
            // Reproducir sonido de notificación cuando haya nuevas notificaciones
            console.log('Reproduciendo sonido de notificación');
            notificationSound.play().catch(error => console.error('Error al reproducir el sonido:', error));

            // Mostrar el badge con la cantidad de notificaciones
            notificationBadge.textContent = data.notifications.length;
            notificationBadge.classList.remove('d-none');
            noNotificationsText.classList.add('d-none');  // Ocultar el mensaje de "No notifications"

            // Iterar sobre las notificaciones y mostrarlas
            data.notifications.forEach(notification => {
              const notificationItem = document.createElement('a');
              notificationItem.classList.add('dropdown-item', 'preview-item');
              notificationItem.dataset.id = notification.id;  // Guardar el ID de la notificación
              notificationItem.innerHTML = `
                <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-bell text-success"></i>
                    </div>
                </div>
                <div class="preview-item-content">
                    <p class="preview-subject mb-1">${notification.message}</p>
                </div>
              `;
              notificationList.appendChild(notificationItem);
            });
          } else {
            notificationBadge.classList.add('d-none');
            noNotificationsText.classList.remove('d-none');
            console.log('No hay notificaciones');
          }
        } else {
          console.log('Error: ', data.error);
        }
      })
      .catch(error => console.error('Error al verificar las notificaciones:', error));
  }

  // Función para marcar las notificaciones como leídas
  function markNotificationsAsRead(notificationIds) {
    console.log('Marcando notificaciones como leídas:', notificationIds);
    fetch('api/v1/notifications/mark-as-read', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({ notification_ids: notificationIds })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        console.log('Notificaciones marcadas como leídas');
      } else {
        console.error('Error al marcar las notificaciones:', data.message);
      }
    })
    .catch(error => console.error('Error al marcar las notificaciones como leídas:', error));
  }

  // Llamar a la función que revisa tareas pendientes cada 0 segundos
  setInterval(checkPendingTasks, 10000);  // 10 segundos
});
