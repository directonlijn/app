@extends('baselayout')

@section('title')
	Login
@stop

@section('content')
<?php
	// $password = 'password';
	// $hashedPassword = Hash::make($password);
	// echo $hashedPassword; // $2y$10$jSAr/RwmjhwioDlJErOk9OQEO7huLz9O6Iuf/udyGbHPiTNuB3Iuy
?>
<div class="row">
	<div class="col-md-6">
		<h2>Log in</h2>
		<p>Hi, here you can login to your account. Just fill in the form and press Sign In button.</p>
		<br>
		{!! Html::ul($errors->all(), array('class'=>'alert alert-danger errors')) !!}

		{!! Form::open(array('url' => 'login','class'=>'form')) !!}

		<br>{!! Form::label('email', 'E-Mail Address') !!}
		{!! Form::text('email', null, array('class' => 'form-control','placeholder' => 'example@gmail.com')) !!}
		<br>{!! Form::label('password', 'Password') !!}
		{!! Form::password('password', array('class' => 'form-control')) !!}
		<br>
		{!! Form::submit('Sign In' , array('class' => 'btn btn-primary')) !!}

		{!! Form::close() !!}
		<br>
	</div>
</div>

@stop
