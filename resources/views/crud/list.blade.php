@extends('framework::basic.navigation')

@section('content')
<table class="data">
 <th>
 @foreach ($columns as $column)
  <td class="{{ $column->class }}">@if($column->sortable)<a href="{{ $column->link }}">@endif{{ __($column->title) }}@if($column->sortable)</a>@endif</td>
 @endforeach
 </th>
 @forelse ($datarows as $row)
 
 @empty
 <tr><td colspan="100">{{ __('No entries.') }}</td></tr>
 @endforelse
</table>
@endsection
