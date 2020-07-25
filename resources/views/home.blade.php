@extends('layouts.apps')

@section('content')
        <div class="header">
            <ol class="breadcrumb breadcrumb-col-pink">
                <li><a href="/"><i class="material-icons">home</i> 后台主页</a></li>
                <li class="active"><i class="material-icons">library_books</i> 入驻机构列表</li>
            </ol>

            <ul class="header-dropdown m-r--5">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="label label-dot label-info">Info</span>
                        <span class="label label-dot label-warning">Warning</span>
                        <span class="label label-dot label-danger">Danger</span>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">数据分析</a></li>
                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">上下级分析</a></li>
                    </ul>
                </li>
            </ul>
        </div>
@endsection
