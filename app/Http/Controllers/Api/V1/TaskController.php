<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use App\Models\Notification;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function getTasksForToday()
    {
        // Obtener solo las tareas del día actual
        $tasks = Task::whereDate('created_at', Carbon::today())
            ->orderBy('is_completed', 'desc')
            ->get();

        return response()->json($tasks);
    }

    public function toggleTaskCompletion(Request $request, $id)
    {
        // Alternar el estado de la tarea (completada o pendiente)
        $task = Task::find($id);
        $task->is_completed = !$task->is_completed;  // Cambiar el estado
        $task->save();

        return response()->json(['success' => true]);
    }

    public function addTask(Request $request)
    {
        // Añadir una nueva tarea
        $task = Task::create([
            'description' => $request->input('description'),
            'due_at' => Carbon::today()->setTime(20, 30),
        ]);

        return response()->json($task);
    }

    public function markAsCompleted(Request $request, $id)
    {
        $task = Task::find($id);
        $task->is_completed = true;
        $task->save();

        return response()->json(['success' => true]);
    }

    public function getNotifications()
    {
        $notifications = Notification::where('is_read', false)->get();
        return response()->json($notifications);
    }

    public function checkPendingTasks()
    {
        try {
            // Verificar las tareas pendientes con `due_at` en el pasado o en el momento actual
            $tasks = Task::where('is_completed', false)
                ->where('due_at', '<=', Carbon::now()) // "duea_at" es mayor a la fecha de hoy
                ->get();

            $notifications = [];

            foreach ($tasks as $task) {
                // Verificar si ya existe una notificación para esta tarea
                $existingNotification = Notification::where('task_id', $task->id)->first();

                if (!$existingNotification) {
                    $newNotification = Notification::create([
                        'task_id' => $task->id,
                        'type' => 'task_reminder',
                        'message' => 'Recuerda completar la tarea: ' . $task->description,
                        'notified_at' => Carbon::now(),
                    ]);

                    Log::info('Notificación creada: ' . $newNotification);

                    $notifications[] = $newNotification;  // Agregar la nueva notificación al array
                } else if(!$existingNotification->is_read) {
                    $notifications[] = $existingNotification;
                } else {
                    Log::info('Notificación ya existe: ' . $existingNotification);
                }
            }

            if (!empty($notifications)) {
                return response()->json(['success' => true, 'notifications' => $notifications]);
            } else {
                return response()->json(['success' => true, 'notifications' => []]);
            }
        } catch (\Exception $e) {
            Log::error('Error en checkPendingTasks: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteTask($id)
    {
        // Eliminar la tarea
        $task = Task::find($id);

        if ($task) {
            $task->delete();  // Eliminar la tarea
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Tarea no encontrada'], 404);
    }

    public function markNotificationsAsRead(Request $request)
    {
        try {
            // Recibir los IDs de las notificaciones que se deben marcar como leídas
            $notificationIds = $request->input('notification_ids', []);

            if (!empty($notificationIds)) {
                // Actualizar el campo 'is_read' a true para las notificaciones con esos IDs
                Notification::whereIn('id', $notificationIds)
                    ->update(['is_read' => true]);

                return response()->json(['success' => true, 'message' => 'Notificaciones marcadas como leídas']);
            } else {
                return response()->json(['success' => false, 'message' => 'No se proporcionaron notificaciones']);
            }
        } catch (\Exception $e) {
            Log::error('Error al marcar notificaciones como leídas: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
