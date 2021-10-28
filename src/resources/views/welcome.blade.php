@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center flex-wrap">
            <v-card
            >
                <div>
                    <v-card-title class="pl-10">{{ __('Support Tickets') }}</v-card-title>
                    <div class="card-form">
                        <tickets-component></tickets-component>
                    </div>
                </div>
            </v-card>
        </div>
    </div>
@endsection
