@extends('layouts_mapa.app')


@section('content')
	<div id="map"></div>
@endsection

@section('scripts')
	<script>
        mapboxgl.accessToken = 'pk.eyJ1IjoibHVpc2plc3VzMDciLCJhIjoiY2s4YzkxMWZ2MGgxNTNsczJwZDRyc2VrciJ9.1hUQ7e4IIJYtOXtqfVp_MA';
        var map = new mapboxgl.Map({
            container: 'map', // container id
            style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
            center: [-112.5, 25.5], // starting position [lng, lat]
            zoom: 6 // starting zoom
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