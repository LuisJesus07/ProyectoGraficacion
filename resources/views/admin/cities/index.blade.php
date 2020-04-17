@extends('layouts_admin.app')

<style type="text/css">

	@import url("https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap");
	
	.city-box{
		height: 28vh;
        width: 30%;
        margin-right: 3%;
        margin-bottom: 3%;
        background-color: #e5e9ef;
        border-radius: 10px;
	}

	.city-box:hover{
		transition: all linear .3s;
		cursor: pointer;
		background-color: #007bff;
		box-shadow: 2px 5px 5px rgba(0, 0, 0, 0.3);
	}

	.city-box:hover > .logo{
		transition: all linear .3s;
		transform: scale(1.1);
	}

	.city-box:hover > h2{
		color: white;
		transition: all linear .3s;
		transform: scale(1.1);
	}


	.city-box img {
		transform-origin: 0 0;
        width: 100%;
        height: 17vh;
    }

    .city-box h2 {
        float: right;
        font-family: Fjalla One, sans-serif;;
        margin-top: 5%;
        margin-right: 10%;
    }

    .city-box a{
    	text-decoration: none;
    }

    .logo {
       margin-left: 25px;
       margin-top: -45px
    }

    .logo img{
      border-radius: 50%;
      box-shadow: 2px 5px 5px rgba(0, 0, 0, 0.3);
      width: 90px;
      height: 15vh;
    }
</style>

@section('content')
	
	<div class="card">
     	<div class="card-header">
     		<div class="container">
     			<div class="row">
					<div class="col-md">
						<h3>Municipios</h3>
					</div>
				</div>
     		</div>
     	</div>	
     	<div class="card-body">
     		<div class="row d-flex align-items-stretch registros">
				@foreach($cities as $city)
				<div class="city-box" onclick="cityDetail({{$city->id}})">
					<img id="image-city" src="{{asset('fotos_cities')}}/{{$city->url_foto}}">
					<h2 id="name-city">{{$city->name}}</h2>
					<div class="logo">
						<img id="logo-city" src="{{asset('fotos_cities')}}/{{$city->logo}}">
					</div>
				</div>
			    @endforeach
		    </div>	
     	</div>
    </div>	

@endsection

@section('scripts')

<script type="text/javascript">

	function cityDetail(id){

		location.href = "/cities/"+id
	}

</script>

@endsection