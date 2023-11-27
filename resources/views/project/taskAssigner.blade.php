@extends('layout.main')
@section('content')
<div class="main-screen">
	<section class="reports">
		<div id="taskAssignApp" class="row">
			<div class="col-md-12">
				<select v-model="user_id" class="form-control">
					<option value="0">Select User/Workforce</option>
					@foreach($users as $user)
						<option value="{{$user->id}}">{{$user->name}} | {{$user->email}}</option>
					@endforeach
				</select>
				<hr>
			</div>
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr v-for="(task, taskk) in tasks" :key="taskk">
								<td>
									<select v-model="task.grid_id" class="form-control">
										<option value="0">Grid/Task Type</option>
										@foreach($project->grids as $grid)
											<option value="{{$grid->id}}">{{$grid->grid_name}}</option>
										@endforeach
									</select>
								</td>
								<td>
									<input v-model="task.due_date" type="datetime-local" class="form-control" placeholder="Due Date" />
								</td>
								<td>
									<select v-model="task.priority" class="form-control">
										<option value="">Priority</option>
										@foreach($taskPriorities as $tpk=>$tp)
											<option value="{{$tpk}}">{{$tp['name']}}</option>
										@endforeach
									</select>
								</td>
								<td style="width: 400px">
									<input v-model="task.title" type="text" placeholder="Title" class="form-control" />
									<textarea v-model="task.description" class="form-control mt-3" placeholder="Task Detail"></textarea>
									<input :id="'taskFiles'+taskk" multiple type="file" class="form-control mt-3" />
								</td>
								<td>
									<button @click="removeRow(taskk)" class="border-0 bg-danger text-light rounded">
										<i class="fa fa-trash"></i>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-12">
				<button @click="addRow" class="btn btn-info float-end ml-3">Add Row</button>
				<button @click="assignTasks" class="btn btn-warning ml-3">Assign Now</button>
			</div>
		</div>
	</section>
</div>
@endsection
@push('js')
<script>
const taskAssignApp = createApp({
	data() {
		return {
			tasks: [],
			user_id: 0,
		}
	},
	methods: {
		addRow(){
			this.tasks.push({
				grid_id: '0',
				priority: '0',
				due_date: '',
				title: '',
				description: '',
				files: [],
			})
		},
		removeRow(index){
			this.tasks.splice(index, 1);
		},
		async assignTasks(){
			const formData = new FormData();
			for(let i = 0; i < this.tasks.length; i++){
				const task = this.tasks[i]
				formData.append('task['+i+'][user_id]', this.user_id)
				formData.append('task['+i+'][project_grid_id]', task.grid_id)
				formData.append('task['+i+'][project_id]', {{$project->id}})
				formData.append('task['+i+'][due_date]', task.due_date)
				formData.append('task['+i+'][title]', task.title)
				formData.append('task['+i+'][is_priority]', task.priority)
				formData.append('task['+i+'][description]', task.description)
				const files = document.getElementById('taskFiles'+i).files
				for(let q = 0; q < files.length; q++){
					formData.append('task['+i+'][files]['+q+']',files[q])
				}
			}
			const result = await axios.post('{{route('workforce.tasks.store',$project)}}', formData).then(e=>e.data)
			if(result.status){
				this.tasks = [];
				swal({
					title: "Tasks Assigned",
					icon: "success",
				});
			}
		}
	},
	mounted(){
		this.addRow()
	},
}).mount('#taskAssignApp')
</script>
@endpush
@push('css')
<style>
	.reports {
		background: #fff;
		padding: 40px;
		border-radius: 20px;
	}
</style>
@endpush