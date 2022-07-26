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
                <li><a href="{{ route('dashboard.categories.index') }}">@lang('site.categories')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section><!-- end of content header -->

        <section class="content">

            @include('partials._errors')

            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="col-md-4">
                        <a href="{{ route('dashboard.categories.index')}}"
                           class="btn btn-primary btn-sm" title="@lang('site.back')">
                            <i class="fa fa-rotate-left"></i></a>
                    </div>
                </div><!-- end of box header -->

                <div class="box-body">

                    <form method="POST" action="{{ route('dashboard.categories.update',$category->id)}}">
                        @csrf
                        @method('patch')

                        <div class="form-group">
                            <label for="name_ar">@lang('site.name_ar')</label>
                            <input type="text" name="name_ar" id="name_ar" class="form-control"
                                   value="{{ $category->name_ar }}"
                                   placeholder="@lang('site.name_ar')" required>
                            @error('name_ar')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="name_en">@lang('site.name_en')</label>
                            <input type="text" name="name_en" id="name_en" class="form-control"
                                   value="{{ $category->name_en }}"
                                   placeholder="@lang('site.name_en')" required>
                            @error('name_en')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            @if(auth()->user()->hasPermission('categories_update'))
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-edit"></i> @lang('site.update')
                                </button>
                            @else
                                <a class="btn btn-primary btn-block disabled"><i class="fa fa-edit"></i> @lang('site.update')</a>
                            @endif
                        </div>

                    </form>

                </div><!-- /.box-body -->
            </div><!-- end of box primary -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
