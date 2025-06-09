const carousel = document.querySelector('#carouselExampleAutoplaying .carousel-inner');
const outerCarousel = document.querySelector('#carouselExampleAutoplaying');
let startX = 0;
let currentX = 0;
let diffX = 0;
let isDragging = false;

outerCarousel.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
    isDragging = true;
    carousel.style.transition = 'none';
});

outerCarousel.addEventListener('touchmove', (e) => {
    if (!isDragging) return;
    currentX = e.touches[0].clientX;
    diffX = currentX - startX;

    carousel.style.transform = `translateX(${diffX}px)`;
});

outerCarousel.addEventListener('touchend', () => {
    if (!isDragging) return;
    isDragging = false;

    carousel.style.transition = 'transform 0.3s ease';

    const threshold = 50;
    const bsCarousel = bootstrap.Carousel.getInstance(outerCarousel);

    if (diffX > threshold) {
        carousel.style.transform = `translateX(100%)`;
        setTimeout(() => {
            bsCarousel.prev();
            carousel.style.transform = '';
        }, 300);
    } else if (diffX < -threshold) {
        carousel.style.transform = `translateX(-100%)`;
        setTimeout(() => {
            bsCarousel.next();
            carousel.style.transform = '';
        }, 300);
    } else {
        carousel.style.transform = 'translateX(0)';
    }
});