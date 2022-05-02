<x-app-layout>
  <div>
    <ul class="my-40">
      @foreach ($question_answers as $question_answer)
      <li class="max-w-2xl border-2 border-white truncate mx-auto mb-2 px-2 py-4 rounded-md cursor-pointer hover:bg-indigo-600">
        <a href="/edit/{{ $question_answer['id'] }}">
          <div class="text-white text-xl ml-4 mr-2">
            <input type="hidden" name="titleID" value="{{ $question_answer['title_id'] }}">
            <label for="question">問い：</label>
            <span class="border-b-2 border-white">{{ $question_answer['question'] }}</span><br>
            <label for="answer" class="">解答：</label>
            <span>{{ $question_answer['answer'] }}</span>
          </div>
        </a>
      </li>
      @endforeach
    </ul>
  </div>
</x-app-layout>