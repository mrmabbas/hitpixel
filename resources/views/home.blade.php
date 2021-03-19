@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add IP') }}</div>
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('addIp') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="ip" class="col-md-4 col-form-label text-md-right">{{ __('Enter IP') }}</label>

                            <div class="col-md-6">
                                <input id="ip" type="text" class="form-control @error('ip') is-invalid @enderror" name="ip" value="{{ old('ip') }}" required autocomplete="ip" autofocus placeholder="xxx.xxx.xxx.xxx">

                                @error('ip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add') }}
                                </button>

                              
                            </div>
                        </div>
                    </form>

                    <div class="row" style="margin-top: 50px;">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">IP</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Message</th>

                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($ipAddress))

                                @php $sr=1; @endphp
                                @foreach($ipAddress as $row)
                                @if($row->status == 'Accepted')
                                <tr>
                                    <th class="evencolor" scope="row">{{$sr}}</th>
                                    <td class="evencolor">{{$row->ip}}</td>
                                    <td class="evencolor">{{$row->status}}</td>
                                    <td class="evencolor">{{$row->msg}}</td>
                                    
                                </tr>
                                @else
                                <tr>
                                    <th scope="row">{{$sr}}</th>
                                    <td class="oddcolor">{{$row->ip}}</td>
                                    <td class="oddcolor">{{$row->status}}</td>
                                    <td class="oddcolor">{{$row->msg}}</td>
                                    
                                </tr>
                                @endif
                                @php $sr++; @endphp
                                @endforeach

                                @endif

                                
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 d-flex justify-content-center"><?php echo $ipAddress->render(); ?></div>
                </div>




                </div>
            </div>
        </div>
    </div>
</div>
@endsection
