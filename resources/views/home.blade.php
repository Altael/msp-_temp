@extends( auth()->user()->sadvipra ? 'layouts.sadvipra' : 'layouts.app')

@section('page_css')
    @if(auth()->user()->sadvipra)
        <link href="{{ mix('css/sadvipra/medForEve.css') }}" rel="stylesheet">
    @endif
@endsection

@section('content')
    @if (session('status'))
        <div class="mb-5 alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if(auth()->user()->sadvipra)
        <med-for-eve></med-for-eve>
    @else
        <div class="appHome">

        </div>
    @endif
@endsection
