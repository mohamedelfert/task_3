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
                <li class="active">{{ $title }}</li>
            </ol>

        </section><!-- end of content header -->

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h4 class="box-title" style="margin-bottom: 15px;">@lang('site.products')</h4>
                    <span><small>( {{ $products->total() }} )</small></span>

                    <form action="{{ route('dashboard.products.index') }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="category_id">
                                    <option value="">@lang('site.categories')</option>
                                    @foreach($categories as $category)
                                        <option
                                            value="{{ $category->id }}" {{ request()->category_id == $category->id ? 'selected' : ''  }}>{{ config('app.locale') == 'ar' ? $category->name_ar : $category->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary btn-sm" title="@lang('site.search')">
                                    <i class="fa fa-search"></i></button>
                                <a class="btn btn-danger btn-sm" href="{{ route('dashboard.products.index') }}"
                                   title="@lang('site.clear')">
                                    <i class="fa fa-eraser"></i></a>
                                @if(auth()->user()->hasPermission('products_create'))
                                    <a href="{{ route('dashboard.products.create')}}"
                                       class="btn btn-success btn-sm" title="@lang('site.add')">
                                        <i class="fa fa-plus-square"></i> / <i class="fa fa-user"></i>
                                    </a>
                                @else
                                    <a href="#"
                                       class="btn btn-success btn-sm disabled" title="@lang('site.add')">
                                        <i class="fa fa-plus-square"></i> / <i class="fa fa-user"></i></a>
                                @endif
                            </div>
                        </div>
                    </form>

                </div><!-- end of box header -->

                <div class="box-body">

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
                                <th>@lang('site.control')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ config('app.locale') == 'ar' ? $product->name_ar : $product->name_en }}</td>
                                    <td>{!! config('app.locale') == 'ar' ? $product->description_ar : $product->description_en !!}</td>
                                    <td>
                                        <image src="{{ $product->image_path }}"
                                               class="img-thumbnail" alt="@lang('site.image')" style="width:70px;"></image>
                                    </td>
                                    <td>{{ $product->purchase_price }}</td>
                                    <td>{{ $product->sale_price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ config('app.locale') == 'ar' ? $product->category->name_ar : $product->category->name_en }}</td>
                                    <td>
                                        @if(auth()->user()->hasPermission('products_update'))
                                            <a href="{{ route('dashboard.products.edit',$product->id)}}"
                                               class="btn btn-primary btn-sm" title="@lang('site.edit')">
                                                <i class="fa fa-edit"></i></a>
                                        @else
                                            <a href="#"
                                               class="btn btn-primary btn-sm disabled" title="@lang('site.edit')">
                                                <i class="fa fa-edit"></i></a>
                                        @endif

                                        @if(auth()->user()->hasPermission('products_delete'))
                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                               data-toggle="modal" href="#delete{{ $product->id }}"
                                               title="@lang('site.delete')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @else
                                            <a href="#"
                                               class="btn btn-danger btn-sm disabled" title="@lang('site.edit')">
                                                <i class="fa fa-edit"></i></a>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Delete -->
                                <div class="modal fade" id="delete{{ $product->id }}">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content modal-content-demo">
                                            <div class="modal-header">
                                                <h6 class="modal-title">@lang('site.delete')</h6>
                                                <button aria-label="Close" class="close" data-dismiss="modal"
                                                        type="button"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form action="{{ route('dashboard.products.destroy',$product->id) }}"
                                                  method="post">
                                                {{ method_field('delete') }}
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <p>@lang('site.msg_delete')</p><br>
                                                    <input type="hidden" name="id" id="id" value="{{ $product->id }}">
                                                    <input class="form-control" name="name" id="name" type="text"
                                                           value="{{ config('app.locale') == 'ar' ? $product->name_ar : $product->name_en }}" readonly>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">@lang('site.cancel')</button>
                                                    <button type="submit"
                                                            class="btn btn-danger">@lang('site.confirm')</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Delete -->
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
                                <th>@lang('site.control')</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="9" class="text-center text-danger">@lang('site.no_data_found')</td>
                            </tr>
                            </tbody>
                        </table>
                    @endif

                </div><!-- /.box-body -->

                <ul class="pull-right">
                    {{ $products->appends(request()->input())->links() }}
                </ul>

            </div><!-- end of box primary -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
