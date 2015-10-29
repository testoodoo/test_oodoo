<p>From:{{$from}}&lt;{{$messageSender}}&gt;</code><br>
To: {{$to}}&lt;{{$messageTo}}&gt;<br>
Sub: {{$subject}}<br>
Date: {{$time}}</p>
<br><br>
{{$body}}
<br><br>
{{ Form::open( array( 'route' => array('reply'), 'method' => 'POST',)  ) }}
    	From:<input type='text' name='from' value='{{$messageTo}}'><br>
    	To: <input type='text' name='to' value='{{$messageSender}}'><br>
    	Message: <textarea name='body'></textarea><br>
    	<input type='hidden' name='from_name' value='{{$to}}'>
    	<input type='hidden' name='to_name' value='{{$from}}'>
    	<input type='hidden' name='subject' value='{{$subject}}'>    	
    	<input type='submit' name='submit' placeholder='submit'>
{{ Form::close() }}


