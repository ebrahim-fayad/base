
    <button type="button" class="btn-searchTable">
        <i class="feather icon-filter"></i> <span>{{  __('admin.filter') }}</span>
    </button>

<div class="searchTable">
    <div class="forma">

        <div class="d-flex align-items-center justify-content-between">
            <h3 class="font-bold"> {{  __('admin.filter_according') }} : </h3>
            <div class="text-danger btnClose"> <i class="fa fa-times"></i> </div>
        </div>

        @isset($order)
            <div class="form-group">
                <label for="first-name-column">{{ __('admin.sort_by') }}</label>
                <div class="controls border">
                    <i class="fa fa-times clean-input"></i>
                    <select name="order" class="form-control search-input select2">
                        <option value>{{ __('admin.choose') }}</option>
                        <option value="ASC">{{ __('admin.Progressive') }}</option>
                        <option value="DESC" selected>{{ __('admin.descending') }}</option>
                    </select>
                </div>
            </div>
        @endisset

        @isset($datefilter)
            <div class="form-group">
                <label for="first-name-column">{{ __('admin.beginning_date') }}</label>
                <div class="controls border" id="start">
                    <input type="date"  name="created_at_min" class="form-control search-input" data-input>
                    <i class="fa fa-times clear-input" data-clear></i>
                </div>
            </div>
            <div class="form-group">
                <label for="first-name-column">{{ __('admin.end_date') }}</label>
                <div class="controls border" id="end">
                    <input type="date"  name="created_at_max" class="form-control search-input" data-input>
                    <i class="fa fa-times clear-input" data-clear></i>
                </div>
            </div>
        @endisset
        
        @isset($searchArray)
            @foreach ($searchArray as $key => $value)
                <div class="form-group">
                    <label for="first-name-column">{{ $value['input_name'] }}</label>
                    <div class="controls border">
                        <i class="fa fa-times clean-input"></i>
                        @if ($value['input_type'] == 'text')
                            <input type="text" name="{{ $key }}" class="form-control search-input "
                                    placeholder="{{ __('site.write') . $value['input_name'] }}">
                        @elseif ($value['input_type'] == 'select')
                            <select name="{{ $key }}" class="form-control search-input select2">
                                <option value>{{ __('admin.choose') }}</option>
                                @foreach ($value['rows'] as $row)
                                    <option value="{{ $row['id'] }}">
                                        {{ isset($value['row_name']) ? $row[$value['row_name']] : $row['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
            @endforeach
        @endisset
    </div>
</div>