<!-- resources/views/tasks.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors') 
        
        <!-- New Task Form -->

        <form action="{{ url('task/'.$task->id) }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}
            {!! method_field('PATCH') !!}

            <!-- Task Name -->
            <div class="form-group">
                <label for="task" class="col-sm-3 control-label">Task</label>

                <div class="col-sm-6">
                    <input type="text" name="name" id="edit-task-{{ $task->id }}" value="{{ $task->name }}" class="form-control">
                </div>
            </div>

            <!-- Task Status -->
            <div class="form-group">
                <label for="task_status" class="col-sm-3 control-label">Task Status</label>

                <div class="col-sm-3">
                    <!-- <input type="text" name="task_status" id="task_status-{{ $task->id }}" value="{{ $task->task_status }}" class="form-control"> -->
                    <select id="task_status" name="task_status">
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>

            <!-- Update Task Button -->
            <div class="col-sm-offset-4 col-sm-2">
                <!-- <div class="col-sm-offset-3 col-sm-5"> -->
                    <button type="submit" class="btn btn-info">
                        <i class="fa fa-save"></i> Update Task
                    </button>
                    
                    
               <!--  </div> -->
                
            </div>
        </form>
       <!--  <form action="{{ url('/tasks') }}" method="GET" class="form-horizontal"> -->
            <!-- {!! csrf_field() !!} -->
               <div class=col-sm-offset-6> 
                    <a href="{{ url('/tasks') }}">
                        <button class="btn btn-info">
                            <i class="fa fa-times"></i> Cancel
                    </button>    
                    </a>

                </div>
        <!-- </form> -->
        
    </div>

@endsection
