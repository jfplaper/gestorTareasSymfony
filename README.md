# App de Gestión de tareas

## Descripción

Es una aplicación web para gestionar las tareas de diferentes proyectos, personales o colectivos, 
de una empresa.

## Requisitos y funcionamiento

- La empresa tiene proyectos y cada proyecto tiene tareas, con su descripción, fecha de entrega o límite, y trabajador-creador de la tarea.
- Sólo el administrador puede: crear proyectos, mandar invitación a trabajadores y cambiar una tarea de hecha a no hecha de nuevo (conviene hacer un CRUD).
- Por defecto, al registrarse un usuario, se le crea un proyecto personal donde puede crear sus propias tareas. Luego los trabajadores pueden aceptar proyectos, y entonces: crear tareas, marcar como hechas y asignar.
- Sólo son asignadas personas que estén dentro de ese proyecto y sólo una persona por tarea.
- Cuando se marca una tarea como hecha queremos saber quién la ha marcado como hecha y cuándo. También se pueden borrar.
