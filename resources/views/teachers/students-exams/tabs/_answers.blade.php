<table class="table table-striped table-bordered">
    <thead>

    <tr>
        <th>#</th>
        <th>Question</th>
        <th>Given Answer</th>
        <th>Correct Answer</th>
        <th>Status</th>

    </tr>
    </thead>

    <tbody>
        @foreach($studentQuiz->answers as $quizAnswer)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $quizAnswer->question }}</td>
                <td>{{ $quizAnswer->given_answer }}</td>
                <td>{{ $quizAnswer->correct_answer }}</td>
                <td>
                    @if($quizAnswer->correct)
                        <i class="fa fa-check fa-4x fa-green"></i>
                    @else
                        <i class="fa fa-times fa-4x fa-red"></i>
                    @endif
                </td>
            </tr>
        @endforeach

    </tbody>
</table>