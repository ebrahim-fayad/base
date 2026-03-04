<div class="row m-0 justify-content-between">
    <div class="buttons">

        @if(isset($addbutton) && !empty($addbutton))
            <a href="{{$addbutton}}" class="btn bg-gradient-primary mr-1 mb-1 waves-effect waves-light" ><i class="feather icon-plus"></i> {{__('admin.add')}}</a>
        @endif

        @isset($deletebutton)
            <button type="button" data-route="{{$deletebutton}}" class="btn bg-gradient-danger mr-1 mb-1 waves-effect waves-light delete_all_button"><i class="feather icon-trash"></i> {{__('admin.delete_selected')}}</button>
        @endisset

        @isset($extrabuttons)
            {{$extrabuttonsdiv}}
        @endif

        <button type="button" class="reloadTable btn bg-gradient-warning mr-1 mb-1 waves-effect waves-light"><i class="feather icon-refresh-cw"></i> {{__('admin.refresh')}}</button>
    </div>
</div>
