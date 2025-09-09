<form method="POST" action="{{ route('quiz.submit') }}">
  @csrf
  @foreach($questions as $question)
    <div>
      <h4>{{ $question->question_text }}</h4>
      @foreach($question->answers as $answer)
        <label>
          <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}">
          {{ $answer->answer_text }}
        </label><br>
      @endforeach
    </div>
    <hr>
  @endforeach
  <button type="submit">Submit Test</button>
</form>
