@extends('framework::basic.navigation')

@section('content')
<div class="table-head">
@if(!empty($filters))
<div class="element">
<select class="filter" name="filter" id="filter">
 <option value="none">{{ __('(no filter)') }}</option>
@foreach ($filters as $filter)
 <option value="{{ $filter->value }}">{{ __($filter->name) }}</option>
@endforeach
</select>
</div>
@endif
</div>
<table class="data">
 <th>
@foreach ($columns as $column)
  <td class="{{ $column->class }}"><x-optional_link :entry="$column"/></td>
@endforeach
 </th>
@forelse ($datarows as $row)
 <tr>
@foreach ($row as $column)
  <td class="{{ $column->class}}"><x-optional_link :entry="$column->data"/></td>
@endforeach
 </tr>
@empty
 <tr><td colspan="100">{{ __('No entries.') }}</td></tr>
@endforelse
</table>
<div class="table-foot">
</div>
@if(!empty($pagination))
<nav role="paginator">
<ul>
@foreach ($pagination as $page)
  <li>
@switch ($page->type)
@case('link')
   <a href="{{ $page->link }}">{{ $page->title }}</a>
@break
@case('ellipse')
   <div class="ellipse">...</div>
@break
@case('current')
   <div class="active-page">{{ $page->title }}</div>
@break      
@endswitch  
  </li>
@endforeach
 </ul> 
</nav>
@endif
@endsection
