@extends('admin.excel_layouts.index-for-excel')
@section('content')

    @if(!empty($records))
            <table class="table m-b-xs">
                <tbody>
                <tr style="background-color: #337ab7;color: #FFF;">
                    @foreach($cols as $col)
                        <th style="text-align: center;background-color: #0a6ebd;color: #ffffff;">{{$col}}</th>
                    @endforeach
                </tr>
                @if(!empty($records))

                    @foreach($records as $record)
                        <tr>
                            @foreach($values as $val)
                                <td style="text-align: center">
                                    @if(!empty($image_columns) && isset($image_columns[$val]))
                                        {{-- Leave empty for image columns - images are added via drawings --}}
                                    @else
                                        {{ data_get($record, $val) ?? __('admin.main_categories') }}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td style="text-align: center" colspan="5">لا يوجد نتائج</td>
                    </tr>
                @endif

                </tbody>
            </table>
    @endif
@stop
