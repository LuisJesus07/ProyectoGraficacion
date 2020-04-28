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

		<div class="categories-box">
			<div class="categories-title">
				<i class="fas fa-sync-alt" id="reload-categories"></i>
				<img src="{{asset('iconos/load.gif')}}" id="loading-category">
				<h2>Categorias</h2>
			</div>
			<div class="categories">
				<ul>
					@foreach($categories as $category)
					<a onclick="markersByCategory({{$category->id}})">
						<li>
							<img src="{{asset('iconos')}}/{{$category->url_icon}}">
							<b>{{$category->name}}</b>
						</li>
					</a>
					@endforeach
				</ul>
			</div>
		</div>

		<div class="sidebar">
			<img id="image-place">

			<button id="btn-close">
				<i class="fas fa-times"></i>
			</button>

			<img id="loading" src="{{asset('iconos/loading2.gif')}}">

			<h1 id="name-place" class="h1">Nombre</h1>
			<label id="category-place">Categoria</label>

			<div class="info-place">
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
						<label id="phone-place">No disponible</label><br>
					</div>
					<div class="icon">
						<i class="fas fa-phone"></i>
					</div>
				</div>
				<hr>
				<div class="card-feature">
					<div class="feature">
						<a target="_blank" id="web-place">
							No disponible
						</a>
					</div>
					<div class="icon">
						<i class="fas fa-globe-americas"></i>
					</div>
				</div>
				<hr>
				<div class="card-feature">
					<div class="feature">
						<label id="description-place">Descripción</label>
					</div>
					<div class="icon">
						<i class="fas fa-audio-description"></i>
					</div>	
				</div>
			</div>
		</div>

	</div>
@endsection

@section('scripts')
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
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
				this.checkZoom()
				this.closeSidebar()
				this.reloadCategories()
			},
			el: '#app',
			data: {
				places: null,
				map: null,
				cityBox: document.querySelector('.city-box'),
				categoriesBox: document.querySelector('.categories-box'),
				sidebar: document.querySelector('.sidebar'),
				loading: document.getElementById('loading'),
				reloadAllCategories: document.getElementById('reload-categories'),
				info_place: document.querySelector('.info-place'),
				imagePlace: document.getElementById('image-place'),
				descriptionPlace: document.getElementById('description-place'),
				btnClose: document.getElementById('btn-close'),
				namePlace: document.getElementById('name-place'),
				categoryPlace: document.getElementById('category-place'),
				addressPlace: document.getElementById('address-place'),
				horarioPlace: document.getElementById('horario-place'),
				phonePlace: document.getElementById('phone-place'),
				webPlace: document.getElementById('web-place'),
				logoCity: document.getElementById('logo-city'),
				nameCity: document.getElementById('name-city'),
				imageCity: document.getElementById('image-city'),
				actualCity: null,
				levelZoom: null,
				markers: null
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
					var all_cities = this.geojsonDataCities()

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
						  	el.className = 'marker';

						  	//anadir el icono de categoria 
						  	el.style.backgroundImage = 'url({{ asset('iconos') }}/'+marker.properties.category_icon+')';


						  	var oneMarker = new mapboxgl.Marker(el)
						  	  .setLngLat(marker.geometry.coordinates)
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

						//guardar los marcadores(para luego ocultarlos)
						_this.markers = document.querySelectorAll('.marker')

					})
					.catch(err =>{
						//error
						Swal.fire({
						  title: 'Error al cargar lugares!!',
						  text: "Ocurrio un error en el servidor",
						  icon: 'error',
						  showCancelButton: false,
						  confirmButtonColor: '#3085d6',
						  confirmButtonText: 'Cargar lugares'
						}).then((result) => {
						  if (result.value) {
						    	
						    //volver a cargar sitios
						    _this.makeMarkers(_this.actualCity)

						  }
						})
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
						_this.descriptionPlace.innerHTML = place.description
						_this.namePlace.innerHTML = place.name
						_this.categoryPlace.innerHTML = res.data.category.name 
						_this.addressPlace.innerHTML = place.address
						_this.horarioPlace.innerHTML = place.horario

						if(place.phone_number != null){
							_this.phonePlace.innerHTML = place.phone_number.substr(0, 3)+'-'+place.phone_number.substr(3, 3)+'-'+place.phone_number.substr(6, 4)
						}else{
							_this.phonePlace.innerHTML = "No disponible"
						}
						

						if(place.web != null){
							_this.webPlace.innerHTML = place.web
							_this.webPlace.href = "https://"+place.web
						}else{
							_this.webPlace.innerHTML = "No disponible"
							_this.webPlace.href = ""
						}
						
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
							_this.cleanMarkers()

							//guardar el id de la ciudad seleccionada actualmente
							_this.actualCity = e.features[0].properties.id

							//pasar por parametro el id de la ciudad para mostrar markers
							_this.makeMarkers(e.features[0].properties.id)


							///ocultar sidebar
							_this.sidebar.classList.remove("show-sidebar")
							_this.sidebar.classList.add("hide-sidebar")
							//ocultar sidebar

							//desaparecer categorias 
							_this.categoriesBox.style.visibility = "hidden"
							_this.categoriesBox.style.opacity = "0"

							/////actualizar info de la ciudad
							_this.cityBox.style.visibility = "visible"
							_this.cityBox.style.opacity = "1"
							_this.nameCity.innerHTML = e.features[0].properties.name
							_this.imageCity.src = "fotos_cities/"+e.features[0].properties.url_foto+""
							_this.logoCity.src = "fotos_cities/"+e.features[0].properties.logo+""
							/////actualizar info de la ciudad

							//despues de 20 segundos aparecer card de categorias
							setTimeout(function(){
								
								//desaparece card del municipio
								_this.cityBox.style.visibility = "hidden"
								_this.cityBox.style.opacity = "0"

								//aparecer card de categorias
								_this.categoriesBox.style.visibility = "visible"
								_this.categoriesBox.style.opacity = "1"

							}, 15000);

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
				checkZoom: function(){
					const _this = this
					this.map.on('zoomend', function(){
						//get zoom
						_this.levelZoom = this.getZoom()

						//desaparecer iconos dependiendo del zoom
						if(_this.levelZoom < 12.5){

							if(_this.markers != null){

								for (var i = _this.markers.length - 1; i >= 0; i--) {
									_this.markers[i].style.display = "none"
								}

							}

						}else{
							//vuelve a aparecer los iconos
							for (var i = _this.markers.length - 1; i >= 0; i--) {
								_this.markers[i].style.display = "block"
							}
							
						}
						
					})
				},
				cleanMarkers: function(){

					if(currentMarkers.length > 0){

						for (var i = currentMarkers.length - 1; i >= 0; i--) {
							//remover marker
							currentMarkers[i].remove()
							//eliminar marker del aray
							currentMarkers.splice(i,1)
						}								
					}

				},
				closeSidebar: function(){
					const _this = this

					this.btnClose.addEventListener('click', function(){
						_this.sidebar.classList.remove("show-sidebar")
						_this.sidebar.classList.add("hide-sidebar")
					})
				},
				reloadCategories: function(){
					
					const _this = this

					this.reloadAllCategories.addEventListener('click', function(){

						_this.cleanMarkers()
						_this.makeMarkers(_this.actualCity)

					})
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
				},
				geojsonDataCities: function(){
					const data = {
							"type": "FeatureCollection",
							"features": [
									{
								      "properties": {
								      	"id": 1,
								      	"name": "Mulege",
								      	"url_foto": "mulege.jpeg",
								      	"logo": "mulege-logo.jpg",
								      	"viewLatitud": -111.98240162057033,
										"viewLongitud": 26.891017395541013,
										"zoom": 14
								      },
								      "geometry": {
								        "type": "Polygon",
								        "coordinates": [
									        [
											  [
											    -112.79877806291651,
											    26.44592900845238
											  ],
											  [
											    -111.88083593408487,
											    26.6632807275018
											  ],
											  [
											    -111.99422878529342,
											    27.058279629421065
											  ],
											  [
											    -112.3128087005937,
											    27.39917170005785
											  ],
											  [
											    -112.35060631767065,
											    27.5237437116524
											  ],
											  [
											    -112.57739202008773,
											    27.638608144723847
											  ],
											  [
											    -112.71238350962203,
											    27.796349989213056
											  ],
											  [
											    -112.77177976501702,
											    27.968171250553368
											  ],
											  [
											    -114.06229840496292,
											    27.987245659747146
											  ],
											  [
											    -114.15949227742757,
											    27.78679637628754
											  ],
											  [
											    -114.29448376696186,
											    27.848879845815915
											  ],
											  [
											    -115.07203474667818,
											    27.829781020684976
											  ],
											  [
											    -114.57526606519251,
											    27.451892420728612
											  ],
											  [
											    -114.44567423524006,
											    27.197643285035284
											  ],
											  [
											    -114.27828478821755,
											    27.10635567726895
											  ],
											  [
											    -114.13789363910223,
											    27.10635567726895
											  ],
											  [
											    -114.02450078789327,
											    26.98612691283698
											  ],
											  [
											    -113.86791066003407,
											    26.971690810979837
											  ],
											  [
											    -113.77071678756941,
											    26.885035347114794
											  ],
											  [
											    -113.72211985133687,
											    26.783853269794548
											  ],
											  [
											    -113.60872700012833,
											    26.7163483832512
											  ],
											  [
											    -113.52233244682657,
											    26.735639583810197
											  ],
											  [
											    -113.45753653185014,
											    26.832046484827913
											  ],
											  [
											    -113.33874402106015,
											    26.79349355129095
											  ],
											  [
											    -113.07416070157342,
											    26.639150900894222
											  ],
											  [
											    -113.00936478659699,
											    26.542580640578905
											  ],
											  [
											    -112.90137159496989,
											    26.55224133174262
											  ],
											  [
											    -112.79877806291651,
											    26.44592900845238
											  ]
											]
								        ]
								      }
								    },
								    {
								      "properties": {
								      	"id": 2,
								      	"name": "Comondu",
								      	"url_foto": "comondu.jpg",
								      	"logo": "comondu-logo.jpg",
								      	"viewLatitud": -111.65219858666967,
										"viewLongitud": 25.032652350767933,
										"zoom": 13
								      },
								      "geometry": {
								        "type": "Polygon",
								        "coordinates": [
									        [
											  [
											    -111.66561305035337,
											    24.582733452808156
											  ],
											  [
											    -111.50986492858267,
											    24.664069692829813
											  ],
											  [
											    -111.43033397278484,
											    24.70622318795327
											  ],
											  [
											    -111.2944685899635,
											    24.778453127650423
											  ],
											  [
											    -111.19174110539139,
											    24.859661592511046
											  ],
											  [
											    -111.06581709204497,
											    24.967856620634635
											  ],
											  [
											    -110.95314823799795,
											    25.018915695992206
											  ],
											  [
											    -110.83053801447649,
											    25.051942611915507
											  ],
											  [
											    -110.86677267672692,
											    25.10215885881786
											  ],
											  [
											    -111.02010220674659,
											    25.13686592800029
											  ],
											  [
											    -111.07237363743513,
											    25.18417785435257
											  ],
											  [
											    -111.09676697175642,
											    25.27559548552479
											  ],
											  [
											    -111.0549498272058,
											    25.348050197844856
											  ],
											  [
											    -111.22221840540938,
											    25.433050372224145
											  ],
											  [
											    -111.46615174862944,
											    25.48347998153409
											  ],
											  [
											    -111.55327079977721,
											    25.568384591713382
											  ],
											  [
											    -111.62296604069508,
											    25.72545640232393
											  ],
											  [
											    -111.64387461297093,
											    25.866643905384734
											  ],
											  [
											    -111.75215840178171,
											    26.145614601521373
											  ],
											  [
											    -111.7486736397357,
											    26.2769245866492
											  ],
											  [
											    -111.76261268791961,
											    26.42681138103454
											  ],
											  [
											    -111.7486736397357,
											    26.523509883801168
											  ],
											  [
											    -111.7904907842869,
											    26.57962006838177
											  ],
											  [
											    -111.84973173906738,
											    26.64193248822194
											  ],
											  [
											    -111.87412507338867,
											    26.663733810363965
											  ],
											  [
											    -111.99609174499508,
											    26.62635756667227
											  ],
											  [
											    -112.10760413046415,
											    26.595201355890154
											  ],
											  [
											    -112.2330555641171,
											    26.573386959656986
											  ],
											  [
											    -112.3619917598155,
											    26.532863487752635
											  ],
											  [
											    -112.52926033801906,
											    26.498563214263967
											  ],
											  [
											    -112.68607463008524,
											    26.461133055434175
											  ],
											  [
											    -112.78713272941637,
											    26.429931955743953
											  ],
											  [
											    -112.71046796440655,
											    26.348769578615446
											  ],
											  [
											    -112.56759272052425,
											    26.2769245866492
											  ],
											  [
											    -112.48395843142247,
											    26.23942256940549
											  ],
											  [
											    -112.41774795255002,
											    26.248799208865904
											  ],
											  [
											    -112.35502223572352,
											    26.189401054677447
											  ],
											  [
											    -112.31320509117292,
											    26.083034025452903
											  ],
											  [
											    -112.24350985025448,
											    26.03294545734417
											  ],
											  [
											    -112.18078413342855,
											    25.976570243428668
											  ],
											  [
											    -112.1354822268314,
											    25.838650418109026
											  ],
											  [
											    -112.0936650822808,
											    25.725687177441742
											  ],
											  [
											    -112.05881746182156,
											    25.600046504377715
											  ],
											  [
											    -112.06578698591352,
											    25.48685690434455
											  ],
											  [
											    -112.06578698592315,
											    25.398700051311508
											  ],
											  [
											    -112.07972603410705,
											    25.27586791627556
											  ],
											  [
											    -112.10760413047431,
											    25.215981503197412
											  ],
											  [
											    -112.11805841661226,
											    25.12451908570523
											  ],
											  [
											    -112.12502794070365,
											    25.02983068861758
											  ],
											  [
											    -112.11457365456624,
											    24.89398318117506
											  ],
											  [
											    -112.07624127206107,
											    24.81177019798966
											  ],
											  [
											    -112.01003079318862,
											    24.770643232922822
											  ],
											  [
											    -111.9542746004541,
											    24.757986039878233
											  ],
											  [
											    -111.89503364567415,
											    24.697846769823997
											  ],
											  [
											    -111.83579269089364,
											    24.609167551638166
											  ],
											  [
											    -111.78700602225052,
											    24.55212625170563
											  ],
											  [
											    -111.7242803054246,
											    24.539446881084714
											  ],
											  [
											    -111.66561305035337,
											    24.582733452808156
											  ]
											]
								        ]
								      }
								    },
								    {
								      "properties": {
								      	"id": 3,
								      	"name": "Loreto",
								      	"url_foto": "loreto.jpg",
								      	"logo": "loreto-logo.png",
								      	"viewLatitud": -111.35095378732757,
										"viewLongitud": 26.009251489501025,
										"zoom": 13
								      },
								      "geometry": {
								        "type": "Polygon",
								        "coordinates": [
									        [
											  [
											    -110.87216743941104,
											    25.109904670547067
											  ],
											  [
											    -110.96572999550189,
											    25.129267815346424
											  ],
											  [
											    -111.01384788149171,
											    25.146208049627276
											  ],
											  [
											    -111.05661933570477,
											    25.18008146463484
											  ],
											  [
											    -111.0806782786997,
											    25.223619166423234
											  ],
											  [
											    -111.09137114225317,
											    25.26955872786033
											  ],
											  [
											    -111.05394611981642,
											    25.33481135796147
											  ],
											  [
											    -111.09671757402948,
											    25.37829357953062
											  ],
											  [
											    -111.17156761890257,
											    25.412102267730177
											  ],
											  [
											    -111.24374444788731,
											    25.448315347339246
											  ],
											  [
											    -111.33463378808977,
											    25.467624538355707
											  ],
											  [
											    -111.43354277595779,
											    25.486930630524824
											  ],
											  [
											    -111.48433387783555,
											    25.52070883012631
											  ],
											  [
											    -111.55651070682029,
											    25.58582565243364
											  ],
											  [
											    -111.61264824047478,
											    25.71836141147206
											  ],
											  [
											    -111.63670718347296,
											    25.867588472508217
											  ],
											  [
											    -111.67947863768605,
											    25.980586834315687
											  ],
											  [
											    -111.71957687601075,
											    26.081472307329776
											  ],
											  [
											    -111.7409626031173,
											    26.14388169700287
											  ],
											  [
											    -111.74363581900566,
											    26.23743323365686
											  ],
											  [
											    -111.74630903489403,
											    26.326117720825366
											  ],
											  [
											    -111.7570018984471,
											    26.417128439830336
											  ],
											  [
											    -111.74898225078279,
											    26.49377205621954
											  ],
											  [
											    -111.74630903489442,
											    26.539220229970027
											  ],
											  [
											    -111.67947863768684,
											    26.54639461273031
											  ],
											  [
											    -111.56453035448905,
											    26.565524105813452
											  ],
											  [
											    -111.46829458250942,
											    26.517694389841722
											  ],
											  [
											    -111.46027493484472,
											    26.467451737938532
											  ],
											  [
											    -111.46562136662146,
											    26.414793042204877
											  ],
											  [
											    -111.43354277596146,
											    26.374085757187643
											  ],
											  [
											    -111.39611775352512,
											    26.328572404155594
											  ],
											  [
											    -111.38542488997163,
											    26.28064427628631
											  ],
											  [
											    -111.39344453763674,
											    26.242287512410897
											  ],
											  [
											    -111.36938559464183,
											    26.165536009074287
											  ],
											  [
											    -111.3479998675353,
											    26.12234106866164
											  ],
											  [
											    -111.32394092454038,
											    26.079130153459218
											  ],
											  [
											    -111.33463378809387,
											    26.033501321822143
											  ],
											  [
											    -111.33122587316103,
											    25.987184117048628
											  ],
											  [
											    -111.35334629931204,
											    25.927766418842936
											  ],
											  [
											    -111.33730700398222,
											    25.87486334391339
											  ],
											  [
											    -111.30790162921342,
											    25.785836554063366
											  ],
											  [
											    -111.27582303855382,
											    25.74250203143309
											  ],
											  [
											    -111.22503193667563,
											    25.708786471817845
											  ],
											  [
											    -111.1956265619044,
											    25.631686471047658
											  ],
											  [
											    -111.16354797124437,
											    25.561771567076562
											  ],
											  [
											    -111.11543008525457,
											    25.532829314497988
											  ],
											  [
											    -111.06998541515313,
											    25.515943107626086
											  ],
											  [
											    -111.01117466561026,
											    25.50870543447253
											  ],
											  [
											    -111.01117466561026,
											    25.460443134991692
											  ],
											  [
											    -111.01117466561026,
											    25.39767320068232
											  ],
											  [
											    -110.9897889385037,
											    25.378352800052596
											  ],
											  [
											    -110.95765785848853,
											    25.310683342192547
											  ],
											  [
											    -110.936272131382,
											    25.281680735156442
											  ],
											  [
											    -110.936272131382,
											    25.238163822296613
											  ],
											  [
											    -110.90686675661033,
											    25.184955320942663
											  ],
											  [
											    -110.90686675661033,
											    25.16076195166373
											  ],
											  [
											    -110.87216743941104,
											    25.109904670547067
											  ]
											]
								        ]
								      }
								    },	
								    {
								      "properties": {
								      	"id": 4,
								      	"name": "La Paz",
								      	"url_foto": "paz.jpg",
								      	"logo": "paz-logo.png",
								      	"viewLatitud": -110.30370345205722,
										"viewLongitud": 24.138634649350692,
										"zoom": 13
								      },
								      "geometry": {
								        "type": "Polygon",
								        "coordinates": [
								            [
											  [
											    -110.12567473377926,
											    23.118377770081565
											  ],
											  [
											    -109.9831602344525,
											    23.161266534613958
											  ],
											  [
											    -109.87951332585114,
											    23.250574006947446
											  ],
											  [
											    -109.89117360306888,
											    23.355285221925925
											  ],
											  [
											    -109.84194132148326,
											    23.360042862892357
											  ],
											  [
											    -109.81343842161806,
											    23.393341570700613
											  ],
											  [
											    -109.69165330401032,
											    23.654682318637313
											  ],
											  [
											    -109.71849897694516,
											    23.71486074237974
											  ],
											  [
											    -109.70113733589325,
											    23.790342945892206
											  ],
											  [
											    -109.83134964378368,
											    23.901499987859253
											  ],
											  [
											    -109.80964759246872,
											    24.004631747562343
											  ],
											  [
											    -109.84003046430982,
											    24.036347990919708
											  ],
											  [
											    -109.97024277220058,
											    24.0442758289184
											  ],
											  [
											    -110.02666810562002,
											    24.155214120811777
											  ],
											  [
											    -110.06573179798721,
											    24.18689311140075
											  ],
											  [
											    -110.2133057469299,
											    24.31353034695995
											  ],
											  [
											    -110.30445436245347,
											    24.35307859817678
											  ],
											  [
											    -110.32615641376879,
											    24.234396848064847
											  ],
											  [
											    -110.31747559324266,
											    24.18689311140075
											  ],
											  [
											    -110.48241118323757,
											    24.194811630449436
											  ],
											  [
											    -110.63866595270638,
											    24.30957484304686
											  ],
											  [
											    -110.72981456822997,
											    24.546686198079883
											  ],
											  [
											    -110.68641046559871,
											    24.73618000066007
											  ],
											  [
											    -110.6777296450726,
											    24.870140849775026
											  ],
											  [
											    -110.74283579901815,
											    24.95674415229236
											  ],
											  [
											    -110.82964400427835,
											    25.05508309180729
											  ],
											  [
											    -111.04666451742963,
											    24.972483671274333
											  ],
											  [
											    -111.2463233895287,
											    24.795298216402742
											  ],
											  [
											    -111.6528305664056,
											    24.572526778724225
											  ],
											  [
											    -111.61437841796821,
											    24.477572961538414
											  ],
											  [
											    -111.37267919921797,
											    24.29245733636199
											  ],
											  [
											    -111.11450048828051,
											    24.147177648380392
											  ],
											  [
											    -110.86730810546815,
											    23.96660052198591
											  ],
											  [
											    -110.64208837890554,
											    23.740523016658358
											  ],
											  [
											    -110.37841650390631,
											    23.589586159646913
											  ],
											  [
											    -110.21362158203127,
											    23.403191391804143
											  ],
											  [
											    -110.12567473377926,
											    23.118377770081565
											  ]
											] 
									        
								        ]
								      }
								    },
								    {
							      	  "properties": {
							      	    "id": 5,
									    "name": "Los Cabos",
									    "url_foto": "cabos.jpg",
									    "logo": "cabos-logo.png",
									    "viewLatitud": -109.91386855307411,
									    "viewLongitud": 22.892273767112485,
									    "zoom": 13
							          },
							          "geometry": {
							          "type": "Polygon",
							          "coordinates": [
								          [
											  [
											    -109.68880135907872,
											    23.654394280627997
											  ],
											  [
											    -109.68062952354333,
											    23.64716118915682
											  ],
											  [
											    -109.67087867949408,
											    23.641867989483316
											  ],
											  [
											    -109.6607666930726,
											    23.638890470588763
											  ],
											  [
											    -109.65354384562862,
											    23.636574575734116
											  ],
											  [
											    -109.64595216416708,
											    23.63387968858723
											  ],
											  [
											    -109.64188678864497,
											    23.633038693341348
											  ],
											  [
											    -109.63952624801918,
											    23.631717118469936
											  ],
											  [
											    -109.63782141312252,
											    23.628953782456747
											  ],
											  [
											    -109.6376902719766,
											    23.62715157538257
											  ],
											  [
											    -109.6344117433299,
											    23.625950090222545
											  ],
											  [
											    -109.62942837978649,
											    23.62450829348272
											  ],
											  [
											    -109.62392045165952,
											    23.623426935513606
											  ],
											  [
											    -109.61500285373958,
											    23.62138434610624
											  ],
											  [
											    -109.61187606694571,
											    23.621162914051382
											  ],
											  [
											    -109.6098251652048,
											    23.621098118638116
											  ],
											  [
											    -109.60925939920725,
											    23.62083893666538
											  ],
											  [
											    -109.6074913804651,
											    23.621746071326456
											  ],
											  [
											    -109.60409678448057,
											    23.619866999701273
											  ],
											  [
											    -109.60437966747934,
											    23.6191542413452
											  ],
											  [
											    -109.60367245998242,
											    23.618247088738357
											  ],
											  [
											    -109.60303597323535,
											    23.617728713000588
											  ],
											  [
											    -109.60183372049076,
											    23.617469524363358
											  ],
											  [
											    -109.60098507149445,
											    23.617275132547945
											  ],
											  [
											    -109.59971209799997,
											    23.617080740444834
											  ],
											  [
											    -109.59850984525536,
											    23.61630316914807
											  ],
											  [
											    -109.59624678126555,
											    23.615201601913398
											  ],
											  [
											    -109.5956102945185,
											    23.614618415510648
											  ],
											  [
											    -109.59426660027451,
											    23.614035226512655
											  ],
											  [
											    -109.59292290603052,
											    23.613840829603546
											  ],
											  [
											    -109.58756728538903,
											    23.610360096464277
											  ],
											  [
											    -109.58149438374029,
											    23.60464899575129
											  ],
											  [
											    -109.57574110849416,
											    23.60010922541271
											  ],
											  [
											    -109.57206540486499,
											    23.599230542032743
											  ],
											  [
											    -109.5683897012354,
											    23.597912505924896
											  ],
											  [
											    -109.56327567879407,
											    23.59630155491662
											  ],
											  [
											    -109.55848128275576,
											    23.59410477165639
											  ],
											  [
											    -109.53099341212855,
											    23.58751420115098
											  ],
											  [
											    -109.52603920288851,
											    23.587074818014145
											  ],
											  [
											    -109.52284293886284,
											    23.584731416436057
											  ],
											  [
											    -109.52012611444107,
											    23.584292023982044
											  ],
											  [
											    -109.51836816922716,
											    23.58297383779214
											  ],
											  [
											    -109.51724947681802,
											    23.581362703359844
											  ],
											  [
											    -109.51804854282454,
											    23.579751549151823
											  ],
											  [
											    -109.51820835602584,
											    23.577261544662107
											  ],
											  [
											    -109.5170896636167,
											    23.575357391715883
											  ],
											  [
											    -109.51549153160408,
											    23.572720826661964
											  ],
											  [
											    -109.51549153160408,
											    23.571402524283243
											  ],
											  [
											    -109.51437283919495,
											    23.570377168839272
											  ],
											  [
											    -109.51261489398101,
											    23.56949828637235
											  ],
											  [
											    -109.51069713556537,
											    23.56861939802404
											  ],
											  [
											    -109.5079803111436,
											    23.56774050379444
											  ],
											  [
											    -109.50686161873487,
											    23.567154571040803
											  ],
											  [
											    -109.50478404711794,
											    23.56612918243289
											  ],
											  [
											    -109.50350554150789,
											    23.565396757098114
											  ],
											  [
											    -109.50206722269617,
											    23.56495729993641
											  ],
											  [
											    -109.49951021147571,
											    23.564371354767772
											  ],
											  [
											    -109.49743263985917,
											    23.56407838120343
											  ],
											  [
											    -109.4947158154374,
											    23.56378540698563
											  ],
											  [
											    -109.49263824382044,
											    23.56319945659071
											  ],
											  [
											    -109.49008123259999,
											    23.56275999207851
											  ],
											  [
											    -109.48768403458084,
											    23.56202754795919
											  ],
											  [
											    -109.48512702336038,
											    23.561734569167953
											  ],
											  [
											    -109.48241019893862,
											    23.561002119331164
											  ],
											  [
											    -109.47921393491295,
											    23.560416156522905
											  ],
											  [
											    -109.47729617649729,
											    23.559830191100687
											  ],
											  [
											    -109.47521860488074,
											    23.559244223065306
											  ],
											  [
											    -109.4686250178135,
											    23.5546961935394
											  ],
											  [
											    -109.46814557820957,
											    23.552498714087903
											  ],
											  [
											    -109.46878483101479,
											    23.55015469551178
											  ],
											  [
											    -109.47038296302742,
											    23.54781063513839
											  ],
											  [
											    -109.47246053464438,
											    23.546052562431584
											  ],
											  [
											    -109.47405866665703,
											    23.543854938489744
											  ],
											  [
											    -109.47501754586484,
											    23.541950301364267
											  ],
											  [
											    -109.47677549107878,
											    23.539313065957714
											  ],
											  [
											    -109.47789418348789,
											    23.53696881231332
											  ],
											  [
											    -109.47869324949443,
											    23.534917556102997
											  ],
											  [
											    -109.47965212870184,
											    23.531987134603057
											  ],
											  [
											    -109.48029138150706,
											    23.52905664783421
											  ],
											  [
											    -109.48061100790966,
											    23.526126095801104
											  ],
											  [
											    -109.48061100790966,
											    23.522755880290177
											  ],
											  [
											    -109.48013156830577,
											    23.52011826013046
											  ],
											  [
											    -109.47885306269573,
											    23.515868649826103
											  ],
											  [
											    -109.47565568329917,
											    23.512644716023132
											  ],
											  [
											    -109.47453699089003,
											    23.510299987326704
											  ],
											  [
											    -109.4727790456761,
											    23.507662117646376
											  ],
											  [
											    -109.47054166085785,
											    23.504437982964987
											  ],
											  [
											    -109.46878371564391,
											    23.500920655138614
											  ],
											  [
											    -109.46718558363085,
											    23.497989476892755
											  ],
											  [
											    -109.46510801201431,
											    23.495791050421857
											  ],
											  [
											    -109.4635098800017,
											    23.494178847703353
											  ],
											  [
											    -109.46143230838473,
											    23.490807814660883
											  ],
											  [
											    -109.46063324237862,
											    23.48816955475702
											  ],
											  [
											    -109.460313615976,
											    23.486410685492004
											  ],
											  [
											    -109.45791641795645,
											    23.484651792763984
											  ],
											  [
											    -109.45487996713207,
											    23.482892876575008
											  ],
											  [
											    -109.45232295591161,
											    23.481427095163596
											  ],
											  [
											    -109.44976594469117,
											    23.479668135967145
											  ],
											  [
											    -109.447368746672,
											    23.47790915331278
											  ],
											  [
											    -109.44529117505547,
											    23.475124049473905
											  ],
											  [
											    -109.44481173545019,
											    23.47145934958324
											  ],
											  [
											    -109.44353322984017,
											    23.46735476486556
											  ],
											  [
											    -109.44193509782713,
											    23.464569438245192
											  ],
											  [
											    -109.43937808660667,
											    23.462223854450116
											  ],
											  [
											    -109.43698088858753,
											    23.46075784341295
											  ],
											  [
											    -109.43394443776315,
											    23.458852004727106
											  ],
											  [
											    -109.4320266793479,
											    23.45826558728885
											  ],
											  [
											    -109.42962948132833,
											    23.457679167246084
											  ],
											  [
											    -109.42803134931572,
											    23.45548006889021
											  ],
											  [
											    -109.42675284370527,
											    23.45313432361047
											  ],
											  [
											    -109.42611359090006,
											    23.4515215995616
											  ],
											  [
											    -109.42547433809526,
											    23.44902916911599
											  ],
											  [
											    -109.42483508529004,
											    23.446536691640276
											  ],
											  [
											    -109.42387620608221,
											    23.44565698247959
											  ],
											  [
											    -109.42499489849135,
											    23.44463064772232
											  ],
											  [
											    -109.42627340410137,
											    23.44287119816026
											  ],
											  [
											    -109.42755190971181,
											    23.43979210505192
											  ],
											  [
											    -109.42707247010789,
											    23.437592708906422
											  ],
											  [
											    -109.42627340410137,
											    23.43510001569453
											  ],
											  [
											    -109.42755190971181,
											    23.431727473584843
											  ],
											  [
											    -109.42915004172443,
											    23.428648120865603
											  ],
											  [
											    -109.43138742653755,
											    23.4213160400287
											  ],
											  [
											    -109.43234630574497,
											    23.418089795686285
											  ],
											  [
											    -109.43218649254365,
											    23.413836898835456
											  ],
											  [
											    -109.43122761333625,
											    23.410903786874727
											  ],
											  [
											    -109.43010892092711,
											    23.407823949346735
											  ],
											  [
											    -109.42835097571319,
											    23.405624021518847
											  ],
											  [
											    -109.42355657967445,
											    23.40342405712778
											  ],
											  [
											    -109.4206799420514,
											    23.402837393781965
											  ],
											  [
											    -109.4160453592144,
											    23.40254406113408
											  ],
											  [
											    -109.41700139509474,
											    23.396968007803565
											  ],
											  [
											    -109.41748083469868,
											    23.39506124945386
											  ],
											  [
											    -109.41572288948431,
											    23.390074213211932
											  ],
											  [
											    -109.41364531786778,
											    23.387433941540166
											  ],
											  [
											    -109.41316587826387,
											    23.38450024463431
											  ],
											  [
											    -109.4150836366791,
											    23.382299929327417
											  ],
											  [
											    -109.41716120829606,
											    23.381859861882063
											  ],
											  [
											    -109.42035747232173,
											    23.38259330681271
											  ],
											  [
											    -109.4232341099448,
											    23.38259330681271
											  ],
											  [
											    -109.42802850598311,
											    23.38009957748534
											  ],
											  [
											    -109.43154439641138,
											    23.377752495253816
											  ],
											  [
											    -109.43154439641138,
											    23.37452518932085
											  ],
											  [
											    -109.42994626439834,
											    23.369830785889164
											  ],
											  [
											    -109.42882757198963,
											    23.36689669933982
											  ],
											  [
											    -109.42770371418615,
											    23.364104515134343
											  ],
											  [
											    -109.42642520857572,
											    23.36102358952904
											  ],
											  [
											    -109.42626539537443,
											    23.35544839939638
											  ],
											  [
											    -109.42818315378966,
											    23.351633660638953
											  ],
											  [
											    -109.42738408778355,
											    23.34605807597393
											  ],
											  [
											    -109.42674483497834,
											    23.34106919644158
											  ],
											  [
											    -109.42497923005361,
											    23.338129785174146
											  ],
											  [
											    -109.4243399772484,
											    23.334167806663103
											  ],
											  [
											    -109.42545866965753,
											    23.329471975386085
											  ],
											  [
											    -109.42625773566364,
											    23.324922730548124
											  ],
											  [
											    -109.42785586767668,
											    23.31875898908902
											  ],
											  [
											    -109.42769605447538,
											    23.315530248531104
											  ],
											  [
											    -109.42593810926101,
											    23.31098052646287
											  ],
											  [
											    -109.42529885645621,
											    23.308191910180227
											  ],
											  [
											    -109.42545866965753,
											    23.303788712783714
											  ],
											  [
											    -109.42737642807275,
											    23.300559608716867
											  ],
											  [
											    -109.42897456007836,
											    23.29400480000558
											  ],
											  [
											    -109.43201101090274,
											    23.28930755007333
											  ],
											  [
											    -109.4352072749284,
											    23.28152736524521
											  ],
											  [
											    -109.43968204456411,
											    23.27081051733279
											  ],
											  [
											    -109.43808391255148,
											    23.260092807275697
											  ],
											  [
											    -109.43744465974625,
											    23.252751412650085
											  ],
											  [
											    -109.43648578053843,
											    23.245850133135733
											  ],
											  [
											    -109.44143998977755,
											    23.230871659966
											  ],
											  [
											    -109.44591475941324,
											    23.22396924869905
											  ],
											  [
											    -109.45134840825675,
											    23.216038378237954
											  ],
											  [
											    -109.45438485908113,
											    23.207666392991456
											  ],
											  [
											    -109.46269514554612,
											    23.19238984032222
											  ],
											  [
											    -109.4786764656745,
											    23.17461396235899
											  ],
											  [
											    -109.49561666501029,
											    23.150958100402036
											  ],
											  [
											    -109.55673559666123,
											    23.09888372493789
											  ],
											  [
											    -109.60462714985462,
											    23.071673809389054
											  ],
											  [
											    -109.68488391465051,
											    23.050235421001588
											  ],
											  [
											    -109.718539977307,
											    23.004965393250615
											  ],
											  [
											    -109.74701818417029,
											    22.979050451618548
											  ],
											  [
											    -109.80656352579308,
											    22.948061524781806
											  ],
											  [
											    -109.82986387686279,
											    22.900372395007594
											  ],
											  [
											    -109.89458707427916,
											    22.881292045061713
											  ],
											  [
											    -109.88763071963331,
											    22.875133494692406
											  ],
											  [
											    -109.96008809988047,
											    22.86351753753908
											  ],
											  [
											    -110.0240334691119,
											    22.893217578183283
											  ],
											  [
											    -110.0758120270449,
											    22.948061524781806
											  ],
											  [
											    -110.09393452232143,
											    23.005266301606085
											  ],
											  [
											    -110.10946808970138,
											    23.055300599090558
											  ],
											  [
											    -110.12241272918432,
											    23.117222065587782
											  ],
											  [
											    -110.06286738756155,
											    23.13626908252985
											  ],
											  [
											    -110.02921132490506,
											    23.141030414157186
											  ],
											  [
											    -109.97743276697204,
											    23.16245431351733
											  ],
											  [
											    -109.94377670431558,
											    23.16483453530161
											  ],
											  [
											    -109.87387565110603,
											    23.25287297065813
											  ],
											  [
											    -109.88940921848598,
											    23.359868440480582
											  ],
											  [
											    -109.85316422793292,
											    23.35511491503918
											  ],
											  [
											    -109.77031853524001,
											    23.35511491503918
											  ],
											  [
											    -109.84021958844956,
											    23.366998409269428
											  ],
											  [
											    -109.80915245368966,
											    23.393138347914658
											  ],
											  [
											    -109.68880135907872,
											    23.654394280627997
											  ]
											  ]
								          ]
								      }
								    }
								 
								]
					}

					return data
				}
			}
		})	

		function markersByCategory(category_id){

			const loading = document.querySelector('#loading-category')
			//limpiar markers
			app.cleanMarkers()

			//mostar icono cargando
			loading.style.display = "block"

			//get info places by category
			axios.get('/get_place_by_category/'+app.actualCity+'/'+category_id)
			.then(res => {

				app.places = res.data
				//////////pone los lugares en el mapa
				// add markers to map
				app.places.feautues.forEach(function(marker){

					var el = document.createElement('div');
				  	el.className = 'marker';

				  	//anadir el icono de categoria 
				  	el.style.backgroundImage = 'url({{ asset('iconos') }}/'+marker.properties.category_icon+')';


				  	var oneMarker = new mapboxgl.Marker(el)
				  	  .setLngLat(marker.geometry.coordinates)
				  	  .addTo(app.map);

				  	//añadir evento click al marker
				  	el.addEventListener('click', () => 
					   { 
					   	  //obtener info del lugar
					   	  app.getInfoPlace(marker.properties.id)
					   }
					); 

				  	//añadir los markers de la ciudad al array
					currentMarkers.push(oneMarker)

				})

				//guardar los marcadores(para luego ocultarlos)
				app.markers = document.querySelectorAll('.marker')
			})
			.then(function() {
		      	//desaparecer carga
		        loading.style.display = 'none'
		    })
			.catch(err => {

			})
		}

    </script>
@endsection