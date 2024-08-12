@extends('user.layout.base')

@section('title', 'My Cards ')

@section('content')

    <div class="col-md-12">
        <div class="dash-content">
            <div class="row no-margin">
                <div class="col-md-12">
                    <h4 class="page-title">{{ translateKeyword('my_cards') }}</h4>
                    <h6><a href="{{ route('web.card.add') }}">(+) {{ translateKeyword('add_card')}}</a></h6>
                </div>
            </div>

            <div class="row no-margin ride-detail">
                <div class="col-md-12">
                    @if ($cards->count() > 0)

                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>{{ translateKeyword('card_no') }}</th>
                                <th>{{ translateKeyword('card_brand') }}</th>
                                <th>{{ translateKeyword('card_default') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($cards as $index => $card)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $card->last_four }}</td>
                                    <td>{{ $card->brand }}</td>
                                    <td> 
                                        {{ $card->is_default ? 'Yes' : 'No' }}
                                        &nbsp;
                                         @if ($cards->count() > 1)
                                            @if(!$card->is_default)
                                                <a href="{{ route('card.delete', $card->id) }}" class="btn btn-danger">{{ translateKeyword('delete')}}</a>
                                                <a href="{{ route('card.make-default', $card->id) }}" class="btn btn-info">{{ translateKeyword('make-default')}}</a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <hr>
                        <p style="text-align: center;">{{ translateKeyword('no_history_available') }}</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
