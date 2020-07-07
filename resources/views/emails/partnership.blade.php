@extends('emails/master')

@section('content')
    

    <h2 style="text-align: left"> Category : {{$category}} </h2>  <br />
    @if($category == "Academy")
    <p style="text-align: left"> Name academy : </p>{{ $name_academy}} <br /> 
    @endif

	<table rules="all" bordercolor="#4d4c4d" border="1" bgcolor="#FFFFFF" cellpadding="10"  align="center" width="800">
        
            <tr>
                <th>Email</th>
                <th>Phone</th>
                <th>Full name</th>
                <th>Date of birth</th>
                <th>Gender</th>
                <th> Address </th>
            </tr>
     
          
            
                <tr>
                    <td>
                     {{ $email}}
                    </td>
                    <td>
                        {{ $phone}}
                    </td>
                    <td>
                        {{ $full_name}}
                    </td>
                    <td>
                        {{ $date_birth}}
                    </td>
                    <td>
                        {{ $gender}}
                    </td>
                    <td>
                        {{ $country}}
                    </td>
                </tr>
     
    </table>
    <p style="text-align: left">Cover lettre :     {{$cover_lettre }}</p> 
 
    <p style="text-align: left"> 2. What courses do you require to be accredited at?:  </p>  
        @if(isset($course_choice ))
        <ul>
        @foreach ($course_choice as $choice )
            <li style="text-align: left"> {{$choice}} </li>
        @endforeach
        </ul>
         @endif
    @if(isset($question4 ))
    <p style="text-align: left">
        If the course you wish to be certified at, is not listed ,please add it here.    {{$question4}} <p>
    @endif
    <p style="text-align: left"> 3. What marketing plan do you follow? Please attach a sample form.  {{$question5 }}</p> <br/>

@stop
   