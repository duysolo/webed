@php
    $hasFilter = isset($filter) && $filter ? true : false;
    $hasTableActions = isset($tableActions) && $tableActions ? true : false;
    $totalColumns = sizeof($headings);
@endphp
<div class="table-container">
    @if($hasTableActions)
        <div class="table-actions-wrapper">
            <span></span>
            {!! $tableActions !!}
            <button class="btn btn-sm green table-group-action-submit" data-toggle="confirmation">
                <i class="fa fa-check"></i> Submit
            </button>
        </div>
    @endif
    <table class="table table-striped table-bordered table-hover vertical-middle datatables">
        <thead>
        <tr role="row" class="heading">
            @if($hasTableActions)
                <th width="1%" class="no-sort no-search sorting_disabled">
                    {!! form()->customCheckbox([
                        ['group_checkable', 1]
                    ]) !!}
                </th>
            @endif
            @foreach($headings as $heading)
                <th width="{{ $heading['width'] or '' }}">{{ $heading['name'] or '' }}</th>
            @endforeach
        </tr>
        @if($hasFilter)
            <tr role="row" class="filter">
                @if($hasTableActions)
                    <td></td>
                @endif
                @for($i = 1; $i < $totalColumns; $i++)
                    <td>
                        {!! $filter[(($hasTableActions) ? $i : $i - 1)] or '' !!}
                    </td>
                @endfor
                <td>
                    <button class="btn btn-sm green filter-submit">
                        <i class="fa fa-search"></i>
                    </button>
                    <button class="btn btn-sm yellow-lemon filter-cancel">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        @endif
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
