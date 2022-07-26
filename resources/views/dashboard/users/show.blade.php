@extends('layouts.dashboard.app')
@section('title')
    {{ $title }}
@endsection
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>{{ $title }}</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active">@lang('site.profile')</li>
            </ol>
        </section><!-- end of content header -->

        <section class="content">

            {{--            @include('partials._errors')--}}

            <div class="box box-primary">
                {{--                <div class="box-header with-border">--}}
                {{--                    <div class="col-md-4">--}}
                {{--                        <a href="{{ route('dashboard.users.index')}}"--}}
                {{--                           class="btn btn-primary btn-sm" title="@lang('site.back')">--}}
                {{--                            <i class="fa fa-rotate-left"></i></a>--}}
                {{--                    </div>--}}
                {{--                </div><!-- end of box header -->--}}

                <div class="box-body">

                    <div class="col-lg-4 pull-right">
                        <div class="row text-center" style="margin-top:20px">
                            <div class="form-group">
                                <img class="img-responsive" style="width:100%" alt="@lang('site.image')"
                                     src="{{ $user->image_path }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 pull-left">
                        <form method="POST" action="{{ route('dashboard.users.profile',$user->id)}}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <div class="form-group">
                                <label for="first_name">@lang('site.first_name')</label>
                                <input type="text" name="first_name" id="first_name" class="form-control"
                                       value="{{ old('first_name',$user->first_name) }}"
                                       placeholder="@lang('site.first_name')" required>
                                @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label for="last_name">@lang('site.last_name')</label>
                                <input type="text" name="last_name" id="last_name" class="form-control"
                                       value="{{ old('last_name',$user->last_name) }}"
                                       placeholder="@lang('site.last_name')" required>
                                @error('last_name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label for="email">@lang('site.email')</label>
                                <input type="email" name="email" id="email" class="form-control"
                                       value="{{ old('email',$user->email) }}" placeholder="@lang('site.email')"
                                       required>
                                @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label for="image">@lang('site.image')</label>
                                <input type="file" name="image" id="image" class="form-control">
                                @error('image')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label for="password">@lang('site.password')</label>
                                <input type="password" name="password" id="password" class="form-control"
                                       placeholder="@lang('site.password')">
                                @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">@lang('site.password_confirmation')</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="form-control"
                                       value="{{ old('password_confirmation') }}"
                                       placeholder="@lang('site.password_confirmation')">
                                @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                @if($user->id === auth()->user()->id)
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-edit"></i> @lang('site.update')
                                    </button>
                                @else
                                    <a class="btn btn-primary btn-block disabled"><i
                                            class="fa fa-edit"></i> @lang('site.update')</a>
                                @endif
                            </div>

                        </form>
                    </div>

                </div><!-- /.box-body -->
            </div><!-- end of box primary -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
