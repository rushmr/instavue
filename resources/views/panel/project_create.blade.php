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
@if(count($errors)>0)
	<ul class="list-group">
		@foreach($errors->all() as $error)
			<li class="list-group-item text-danger">{{ $error }}</li>
		@endforeach
	</ul>
@endif

<div class="panel panel-info">

  <div class="panel-heading">
    <h4>Новый проект</h4>
  </div>

  <div class="panel-body">

	 <form action="{{ route('project.store') }}" method="POST">
	 	{{ csrf_field() }}
	  <div class="form-group">
	    <label for="name">Название</label>
	    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
	  </div>
	  <div class="form-group">
	    <label for="login">Инстаграмм логин</label>
	    <input type="text" name="login" class="form-control" value="{{ old('login') }}">
	  </div>
	  <div class="form-group">
	    <label for="password">Инстаграмм пароль</label>
	    <input type="password" name="password" class="form-control" value="{{ old('password') }}">
	  </div>
	  <div class="form-group">
	    <label for="feed">Источники контента (паблики VK)</label>
	    <textarea name="feed" id="feed" class="form-control" rows="10">{{ old('feed') }}</textarea>
	  </div>
	  <div class="form-group">
	    <label for="tags">Список тегов для поста</label>
	    <textarea name="tags" id="tags" class="form-control" rows="10">{{ old('tags') }}</textarea>
	  </div>
	  <button type="submit" class="btn btn-success">Добавить</button>
	</form>

  </div>
</div>
</div>
</div>
@stop

@section('main_scripts')
<script src="{{ asset('js/app.js') }}"></script>
@stop