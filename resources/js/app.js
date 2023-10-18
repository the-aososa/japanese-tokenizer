import './bootstrap';
import 'kuromoji';

import.meta.glob([
    '../dict/**',
  ]);
// var builder = kuromoji.builder({ dicPath: "dict" });
// builder.build(function(err, tokenizer) {
//     // tokenizer is ready
//     var path = tokenizer.tokenize("すもももももももものうち");
//     console.log(path);
// });
// kuromoji.builder({ dicPath: "dict" }).build(function (err, tokenizer) {
//     // tokenizer is ready
//     var path = tokenizer.tokenize("すもももももももものうち");
//     console.log(path);
// });