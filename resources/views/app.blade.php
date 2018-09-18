@extends('layouts.app')

@section('content')
    <section id="select-action">
        <div class="container">
            <div>
                <button class="large" data-toggle="section" data-section="select-parking">{{ __('app.selectAction.parking') }}</button>
            </div>

            <div>
                <button class="large" data-toggle="section" data-section="scan-ticket">{{ __('app.selectAction.pay') }}</button>
            </div>
        </div>
    </section>

    <section id="select-parking">
        <div class="go-back" data-toggle="section" data-section="select-action">
            {{ __('app.goBack') }}
        </div>

        <div class="container">
            <div class="col-xs-12">
                <h2>{{ __('app.selectParking.title') }}</h2>
                <div class="parking-grid-outer">
                    <div class="parking-grid">

                        @foreach($parkingSpots as $parkingSpot)

                            <div
                                class="parking-spot-outer {{ $parkingSpot->orientation }}"
                                style="top: {{ $parkingSpot->grid_y }}%; left: {{ $parkingSpot->grid_x }}%;">
                                <div
                                    id="parking-spot-{{ $parkingSpot->code }}"
                                    class="parking-spot {{ $parkingSpot->available ? '' : 'taken' }}">
                                    <span class="spot-number">{{ $parkingSpot->code }}</span>
                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>

                <button id="parking-selected">{{ __('app.next') }}</button>
            </div>
        </div>
    </section>

    <section id="ticket">
        <div class="container">
            <div class="col-xs-12">
                <h2>{{ __('app.ticket.title') }}</h2>
                <img id="ticket-barcode" src="" alt="barcode" />
                <span id="ticket-barcode-text" class="underpoint"></span>
                <h3>{!! __('app.ticket.spot') !!}</h3>
                <h3>{{ __('app.ticket.disclaimer') }}</h3>
                <button class="refresh-app">{{ __('app.ticket.take') }}</button>
            </div>
        </div>
    </section>

    <section id="scan-ticket">
        <div class="go-back" data-toggle="section" data-section="select-action">
            {{ __('app.goBack') }}
        </div>
        
        <div class="container">
            <div class="col-xs-12">
                <h2>{{ __('app.scanTicket.title') }}</h2>
                <h3>{{ __('app.scanTicket.direction') }}</h3>
                <span class="underpoint">{{ __('app.scanTicket.directionSub') }}</span>
                <input type="text" id="ticket-code-input" />
                <div>
                    <button id="scan-ticket-button">{{ __('app.next') }}</button>
                </div>
            </div>
        </div>
    </section>

    <section id="pay-ticket">
        <div class="go-back" data-toggle="section" data-section="scan-ticket">
            {{ __('app.goBack') }}
        </div>

        <div class="container">
            <div class="col-xs-12">
                <h2>{{ __('app.payTicket.title') }}</h2>
                <h3 id="stay-duration"></h3>
                <span class="underpoint">{{ __('app.payTicket.duration') }}</span>
                <h3 id="balance-owed"></h3>
                <span class="underpoint">{{ __('app.payTicket.balance') }}</span>
                <div>
                    <button id="pay-ticket-button">{{ __('app.payTicket.pay') }}</button>
                </div>
            </div>
        </div>
    </section>
@endsection
