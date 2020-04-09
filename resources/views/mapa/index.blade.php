@extends('layouts_mapa.app')


@section('content')
	<div id="app">
		<div id="map"></div>
		<div class="calculation-box">
			<p>Ciudad.</p>
			<label id="name-city"></label>
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
				nameCity: document.getElementById('name-city'),
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
						  	  .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
						  		  .setHTML('<h3>' + marker.properties.name + '</h3><p>' + marker.properties.description + '</p>'))
						  	  .addTo(_this.map);

						  	//añadir evento click al marker
						  	el.addEventListener('click', () => 
							   { 
							      //obtener info del lugar
							      axios.get('get_place_by_id/'+marker.properties.id)
							      .then(res => {
							      		console.log(res.data)
							      })
							      .catch(err => {
							      		console.log(err)
							      })
							   }
							); 

						  	//añadir los markers de la ciudad al array
							currentMarkers.push(oneMarker)


						})

						//////////pone los lugares en el mapa

					})
					.catch(err =>{

					})
					
				},
				clickCity: function(){
					//variable para acceder a la funcion makeMarkers 
					let _this = this

					this.map.on('click', 'cities-fill', function(e) {

						//traer los markers de la ciudad si el click no es sobre la ciudad seleccionada actualmente
						if(_this.actualCity != e.features[0].properties.id){

							//borar los markers actuales para luego pintar los de la ciudad
							//clickeada
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

							//mostrar el name de la ciudad
							_this.nameCity.innerHTML = e.features[0].properties.name

							//cambiar la vista el mapa
							this.flyTo({
								center: [
									e.features[0].properties.viewLatitud,
									e.features[0].properties.viewLongitud
								],
								essential: true, // this animation is considered essential with respect to prefers-reduced-motion
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