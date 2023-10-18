<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<textarea id="tokenizeTextArea" rows="4" cols="50"> </textarea>
<button onclick="tokenizeText()">Tokenize</button>
<script>
    function tokenizeText() {
        var text = document.getElementById('tokenizeTextArea').value;
        var builder = kuromoji.builder({ dicPath: "dict" });
        builder.build(function(err, tokenizer) {
            if (err) throw err;

            var tokens = tokenizer.tokenize(text);
            var words = [];
            tokens.forEach((token) => {
                if (token['word_type'] == 'KNOWN') {
                    var knownWord = {
                        "word_id": token['word_id'],
                        "word": token['basic_form']
                    };
                    words.push(knownWord);
                }
            });
            fetch('/api/tokenize', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    words: words
                })
            })
            .then(response => response.json())
            .then(data => {
                let responseElement = document.getElementById('apiResponse');
                responseElement.innerHTML = '';
                data.forEach(item => {
                    let token = JSON.parse(item);
                    let row = document.createElement('div');
                    let tokenizedWord = document.createElement('tokenizedWord');
                    tokenizedWord.textContent = `${token.word}: ${token.meaning}`;
                    row.appendChild(tokenizedWord);

                    if(!token.registered) {
                        let button = document.createElement('button');
                        button.textContent = 'Add to vocabulary';
                        button.onclick = function() {
                            fetch('/api/store', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    word_id: token.word_id,
                                    word: token.word,
                                    meaning: token.meaning
                                })
                            })
                            .then(response => {
                                if (response.status === 201) {
                                    button.remove();
                                }
                            })
                        };
                        row.appendChild(button);
                    } else {
                        let button = document.createElement('button');
                        button.textContent = 'Remove from vocabulary';
                        button.onclick = function() {
                            fetch(`/api/remove/${token.word_id}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.status === 204) {
                                    button.remove();
                                }
                            })
                        };
                        row.appendChild(button);
                    }
                    
                    responseElement.appendChild(row);
                });
            });
        });
    }
</script>
<div id="apiResponse"></div>