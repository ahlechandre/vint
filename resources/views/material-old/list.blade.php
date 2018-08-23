<ul class="mdc-list">
  @foreach($items as $item)
  <li class="mdc-list-item">{{ $item['text'] }}</li>  
  @endforeach
</ul>