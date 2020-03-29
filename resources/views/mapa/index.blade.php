@extends('layouts_mapa.app')


@section('content')
	<div id="map"></div>
	<div class="calculation-box">
		<p>Draw a polygon using the draw tools.</p>
		<div id="calculated-area"></div>
	</div>
@endsection

@section('scripts')
	<script src="https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v3.0.11/turf.min.js"></script>
	<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.js"></script>
	<script>
        mapboxgl.accessToken = 'pk.eyJ1IjoibHVpc2plc3VzMDciLCJhIjoiY2s4YzkxMWZ2MGgxNTNsczJwZDRyc2VrciJ9.1hUQ7e4IIJYtOXtqfVp_MA';
        var map = new mapboxgl.Map({
            container: 'map', // container id
            style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
            center: [-112.5, 25.5], // starting position [lng, lat]
            zoom: 6, // starting zoom
            boxZoom: true
        });



        var draw = new MapboxDraw({
			displayControlsDefault: false,
			controls: {
				polygon: true,
				trash: true
			}
		});
		map.addControl(draw);
		 
		map.on('draw.create', updateArea);
		map.on('draw.delete', updateArea);
		map.on('draw.update', updateArea);
			 
		function updateArea(e) {

			console.log(e)

			var data = draw.getAll();
			var answer = document.getElementById('calculated-area');
			if (data.features.length > 0) {
			var area = turf.area(data);
			// restrict to area to 2 decimal points
			var rounded_area = Math.round(area * 100) / 100;
				answer.innerHTML =
				'<p><strong>' +
				rounded_area +
				'</strong></p><p>square meters</p>';
			} else {
			answer.innerHTML = '';
			if (e.type !== 'draw.delete')
				alert('Use the draw tools to draw a polygon!');
			}

		}


        
        map.on('load', function() {
			var layers = map.getStyle().layers;
			// Find the index of the first symbol layer in the map style
			var firstSymbolId;
				for (var i = 0; i < layers.length; i++) {
					if (layers[i].type === 'symbol') {
						firstSymbolId = layers[i].id;
						break;
					}
				}
			map.addSource('urban-areas', {
				'type': 'geojson',
				'data': 
					{
						"type": "FeatureCollection",
						"features": [
							{
							  "id": "100",
						      "type": "Feature",
						      "properties": {
						        "scalerank": 3,
						        "area_sqkm": 1002.565,
						        "featureclass": "Urban area"
						      },
						      "geometry": {
						        "type": "Polygon",
						        "coordinates": [
						          [
						            [
						              -121.37881303595779,
						              38.39168793390614
						            ],
						            [
						              -121.37881303595779,
						              38.39168793390614
						            ],
						            [
						              -121.37881303595779,
						              38.39168793390614
						            ],
						            [
						              -121.42144609259859,
						              38.3858743352733
						            ],
						            [
						              -121.48040890184362,
						              38.39168793390614
						            ],
						            [
						              -121.51616899298959,
						              38.444811306302185
						            ],
						            [
						              -121.58203060594559,
						              38.4678848333205
						            ],
						            [
						              -121.5930118478076,
						              38.626428127591964
						            ],
						            [
						              -121.46772233771595,
						              38.671102403308296
						            ],
						            [
						              -121.39491024461671,
						              38.75068410903778
						            ],
						            [
						              -121.31532853888723,
						              38.82349620213702
						            ],
						            [
						              -121.23913163947286,
						              38.82349620213702
						            ],
						            [
						              -121.19226111538413,
						              38.73701569269657
						            ],
						            [
						              -121.13750993537089,
						              38.65836416274834
						            ],
						            [
						              -121.19386308478518,
						              38.61312144627681
						            ],
						            [
						              -121.26453060594432,
						              38.58219310155013
						            ],
						            [
						              -121.32057369676485,
						              38.53666616470099
						            ],
						            [
						              -121.37881303595779,
						              38.4933096380081
						            ],
						            [
						              -121.37062232143953,
						              38.43667226821621
						            ],
						            [
						              -121.37881303595779,
						              38.39168793390614
						            ]
						          ]
						        ]
						      }
						    },
						    {
						      "id": "200",
						      "type": "Feature",
						      "properties": {
						        "scalerank": 3,
						        "area_sqkm": 1002.565,
						        "featureclass": "Urban area"
						      },
						      "geometry": {
						        "type": "Polygon",
						        "coordinates": [
						          [
						            [
						              -111.42778344593556,
						              24.92302108466447
						            ],
						            [
						              -110.8564943834355,
						              24.893127791563316
						            ],
						            [
						              -110.8564943834355,
						              24.493861335969882
						            ],
						            [
						              -111.40581078968565,
						              24.493861335969882
						            ],
						            [
						              -111.42778344593556,
						              24.92302108466447
						            ]
						          ]
						        ]
						      }
						    }
						]
					}
			});
			map.addLayer(
			{
				'id': 'urban-areas-fill',
				'type': 'fill',
				'source': 'urban-areas',
				'layout': {},
				'paint': {
				'fill-color': '#f08',
				'fill-opacity': 0.4
			}
			// This is the important part of this example: the addLayer
			// method takes 2 arguments: the layer as an object, and a string
			// representing another layer's name. if the other layer
			// exists in the stylesheet already, the new layer will be positioned
			// right before that layer in the stack, making it possible to put
			// 'overlays' anywhere in the layer stack.
			// Insert the layer beneath the first symbol layer.
			},
			firstSymbolId
			);
		});



		map.on('mouseover', 'urban-areas-fill', function(e) {
			console.log(e)

		});
		

        var geojson = {
		  type: 'FeatureCollection',
		  features: [{
		    type: 'Feature',
		    geometry: {
		      type: 'Point',
		      coordinates: [-77.032, 38.913]
		    },
		    properties: {
		      title: 'Mapbox',
		      description: 'Washington, D.C.'
		    }
		  },
		  {
		    type: 'Feature',
		    geometry: {
		      type: 'Point',
		      coordinates: [-122.414, 37.776]
		    },
		    properties: {
		      title: 'Mapbox',
		      description: 'San Francisco, California'
		    }
		  },
		  {
		    type: 'Feature',
		    geometry: {
		      type: 'Point',
		      coordinates: [-110.414, 24.100]
		    },
		    properties: {
		      title: 'La Paz',
		      description: 'La Paz, B.C.S',
		      'marker-size': 'large',
		      'marker-color': '#592913',
		      'marker-symbol': 'cafe',

		    }
		  }]
		};

		// add markers to map
		geojson.features.forEach(function(marker) {

		  // create a HTML element for each feature
		  var el = document.createElement('div');
		  el.className = 'marker';

		  // make a marker for each feature and add to the map
		  new mapboxgl.Marker(el)
		    .setLngLat(marker.geometry.coordinates)
		    .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
    			.setHTML('<h3>' + marker.properties.title + '</h3><p>' + marker.properties.description + '</p>'))
		    .addTo(map);
		});

    </script>
@endsection