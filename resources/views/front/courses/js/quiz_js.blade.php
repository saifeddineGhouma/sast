<script>

    var Timer;
    var TotalSeconds;


    function CreateTimer(TimerID, Time) {
        Timer = document.getElementById(TimerID);
        TotalSeconds = Time;

        UpdateTimer()
        window.setTimeout("Tick()", 1000);
 
    }
 
    function Tick() {
        if (TotalSeconds <= 0) {
            //alert("Time's up!")
			//document.forms['formquiz'].submit();
            $('.quiz_question_end').trigger( "click" );
            return;
        }

        TotalSeconds -= 1;
        UpdateTimer()
        window.setTimeout("Tick()", 1000);
    }

    function UpdateTimer() {
        var Seconds = TotalSeconds;

        var Days = Math.floor(Seconds / 86400);
        Seconds -= Days * 86400;

        var Hours = Math.floor(Seconds / 3600);
        Seconds -= Hours * (3600);

        var Minutes = Math.floor(Seconds / 60);
        Seconds -= Minutes * (60);


        var TimeStr = ((Days > 0) ? Days + " days " : "") + LeadingZero(Hours) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds)


        Timer.innerHTML = TimeStr;
    }


    function LeadingZero(Time) {

        return (Time < 10) ? "0" + Time : + Time;

    }

    //var myCountdown1 = new Countdown({time:<?php echo $seconds;?>, rangeHi:"hour", rangeLo:"second"});
    //setTimeout(submitform,'<?php echo ($seconds+2) * 1000;?>');
    function submitform(){
        alert('Time Over');
        
    }
var questionsCount = parseInt('{{ $questions->count() }}');
function show_next(btn){
    $("button.previous").show();
    $("button.next").show();
    var thisBtn = $(btn);
    var currentId = $(".question_div:visible").data("id");
    var count = '{{ $questions->count() }}';
    if(currentId==count-1){
        thisBtn.hide();
    }
    if(currentId != count){
        var nextId = parseInt(currentId,10)+1;
        $("#question_"+currentId).hide();
        $("#question_"+nextId).show();
        //updateQuestions();

    }
    updateCount();

}

function show_prev(btn){
    $("button.previous").show();
    $("button.next").show();
    var thisBtn = $(btn);
    var currentId = $(".question_div:visible").data("id");
    if(currentId==2){
        thisBtn.hide();
    }
    if(currentId!=1){
        var prevId = parseInt(currentId,10)-1;
        $("#question_"+currentId).hide();
        $("#question_"+prevId).show();
        //updateQuestions();

    }
    updateCount();
}
function updateCount(){
    var solved = 0;
    @foreach($questions as $question)
    var questionVal = $("input[name='questions[{{$question->id}}]']:checked").val();
    console.log(questionVal);
    if(questionVal!=undefined){
        solved++;
    }
    @endforeach
    var rest = questionsCount - solved;
    $("#solved").html(solved);
    $("#rest").html(rest);
}
    var currentRequest = null;

function updateQuestions(){
    var form = $("#form-quiz");
	//alert("afef");
    currentRequest =$.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
                if(currentRequest != null) {
                    currentRequest.abort();
                }
            },
            success: function( message ) {
                var data = JSON.parse(message);
                $("#solved").html(data['solved']);
                $("#rest").html(data['rest']);
               if(data['message']=="expired"){
                   {{-- window.location="{{ url(App('urlLang').'courses/quiz-result?studentQuiz_id='.$studentQuiz->id) }}";--}}
               }
            },
            //complete event
            complete: function() {

            }
        });
}

</script>