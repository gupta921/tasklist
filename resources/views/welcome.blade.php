<!DOCTYPE html>
<html lang="en">
	<head>
  		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		  <meta name="csrf-token" content="{{ csrf_token() }}">
  		<title>Simple To Do List</title>
  		<link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
		  <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet"  type='text/css'>
		<style>
			
			.task-table {
			margin-top: 20px;
			}
			.btn-action {
			display: flex;
			gap: 10px;
			justify-content: center;
			}
			.add-task-btn {
			margin-left: 10px;
			}
		</style>
		<script>
			var base_url = {!! json_encode(url('/')) !!}
		</script>
	</head>
	<body>
		<div class="container mt-5">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title text-center">PHP - Simple To Do List App</h3>
					<div id="taskResponse"></div>
					<div class="d-flex justify-content-center mb-3">
						<input type="text" class="form-control w-50" placeholder="Enter task" aria-label="Task input" name="task" id="task">
						<button class="btn btn-primary add-task-btn addTask">Add Task</button>
						<button class="btn btn-primary add-task-btn showAllTask">Show All Task</button>
					</div>
					<table class="table table-striped table-bordered text-center task-table">
						<thead>
							<tr>
								<th>#</th>
								<th>Task</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="taskList">
							@if($tasks->isEmpty())
								<p>No task found.</p>
							@else
							@foreach($tasks as $task)
								<tr>
									<td>{{ $task->id }}</td>
									<td>{{ $task->task }}</td>
									<td id="tsk_status_{{$task->id}}">{{$task->completed==0?"":"Done"}}</td>
									<td class="btn-action">
										@if($task->completed==0)
										<button class="btn btn-success completeTask completeBtn_{{$task->id}}" id="{{$task->id}}"><i class="fa fa-check"></i></button>
										@endif
										
										<button class="btn btn-danger deleteTask" id="{{$task->id}}"><i class="fa fa-close"></i></button>
									</td>
								</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>

  		<script src="{{ asset('js/jquery.min.js')}}"></script>
  		<script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
		 <script src="{{ asset('js/custom.js')}}"></script>
	</body>
</html>