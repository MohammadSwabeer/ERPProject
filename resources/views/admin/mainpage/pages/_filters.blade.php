<td id="filter_col{{$filter->pos[$i-1]}}" data-column="{{$filter->pos[$i-1]}}">
  <input list="filter{{$i}}" type="text" class="column_filter filter-field" id="col{{$filter->pos[$i-1]}}_filter" placeholder="{{$filter->name[$i-1]}}">
  <datalist id="filter{{$i}}">
     @foreach($post as $filters)
       <?php $data = $filter->param[$i-1]; ?>
       @if($filter->name[$i-1] != 'Age')
         <option value="{{($filters->$data != '-' && $filters->$data != 'None') ? $filters->$data : '' }}"></option>
       @else
         <option value="{{$main->age($filters->$data)}}"></option>
       @endif
     @endforeach
  </datalist>
</td>