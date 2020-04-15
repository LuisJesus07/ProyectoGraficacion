@extends('layouts_mapa.app')


@section('content')
	<div id="app">
		<div id="map"></div>

		<div class="city-box">
			<img id="image-city" src="">
			<h2 id="name-city"></h2>
			<div class="logo">
				<img id="logo-city" src="">
			</div>
		</div>

		<div class="sidebar">
			<img id="image-place">

			<img id="loading" src="{{asset('iconos/loading2.gif')}}">

			<h1 id="name-place" class="h1">Nombre</h1>
			<label id="category-place">Categoria</label>

			<div class="info-place">
				<hr>
				<div class="card-feature">
					<div class="feature">
						<label id="description-place">Descripcion</label>
					</div>
					<div class="icon">
						<i class="fas fa-audio-description"></i>
					</div>	
				</div>
				<hr>
				<div class="card-feature">
					<div class="feature">
						<label id="address-place">Dirección</label>
					</div>
					<div class="icon">
						<i class="fas fa-map-marker-alt" style="margin-left: 10px;"></i>
					</div>
				</div>
				<hr>
				<div class="card-feature">
					<div class="feature">
						<label id="horario-place">Horario</label><br>
					</div>
					<div class="icon">
						<i class="fas fa-clock"></i>
					</div>
				</div>
				<hr>
				<div class="card-feature">
					<div class="feature">
						<a target="_blank" id="web-place">
							Web
						</a>
					</div>
					<div class="icon">
						<i class="fas fa-globe-americas"></i>
					</div>
				</div>	
			</div>
		</div>

	</div>
@endsection

@section('scripts')
	<script src="https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v3.0.11/turf.min.js"></script>
	<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.js"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

	<script>

		//variable que guarda los markers
		var currentMarkers = []
		
		const app = new Vue({
			created: function(){
				this.makeMap()
				this.printCities()
				this.clickCity()
				//this.drawCity()
			},
			el: '#app',
			data: {
				places: null,
				map: null,
				cityBox: document.querySelector('.city-box'),
				sidebar: document.querySelector('.sidebar'),
				loading: document.getElementById('loading'),
				info_place: document.querySelector('.info-place'),
				imagePlace: document.getElementById('image-place'),
				namePlace: document.getElementById('name-place'),
				categoryPlace: document.getElementById('category-place'),
				descriptionPlace: document.getElementById('description-place'),
				addressPlace: document.getElementById('address-place'),
				horarioPlace: document.getElementById('horario-place'),
				webPlace: document.getElementById('web-place'),
				logoCity: document.getElementById('logo-city'),
				nameCity: document.getElementById('name-city'),
				imageCity: document.getElementById('image-city'),
				actualCity: null
			},
			methods: {
				makeMap: function(){
					///////////crear el mapa
			        mapboxgl.accessToken = 'pk.eyJ1IjoibHVpc2plc3VzMDciLCJhIjoiY2s4YzkxMWZ2MGgxNTNsczJwZDRyc2VrciJ9.1hUQ7e4IIJYtOXtqfVp_MA';
			        this.map = new mapboxgl.Map({
			            container: 'map', // container id
			            style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
			            center: [-112.5, 25.5], // starting position [lng, lat]
			            zoom: 6, // starting zoom
			            boxZoom: true
			        });
			        ///////////crear el mapa
				},
				printCities: function(){
					//obtener json con info de los municipios
					var all_cities = @json($cities)

					//////////pinta en el mapa los municipios
        			this.map.on('load', function() {

			
						this.addSource('cities', {
							'type': 'geojson',
							'data': all_cities
						});

						////////////colores de los municipios
						const expression = { "property": "id", "stops": [ [0, 'white'], [1, 'yellow'], [2, 'blue'], [3, 'red'], [4, 'violet'], [5, 'green'] ] };
						////////////colores de los municipios

						this.addLayer({
							'id': 'cities-fill',
							'type': 'fill',
							'source': 'cities',
							'layout': {},
							'paint': {
								'fill-color': expression,
								'fill-opacity': 0.2
							}
						});
						
					});
					//////////pinta en el mapa los municipios
				},
				makeMarkers: function(city_id){
					//variable para acceder a this.map
					let _this = this

					//obtener todos los lugares
					axios.get('get_places/'+city_id)
					.then(res =>{
						this.places = res.data

						//////////pone los lugares en el mapa
						// add markers to map
						this.places.feautues.forEach(function(marker){

							var el = document.createElement('div');
						  	//el.className = 'marker';

						  	//poner marker dependiendo de la categoria
						  	switch(marker.properties.category){
						  		case 'Cines':
						  				el.className = 'cines';	
						  			break;
						  		case 'Restaurantes':
						  				el.className = 'restaurantes';	
						  			break;
						  		case 'Plazas':
						  				el.className = 'restaurantes';
						  			break;
						  	}

						  	var oneMarker = new mapboxgl.Marker(el)
						  	  .setLngLat(marker.geometry.coordinates)
						  	  //.setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
						  		  //.setHTML('<h3>' + marker.properties.name + '</h3><p>' + marker.properties.description + '</p>'))
						  	  .addTo(_this.map);

						  	//añadir evento click al marker
						  	el.addEventListener('click', () => 
							   { 
							   	  //obtener info del lugar
							   	  _this.getInfoPlace(marker.properties.id)
							   }
							); 

						  	//añadir los markers de la ciudad al array
							currentMarkers.push(oneMarker)

						})

					})
					.catch(err =>{

					})
					
				},
				getInfoPlace: function(id){

					_this = this
					//apaecer icono de carga
				   	_this.loading.style.display = 'block'
				   	_this.info_place.style.opacity = '0.5'

				      //obtener info del lugar
				    axios.get('get_place_by_id/'+id)
				    .then(res => {
				      	const place = res.data.property
				      	///mostrar sidebar
						_this.sidebar.classList.remove("hide-sidebar")
						_this.sidebar.classList.add("show-sidebar")
						//mostrar sidebar

						////actualizar info del sidebar
						_this.imagePlace.src = "fotos_places/"+place.url_foto+""
						_this.namePlace.innerHTML = place.name
						_this.categoryPlace.innerHTML = res.data.category.name 
						_this.descriptionPlace.innerHTML = place.description
						_this.addressPlace.innerHTML = place.address
						_this.horarioPlace.innerHTML = place.horario
						_this.webPlace.innerHTML = place.web
						_this.webPlace.href = "https://"+place.web
						////actualizar info del sidebar
				    })
				    .catch(err => {
				      	console.log(err)
				    })
				    .then(function() {
				      	//desaparecer carga
				        loading.style.display = 'none'
				        _this.info_place.style.opacity = '1'
				    });

				},
				clickCity: function(){
					//variable para acceder a la funcion makeMarkers 
					let _this = this

					this.map.on('click', 'cities-fill', function(e) {

						//traer los markers de la ciudad si el click no es sobre la ciudad seleccionada actualmente
						if(_this.actualCity != e.features[0].properties.id){

							//borar los markers actuales para luego pintar los de la ciudad clickeada
							if(currentMarkers.length > 0){

								for (var i = currentMarkers.length - 1; i >= 0; i--) {
									//remover marker
									currentMarkers[i].remove()
									//eliminar marker del aray
									currentMarkers.splice(i,1)
								}								
							}

							//guardar el id de la ciudad seleccionada actualmente
							_this.actualCity = e.features[0].properties.id

							//pasar por parametro el id de la ciudad para mostrar markers
							_this.makeMarkers(e.features[0].properties.id)


							///ocultar sidebar
							_this.sidebar.classList.remove("show-sidebar")
							_this.sidebar.classList.add("hide-sidebar")
							//ocultar sidebar

							/////actualizar info de la ciudad
							_this.cityBox.style.visibility = "visible"
							_this.cityBox.style.opacity = "1"
							_this.nameCity.innerHTML = e.features[0].properties.name
							_this.imageCity.src = "fotos_cities/"+e.features[0].properties.url_foto+""
							_this.logoCity.src = "fotos_cities/"+e.features[0].properties.logo+""
							/////actualizar info de la ciudad


							//cambiar la vista el mapa
							this.flyTo({
								center: [
									e.features[0].properties.viewLatitud,
									e.features[0].properties.viewLongitud
								],
								essential: true,
								speed: 0.2,
								zoom: e.features[0].properties.zoom
							});

						}

					});
				},
				drawCity: function(){
					/////////dibujar los municipios
			        var draw = new MapboxDraw({
						displayControlsDefault: false,
						controls: {
							polygon: true,
							trash: true
						}
					});
					this.map.addControl(draw);
					 
					this.map.on('draw.create', updateArea);
					this.map.on('draw.delete', updateArea);
					this.map.on('draw.update', updateArea);
						 
					function updateArea(e) {

						console.log(e)

						var data = draw.getAll();
						
					}
					//////////dibujar los municipios
				}
			}
		})	

    </script>
@endsection