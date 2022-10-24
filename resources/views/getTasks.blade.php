@foreach($tasks as $task)
    <tr>
        <td>{{ $task->id }}</td>
        <td>{{ $task->name }}</td>
        <td>{{ $task->password }}</td>
        <td>{{ $task->point }}</td>
        <td><button value="{{ $task->id }}" type="button" id="delete" data-bs-toggle="modal" data-bs-target="#deletemodal" class="btn btn-primary pull-right delete_button">Delete</button>
            <button value="{{ $task->id }}" type="button" id="add" data-bs-toggle="modal" data-bs-target="#addnew" class="btn btn-primary pull-right edit_button">Edit</button>
        </td>
    </tr>
@endforeach