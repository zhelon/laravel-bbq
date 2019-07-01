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

<div class="row">

        @foreach($publications as $p)

        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="{{asset($p->file_name) }}" alt="{{$p->file_name}}" />
          <div class="card-body">
            <p class="card-text">{{$p->description}}</p>
          </div>
        </div>

        @endforeach
    {{ $publications->links() }}
</div>
@endsection