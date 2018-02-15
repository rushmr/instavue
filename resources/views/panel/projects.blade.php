@extends('layouts.app')

@section('content')
	 <div class="row">
    <div class="col-md-3">
	 	<a href="{{ route('projects') }}"><button type="button" class="btn btn-info">Список проектов</button></a>
    </div>
    <div class="col-md-3">
    <a href="{{ route('project.create') }}"><button type="button" class="btn btn-info">Добавить проект</button></a>
    </div>
  </div>
    <br>
    <div class="row">
    	<div class="col-md-12">
<div class="panel panel-info">

	<div class="panel-heading">
		<h4>Проекты</h4>
	</div>

	<div class="panel-body">


	@if(!$projects->isEmpty())
	<table class="table table-hover">

		<thead>
			<th>Название</th>
			<th>Редактирование</th>
			<th>Удаление</th>
		</thead>

		<tbody>
		@foreach($projects as $p)
			<tr>
				<td>{{ $p->name }}</td>
				<td><a class="btn btn-xs btn-info" href="{{ route('project.edit', ['id' =>$p->id]) }}">Редактировать</a></td>
				<td><a onclick="return confirm('Уверены?');" class="btn btn-xs btn-danger" href="{{ route('project.delete', ['id' =>$p->id]) }} ">Удалить</a></td>
			</tr>
		@endforeach
		</tbody>
	</table>
	@else
	Проектов нет
	@endif
</div>
</div>
</div>
</div>
@stop

@section('main_scripts')
<script src="{{ asset('js/app.js') }}"></script>
@stop