<table style="width:100%">
  <tr>
    <td>Sender</td>
    <td>Subject</td> 
    <td>Snippet</td>
    <td>Date</td> 
  </tr>
@foreach($data as $key)
  <tr> 
    <td>{{$key['messageSender']}}</td>
    <td>{{$key['messageSubject']}}</td>
   <td><a href="{{ URL::route('show', array('messageId' => $key['messageId'])) }}"> {{ $key['messageSnippet'] }}</a></td> 
    <td>{{$key['messageDate']}}</td> 
  </tr>
@endforeach
</table>