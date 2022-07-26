@extends('layouts.dashboard.app')

@section('title')
    {{ $title }}
@endsection

@section('css')

@endsection

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>{{ $title }}</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">{{ $title }}</li>
            </ol>
        </section>

        <section class="content">

            <div class="row">

                {{-- categories--}}
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $categories_count }}</h3>
                            <p>@lang('site.categories')</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('dashboard.categories.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                {{--products--}}
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $products_count }}</h3>
                            <p>@lang('site.products')</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('dashboard.products.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                {{--users--}}
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $users_count }}</h3>
                            <p>@lang('site.users')</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="{{ route('dashboard.users.index') }}" class="small-box-footer">
                            @lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div><!-- end of row -->

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('site.latest_products')</h3>
                </div>
                <div class="box-body border-radius-none">
                    @if($products->count() > 0)
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.description')</th>
                                <th>@lang('site.product_image')</th>
                                <th>@lang('site.purchase_price')</th>
                                <th>@lang('site.sale_price')</th>
                                <th>@lang('site.stock')</th>
                                <th>@lang('site.category_name')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ config('app.locale') == 'ar' ? $product->name_ar : $product->name_en }}</td>
                                    <td>{!! config('app.locale') == 'ar' ? $product->description_ar : $product->description_en !!}</td>
                                    <td>
                                        <image src="{{ $product->image_path }}" class="img-thumbnail"
                                               alt="@lang('site.image')" style="width:70px;"></image>
                                    </td>
                                    <td>{{ $product->purchase_price }}</td>
                                    <td>{{ $product->sale_price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ config('app.locale') == 'ar' ? $product->category->name_ar : $product->category->name_en }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.description')</th>
                                <th>@lang('site.product_image')</th>
                                <th>@lang('site.purchase_price')</th>
                                <th>@lang('site.sale_price')</th>
                                <th>@lang('site.stock')</th>
                                <th>@lang('site.category_name')</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="8" class="text-center text-danger">@lang('site.no_data_found')</td>
                            </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div><!-- /.box-body -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection

@section('js')

@endsection
