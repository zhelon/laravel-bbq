@extends('layouts.app')

@section('content')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @foreach($publications as $p)
            <div class="card">
              <img src="{{asset("/storage/app/{$p->file_name}") }}" alt="{{$p->file_name}}" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">{{$p->description}}</p>
                <a href="#" class="btn btn-primary">Detail</a>
              </div>
            </div>
        @endforeach
    {{ $publications->links() }}


@endsection