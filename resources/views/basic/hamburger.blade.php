@extends('framework::basic.html')

@section('body')
<nav role='navigation'>
  <div id="menuToggle">
    <!--
    A fake / hidden checkbox is used as click reciever,
    so you can use the :checked selector on it.
    -->
    <input type="checkbox" />
    
    <!--
    Some spans to act as a hamburger.
    
    They are acting like a real hamburger,
    not that McDonalds stuff.
    -->
    <span></span>
    <span></span>
    <span></span>
    
    <!--
    Too bad the menu has to be inside of the button
    but hey, it's pure CSS magic.
    -->
    <ul id="menu">
      <a href="#"></a>
      @foreach ($hamburger_entries as $entry)
      <a href="{{ route($entry->route) }}"><li>{{ __($entry->text) }}</li></a>
      @endforeach
      <a href="{{ route('admin.settings) }}"><li><{{ __('settings...') }}</li></a>
    </ul>
  </div>
</nav>
@endsection