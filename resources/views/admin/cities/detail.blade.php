@extends('layouts_admin.app')

<style type="text/css">
	
	@import url("https://fonts.googleapis.com/css2?family=Oswald&display=swap");

	.features label{
      font-size: 1.2rem;
      font-family: 'Oswald', sans-serif;
    }
</style>

@section('content')
	
	<!-- Main content -->
	<section class="content">
	  <div class="container-fluid">
	    <div class="row">
	      <div class="col-md-3">

	        <!-- Profile Image -->
	        <div class="card card-primary card-outline">
	          <div class="card-body box-profile">
	            <div class="text-center">
	              <img class="profile-user-img img-fluid img-circle"
	                   src="{{asset('fotos_cities')}}/{{$city->logo}}"
	                   alt="User profile picture">
	            </div>

	            <h3 class="profile-username text-center">{{$city->name}}</h3>

	            <p class="text-muted text-center"></p>

	            <ul class="list-group list-group-unbordered mb-3">
	              <li class="list-group-item">
	                <b>Total de Lugares: </b> <a class="float-right">{{count($city->places)}} lugares</a>
	              </li>
	            </ul>

	          </div>
	          <!-- /.card-body -->
	        </div>
	        <!-- /.card -->
	      </div>
	      <!-- /.col -->
	      <div class="col-md-9">
	        <div class="card">
	          <div class="card-header p-2">
	            <ul class="nav nav-pills">
	              <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Lugares</a></li>
	                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Registrar un lugar</a></li>
	            </ul>
	          </div><!-- /.card-header -->
	          <div class="card-body">
	            <div class="tab-content">
	              <!-- /.tab-pane -->
	              <div class="active tab-pane" id="timeline">
                    @foreach($city->places as $place)

                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="{{asset('fotos_places')}}/{{$place->property->url_foto}}" alt="User Image">
                        <span class="username">
                          <a href="#">{{$place->property->name}}</a>
                        </span>
                        <span class="description">Regitrado el {{$place->property->created_at}}</span>
                      </div>
                      <!-- /.user-block -->
                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img class="img-fluid" src="{{asset('fotos_places')}}/{{$place->property->url_foto}}" alt="Photo">
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                          <div class="row features">
                            <label>Direccion: {{$place->property->address}}</label>
                            <label>Horario: {{$place->property->horario}}</label>
                            <label>Web: <a target="_blank" href="https://{{$place->property->web}}">{{$place->property->web}}</a></label>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    </div>
                    <!-- /.post -->

                    @endforeach
	              </div>
	              <!-- /.tab-pane -->
	              <div class="tab-pane" id="settings">
	                  <form class="form-horizontal" method="POST" action="/inscribeToProject/">
	                    @csrf
	                    <div class="form-group row">
	                      <label for="inputName" class="col-sm-2 col-form-label">Proyecto</label>
	                      <div class="col-sm-10">
	                        
	                      </div>
	                    </div>
	                    <div class="form-group row">
	                      <div class="offset-sm-2 col-sm-10">
	                        <button type="submit" class="btn btn-primary">Inscribir</button>
	                      </div>
	                    </div>
	                  </form>
	              </div>
	              <!-- /.tab-pane -->
	            </div>
	            <!-- /.tab-content -->
	          </div><!-- /.card-body -->
	        </div>
	        <!-- /.nav-tabs-custom -->
	      </div>
	      <!-- /.col -->
	    </div>
	    <!-- /.row -->
	  </div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->

@endsection