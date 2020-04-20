@extends('layouts_admin.app')

@section('head')

	<script src="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.js"></script>
  <link href="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.css" rel="stylesheet" />

    <style type="text/css">
	
	@import url("https://fonts.googleapis.com/css2?family=Oswald&display=swap");

	.features label{
      font-size: 1.2rem;
      font-family: 'Oswald', sans-serif;
    }

    #map { 
    	width: 100%; 
    	height: 400px;
    }

    .marker {
      background-image: url({{ asset('iconos/mapbox-icon.png') }});
      background-size: cover;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      cursor: pointer;
       z-index: 200;
    }

    .map-loading{
      display: none;
      margin-top: 1%;
      margin-left: 50%;
    }
</style>

@endsection


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
	              <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab" v-on:click="makeMap">Registrar un lugar</a></li>
                <label class="map-loading">Cargando mapa...</label>
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
                          <a href="/places/{{$place->id}}">{{$place->property->name}}</a>
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
                            <label>Categoria: {{$place->category->name}}</label>
                          </div>
                          <div class="row features">
                            <label>Direccion: {{$place->property->address}}</label>
                          </div>
                          <div class="row features">
                            <label>Horario: {{$place->property->horario}}</label>
                          </div>
                          <div class="row features">
                            <label>Numero telefonico: {{$place->property->phone_number}}</label>
                          </div>
                          <div class="row features">
                            <label>Web: <a target="_blank" href="https://{{$place->property->web}}">{{$place->property->web}}</a></label>
                          </div>
                            <!-- /.col -->
                          
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
	                  <form class="form-horizontal" method="POST" action="/store_place" enctype="multipart/form-data">
	                    @csrf
                      <input type="hidden" class="form-control" name="city_id" value="{{$city->id}}">
	                    <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Nombre</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" placeholder="Nombre">
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
                            <input type="text" class="form-control" name="description" placeholder="Descripción">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Dirección</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="address" placeholder="Dirección">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Horario</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="horario" placeholder="Horario">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Numero telefonico</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control" name="phone_number" placeholder="Numero telefonico">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Pagina web</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="web" placeholder="Pagina web">
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
                            <input type="text" class="form-control" id="lng" name="longitud" placeholder="Longitud">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Latitud</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="lat" name="latitud" placeholder="Latitud">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Localize el lugar</label>
                          <div class="col-sm-10">
                            <div id="map"></div>
                          </div>
                        </div>
	                    <div class="form-group row">
	                      <div class="offset-sm-2 col-sm-10">
	                        <button type="submit" class="btn btn-primary float-right">Registrar</button>
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

@section('scripts')
	<script src="https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v3.0.11/turf.min.js"></script>
	<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.js"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    <script type="text/javascript">

      //variable que guarda los markers
      var currentMarkers = []

    	const app = new Vue({
    		data:{
    			cityView: @json($city),
          loaded: false
    		},
    		el: '#app',
    		methods:{
    			makeMap: function(){

              if(this.loaded == false){

                //cargando mapa
                $('.map-loading').show()

  					    ///////////crear el mapa
  			        mapboxgl.accessToken = 'pk.eyJ1IjoibHVpc2plc3VzMDciLCJhIjoiY2s4YzkxMWZ2MGgxNTNsczJwZDRyc2VrciJ9.1hUQ7e4IIJYtOXtqfVp_MA';
  			        this.map = new mapboxgl.Map({
  			            container: 'map', // container id
  			            style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
  			            center: [this.cityView.viewLatitud, this.cityView.viewLongitud], // starting position [lng, lat]
  			            zoom: this.cityView.zoom, // starting zoom
  			        });
                ///////////crear el mapa

                //mostrar mapa en todo el div
                this.map.once('load', () => {
                    this.map.resize()

                    //quitar cargando
                    $('.map-loading').hide()

                });

                //funcion que dibuja el marker
                this.getCordenadas()
              }

              //varible para no cargar mapa mas de una vez
              this.loaded = true
			        
				},
				getCordenadas: function(){
					const _this = this

					this.map.on('click', function(e) {

            if(currentMarkers.length > 0){
              //remover marker
              currentMarkers[0].remove()
              //eliminar marker del aray
              currentMarkers.splice(0,1)
            }
            

            //poner la lng y lat en inputs
            $('#lat').val(e.lngLat.wrap().lat);
            $('#lng').val(e.lngLat.wrap().lng);


            //dibujar el marker
            var el = document.createElement('div');
            el.className = 'marker';
            var oneMarker = new mapboxgl.Marker(el)
              .setLngLat(e.lngLat.wrap())
              .addTo(_this.map);
						
            //gurdar el marker
            currentMarkers.push(oneMarker)
					
					});
				}

    		}
    	})
    </script>

@endsection