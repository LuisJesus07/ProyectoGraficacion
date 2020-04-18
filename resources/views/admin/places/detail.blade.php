@extends('layouts_admin.app')

@section('head')
	
	<style type="text/css">
		
		.card-body{
			padding: 0;
		}
		.card-body img{
			width: 100%;
		}

		.info-place{
			padding: 20px;
		}

	</style>
@endsection

@section('content')

	<!-- Main content -->
	<section class="content">
	  <div class="container-fluid info-place">
	    <div class="row">
	      <div class="col-md-3">

	        <!-- Profile Image -->
	        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">{{$place->property->name}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

              	<img src="{{asset('fotos_places')}}/{{$place->property->url_foto}}">

              	<div class="info-place">
              		
	                <strong><i class="fas fa-book mr-1"></i> Descripcion</strong>

	                <p class="text-muted">
	                  {{$place->property->description}}
	                </p>

	                <hr>

	                <strong><i class="fas fa-map-marker-alt mr-1"></i> Dirección</strong>

	                <p class="text-muted">{{$place->property->address}}</p>

	                <hr>

	                <strong><i class="fas fa-clock"></i> Horario</strong>

	                <p class="text-muted">
	                  {{$place->property->horario}}
	                </p>

                  <hr>

                  <strong><i class="fas fa-phone"></i> Numero telefonico</strong>

                  <p class="text-muted">
                    {{$place->property->phone_number}}
                  </p>

	                <hr>

	                <strong><i class="fas fa-globe-americas"></i> Pagina Web</strong>

	                <p class="text-muted">{{$place->property->web}}</p>

                </div>
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
	              <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab" v-on:click="makeMap">Información</a></li>
	            </ul>
	          </div><!-- /.card-header -->
	          <div class="card-body info-place">
	            <div class="tab-content">
	              <div class="active tab-pane" id="settings">
	                  <form class="form-horizontal" method="POST" action="/update_place" enctype="multipart/form-data">
	                    @csrf
                      @method('PUT')

                      <input type="hidden" class="form-control" name="place_id" value="{{$place->id}}">

                      <input type="hidden" class="form-control" name="property_id" value="{{$place->property->id}}">

                      <input type="hidden" class="form-control" name="geometry_id" value="{{$place->geometry->id}}">

	                    <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Nombre</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" placeholder="Nombre" value="{{$place->property->name}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Foto</label>
                          <div class="col-sm-10">
                            <input type="file" class="form-control" name="url_foto">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Descripción</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="description" placeholder="Descripción" value="{{$place->property->description}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Dirección</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="address" placeholder="Dirección" value="{{$place->property->address}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Horario</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="horario" placeholder="Horario" value="{{$place->property->horario}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Numero telefonico</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control" name="phone_number" placeholder="Numero telefonico" value="{{$place->property->phone_number}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Pagina web</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="web" placeholder="Pagina web" value="{{$place->property->web}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Categoria</label>
                          <div class="col-sm-10">
                            <select class="form-control" name="category_id">
                            	@foreach($categories as $category)
                            		<option value="{{$category->id}}">
                            			{{$category->name}}
                            		</option>
                            	@endforeach
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Longitud</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="lng" name="longitud" placeholder="Longitud" value="{{$place->geometry->longitud}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Latitud</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="lat" name="latitud" placeholder="Latitud" value="{{$place->geometry->latitud}}">
                          </div>
                        </div>
	                    <div class="form-group row">
	                      <div class="offset-sm-2 col-sm-10">
	                        <button type="submit" class="btn btn-primary float-right">Actualizar</button>
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