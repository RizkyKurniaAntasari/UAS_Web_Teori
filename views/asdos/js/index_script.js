// Slider Script
document.addEventListener("DOMContentLoaded", function() {
    const slider = document.querySelector(".slider");
    const slides = document.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".slider-dot");
    let currentSlide = 0;
    const slideCount = slides.length;

    function goToSlide(index) {
        slider.style.transform = `translateX(-${index * 100}%)`;
        dots.forEach((dot) => dot.classList.remove("active"));
        dots[index].classList.add("active");
        currentSlide = index;
    }

    dots.forEach((dot, index) => {
        dot.addEventListener("click", () => {
            goToSlide(index);
        });
    });

    function nextSlide() {
        let next = currentSlide + 1;
        if (next >= slideCount) {
            next = 0;
        }
        goToSlide(next);
    }

    const slideInterval = setInterval(nextSlide, 5000);
    slider.addEventListener("mouseenter", () => {
        clearInterval(slideInterval);
    });
});

// Search & Filter Script
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("search-matkul");
    const filterAll = document.getElementById("filter_all");
    const filterIlmuKomputer = document.getElementById("filter_ilmukomputer");
    const filterSistemInformasi = document.getElementById("filter_sistem_informasi");
    const filterManajemenInformatika = document.getElementById("filter_manajemeninformasir");

    searchInput.addEventListener("input", function() {
        console.log("Searching for:", this.value);
    });

    filterAll.addEventListener("change", function() {
        if (this.checked) {
            filterIlmuKomputer.checked = false;
            filterSistemInformasi.checked = false;
            filterManajemenInformatika.checked = false;
        }
    });

    [filterIlmuKomputer, filterSistemInformasi, filterManajemenInformatika].forEach(
        (filter) => {
            filter.addEventListener("change", function() {
                if (this.checked) {
                    filterAll.checked = false;
                }
                if (
                    !filterIlmuKomputer.checked &&
                    !filterSistemInformasi.checked &&
                    !filterManajemenInformatika.checked
                ) {
                    filterAll.checked = true;
                }
            });
        },
    );
});

// Accordion Function
function toggleAccordion(id) {
    const element = document.getElementById(id);
    const arrow = document.getElementById(`${id}-arrow`);
    if (element.classList.contains('hidden')) {
        element.classList.remove('hidden');
        arrow.classList.remove('rotate-180');
    } else {
        element.classList.add('hidden');
        arrow.classList.add('rotate-180');
    }
}
