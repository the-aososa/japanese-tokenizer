<head>
    <title>Vocab Words</title>
</head>
<body>
    @if($vocabWords->count())
        <table>
            <thead>
                <tr>
                    <th>Word</th>
                    <th>Meaning</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vocabWords as $vocabWord)
                    <tr>
                        <td>{{ $vocabWord->word }}</td>
                        <td>{{ $vocabWord->meaning }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No words found.</p>
    @endif
</body>
</>