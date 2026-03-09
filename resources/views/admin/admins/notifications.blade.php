@extends('admin.layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/pages/app-email.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/assets/css/notifications.css')}}?v={{time()}}">
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" type="text/css" href="{{asset('admin/assets/css/notifications-rtl.css')}}?v={{time()}}">
    @endif
@endsection

@section('content')
    <div class="card ">
        <div class="card-content">
            <div class="card-body">

                <div class="email-app-list-wrapper">
                    <div class="email-app-list">
                        {{-- header content --}}
                        @if (auth('admin')->user()->notifications->count() > 0)

                            <div class="app-action d-flex justify-content-between mb-2">
                                <div class="action-left">
                                    <div class="vs-checkbox-con selectAll">
                                        <input type="checkbox">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-minus"></i>
                                            </span>
                                        </span>
                                        <span>{{__('admin.select_all')}}</span>
                                    </div>
                                </div>
                                <div class="action-right">
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item mail-delete delete_all_button"><span class="action-icon"><i class="feather icon-trash"></i></span></li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                        {{-- header content --}}

                        <div class="email-user-list list-group ps ps--active-y">
                            <ul class="users-list-wrapper media-list">
                                @foreach (auth('admin')->user()->notifications as $notification)
                                    <li class="media mail-read">
                                        <div class="media-left pr-50">
                                            <div class="user-action">
                                                <div class="vs-checkbox-con checkSingle" >
                                                    <input type="checkbox" id="{{$notification->id}}" >
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                        <i class="vs-icon feather icon-minus"></i>
                                                    </span>
                                                </span>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="media-body" data-url="{{ $notification->data['url'] ?? '#' }}">
                                            <div class="user-details">
                                                <div class="mail-items">
                                                    <span class="list-group-item-text text-truncate">{{$notification->title}}</span>
                                                </div>
                                                <div class="mail-meta-item">
                                                <span class="float-right d-flex align-items-center gap-2">
                                                    <span class="delete-single-notification cursor-pointer" data-id="{{$notification->id}}" title="{{__('admin.delete')}}">
                                                        <i class="feather icon-trash"></i>
                                                    </span>
                                                    <span class="mail-date">{{$notification->created_at->diffForHumans()}}</span>
                                                </span>
                                                </div>
                                            </div>
                                            <div class="mail-message">
                                                <p class="list-group-item-text truncate mb-0">{{$notification->body}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <hr>
                                @endforeach
                                <div class="no-data">
                                    <img  src="{{asset('admin/app-assets/images/pages/404.png')}}" alt="">
                                    <span class="mt-2" style="font-family: cairo">{{__('admin.there_is_no_data_at_the_moment')}}</span>
                                </div>
                            </ul>
                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 438px; left: 944px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 135px;"></div></div></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="{{asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js')}}"></script>
    <script src="{{asset('admin/app-assets/js/scripts/pages/app-email.js')}}"></script>
    
    <script>
        // تمرير الترجمات والـ routes للـ JavaScript
        window.translations = {
            are_you_sure: "{{__('admin.are_you_sure')}}",
            you_will_not_be_able_to_revert_this: "{{__('admin.you_will_not_be_able_to_revert_this')}}",
            yes_delete_it: "{{__('admin.yes_delete_it')}}",
            cancel: "{{__('admin.cancel')}}",
            confirm: "{{__('admin.confirm')}}",
            deleted_successfully: "{{__('admin.deleted_successfully')}}",
            error: "{{__('admin.error')}}",
            warning: "{{__('admin.warning')}}",
            something_went_wrong: "{{__('admin.something_went_wrong')}}",
            are_you_sure_text: "{{__('admin.are_you_sure_text')}}",
            the_selected_has_been_successfully_deleted: "{{__('admin.the_selected_has_been_successfully_deleted')}}",
            please_select_items: "{{__('admin.please_select_items_to_delete')}}"
        };
        
        window.routes = {
            deleteNotifications: "{{route('admin.admins.notifications.delete')}}"
        };
    </script>
    
    <script src="{{asset('admin/assets/js/notifications.js')}}?v={{time()}}"></script>
@endsection
