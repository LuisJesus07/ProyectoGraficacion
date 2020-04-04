            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>
                        @if(isset($main_title))
                            {{ $main_title }}
                        @else
                            Sección
                        @endif
                    </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="">
                                @if(isset($main_title))
                                    {{ $main_title }}
                                @else
                                    Sección
                                @endif
                            </a>
                        </li>
                        @if(isset($second_level) and $second_level !="")
                        <li class="breadcrumb-item active">
                            <strong>{{ $second_level }}</strong>
                        </li>
                        @endif
                    </ol>
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
                        @if(isset($add_action) and $add_action)
                        <a href=""  class="btn btn-primary" data-toggle="modal" data-target="#ModalAgregar">
                            Añadir registro
                        </a>
                        @endif
                    </div>
                </div>
            </div>