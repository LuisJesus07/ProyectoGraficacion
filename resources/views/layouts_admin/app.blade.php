<!DOCTYPE html>
<html lang="es">
<head>
    @include('layouts_admin.head')
    @yield('head')
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        @include('layouts_admin.nav')

        @include('layouts_admin.sidebar')

        <div class="content-wrapper">

            <div class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@yield('title')</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      
                      @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <strong>Great</strong> Your process has finished successfully
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                      @endif

                      @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>Error!</strong> The proccess hasnt finished, verify your info
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                      @endif

                      @if(session('ya_inscrito'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>Error!</strong> El usuario ya esta inscrito a ese proyecto.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                      @endif
                    </ol>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div><!-- /.container-fluid -->
            </div>

            <section class="content">
              
              <div class="card card-solid">
                <div class="card-body pb-0">
                  @yield('content')
                </div> 
              </div>
              
            </section>

            
        </div>
        
    </div>
    
  @yield('modals')
  @include('layouts_admin.scripts')
  @yield('scripts')
</body>
</html>
