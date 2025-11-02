
@extends('layouts.nav')

@section('name', 'Activities List')
@section('custom-css')

@endsection
@section('content')

<div class="page-wrapper page-wrapper-one">
    <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>All Notifications</h4>
                        <h6>View your all activities</h6>
                    </div>
                </div>

                <div class="activity">
                    <div class="activity-box">
                        <ul class="activity-list">

                            @foreach ($groupedOrders as $groupedOrder)
                            <li>
                                <div class="activity-user">
                                    @php
                                    // Retrieve the user associated with the request_id
                                    $user = \App\Models\User::find($groupedOrder->first()->customer_id);
                                    $imageSrc = $user ? asset('uploads/users/' . $user->file) : '';
                                    $roleName = $user ? $user->roles()->first()->name : 'Role not found';
                                @endphp
                                    <a href="{{ route('show_sales', ['request_id' => $groupedOrder->first()->request_id]) }}"
                                        data-original-title="Lesley Grauer">
                                        <img alt="" src="{{ $imageSrc }}">

                                    </a>
                                </div>
                                <div class="activity-content">
                                    <div class="timeline-content">
                                        <a href="{{ route('show_sales', ['request_id' => $groupedOrder->first()->request_id]) }}">
                                            The {{ $roleName }} {{ $user->username }} </a> Ordered <a
                                            href="javascript:void(0);">{{ $groupedOrder->count() }} requests</a>
                                        <span class="time">{{ \Carbon\Carbon::parse($groupedOrder->first()->created_at)->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                          



                        </ul>
                    </div>
                </div>

            </div>
        </div>



        @endsection
        @section('custom-js')
    

            <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    
            <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
            <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
        @endsection