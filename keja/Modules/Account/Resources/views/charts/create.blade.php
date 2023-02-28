@extends('layouts.master')
@section('title') New Account @endsection
@section('content')

    <ul class="nav nav-pills primary">
        <li class=""><a class="btn btn-sm btn-primary" href="{{ route('chart.index') }}"> Back </a></li>
    </ul>

    <div class="box">
        <div class="box-body">
            <form class="form-horizontal" action="{{ route('chart.store') }}" method="post" autocomplete="off">
                {{ csrf_field() }}
                <input type="hidden" name="account_id">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="col-md-2">Chart Of Account </label>
                        <div class="col-md-4">

                            <select
                                class="select2 form-control"
                                name="chart_id"
                            >
                                @foreach($charts as $chart)
                                    <option value="{{ $chart->id }}">{{ $chart->name }}</option>
                                @endforeach

                            </select>


                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <label8 class="col-md-1"> {{ __('Parent') }} </label8>

                        <div class="col-md-4">

                            <select
                                class="select2 form-control"
                                name="parent_id"
                                id="parent_id"
                            >
                                <option value=""> -Select parent-</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" data-glcode="{{ $parent->glcode }}">{{ $parent->name }}</option>
                                @endforeach

                            </select>


                            @error('id_no')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="has_children" class="col-md-2">{{ __('Has children') }}</label>

                        <div class="col-md-4">
                            <input
                                type="checkbox"
                                class="form-check-input @error('has_children') is-invalid @enderror"
                                id="has_children"
                                name="has_children"
                                aria-describedby="emailHelp"
                                value="{{ old('email') }}"
                                placeholder="Has children">
                            @error('has_children')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <label for="allow_manual_entry" class="col-md-1">{{ __('Allow manual Entry') }}</label>

                        <div class="col-md-4">
                            <input
                                type="checkbox"
                                class="form-check-input @error('allow_manual_entry') is-invalid @enderror"
                                id="allow_manual_entry"
                                name="allow_manual_entry"
                                aria-describedby="allow_manual_entry"
                                value="{{ old('email') }}"
                                placeholder="Has children">
                            @error('allow_manual_entry')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                    </div>


                    <div class="form-group">
                        <label for="glcode" class="col-md-2">{{ __('GLCODE') }}</label>

                        <div class="col-md-4">
                            <input
                                type="text"
                                class="form-control @error('glcode') is-invalid @enderror"
                                id="glcode"
                                name="glcode"
                                aria-describedby="glcode"
                                value="{{ old('glcode') }}"
                                placeholder="Enter Account glcode">
                            @error('glcode')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>


                        <label for="account_name" class="col-md-1">{{ __('Account Name') }}</label>

                        <div class="col-md-4">
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="account_name"
                                name="name"
                                aria-describedby="emailHelp"
                                value="{{ old('account_name') }}"
                                placeholder="Enter Account Name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                    </div>



                    <div class="form-group">

                        <label for="description" class="col-md-2"> Description </label>

                        <div class="col-md-10">
                            <textarea
                                type="text"
                                class="form-control @error('description') is-invalid @enderror"
                                id="description"
                                name="description"
                                rows="5"
                                aria-describedby="description"
                                placeholder=""></textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('js')
    @include('layouts._form-scripts')
    <script>
        $("#parent_id").on('change',function () {
            let glcode =  $("select#parent_id option:selected").attr('data-glcode');
            $("input#glcode").val(glcode)

        })
    </script>
@endsection
