const text = ["Web Developer", "AI & Arduino Enthusiast", "Full Stack Developer"];
    let count = 0;
    let index = 0;
    let currentText = '';
    let letter = '';
    (function type() {
        if(count === text.length) count = 0;
        currentText = text[count];
        letter = currentText.slice(0, ++index);
        document.getElementById('typing-text').textContent = letter;
        if(letter.length === currentText.length){
            setTimeout(() => { index = 0; count++; type(); }, 1500);
        } else {
            setTimeout(type, 200);
        }
    }());

    // Smooth Scrolling for Nav Links
    document.querySelectorAll('nav a').forEach(link => {
        link.addEventListener('click', function(e){
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });