@extends('layouts.dashboard.app')
@section('title')
    {{ $title }}
@endsection
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>{{ $title }}</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.users.index') }}">@lang('site.users')</a></li>
                <li class="active">@lang('site.add')</li>
            </ol>
        </section><!-- end of content header -->

        <section class="content">

{{--            @include('partials._errors')--}}

            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="col-md-4">
                        <a href="{{ route('dashboard.users.index')}}"
                           class="btn btn-primary btn-sm" title="@lang('site.back')">
                            <i class="fa fa-rotate-left"></i></a>
                    </div>
                </div><!-- end of box header -->

                <div class="box-body">

                    <form method="POST" action="{{ route('dashboard.users.store')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="first_name">@lang('site.first_name')</label>
                            <input type="text" name="first_name" id="first_name" class="form-control"
                                   value="{{ old('first_name') }}" placeholder="@lang('site.first_name')" required>
                            @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="last_name">@lang('site.last_name')</label>
                            <input type="text" name="last_name" id="last_name" class="form-control"
                                   value="{{ old('last_name') }}" placeholder="@lang('site.last_name')" required>
                            @error('last_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="email">@lang('site.email')</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="{{ old('email') }}" placeholder="@lang('site.email')" required>
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="image">@lang('site.image')</label>
                            <input type="file" name="image" id="image" class="form-control user_image">
                            @error('image')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <img class="img-responsive image_preview" style="width:100px" alt="@lang('site.image')" src="{{ asset('uploads/users_images/default.png') }}">
                        </div>

                        <div class="form-group">
                            <label for="password">@lang('site.password')</label>
                            <input type="password" name="password" id="password" class="form-control"
                                   placeholder="@lang('site.password')" required>
                            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">@lang('site.password_confirmation')</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                                   value="{{ old('password_confirmation') }}" placeholder="@lang('site.password_confirmation')" required>
                            @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>@lang('site.permissions')</label>
                            <div class="nav-tabs-custom">
                                @php
                                    $models = ['users','categories','products','orders','clients','settings'];
                                    $maps = ['create','read','update','delete'];
                                @endphp

                                <ul class="nav nav-tabs">
                                    @foreach($models as $index=>$model)
                                        <li class="{{ $index == 0 ? 'active' : '' }}">
                                            <a href="#{{ $model }}"
                                               data-toggle="tab" aria-expanded="false">@lang('site.' . $model)</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach($models as $index=>$model)
                                        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}">
                                            @foreach($maps as $map)
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                           value="{{ $model . '_' . $map }}">@lang('site.' . $map)</label>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            @if(auth()->user()->hasPermission('users_create'))
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-plus"></i> @lang('site.add')
                                </button>
                            @else
                                <a class="btn btn-primary btn-block disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                            @endif
                        </div>

                    </form>

                </div><!-- /.box-body -->
            </div><!-- end of box primary -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection

@push('js')
    <script type="text/javascript">
        $('.user_image').change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.image_preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
@endpush
