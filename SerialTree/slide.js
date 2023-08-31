var images = [
    'url(img/serial_bac_1.jpg)',
    'url(img/serial_bac_2.jpg)',
    'url(img/serial_bac_3.jpg)',
    'url(img/serial_bac_4.jpg)',
    'url(img/serial_bac_5.jpg)',
    'url(img/serial_bac_6.jpg)',
    'url(img/serial_bac_7.jpg)'
];

var currentIndex = 0;

function changeBackground() {
    document.body.style.backgroundImage = images[currentIndex];
    document.body.style.backgroundSize = 'cover';
    document.body.style.backgroundRepeat = 'no-repeat';
    document.body.style.backgroundPosition = 'center';
    document.body.style.height = '100vh'; // Set body height to full viewport height
    document.body.style.margin = '0'; // Remove any margins
    document.body.style.padding = '0'; // Remove any padding
    currentIndex = (currentIndex + 1) % images.length;
}

window.onload = function() {
    document.body.style.backgroundImage = images[currentIndex];
    document.body.style.backgroundSize = 'cover';
    document.body.style.backgroundRepeat = 'no-repeat';
    document.body.style.backgroundPosition = 'center';
    document.body.style.height = '100vh';
    document.body.style.margin = '0';
    document.body.style.padding = '0';
    currentIndex = (currentIndex + 1) % images.length;

    setInterval(changeBackground, 10000);
};

