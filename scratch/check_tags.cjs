
const fs = require('fs');
const content = fs.readFileSync('c:/Users/carra/OneDrive/Documentos/GitHub/gestor_portafolios/resources/views/admin.blade.php', 'utf8');

const tags = content.match(/<div|<\/div|<aside|<\/aside|<main|<\/main|<section|<\/section|<body|<\/body|<html|<\/html/g);
let stack = [];
let lines = content.split('\n');

let balance = 0;
for (let i = 0; i < lines.length; i++) {
    let line = lines[i];
    let lineTags = line.match(/<div|<\/div|<aside|<\/aside|<main|<\/main|<section|<\/section|<body|<\/body|<html|<\/html/g);
    if (lineTags) {
        for (let tag of lineTags) {
            if (tag.startsWith('</')) {
                balance--;
                if (balance < 0) {
                    console.log(`Extra closing tag ${tag} at line ${i + 1}`);
                }
            } else {
                balance++;
            }
        }
    }
}
console.log(`Final balance: ${balance}`);
