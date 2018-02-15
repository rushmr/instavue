@extends('layouts.app')

@section('content')
    <div class="row">
    	<div class="col-md-12">
<div class="panel panel-info">

	<div class="panel-heading">
		<h4>Результаты парсинга</h4>
	</div>

	<div class="panel-body">

	<table class="table table-hover">

		<thead>
			<th style='width:25%'>Изображение</th>
			<th style='width:60%'>Текст</th>
			<th style='width:15%'></th>
		</thead>

		<tbody>
		@foreach($posts as $p)
			<tr>
				<td><a class="picture" href="{{ $p['picture_path'] }}" target="_blank"><img src="{{ $p['thumb'] }}"></td>
				<td><textarea class="form-control text" rows="10">{{ $p['text'] }}</textarea></td>
				<td><a data-post-id="{{ $p['post_id'] }}" class="btn btn-success addpost" style="cursor:pointer;">Добавить</a></td>
			</tr>
		@endforeach
		</tbody>
	</table>

</div>
</div>
</div>
</div>
@stop

@section('scripts')
<script src="http://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="{{ asset('js/script.js') }}"></script>
@stop