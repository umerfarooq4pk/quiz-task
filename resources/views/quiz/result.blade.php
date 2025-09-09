<h2>Your Previous Results</h2>
<table>
    <tr>
        <th>Date</th>
        <th>Correct</th>
        <th>Wrong</th>
        <th>Skipped</th>
    </tr>
    @foreach($results as $result)
    <tr>
        <td>{{ $result->created_at->format('d M Y H:i') }}</td>
        <td>{{ $result->correct_count }}</td>
        <td>{{ $result->wrong_count }}</td>
        <td>{{ $result->skipped_count }}</td>
    </tr>
    @endforeach
</table>