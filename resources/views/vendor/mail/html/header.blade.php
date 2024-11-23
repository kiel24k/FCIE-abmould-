@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4FJY3yz3sreSf5at5NK_lBa_pm4yLh0v8MA&s" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
